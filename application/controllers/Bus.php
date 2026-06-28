<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bus extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Bus_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }

        // Hanya admin operasional dan superadmin yang bisa akses CRUD bus
        if ($this->session->userdata('role') != 'operasional' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['bus'] = $this->Bus_model->get_all();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('bus/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $fasilitas = $this->input->post('fasilitas');
        $fasilitas_str = $fasilitas ? implode(', ', $fasilitas) : '';

        $data = [
            'bus_nama' => $this->input->post('bus_nama'),
            'kapasitas' => $this->input->post('kapasitas'),
            'tipe_bus' => $this->input->post('tipe_bus'),
            'deskripsi' => $this->input->post('deskripsi'),
            'fasilitas' => $fasilitas_str,
            'harga_dalam_kota' => $this->input->post('harga_dalam_kota'),
            'harga_luar_kota' => $this->input->post('harga_luar_kota'),
            'status' => $this->input->post('status')
        ];

        // Proses upload foto jika admin memilih file
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './assets/img/bus/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $data['foto'] = $this->upload->data('file_name');
            } else {
                // Upload gagal — tampilkan pesan eror dan batalkan penyimpanan
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('bus');
                return;
            }
        }

        $this->Bus_model->insert($data);
        $this->session->set_flashdata('success', 'Data bus berhasil ditambahkan.');
        redirect('bus');
    }

    public function edit() {
        $id = $this->input->post('bus_id');
        $fasilitas = $this->input->post('fasilitas');
        $fasilitas_str = $fasilitas ? implode(', ', $fasilitas) : '';

        $data = [
            'bus_nama' => $this->input->post('bus_nama'),
            'kapasitas' => $this->input->post('kapasitas'),
            'tipe_bus' => $this->input->post('tipe_bus'),
            'deskripsi' => $this->input->post('deskripsi'),
            'fasilitas' => $fasilitas_str,
            'harga_dalam_kota' => $this->input->post('harga_dalam_kota'),
            'harga_luar_kota' => $this->input->post('harga_luar_kota'),
            'status' => $this->input->post('status')
        ];

        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './assets/img/bus/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $old = $this->db->get_where('bus', ['bus_id' => $id])->row();
                if ($old && $old->foto) { @unlink('./assets/img/bus/' . $old->foto); }
                $data['foto'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('bus');
                return;
            }
        }
        $this->Bus_model->update($id, $data);
        redirect('bus');
    }

    public function hapus($id) {
        // Hapus file foto fisik dari server sebelum menghapus data dari database
        $bus = $this->db->get_where('bus', ['bus_id' => $id])->row();
        if ($bus && !empty($bus->foto)) {
            $file_path = './assets/img/bus/' . $bus->foto;
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
        }

        $this->Bus_model->delete($id);
        $this->session->set_flashdata('success', 'Data bus berhasil dihapus.');
        redirect('bus');
    }
}
