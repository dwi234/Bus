<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Hanya bisa diakses lewat CLI atau token rahasia untuk keamanan
        // Tapi untuk keperluan demo ini, kita biarkan terbuka
    }

    public function send_review_requests()
    {
        // Cari booking dengan status selesai, tanggal_pulang = H-1 (atau lebih lama), dan belum direquest
        $this->db->select('booking.*, customer.nama as customer_name, customer.email, customer.tlp, bus.bus_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id');
        $this->db->where('booking.booking_status', 'selesai');
        $this->db->where('booking.is_review_requested', 0);
        $this->db->where('DATE(booking.tanggal_pulang) <', date('Y-m-d')); // Sudah lewat hari kepulangan
        
        $bookings = $this->db->get()->result_array();

        if (empty($bookings)) {
            echo "Tidak ada permintaan review yang perlu dikirim hari ini.";
            return;
        }

        $count = 0;
        foreach ($bookings as $b) {
            // Generate token (md5 hash dari booking_id + time + salt)
            $token = md5($b['booking_id'] . time() . 'bus_secret_salt');

            // Simpan token ke database
            $this->db->where('booking_id', $b['booking_id']);
            $this->db->update('booking', [
                'review_token' => $token,
                'is_review_requested' => 1
            ]);

            // Link ke form review
            $review_link = base_url('review/form/' . $token);

            // --- SIMULASI PENGIRIMAN WHATSAPP / EMAIL ---
            $pesan = "Halo Kak {$b['customer_name']},\n\n";
            $pesan .= "Terima kasih sudah memercayakan perjalanan rombongan kemarin bersama Dheemobilindo menggunakan armada {$b['bus_nama']}. ";
            $pesan .= "Bagaimana pengalaman Kakak dengan armada dan pelayanan sopir kami?\n\n";
            $pesan .= "Boleh minta waktu 1 menit untuk isi rating di link berikut? Masukan Kakak sangat berarti untuk kami.\n";
            $pesan .= $review_link . "\n\n";
            $pesan .= "Salam hangat,\nTim Dheemobilindo";

            echo "<pre>";
            echo "========================================\n";
            echo "MENGIRIM PESAN KE: " . $b['tlp'] . " / " . $b['email'] . "\n";
            echo "----------------------------------------\n";
            echo $pesan . "\n";
            echo "========================================\n\n";
            echo "</pre>";

            $count++;
        }

        echo "Berhasil mengirim $count permintaan review.\n";
    }

    /**
     * H-10 Pelunasan Reminder (Simulated)
     * Mengirim WA pengingat untuk melunasi sisa tagihan 10 hari sebelum keberangkatan
     */
    public function reminder_pelunasan()
    {
        // Cari pemesanan yang statusnya DP Paid dan berangkat 10 hari lagi
        $this->db->select('booking.*, customer.nama as customer_name, customer.tlp, customer.email, bus.bus_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'booking.customer_id = customer.customer_id', 'left');
        $this->db->join('bus', 'booking.bus_id = bus.bus_id', 'left');
        $this->db->where('booking.booking_status', 'uang_muka_dibayarkan');
        $this->db->where('DATEDIFF(booking.tanggal_keberangkatan, CURDATE()) =', 10);
        $bookings = $this->db->get()->result_array();

        if (empty($bookings)) {
            echo "Tidak ada pengingat pelunasan hari ini.\n";
            return;
        }

        $count = 0;
        foreach ($bookings as $b) {
            $link = base_url('home/booking_detail/' . $b['booking_id']);
            $sisa = number_format($b['sisa_pembayaran'], 0, ',', '.');
            
            $pesan = "Halo Kak {$b['customer_name']},\n\n";
            $pesan .= "Kami dari Dheemobilindo ingin mengingatkan bahwa perjalanan Kakak dengan armada {$b['bus_nama']} tinggal 10 hari lagi!\n\n";
            $pesan .= "Agar jadwal tidak otomatis dibatalkan, mohon segera melakukan pelunasan sisa tagihan sebesar:\n";
            $pesan .= "*Rp {$sisa}*\n\n";
            $pesan .= "Silakan upload bukti pelunasan paling lambat H-3 di link berikut:\n";
            $pesan .= $link . "\n\n";
            $pesan .= "Salam hangat,\nTim Dheemobilindo";

            echo "<pre>";
            echo "========================================\n";
            echo "MENGIRIM PENGINGAT PELUNASAN KE: " . $b['tlp'] . " / " . $b['email'] . "\n";
            echo "----------------------------------------\n";
            echo $pesan . "\n";
            echo "========================================\n\n";
            echo "</pre>";

            $count++;
        }

        echo "Berhasil mengirim $count pengingat pelunasan.\n";
    }
}
