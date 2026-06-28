<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Customer_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }

        // Hanya admin reservasi dan superadmin yang bisa akses CRUD customer
        if ($this->session->userdata('role') != 'reservasi' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['customer'] = $this->Customer_model->get_all();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $data = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'tlp' => $this->input->post('tlp'),
            'alamat' => $this->input->post('alamat')
        ];
        $this->Customer_model->insert($data);
        redirect('customer');
    }

    public function edit() {
        $id = $this->input->post('customer_id');
        $data = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'tlp' => $this->input->post('tlp'),
            'alamat' => $this->input->post('alamat')
        ];
        $this->Customer_model->update($id, $data);
        redirect('customer');
    }

    public function hapus($id) {
        $has_booking = $this->Customer_model->has_booking($id);
        if ($has_booking) {
            $this->session->set_flashdata('error', 'Gagal menghapus data. Pelanggan ini memiliki riwayat pemesanan di sistem.');
        } else {
            $this->Customer_model->delete($id);
            $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus.');
        }
        redirect('customer');
    }
}
