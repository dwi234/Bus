<?php
class Admin_model extends CI_Model {

    public function getAdmin($username)
    {
        return $this->db->get_where('admin', [
            'username' => $username
        ])->row_array();
    }

    public function updatePassword($username, $hashed_password)
    {
        $this->db->where('username', $username);
        return $this->db->update('admin', ['password' => $hashed_password]);
    }

    // ===== User Management Methods =====

    public function get_all()
    {
        $this->db->order_by('admin_id', 'DESC');
        return $this->db->get('admin')->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('admin', ['admin_id' => $id])->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert('admin', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('admin_id', $id);
        return $this->db->update('admin', $data);
    }

    public function delete($id)
    {
        $this->db->where('admin_id', $id);
        return $this->db->delete('admin');
    }

    public function is_username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('admin_id !=', $exclude_id);
        }
        return $this->db->count_all_results('admin') > 0;
    }

    public function count_by_role($role)
    {
        return $this->db->where('role', $role)->count_all_results('admin');
    }
}