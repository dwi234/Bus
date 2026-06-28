<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Driver_model');
        $this->load->model('Bus_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }

        // Hanya admin operasional dan superadmin yang bisa akses CRUD driver
        if ($this->session->userdata('role') != 'operasional' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['driver'] = $this->Driver_model->get_all();
        $data['buses'] = $this->Bus_model->get_all();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('driver/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $status = $this->input->post('status');
        $keterangan = ($status == 'tidak bisa bertugas') ? $this->input->post('keterangan') : null;
        
        $data = [
            'nama' => $this->input->post('nama'),
            'tlp' => $this->input->post('tlp'),
            'bus_id' => $this->input->post('bus_id'),
            'status' => $status,
            'keterangan' => $keterangan
        ];
        $this->Driver_model->insert($data);
        redirect('driver');
    }

    public function edit() {
        $id = $this->input->post('driver_id');
        $status = $this->input->post('status');
        $keterangan = ($status == 'tidak bisa bertugas') ? $this->input->post('keterangan') : null;

        $data = [
            'nama' => $this->input->post('nama'),
            'tlp' => $this->input->post('tlp'),
            'bus_id' => $this->input->post('bus_id'),
            'status' => $status,
            'keterangan' => $keterangan
        ];
        $this->Driver_model->update($id, $data);
        redirect('driver');
    }

    public function hapus($id) {
        $this->Driver_model->delete($id);
        redirect('driver');
    }
}
