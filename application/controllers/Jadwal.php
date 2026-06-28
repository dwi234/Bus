<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Jadwal_model');
        $this->load->model('Booking_model');
        $this->load->model('Bus_model');
        $this->load->model('Driver_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }

        // Hanya admin operasional dan superadmin yang bisa akses CRUD jadwal
        if ($this->session->userdata('role') != 'operasional' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['jadwal'] = $this->Jadwal_model->get_all();
        $data['booking'] = $this->Booking_model->get_all();
        $data['bus'] = $this->Bus_model->get_all();
        $data['driver'] = $this->Driver_model->get_all();
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('jadwal/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $bus_id = $this->input->post('bus_id');
        $driver_id = $this->input->post('driver_id');
        $start_date = $this->input->post('tangal_mulai');
        $end_date = $this->input->post('tanggal_selesai');

        // Jika driver_id kosong, simpan sebagai NULL agar tidak melanggar foreign key constraint
        if (empty($driver_id)) {
            $driver_id = NULL;
        }

        // Pengecekan bentrok
        if ($this->Jadwal_model->check_conflict($bus_id, $driver_id, $start_date, $end_date)) {
            $this->session->set_flashdata('error', 'Gagal menyimpan! Bus atau Supir tersebut sudah memiliki jadwal pada rentang tanggal yang dipilih.');
            redirect('jadwal');
            return;
        }

        $data = [
            'booking_id' => $this->input->post('booking_id'),
            'bus_id' => $bus_id,
            'driver_id' => $driver_id,
            'tangal_mulai' => $start_date,
            'tanggal_selesai' => $end_date
        ];
        $this->Jadwal_model->insert($data);
        $this->session->set_flashdata('success', 'Jadwal berhasil ditambahkan.');
        redirect('jadwal');
    }

    public function edit() {
        $id = $this->input->post('jadwal_id');
        $bus_id = $this->input->post('bus_id');
        $driver_id = $this->input->post('driver_id');
        $start_date = $this->input->post('tangal_mulai');
        $end_date = $this->input->post('tanggal_selesai');

        // Jika driver_id kosong, simpan sebagai NULL agar tidak melanggar foreign key constraint
        if (empty($driver_id)) {
            $driver_id = NULL;
        }

        // Pengecekan bentrok (exclude ID saat ini)
        if ($this->Jadwal_model->check_conflict($bus_id, $driver_id, $start_date, $end_date, $id)) {
            $this->session->set_flashdata('error', 'Gagal mengupdate! Bus atau Supir tersebut sudah memiliki jadwal pada rentang tanggal yang dipilih.');
            redirect('jadwal');
            return;
        }

        $data = [
            'booking_id' => $this->input->post('booking_id'),
            'bus_id' => $bus_id,
            'driver_id' => $driver_id,
            'tangal_mulai' => $start_date,
            'tanggal_selesai' => $end_date
        ];
        $this->Jadwal_model->update($id, $data);
        $this->session->set_flashdata('success', 'Jadwal berhasil diupdate.');
        redirect('jadwal');
    }

    public function hapus($id) {
        $this->Jadwal_model->delete($id);
        redirect('jadwal');
    }
}
