 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {
    public function get_all() {
        $this->db->select('jadwal.*, bus.bus_nama, bus.tipe_bus, driver.nama as driver_nama, driver.tlp as driver_tlp, booking.tempat_tujuan, booking.lokasi_penjemputan, customer.nama as customer_nama');
        $this->db->from('jadwal');
        $this->db->join('bus', 'bus.bus_id = jadwal.bus_id', 'left');
        $this->db->join('driver', 'driver.driver_id = jadwal.driver_id', 'left');
        $this->db->join('booking', 'booking.booking_id = jadwal.booking_id', 'left');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->order_by('jadwal_id', 'DESC');
        return $this->db->get()->result_array();
    }
    public function get_upcoming($limit = 5) {
        $this->db->select('jadwal.*, bus.bus_nama, bus.tipe_bus, driver.nama as driver_nama, driver.tlp as driver_tlp, booking.tempat_tujuan, booking.lokasi_penjemputan, customer.nama as customer_nama');
        $this->db->from('jadwal');
        $this->db->join('bus', 'bus.bus_id = jadwal.bus_id', 'left');
        $this->db->join('driver', 'driver.driver_id = jadwal.driver_id', 'left');
        $this->db->join('booking', 'booking.booking_id = jadwal.booking_id', 'left');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->where('jadwal.tangal_mulai >=', date('Y-m-d'));
        $this->db->order_by('jadwal.tangal_mulai', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
    public function insert($data) {
        return $this->db->insert('jadwal', $data);
    }
    public function update($id, $data) {
        $this->db->where('jadwal_id', $id);
        return $this->db->update('jadwal', $data);
    }
    public function delete($id) {
        $this->db->where('jadwal_id', $id);
        return $this->db->delete('jadwal');
    }

    public function check_conflict($bus_id, $driver_id, $start_date, $end_date, $exclude_jadwal_id = null) {
        // Jika driver_id kosong, kita hanya mengecek konflik untuk bus
        if ($driver_id) {
            $sql = "SELECT COUNT(*) as cnt FROM jadwal
                    WHERE (bus_id = ? OR driver_id = ?)
                      AND ((? BETWEEN tangal_mulai AND tanggal_selesai)
                        OR (? BETWEEN tangal_mulai AND tanggal_selesai)
                        OR (tangal_mulai BETWEEN ? AND ?))";
            $params = array($bus_id, $driver_id, $start_date, $end_date, $start_date, $end_date);
        } else {
            $sql = "SELECT COUNT(*) as cnt FROM jadwal
                    WHERE bus_id = ?
                      AND ((? BETWEEN tangal_mulai AND tanggal_selesai)
                        OR (? BETWEEN tangal_mulai AND tanggal_selesai)
                        OR (tangal_mulai BETWEEN ? AND ?))";
            $params = array($bus_id, $start_date, $end_date, $start_date, $end_date);
        }

        if ($exclude_jadwal_id) {
            $sql .= " AND jadwal_id != ?";
            $params[] = $exclude_jadwal_id;
        }

        $row = $this->db->query($sql, $params)->row();
        return $row->cnt > 0;
    }
}
