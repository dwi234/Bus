<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Booking_model');
        $this->load->model('Bus_model');
        $this->load->model('Customer_model');
        $this->load->model('Notification_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }

        // Hanya admin reservasi dan superadmin yang bisa akses CRUD booking
        if ($this->session->userdata('role') != 'reservasi' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    /** Whitelist status booking yang diizinkan */
    private $_allowed_statuses = [
        'pending', 'menunggu_verifikasi', 'uang_muka_dibayarkan',
        'menunggu_pelunasan', 'siap_berangkat', 'sedang_berlangsung',
        'selesai', 'batal'
    ];

    public function index()
    {
        $data['booking'] = $this->Booking_model->get_all();
        $data['bus'] = $this->Bus_model->get_all();
        $data['customer'] = $this->Customer_model->get_all();
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('booking/index', $data);
        $this->load->view('templates/footer');
    }

    public function persetujuan()
    {
        // Get bookings waiting for verification
        $this->db->select('booking.*, customer.nama as customer_nama, customer.tlp as no_telp, bus.bus_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->where_in('booking_status', ['menunggu_verifikasi', 'menunggu_pelunasan']);
        $this->db->order_by('booking_id', 'ASC'); // First in, first verified
        $data['verifications'] = $this->db->get()->result_array();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('booking/persetujuan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $status = $this->input->post('booking_status');
        if (!in_array($status, $this->_allowed_statuses)) {
            $status = 'pending';
        }

        $data = [
            'customer_id' => (int) $this->input->post('customer_id'),
            'bus_id' => (int) $this->input->post('bus_id'),
            'tanggal_keberangkatan' => $this->input->post('tanggal_keberangkatan'),
            'tanggal_pulang' => $this->input->post('tanggal_pulang'),
            'lokasi_penjemputan' => $this->input->post('lokasi_penjemputan'),
            'tempat_tujuan' => $this->input->post('tempat_tujuan'),
            'total_harga' => $this->input->post('total_harga'),
            'booking_status' => $status
        ];
        $this->Booking_model->insert($data);
        redirect('booking');
    }

    public function edit() {
        $id = (int) $this->input->post('booking_id');
        $status = $this->input->post('booking_status');
        if (!in_array($status, $this->_allowed_statuses)) {
            $status = 'pending';
        }

        $data = [
            'customer_id' => (int) $this->input->post('customer_id'),
            'bus_id' => (int) $this->input->post('bus_id'),
            'tanggal_keberangkatan' => $this->input->post('tanggal_keberangkatan'),
            'tanggal_pulang' => $this->input->post('tanggal_pulang'),
            'lokasi_penjemputan' => $this->input->post('lokasi_penjemputan'),
            'tempat_tujuan' => $this->input->post('tempat_tujuan'),
            'total_harga' => $this->input->post('total_harga'),
            'booking_status' => $status
        ];
        $this->Booking_model->update($id, $data);
        redirect('booking');
    }

    public function hapus($id) {
        $id = (int) $id;
        $this->Booking_model->delete($id);
        redirect('booking');
    }

    /**
     * Verifikasi Pembayaran (Admin Reservasi)
     */
    public function verifikasi_pembayaran()
    {
        $booking_id = (int) $this->input->post('booking_id');
        $action = $this->input->post('action'); // 'terima' atau 'tolak'
        $alasan = $this->input->post('alasan_penolakan');

        $booking = $this->db->where('booking_id', $booking_id)->get('booking')->row_array();
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking tidak ditemukan.');
            redirect('booking');
        }

        if ($action == 'terima') {
            // Determine if verifying DP or Pelunasan
            if ($booking['booking_status'] == 'menunggu_verifikasi') {
                // Verifying DP
                $dp_amount = $booking['dp_nominal'] ?? (0.3 * $booking['total_harga']);
                
                // Hitung batas waktu pelunasan
                $tgl_berangkat = new DateTime($booking['tanggal_keberangkatan']);
                $now = new DateTime();
                $diff = $now->diff($tgl_berangkat)->days;
                
                if ($diff > 3) {
                    $tgl_berangkat->modify('-3 days');
                    $batas_pelunasan = $tgl_berangkat->format('Y-m-d 23:59:59');
                } else {
                    // Jika keberangkatan <= 3 hari, wajib lunas dalam 2 jam
                    $batas_pelunasan = date('Y-m-d H:i:s', strtotime('+2 hours'));
                }

                $data = [
                    'booking_status' => 'uang_muka_dibayarkan',
                    'status_pembayaran' => 'dp_dibayar',
                    'jumlah_dibayar' => $dp_amount,
                    'sisa_pembayaran' => max($booking['total_harga'] - $dp_amount, 0),
                    'pembayaran_type' => 'dp',
                    'alasan_penolakan' => NULL,
                    'batas_waktu_bayar' => $batas_pelunasan
                ];
                $this->Booking_model->update($booking_id, $data);

                // === NOTIFIKASI: Beritahu Admin Operasional untuk atur jadwal ===
                $this->Notification_model->create(
                    'DP Terverifikasi',
                    'Pembayaran DP untuk Booking #BK-' . str_pad($booking_id, 4, '0', STR_PAD_LEFT) . ' telah diverifikasi. Silakan atur jadwal bus dan supir.',
                    'operasional',
                    $booking_id,
                    'success'
                );

                $this->session->set_flashdata('success', 'Pembayaran DP berhasil diverifikasi.');
            } elseif ($booking['booking_status'] == 'menunggu_pelunasan') {
                // Verifying Pelunasan
                $data = [
                    'booking_status' => 'siap_berangkat',
                    'status_pembayaran' => 'lunas',
                    'jumlah_dibayar' => $booking['total_harga'] + $booking['denda'],
                    'sisa_pembayaran' => 0,
                    'pembayaran_type' => 'lunas',
                    'alasan_penolakan' => NULL
                ];
                $this->Booking_model->update($booking_id, $data);

                // === NOTIFIKASI: Beritahu Admin Operasional booking siap berangkat ===
                $this->Notification_model->create(
                    'Pelunasan Terverifikasi',
                    'Pelunasan untuk Booking #BK-' . str_pad($booking_id, 4, '0', STR_PAD_LEFT) . ' telah diverifikasi. Status: Siap Berangkat.',
                    'operasional',
                    $booking_id,
                    'success'
                );

                $this->session->set_flashdata('success', 'Pelunasan berhasil diverifikasi.');
            }
        } elseif ($action == 'tolak') {
            // Tolak pembayaran
            if ($booking['booking_status'] == 'menunggu_verifikasi') {
                $data = [
                    'booking_status' => 'pending',
                    'alasan_penolakan' => $alasan,
                    'batas_waktu_bayar' => date('Y-m-d H:i:s', strtotime('+2 hours'))
                ];
                if ($booking['bukti_pembayaran']) {
                    $path = './assets/img/bukti_transfer/' . $booking['bukti_pembayaran'];
                    if (file_exists($path)) unlink($path);
                    $data['bukti_pembayaran'] = NULL;
                }
            } elseif ($booking['booking_status'] == 'menunggu_pelunasan') {
                $data = [
                    'booking_status' => 'uang_muka_dibayarkan',
                    'alasan_penolakan' => $alasan,
                    'batas_waktu_bayar' => date('Y-m-d H:i:s', strtotime('+2 hours'))
                ];
                if ($booking['bukti_pelunasan']) {
                    $path = './assets/img/bukti_transfer/' . $booking['bukti_pelunasan'];
                    if (file_exists($path)) unlink($path);
                    $data['bukti_pelunasan'] = NULL;
                }
            }
            
            $this->Booking_model->update($booking_id, $data);
            $this->session->set_flashdata('error', 'Pembayaran ditolak. Alasan: ' . $alasan);
        }

        redirect('booking');
    }
}
