<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
    public function get_all() {
        $this->db->select('customer.*, (SELECT COUNT(booking_id) FROM booking WHERE booking.customer_id = customer.customer_id) as booking_count');
        $this->db->from('customer');
        $this->db->order_by('customer_id', 'DESC');
        return $this->db->get()->result_array();
    }
    public function insert($data) {
        return $this->db->insert('customer', $data);
    }
    public function update($id, $data) {
        $this->db->where('customer_id', $id);
        return $this->db->update('customer', $data);
    }
    public function delete($id) {
        $this->db->where('customer_id', $id);
        return $this->db->delete('customer');
    }

    public function has_booking($id) {
        $this->db->where('customer_id', $id);
        $query = $this->db->get('booking');
        return $query->num_rows() > 0;
    }

    public function get_transactions($start_date = null, $end_date = null) {
        $this->db->select('customer.*, COUNT(booking.booking_id) as total_booking, IFNULL(SUM(booking.total_harga), 0) as total_belanja');
        $this->db->from('customer');
        
        $join_condition = "booking.customer_id = customer.customer_id AND booking.booking_status IN ('selesai', 'sedang_berlangsung')";
        if ($start_date && $end_date) {
            $join_condition .= " AND booking.tanggal_keberangkatan >= " . $this->db->escape($start_date) . " AND booking.tanggal_keberangkatan <= " . $this->db->escape($end_date);
        }
        
        $this->db->join('booking', $join_condition, 'left');
        $this->db->group_by('customer.customer_id');
        $this->db->order_by('total_belanja', 'DESC');
        
        return $this->db->get()->result_array();
    }
}
