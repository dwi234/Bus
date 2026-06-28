<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

    /**
     * Buat notifikasi baru
     * @param string $title    Judul singkat notifikasi
     * @param string $message  Pesan lengkap notifikasi
     * @param string $role     Target role: 'superadmin', 'reservasi', 'operasional', atau 'all'
     * @param int|null $booking_id  ID booking terkait (opsional)
     * @param string $type     Tipe notifikasi: 'info', 'warning', 'success', 'danger'
     */
    public function create($title, $message, $role, $booking_id = null, $type = 'info')
    {
        $data = [
            'title'       => $title,
            'message'     => $message,
            'role_target' => $role,
            'booking_id'  => $booking_id,
            'type'        => $type,
            'is_read'     => 0,
            'created_at'  => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('notifications', $data);
    }

    /**
     * Ambil notifikasi berdasarkan role user yang sedang login.
     * Juga mengambil notifikasi bertarget 'all'.
     * @param string $role   Role user saat ini
     * @param int    $limit  Jumlah notifikasi yang diambil
     * @return array
     */
    public function get_by_role($role, $limit = 5)
    {
        $this->db->where_in('role_target', [$role, 'all']);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('notifications')->result_array();
    }

    /**
     * Hitung jumlah notifikasi belum dibaca berdasarkan role.
     * @param string $role  Role user saat ini
     * @return int
     */
    public function count_unread($role)
    {
        $this->db->where_in('role_target', [$role, 'all']);
        $this->db->where('is_read', 0);
        return $this->db->count_all_results('notifications');
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     * @param int $notification_id
     */
    public function mark_as_read($notification_id)
    {
        $this->db->where('notification_id', $notification_id);
        return $this->db->update('notifications', ['is_read' => 1]);
    }

    /**
     * Tandai semua notifikasi untuk role tertentu sebagai sudah dibaca.
     * @param string $role
     */
    public function mark_all_read($role)
    {
        $this->db->where_in('role_target', [$role, 'all']);
        $this->db->where('is_read', 0);
        return $this->db->update('notifications', ['is_read' => 1]);
    }
}
