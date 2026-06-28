<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('session');
    }

    public function login()
    {
        $this->load->view('login_view');
    }

    public function proses_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $admin = $this->Admin_model->getAdmin($username);

        if ($admin) {

            // CEK PASSWORD
            if (password_verify($password, $admin['password'])) {

                $data = [
                    'admin_id' => $admin['admin_id'],
                    'username' => $admin['username'],
                    'nama_lengkap' => $admin['nama_lengkap'],
                    'role' => $admin['role'],
                    'status' => 'login'
                ];

                $this->session->set_userdata($data);
                redirect('dashboard');

            } else {
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('auth/login');
            }

        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan!');
            redirect('auth/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    // AJAX: Verify username exists
    public function verify_username()
    {
        $username = $this->input->post('username');

        if (empty($username)) {
            echo json_encode(['status' => 'error', 'message' => 'Username tidak boleh kosong!']);
            return;
        }

        $admin = $this->Admin_model->getAdmin($username);

        if ($admin) {
            echo json_encode(['status' => 'success', 'message' => 'Username ditemukan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Username tidak ditemukan!']);
        }
    }

    // AJAX: Reset password
    public function reset_password()
    {
        $username = $this->input->post('username');
        $new_password = $this->input->post('new_password');

        if (empty($username) || empty($new_password)) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap!']);
            return;
        }

        if (strlen($new_password) < 4) {
            echo json_encode(['status' => 'error', 'message' => 'Password minimal 4 karakter!']);
            return;
        }

        $admin = $this->Admin_model->getAdmin($username);

        if (!$admin) {
            echo json_encode(['status' => 'error', 'message' => 'Username tidak ditemukan!']);
            return;
        }

        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $result = $this->Admin_model->updatePassword($username, $hashed);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Password berhasil direset! Silakan login.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mereset password.']);
        }
    }
}