<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermanagement extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Admin_model');

        // Cek login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }

        // Hanya superadmin yang bisa akses
        if ($this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Hanya Superadmin yang dapat mengelola user.');
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['admins'] = $this->Admin_model->get_all();
        $data['total_superadmin'] = $this->Admin_model->count_by_role('superadmin');
        $data['total_operasional'] = $this->Admin_model->count_by_role('operasional');
        $data['total_reservasi'] = $this->Admin_model->count_by_role('reservasi');

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('user_management/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $username = $this->input->post('username');

        // Cek username sudah ada
        if ($this->Admin_model->is_username_exists($username)) {
            $this->session->set_flashdata('error', 'Username "' . $username . '" sudah digunakan!');
            redirect('usermanagement');
        }

        $data = [
            'username' => $username,
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'role' => $this->input->post('role')
        ];

        $this->Admin_model->insert($data);
        $this->session->set_flashdata('success', 'Akun admin berhasil ditambahkan.');
        redirect('usermanagement');
    }

    public function edit()
    {
        $id = $this->input->post('admin_id');
        $username = $this->input->post('username');

        // Cek duplikat username (kecuali diri sendiri)
        if ($this->Admin_model->is_username_exists($username, $id)) {
            $this->session->set_flashdata('error', 'Username "' . $username . '" sudah digunakan user lain!');
            redirect('usermanagement');
        }

        $data = [
            'username' => $username,
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'role' => $this->input->post('role')
        ];

        // Jika password diisi, update password juga
        $new_password = $this->input->post('password');
        if (!empty($new_password)) {
            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $this->Admin_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data admin berhasil diperbarui.');
        redirect('usermanagement');
    }

    public function hapus($id)
    {
        // Jangan izinkan menghapus akun sendiri
        if ($id == $this->session->userdata('admin_id')) {
            $this->session->set_flashdata('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
            redirect('usermanagement');
        }

        // Jangan izinkan hapus superadmin terakhir
        $admin = $this->Admin_model->get_by_id($id);
        if ($admin && $admin['role'] == 'superadmin') {
            $count = $this->Admin_model->count_by_role('superadmin');
            if ($count <= 1) {
                $this->session->set_flashdata('error', 'Tidak bisa menghapus Superadmin terakhir!');
                redirect('usermanagement');
            }
        }

        $this->Admin_model->delete($id);
        $this->session->set_flashdata('success', 'Akun admin berhasil dihapus.');
        redirect('usermanagement');
    }

    public function reset_password($id)
    {
        $admin = $this->Admin_model->get_by_id($id);
        if (!$admin) {
            $this->session->set_flashdata('error', 'Admin tidak ditemukan.');
            redirect('usermanagement');
        }

        // Reset ke password default: username + "123"
        $default_password = $admin['username'] . '123';
        $this->Admin_model->update($id, [
            'password' => password_hash($default_password, PASSWORD_DEFAULT)
        ]);

        $this->session->set_flashdata('success', 'Password "' . $admin['username'] . '" direset menjadi: <strong>' . $default_password . '</strong>');
        redirect('usermanagement');
    }
}
