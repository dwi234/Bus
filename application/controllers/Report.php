<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Booking_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }
    }

    /** Validasi format tanggal Y-m-d */
    private function _validate_date($date_string) {
        $d = DateTime::createFromFormat('Y-m-d', $date_string);
        return $d && $d->format('Y-m-d') === $date_string;
    }

    /** Sanitize input report: tanggal & status */
    private function _sanitize_report_inputs() {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $status = $this->input->get('status');

        if ($start_date && !$this->_validate_date($start_date)) $start_date = null;
        if ($end_date && !$this->_validate_date($end_date)) $end_date = null;

        $allowed = ['all','pending','menunggu_verifikasi','uang_muka_dibayarkan',
                    'menunggu_pelunasan','siap_berangkat','sedang_berlangsung','selesai','batal'];
        if ($status && !in_array($status, $allowed)) $status = 'all';

        return [$start_date, $end_date, $status];
    }

    // Laporan Pendapatan - hanya superadmin
    public function index() {
        if ($this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }

        list($start_date, $end_date, $status) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['status'] = $status ? $status : 'all';

        $data['reports'] = $this->Booking_model->get_reports($start_date, $end_date, $data['status']);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/index', $data);
        $this->load->view('templates/footer');
    }

    // Print Laporan Pendapatan - hanya superadmin
    public function print() {
        if ($this->session->userdata('role') != 'superadmin') {
            redirect('dashboard');
        }

        list($start_date, $end_date, $status) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['status'] = $status ? $status : 'all';

        $data['reports'] = $this->Booking_model->get_reports($start_date, $end_date, $data['status']);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Pendapatan.xls");

        $this->load->view('report/print', $data);
    }

    // Utilisasi Bus - hanya operasional
    public function bus() {
        if ($this->session->userdata('role') != 'operasional' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }

        $this->load->model('Bus_model');
        list($start_date, $end_date, ) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['reports'] = $this->Bus_model->get_utilization($start_date, $end_date);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/bus', $data);
        $this->load->view('templates/footer');
    }

    // Print Utilisasi Bus - hanya operasional
    public function print_bus() {
        if ($this->session->userdata('role') != 'operasional' && $this->session->userdata('role') != 'superadmin') {
            redirect('dashboard');
        }

        $this->load->model('Bus_model');
        list($start_date, $end_date, ) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['reports'] = $this->Bus_model->get_utilization($start_date, $end_date);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Utilisasi_Bus.xls");

        $this->load->view('report/print_bus', $data);
    }

    // Aktivitas Supir - hanya operasional
    public function driver() {
        if ($this->session->userdata('role') != 'operasional' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }

        $this->load->model('Driver_model');
        list($start_date, $end_date, ) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['reports'] = $this->Driver_model->get_activity($start_date, $end_date);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/driver', $data);
        $this->load->view('templates/footer');
    }

    // Print Aktivitas Supir - hanya operasional
    public function print_driver() {
        if ($this->session->userdata('role') != 'operasional' && $this->session->userdata('role') != 'superadmin') {
            redirect('dashboard');
        }

        $this->load->model('Driver_model');
        list($start_date, $end_date, ) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['reports'] = $this->Driver_model->get_activity($start_date, $end_date);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Aktivitas_Supir.xls");

        $this->load->view('report/print_driver', $data);
    }

    // Transaksi Pelanggan - hanya reservasi
    public function customer() {
        if ($this->session->userdata('role') != 'reservasi' && $this->session->userdata('role') != 'superadmin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }

        $this->load->model('Customer_model');
        list($start_date, $end_date, ) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['reports'] = $this->Customer_model->get_transactions($start_date, $end_date);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/customer', $data);
        $this->load->view('templates/footer');
    }

    // Print Transaksi Pelanggan - hanya reservasi
    public function print_customer() {
        if ($this->session->userdata('role') != 'reservasi' && $this->session->userdata('role') != 'superadmin') {
            redirect('dashboard');
        }

        $this->load->model('Customer_model');
        list($start_date, $end_date, ) = $this->_sanitize_report_inputs();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['reports'] = $this->Customer_model->get_transactions($start_date, $end_date);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Transaksi_Pelanggan.xls");

        $this->load->view('report/print_customer', $data);
    }
}
