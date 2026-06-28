<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Notification_model');

        // Cek login
        if (!$this->session->userdata('status') || $this->session->userdata('status') != 'login') {
            redirect('auth/login');
        }
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca (AJAX)
     */
    public function mark_read()
    {
        $id = (int) $this->input->post('notification_id');
        if ($id) {
            $this->Notification_model->mark_as_read($id);
        }
        echo json_encode(['status' => 'ok']);
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca (AJAX)
     */
    public function mark_all_read()
    {
        $role = $this->session->userdata('role');
        $this->Notification_model->mark_all_read($role);
        echo json_encode(['status' => 'ok']);
    }
}
