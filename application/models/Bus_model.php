<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bus_model extends CI_Model {
    public function get_all() {
        $this->db->select('bus.*, 
            (SELECT COUNT(*) FROM booking WHERE booking.bus_id = bus.bus_id AND booking.booking_status = "selesai") as total_rentals,
            (SELECT COUNT(*) FROM reviews WHERE reviews.bus_id = bus.bus_id) as total_reviews,
            (SELECT IFNULL(AVG(rating), 0) FROM reviews WHERE reviews.bus_id = bus.bus_id) as avg_rating
        ');
        $this->db->from('bus');
        $this->db->order_by('bus.bus_id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('bus.*, 
            (SELECT COUNT(*) FROM booking WHERE booking.bus_id = bus.bus_id AND booking.booking_status = "selesai") as total_rentals,
            (SELECT COUNT(*) FROM reviews WHERE reviews.bus_id = bus.bus_id) as total_reviews,
            (SELECT IFNULL(AVG(rating), 0) FROM reviews WHERE reviews.bus_id = bus.bus_id) as avg_rating
        ');
        $this->db->from('bus');
        $this->db->where('bus.bus_id', $id);
        return $this->db->get()->row_array();
    }

    /**
     * Ambil semua bus TANPA subquery rating/review.
     * Untuk halaman yang tidak membutuhkan data tersebut (booking form, admin CRUD).
     */
    public function get_all_light() {
        $this->db->from('bus');
        $this->db->order_by('bus_id', 'DESC');
        return $this->db->get()->result_array();
    }
    public function insert($data) {
        return $this->db->insert('bus', $data);
    }
    public function update($id, $data) {
        $this->db->where('bus_id', $id);
        return $this->db->update('bus', $data);
    }
    public function delete($id) {
        $this->db->where('bus_id', $id);
        return $this->db->delete('bus');
    }

    public function get_utilization($start_date = null, $end_date = null) {
        $this->db->select('bus.*, COUNT(booking.booking_id) as total_trip, IFNULL(SUM(booking.total_harga), 0) as pendapatan_bus');
        $this->db->from('bus');
        
        $join_condition = "booking.bus_id = bus.bus_id AND booking.booking_status IN ('selesai', 'sedang_berlangsung')";
        if ($start_date && $end_date) {
            $join_condition .= " AND booking.tanggal_keberangkatan >= " . $this->db->escape($start_date) . " AND booking.tanggal_keberangkatan <= " . $this->db->escape($end_date);
        }
        
        $this->db->join('booking', $join_condition, 'left');
        $this->db->group_by('bus.bus_id');
        $this->db->order_by('total_trip', 'DESC');
        
        return $this->db->get()->result_array();
    }

    /**
     * Ambil semua bus_id yang tidak tersedia pada rentang tanggal tertentu.
     * Digabung menjadi 1 UNION ALL query (sebelumnya 3 query terpisah).
     */
    public function get_unavailable_bus_ids($start_date, $end_date) {
        $sql = "SELECT DISTINCT bus_id FROM (
            SELECT bus_id FROM jadwal
                WHERE (? BETWEEN tangal_mulai AND tanggal_selesai)
                   OR (? BETWEEN tangal_mulai AND tanggal_selesai)
                   OR (tangal_mulai BETWEEN ? AND ?)
            UNION ALL
            SELECT bus_id FROM booking
                WHERE booking_status IN ('uang_muka_dibayarkan','menunggu_pelunasan','siap_berangkat','sedang_berlangsung','selesai')
                  AND ((? BETWEEN tanggal_keberangkatan AND tanggal_pulang)
                    OR (? BETWEEN tanggal_keberangkatan AND tanggal_pulang)
                    OR (tanggal_keberangkatan BETWEEN ? AND ?))
            UNION ALL
            SELECT bus_id FROM bus WHERE status = 'maintenance'
        ) AS unavailable";

        $result = $this->db->query($sql, array(
            $start_date, $end_date, $start_date, $end_date,
            $start_date, $end_date, $start_date, $end_date
        ))->result_array();

        return array_column($result, 'bus_id');
    }
}
