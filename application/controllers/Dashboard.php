<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        // Cek apakah user sudah login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $this->load->model('Jadwal_model');
        $this->load->model('Booking_model');

        $role = $this->session->userdata('role');
        $data['role'] = $role;

        // --- FILTER PERIODE ---
        $month = (int) ($this->input->get('filter_month') ?: date('m'));
        $year = (int) ($this->input->get('filter_year') ?: date('Y'));
        
        $data['filter_month'] = $month;
        $data['filter_year'] = $year;

        // Ambil statistik perbandingan
        $monthly_stats = $this->Booking_model->get_comparison_stats($month, $year);

        // Gabung count bus + driver dalam 1 query (sebelumnya 2 query terpisah)
        $counts = $this->db->query(
            "SELECT (SELECT COUNT(*) FROM bus) as total_bus, (SELECT COUNT(*) FROM driver) as total_driver"
        )->row();
        $data['total_bus'] = $counts->total_bus;
        $data['total_driver'] = $counts->total_driver;

        // Data berdasarkan filter
        $data['total_booking'] = $monthly_stats['current']['total_booking'];
        $data['active_bookers'] = $monthly_stats['current']['active_bookers'];
        $data['growth_percentage'] = $monthly_stats['growth_percentage'];
        $data['revenue_mtd'] = $monthly_stats['current']['revenue'];

        $data['upcoming_jadwal'] = $this->Jadwal_model->get_upcoming(5);
        $data['recent_pending'] = $this->Booking_model->get_recent_pending(5);

        // --- NEW DASHBOARD STATS ---

        // Pending Payments
        $this->db->where('booking_status', 'pending');
        $data['pending_payment'] = $this->db->count_all_results('booking');

        // Active Trips (Jadwal for today)
        $this->db->where('tangal_mulai <=', date('Y-m-d'));
        $this->db->where('tanggal_selesai >=', date('Y-m-d'));
        $data['active_trips'] = $this->db->count_all_results('jadwal');
        
        // Recent Activity — select hanya field yang dipakai di view
        $this->db->select('booking.booking_id, booking.booking_status, booking.tanggal_keberangkatan, booking.total_harga, customer.nama as customer_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->order_by('booking_id', 'DESC');
        $this->db->limit(5);
        $data['recent_activity'] = $this->db->get()->result_array();
        // ---------------------------

        // Chart Data Processing (Last 7 Days)
        $raw_income = $this->Booking_model->get_income_last_7_days();
        $chart_labels = [];
        $chart_data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $chart_labels[] = date('d M', strtotime($date));
            
            $income = 0;
            foreach ($raw_income as $row) {
                if ($row['tanggal'] == $date) {
                    $income = $row['total_pendapatan'];
                    break;
                }
            }
            $chart_data[] = $income;
        }

        $data['chart_labels'] = json_encode($chart_labels);
        $data['chart_data'] = json_encode($chart_data);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
}
