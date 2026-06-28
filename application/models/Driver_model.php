<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_model extends CI_Model {
    public function get_all() {
        $this->db->select('driver.*, bus.bus_nama');
        $this->db->from('driver');
        $this->db->join('bus', 'bus.bus_id = driver.bus_id', 'left');
        $this->db->order_by('driver.driver_id', 'DESC');
        return $this->db->get()->result_array();
    }
    public function insert($data) {
        return $this->db->insert('driver', $data);
    }
    public function update($id, $data) {
        $this->db->where('driver_id', $id);
        return $this->db->update('driver', $data);
    }
    public function delete($id) {
        $this->db->where('driver_id', $id);
        return $this->db->delete('driver');
    }

    public function get_activity($start_date = null, $end_date = null) {
        $this->db->select('driver.*, bus.bus_nama, bus.tipe_bus, COUNT(jadwal.jadwal_id) as total_trip');
        $this->db->from('driver');
        $this->db->join('bus', 'bus.bus_id = driver.bus_id', 'left');
        
        $join_condition = 'jadwal.driver_id = driver.driver_id';
        if ($start_date && $end_date) {
            $join_condition .= " AND jadwal.tangal_mulai >= " . $this->db->escape($start_date) . " AND jadwal.tangal_mulai <= " . $this->db->escape($end_date);
        }
        $this->db->join('jadwal', $join_condition, 'left');
        $this->db->group_by('driver.driver_id');
        $this->db->order_by('bus.tipe_bus', 'ASC');
        $this->db->order_by('total_trip', 'DESC');
        
        return $this->db->get()->result_array();
    }
}
