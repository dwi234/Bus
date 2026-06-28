<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Notification_model');
    }

    public function form($token = null)
    {
        if (!$token) {
            show_error('Token tidak valid atau sudah kadaluarsa.', 400, 'Akses Ditolak');
        }

        // Cari booking dengan token tersebut
        $this->db->select('booking.*, customer.nama as customer_name, bus.bus_nama');
        $this->db->from('booking');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id');
        $this->db->where('booking.review_token', $token);
        $booking = $this->db->get()->row_array();

        if (!$booking) {
            show_error('Ulasan sudah pernah dikirim atau token tidak valid.', 404, 'Halaman Tidak Ditemukan');
        }

        $data['booking'] = $booking;
        $data['token'] = $token;

        $this->load->view('public/review_form', $data);
    }

    public function submit()
    {
        $token = $this->input->post('token');
        $rating = $this->input->post('rating');
        $review_text = $this->input->post('review_text');

        if (!$token || !$rating) {
            $this->session->set_flashdata('error', 'Rating harus diisi.');
            redirect('review/form/' . $token);
            return;
        }

        $booking = $this->db->get_where('booking', ['review_token' => $token])->row_array();

        if (!$booking) {
            show_error('Token tidak valid.', 400, 'Akses Ditolak');
        }

        // Insert review
        $review_data = [
            'booking_id'  => $booking['booking_id'],
            'bus_id'      => $booking['bus_id'],
            'customer_id' => $booking['customer_id'],
            'rating'      => $rating,
            'review_text' => $review_text,
            'created_at'  => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('reviews', $review_data);

        // === NOTIFIKASI: Beritahu Superadmin jika rating rendah (≤ 2 bintang) ===
        if ((int)$rating <= 2) {
            $this->Notification_model->create(
                'Ulasan Negatif Diterima',
                'Customer memberikan rating ' . $rating . '/5 untuk Booking #BK-' . str_pad($booking['booking_id'], 4, '0', STR_PAD_LEFT) . '. Segera tinjau kualitas layanan.',
                'superadmin',
                $booking['booking_id'],
                'danger'
            );
        }

        // Hapus token agar tidak bisa diisi 2x
        $this->db->where('booking_id', $booking['booking_id']);
        $this->db->update('booking', [
            'review_token' => NULL
        ]);

        $this->session->set_flashdata('success', 'Terima kasih! Ulasan Anda sangat berarti untuk meningkatkan kualitas layanan kami.');
        // Redirect back to a success view or just home
        redirect('home');
    }
}
