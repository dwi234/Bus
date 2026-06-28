<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    /**
     * Cache per-request untuk notifikasi topbar.
     * Menghindari query berulang jika dipanggil lebih dari sekali per request.
     */
    private $_topbar_cache = null;

    /**
     * Ambil data notifikasi topbar dengan 2 query ringan:
     * - COUNT(*) untuk badge counter (tanpa fetch row)
     * - SELECT ... LIMIT $limit untuk dropdown alerts
     * Hasilnya di-cache per-request agar tidak query ulang.
     */
    public function get_topbar_notifications($limit = 3) {
        if ($this->_topbar_cache !== null) {
            return $this->_topbar_cache;
        }

        $statuses = ['pending', 'menunggu_verifikasi', 'menunggu_pelunasan'];

        // Query 1: COUNT saja, tanpa fetch row
        $this->db->where_in('booking_status', $statuses);
        $count = $this->db->count_all_results('booking');

        // Query 2: Ambil maksimal $limit alert untuk dropdown
        $this->db->select('booking.booking_id, booking.tanggal_keberangkatan, booking.booking_status, customer.nama as customer_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->where_in('booking.booking_status', $statuses);
        $this->db->order_by('booking.tanggal_keberangkatan', 'ASC');
        $this->db->limit($limit);
        $alerts = $this->db->get()->result_array();

        $this->_topbar_cache = [
            'count'  => $count,
            'alerts' => $alerts
        ];

        return $this->_topbar_cache;
    }

    public function get_all() {
        $this->db->select('booking.*, customer.nama as customer_nama, bus.bus_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->order_by('booking_id', 'DESC');
        return $this->db->get()->result_array();
    }
    public function get_recent_pending($limit = 5) {
        $this->db->select('booking.*, customer.nama as customer_nama, bus.bus_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->where('booking_status', 'pending');
        $this->db->order_by('booking_id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_income_last_7_days() {
        $query = "SELECT DATE(tanggal_keberangkatan) as tanggal, SUM(total_harga) as total_pendapatan 
                  FROM booking 
                  WHERE tanggal_keberangkatan >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                  AND booking_status IN ('selesai', 'sedang_berlangsung', 'siap_berangkat', 'uang_muka_dibayarkan')
                  GROUP BY DATE(tanggal_keberangkatan) 
                  ORDER BY tanggal ASC";
        return $this->db->query($query)->result_array();
    }

    public function get_reports($start_date = null, $end_date = null, $status = null) {
        $this->db->select('booking.*, customer.nama as customer_nama, bus.bus_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        
        if ($start_date && $end_date) {
            $this->db->where('tanggal_keberangkatan >=', $start_date);
            $this->db->where('tanggal_keberangkatan <=', $end_date);
        }
        
        if ($status && $status != 'all') {
            $this->db->where('booking_status', $status);
        }
        
        $this->db->order_by('tanggal_keberangkatan', 'DESC');
        return $this->db->get()->result_array();
    }
    public function insert($data) {
        return $this->db->insert('booking', $data);
    }
    public function update($id, $data) {
        $this->db->where('booking_id', $id);
        return $this->db->update('booking', $data);
    }
    public function delete($id) {
        // Hapus otomatis data jadwal yang terkait dengan booking ini
        $this->db->where('booking_id', $id);
        $this->db->delete('jadwal');

        // Hapus data booking
        $this->db->where('booking_id', $id);
        return $this->db->delete('booking');
    }

    /**
     * Statistik bulanan dalam 1 query (sebelumnya 3 query terpisah).
     * Menggunakan COUNT, COUNT(DISTINCT), dan SUM(CASE) dalam satu SELECT.
     */
    public function get_monthly_stats($month, $year) {
        $this->db->select("COUNT(*) as total_booking,
            COUNT(DISTINCT customer_id) as active_bookers,
            IFNULL(SUM(CASE WHEN booking_status IN ('selesai','sedang_berlangsung','siap_berangkat','uang_muka_dibayarkan') THEN total_harga ELSE 0 END), 0) as revenue
        ");
        $this->db->from('booking');
        $this->db->where('MONTH(tanggal_keberangkatan)', $month);
        $this->db->where('YEAR(tanggal_keberangkatan)', $year);
        $row = $this->db->get()->row();

        return [
            'total_booking'  => $row ? (int) $row->total_booking : 0,
            'active_bookers' => $row ? (int) $row->active_bookers : 0,
            'revenue'        => $row ? $row->revenue : 0
        ];
    }

    public function get_comparison_stats($month, $year) {
        // Calculate previous month and year
        $prev_month = $month - 1;
        $prev_year = $year;
        if ($prev_month == 0) {
            $prev_month = 12;
            $prev_year = $year - 1;
        }

        $current_stats = $this->get_monthly_stats($month, $year);
        $prev_stats = $this->get_monthly_stats($prev_month, $prev_year);

        // Calculate growth percentage for Active Bookers
        $growth = 0;
        if ($prev_stats['active_bookers'] > 0) {
            $growth = (($current_stats['active_bookers'] - $prev_stats['active_bookers']) / $prev_stats['active_bookers']) * 100;
        } elseif ($current_stats['active_bookers'] > 0) {
            $growth = 100; // If previous was 0 and current is > 0
        }

        return [
            'current' => $current_stats,
            'previous' => $prev_stats,
            'growth_percentage' => round($growth, 1)
        ];
    }

    public function auto_check_deadlines() {
        // Load Notification_model jika belum
        $CI =& get_instance();
        $CI->load->model('Notification_model');

        // 1. Cancel pending bookings that passed batas_waktu_bayar (24 hours for DP)
        // Ambil data dulu sebelum update agar bisa kirim notifikasi
        $this->db->where('booking_status', 'pending');
        $this->db->where('batas_waktu_bayar <', date('Y-m-d H:i:s'));
        $expired_pending = $this->db->get('booking')->result_array();

        foreach ($expired_pending as $ep) {
            $this->db->where('booking_id', $ep['booking_id']);
            $this->db->update('booking', [
                'booking_status' => 'batal',
                'alasan_penolakan' => 'Batas waktu pembayaran DP telah habis (otomatis sistem).'
            ]);

            // === NOTIFIKASI: Beritahu Superadmin pembatalan otomatis ===
            $CI->Notification_model->create(
                'Pembatalan Otomatis',
                'Booking #BK-' . str_pad($ep['booking_id'], 4, '0', STR_PAD_LEFT) . ' dibatalkan otomatis oleh sistem karena batas waktu pembayaran DP habis.',
                'superadmin',
                $ep['booking_id'],
                'danger'
            );
        }

        // 2. Cancel bookings that haven't paid Lunas by batas_waktu_bayar
        $this->db->where_in('booking_status', ['uang_muka_dibayarkan', 'menunggu_pelunasan']);
        $this->db->where('batas_waktu_bayar <', date('Y-m-d H:i:s'));
        $late_bookings = $this->db->get('booking')->result_array();
        
        foreach ($late_bookings as $b) {
            $data_update = [
                'booking_status' => 'batal',
                'alasan_penolakan' => 'Pembatalan otomatis karena melewati batas waktu pelunasan.'
            ];
            
            if ($b['status_pembayaran'] == 'dp_dibayar') {
                $data_update['denda'] = 50000;
            }
            
            $this->db->where('booking_id', $b['booking_id']);
            $this->db->update('booking', $data_update);
            
            // Hapus jadwal karena batal
            $this->db->where('booking_id', $b['booking_id']);
            $this->db->delete('jadwal');

            // === NOTIFIKASI: Beritahu Superadmin pembatalan pelunasan ===
            $CI->Notification_model->create(
                'Pembatalan Otomatis (Pelunasan)',
                'Booking #BK-' . str_pad($b['booking_id'], 4, '0', STR_PAD_LEFT) . ' dibatalkan otomatis karena melewati batas waktu pelunasan.',
                'superadmin',
                $b['booking_id'],
                'danger'
            );
        }
    }
}
