<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bus_model');
        $this->load->model('Booking_model');
        $this->load->model('Customer_model');
        $this->load->model('Notification_model');
        $this->load->library('session');
        // NOTE: auto_check_deadlines() moved to Cron controller only
    }

    /**
     * Validasi format tanggal Y-m-d — mencegah SQL injection via field tanggal
     */
    private function _validate_date($date_string) {
        $d = DateTime::createFromFormat('Y-m-d', $date_string);
        return $d && $d->format('Y-m-d') === $date_string;
    }

    /**
     * Landing Page - Public (No Login Required)
     */
    public function index()
    {
        // Ambil ulasan terbaru untuk slider di beranda (misal 10 terbaru dengan rating >= 4)
        $this->db->select('reviews.*, customer.nama as customer_name');
        $this->db->from('reviews');
        $this->db->join('customer', 'customer.customer_id = reviews.customer_id', 'left');
        $this->db->where('reviews.rating >=', 4);
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit(10);
        $data['reviews'] = $this->db->get()->result_array();

        // Hitung rata-rata rating dan total ulasan
        $this->db->select_avg('rating', 'avg_rating');
        $this->db->select('COUNT(review_id) as total_reviews');
        $stats = $this->db->get('reviews')->row_array();
        
        $data['avg_rating'] = $stats['avg_rating'] ? round($stats['avg_rating'], 1) : 5.0;
        $data['total_reviews'] = $stats['total_reviews'] ? $stats['total_reviews'] : 0;

        $this->load->view('public/beranda', $data);
    }


    /**
     * Booking Form Page
     */
    public function bus_detail($bus_id)
    {
        $bus_id = (int) $bus_id;
        $this->load->model('Bus_model');
        $bus = $this->Bus_model->get_by_id($bus_id);
        
        if (!$bus) {
            show_404();
        }

        // Ambil ulasan
        $this->db->select('reviews.*, customer.nama as customer_name');
        $this->db->from('reviews');
        $this->db->join('customer', 'customer.customer_id = reviews.customer_id');
        $this->db->where('reviews.bus_id', $bus_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        $data['reviews'] = $this->db->get()->result_array();

        $data['bus'] = $bus;
        $this->load->view('public/bus_detail', $data);
    }

    public function booking_page()
    {
        $data['buses'] = $this->Bus_model->get_all_light();
        $this->load->view('public/booking', $data);
    }

    /**
     * Bus Catalog - Dedicated Page
     */
    public function bus_catalog()
    {
        $data['buses'] = $this->Bus_model->get_all();
        // Pass buses unavailable today so catalog marks them without requiring date filter
        $today = date('Y-m-d');
        $data['unavailable_today'] = $this->Bus_model->get_unavailable_bus_ids($today, $today);
        $this->load->view('public/bus_catalog', $data);
    }

    /**
     * API for Real-Time Availability Check
     */
    public function check_availability()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if (!$start_date || !$end_date || !$this->_validate_date($start_date) || !$this->_validate_date($end_date)) {
            echo json_encode([]);
            return;
        }

        $unavailable_ids = $this->Bus_model->get_unavailable_bus_ids($start_date, $end_date);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($unavailable_ids));
    }

    /**
     * Process Guest Booking
     */
    public function booking()
    {
        if (!$this->session->userdata('guest_email')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk melakukan pemesanan.');
            redirect('home/guest_login');
            return;
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'No. WhatsApp', 'required|trim');
        $this->form_validation->set_rules('bus_id', 'Bus', 'required');
        $this->form_validation->set_rules('tanggal_keberangkatan', 'Tanggal Berangkat', 'required');
        $this->form_validation->set_rules('tanggal_pulang', 'Tanggal Pulang', 'required');
        $this->form_validation->set_rules('lokasi_penjemputan', 'Lokasi Penjemputan', 'required|trim');
        $this->form_validation->set_rules('tempat_tujuan', 'Tempat Tujuan', 'required|trim');
        $this->form_validation->set_rules('tipe_perjalanan', 'Tipe Perjalanan', 'required|in_list[dalam_kota,luar_kota]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('home/booking_page');
            return;
        }

        // --- BACKEND AVAILABILITY CHECK ---
        $bus_id = (int) $this->input->post('bus_id');
        $start_date = $this->input->post('tanggal_keberangkatan');
        $end_date = $this->input->post('tanggal_pulang');

        // Validasi format tanggal sebelum query
        if (!$this->_validate_date($start_date) || !$this->_validate_date($end_date)) {
            $this->session->set_flashdata('error', 'Format tanggal tidak valid.');
            redirect('home/booking_page');
            return;
        }
        
        $unavailable_ids = $this->Bus_model->get_unavailable_bus_ids($start_date, $end_date);
        if (in_array($bus_id, $unavailable_ids)) {
            $this->session->set_flashdata('error', 'Maaf, Bus yang Anda pilih tidak tersedia untuk tanggal tersebut (sudah dipesan atau sedang dalam masa perbaikan/maintenance). Silakan pilih bus lain.');
            redirect('home/booking_page');
            return;
        }
        // ----------------------------------

        $customer_id = $this->session->userdata('guest_id');

        // Update customer details from the booking form
        $update_data = [
            'nama'   => $this->input->post('nama'),
            'tlp'    => $this->input->post('no_telp'),
        ];
        if ($this->input->post('alamat')) {
            $update_data['alamat'] = $this->input->post('alamat');
        }
        $this->db->where('customer_id', $customer_id)->update('customer', $update_data);
        
        // Update session name if changed
        if ($this->session->userdata('guest_name') !== $update_data['nama']) {
            $this->session->set_userdata('guest_name', $update_data['nama']);
        }

        // 2. Get bus price
        $bus = $this->db->where('bus_id', $this->input->post('bus_id'))->get('bus')->row_array();
        
        if (!$bus) {
            $this->session->set_flashdata('error', 'Bus tidak ditemukan.');
            redirect('home');
            return;
        }

        // Calculate days
        $tgl_berangkat = new DateTime($this->input->post('tanggal_keberangkatan'));
        $tgl_pulang    = new DateTime($this->input->post('tanggal_pulang'));
        $selisih       = $tgl_berangkat->diff($tgl_pulang);
        $jumlah_hari   = $selisih->days > 0 ? $selisih->days : 1;

        $tipe_perjalanan = $this->input->post('tipe_perjalanan');
        $harga_sewa = $tipe_perjalanan == 'dalam_kota' ? $bus['harga_dalam_kota'] : $bus['harga_luar_kota'];
        $total_harga = $harga_sewa * $jumlah_hari;
        
        // Generate unique code (3 digit) for payment verification
        $kode_unik  = rand(100, 999);
        $total_bayar = $total_harga + $kode_unik;
        $dp_amount   = (0.3 * $total_harga) + $kode_unik; // DP 30% dari total + kode unik

        // 3. Insert booking
        $booking_data = [
            'customer_id'           => $customer_id,
            'bus_id'                => $this->input->post('bus_id'),
            'tanggal_keberangkatan' => $this->input->post('tanggal_keberangkatan'),
            'tanggal_pulang'        => $this->input->post('tanggal_pulang'),
            'lokasi_penjemputan'    => $this->input->post('lokasi_penjemputan'),
            'tempat_tujuan'         => $this->input->post('tempat_tujuan'),
            'tipe_perjalanan'       => $tipe_perjalanan,
            'total_harga'           => $total_harga,
            'kode_unik'             => $kode_unik,
            'dp_nominal'            => $dp_amount,
            'booking_status'        => 'pending',
            'batas_waktu_bayar'     => date('Y-m-d H:i:s', strtotime('+2 hours')), // Batas waktu 2 Jam
        ];

        $this->Booking_model->insert($booking_data);
        $booking_id = $this->db->insert_id();

        // === NOTIFIKASI: Beritahu Admin Reservasi ada pesanan baru ===
        $customer_name = $this->input->post('nama');
        $this->Notification_model->create(
            'Pesanan Baru',
            'Pesanan baru #BK-' . str_pad($booking_id, 4, '0', STR_PAD_LEFT) . ' dari ' . $customer_name . '. Menunggu pembayaran DP.',
            'reservasi',
            $booking_id,
            'info'
        );

        // 4. Redirect to voucher page
        $this->session->set_userdata('guest_booking', [
            'booking_id'   => $booking_id,
            'nama'         => $this->input->post('nama'),
            'no_telp'      => $this->input->post('no_telp'),
            'bus_nama'     => $bus['bus_nama'],
            'tgl_berangkat'=> $this->input->post('tanggal_keberangkatan'),
            'tgl_pulang'   => $this->input->post('tanggal_pulang'),
            'penjemputan'  => $this->input->post('lokasi_penjemputan'),
            'tujuan'       => $this->input->post('tempat_tujuan'),
            'total_harga'  => $total_harga,
            'kode_unik'    => $kode_unik,
            'dp_amount'    => $dp_amount,
            'jumlah_hari'  => $jumlah_hari,
        ]);

        redirect('home/voucher');
    }

    /**
     * Voucher / Booking Success Page
     */
    public function voucher()
    {
        $guest_booking = $this->session->userdata('guest_booking');
        
        if (!$guest_booking) {
            redirect('home');
            return;
        }
        
        // Ambil data terbaru dari database
        $this->db->select('booking.*, bus.bus_nama, bus.kapasitas');
        $this->db->from('booking');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->where('booking.booking_id', $guest_booking['booking_id']);
        $db_booking = $this->db->get()->row_array();

        if (!$db_booking) {
            redirect('home');
            return;
        }

        // Gabungkan data
        $data['booking'] = array_merge($guest_booking, $db_booking);
        
        $this->load->view('public/voucher', $data);
    }

    /**
     * Guest Login Page
     */
    public function guest_login()
    {
        if ($this->session->userdata('guest_email')) {
            redirect('home/my_bookings');
            return;
        }
        $this->load->view('public/guest_login');
    }

    /**
     * Google Callback Handler
     * Uses proper JWT signature verification via openssl_verify()
     */
    public function google_callback()
    {
        if (!$this->input->post('credential')) {
            $this->session->set_flashdata('error', 'Login gagal. Token tidak ditemukan.');
            redirect('home/guest_login');
            return;
        }

        $credential = $this->input->post('credential');

        // Verify Google ID token with cryptographic signature verification
        $payload = $this->_verify_google_id_token($credential);

        if (!$payload) {
            $this->session->set_flashdata('error', 'Token Google tidak valid atau sudah kadaluarsa.');
            redirect('home/guest_login');
            return;
        }

        $email = filter_var($payload['email'], FILTER_VALIDATE_EMAIL);
        $name = isset($payload['name']) ? htmlspecialchars($payload['name'], ENT_QUOTES, 'UTF-8') : 'Google User';

        if (!$email) {
            $this->session->set_flashdata('error', 'Email tidak valid dari Google.');
            redirect('home/guest_login');
            return;
        }

        // Check if customer exists
        $customer = $this->db->where('email', $email)->get('customer')->row_array();

        if (!$customer) {
            // Register new customer
            $data = [
                'nama' => $name,
                'email' => $email,
                'tlp' => '-',
                'alamat' => '-'
            ];
            $this->db->insert('customer', $data);
            $customer_id = $this->db->insert_id();
        } else {
            $customer_id = $customer['customer_id'];
            // Auto update name if they log in via Google
            $this->db->where('customer_id', $customer_id)->update('customer', ['nama' => $name]);
        }

        $this->session->set_userdata([
            'guest_email' => $email,
            'guest_id'    => $customer_id,
            'guest_name'  => $name
        ]);

        redirect('home/my_bookings');
    }

    /**
     * Guest Logout
     */
    public function guest_logout()
    {
        $this->session->unset_userdata(['guest_email', 'guest_id', 'guest_name']);
        redirect('home');
    }

    // ========================================================================
    // Google OAuth 2.0 ID Token Verification (no Composer required)
    // ========================================================================

    /**
     * Verify a Google ID token using RSA signature verification.
     * Fetches Google's public keys, verifies the JWT signature, and validates claims.
     *
     * @param string $id_token  The raw JWT string from Google Sign-In
     * @return array|false      Decoded payload on success, FALSE on failure
     */
    private function _verify_google_id_token($id_token)
    {
        $parts = explode('.', $id_token);
        if (count($parts) !== 3) {
            return false;
        }

        list($header64, $payload64, $signature64) = $parts;

        // Decode the JWT header to get the key ID (kid)
        $header = json_decode($this->_base64url_decode($header64), true);
        if (!$header || !isset($header['kid'])) {
            return false;
        }

        // Fetch Google's current public keys
        $google_keys = $this->_get_google_public_keys();
        if (!$google_keys || !isset($google_keys[$header['kid']])) {
            return false;
        }

        // Verify the RSA-SHA256 signature
        $signing_input = $header64 . '.' . $payload64;
        $signature = $this->_base64url_decode($signature64);
        $pem_key = $google_keys[$header['kid']];

        $pub_key = openssl_pkey_get_public($pem_key);
        if (!$pub_key) {
            return false;
        }

        $valid = (openssl_verify($signing_input, $signature, $pub_key, OPENSSL_ALGO_SHA256) === 1);
        openssl_pkey_free($pub_key);

        if (!$valid) {
            return false;
        }

        // Decode and validate claims
        $payload = json_decode($this->_base64url_decode($payload64), true);
        if (!$payload) {
            return false;
        }

        // Validate issuer
        $valid_issuers = ['accounts.google.com', 'https://accounts.google.com'];
        if (!in_array($payload['iss'] ?? '', $valid_issuers)) {
            return false;
        }

        // Validate expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        // Validate audience (client ID) if configured
        $client_id = $this->config->item('google_client_id');
        if (!empty($client_id) && isset($payload['aud']) && $payload['aud'] !== $client_id) {
            return false;
        }

        // Validate email is present and verified
        if (empty($payload['email']) || !filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (isset($payload['email_verified']) && $payload['email_verified'] !== true) {
            return false;
        }

        return $payload;
    }

    /**
     * Fetch Google's public signing keys for ID token verification.
     * Results are cached to a file for 1 hour to avoid repeated HTTP requests.
     *
     * @return array|false  Associative array [kid => PEM] or FALSE on failure
     */
    private function _get_google_public_keys()
    {
        $cache_file = APPPATH . 'cache/google_oauth_keys.json';
        $cache_ttl = 3600; // 1 hour

        // Return cached keys if still valid
        if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_ttl) {
            $cached = @json_decode(file_get_contents($cache_file), true);
            if (is_array($cached) && !empty($cached)) {
                return $cached;
            }
        }

        // Fetch current keys from Google
        $ctx = stream_context_create([
            'http' => [
                'timeout' => 5,
                'method'  => 'GET',
                'header'  => "User-Agent: Dheemobilindo/1.0\r\n"
            ]
        ]);

        $response = @file_get_contents('https://www.googleapis.com/oauth2/v3/certs', false, $ctx);
        if (!$response) {
            return false;
        }

        $data = json_decode($response, true);
        if (!isset($data['keys']) || !is_array($data['keys'])) {
            return false;
        }

        $keys = [];
        foreach ($data['keys'] as $jwk) {
            if (isset($jwk['kid'], $jwk['n'], $jwk['e'], $jwk['kty']) && $jwk['kty'] === 'RSA') {
                $pem = $this->_jwk_to_pem($jwk);
                if ($pem) {
                    $keys[$jwk['kid']] = $pem;
                }
            }
        }

        if (!empty($keys)) {
            @file_put_contents($cache_file, json_encode($keys));
        }

        return !empty($keys) ? $keys : false;
    }

    /**
     * Convert a JWK (JSON Web Key) RSA public key to PEM format.
     *
     * @param array $jwk  JWK with 'n' (modulus) and 'e' (exponent) values
     * @return string|false  PEM-encoded public key or FALSE on failure
     */
    private function _jwk_to_pem($jwk)
    {
        $modulus = $this->_base64url_decode($jwk['n']);
        $exponent = $this->_base64url_decode($jwk['e']);

        if ($modulus === false || $exponent === false) {
            return false;
        }

        // Prepend 0x00 to ensure positive integer encoding (high bit set)
        if (ord($modulus[0]) & 0x80) {
            $modulus = "\x00" . $modulus;
        }
        if (ord($exponent[0]) & 0x80) {
            $exponent = "\x00" . $exponent;
        }

        // Build DER-encoded SubjectPublicKeyInfo structure
        $modulus_tlv  = "\x02" . $this->_der_length(strlen($modulus)) . $modulus;
        $exponent_tlv = "\x02" . $this->_der_length(strlen($exponent)) . $exponent;
        $public_key   = "\x03" . $this->_der_length(strlen($modulus_tlv) . strlen($exponent_tlv)) . "\x00" . $modulus_tlv . $exponent_tlv;

        // Algorithm identifier: rsaEncryption (OID 1.2.840.113549.1.1.1) with NULL
        $alg_id = "\x30\x0d\x06\x09\x2a\x86\x48\x86\xf7\x0d\x01\x01\x01\x05\x00";

        $spki = "\x30" . $this->_der_length(strlen($alg_id) . strlen($public_key)) . $alg_id . $public_key;

        return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode($spki), 64, "\n") . "-----END PUBLIC KEY-----\n";
    }

    /**
     * Base64url decode (RFC 7515).
     */
    private function _base64url_decode($data)
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Encode a length value in DER (ASN.1) format.
     *
     * @param int $length
     * @return string|false
     */
    private function _der_length($length)
    {
        if ($length < 0x80) {
            return chr($length);
        } elseif ($length < 0x100) {
            return "\x81" . chr($length);
        } elseif ($length < 0x10000) {
            return "\x82" . chr($length >> 8) . chr($length & 0xFF);
        }
        return false;
    }

    /**
     * My Bookings - Authenticated via Google
     */
    public function my_bookings()
    {
        if (!$this->session->userdata('guest_email')) {
            redirect('home/guest_login');
            return;
        }

        $customer_id = $this->session->userdata('guest_id');
        $this->db->select('booking.*, bus.bus_nama, bus.kapasitas, bus.tipe_bus, bus.harga_dalam_kota, bus.harga_luar_kota, bus.status as bus_status');
        $this->db->from('booking');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->where('booking.customer_id', $customer_id);
        $this->db->order_by('booking.booking_id', 'DESC');
        $data['bookings'] = $this->db->get()->result_array();

        $this->load->view('public/my_bookings', $data);
    }

    /**
     * Booking Detail Page — Checkout-style view
     */
    public function booking_detail($booking_id = null)
    {
        if (!$this->session->userdata('guest_email')) {
            redirect('home/guest_login');
            return;
        }

        if (!$booking_id) {
            redirect('home/my_bookings');
            return;
        }

        $booking_id = (int) $booking_id;

        $customer_id = $this->session->userdata('guest_id');

        $this->db->select('booking.*, bus.bus_nama, bus.kapasitas, bus.tipe_bus, bus.harga_dalam_kota, bus.harga_luar_kota, bus.status as bus_status, customer.nama as customer_nama, customer.tlp as no_telp, customer.alamat');
        $this->db->from('booking');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->where('booking.booking_id', $booking_id);
        $this->db->where('booking.customer_id', $customer_id);
        $data['booking'] = $this->db->get()->row_array();

        if (!$data['booking']) {
            $this->session->set_flashdata('error', 'Booking tidak ditemukan atau Anda tidak memiliki akses.');
            redirect('home/my_bookings');
            return;
        }

        // Calculate days
        $d1 = new DateTime($data['booking']['tanggal_keberangkatan']);
        $d2 = new DateTime($data['booking']['tanggal_pulang']);
        $data['jumlah_hari'] = max($d1->diff($d2)->days, 1);

        // Calculate DP
        $data['dp_amount'] = $data['booking']['dp_nominal'] ?? (0.3 * $data['booking']['total_harga']); // DP 30% dari total harga + kode unik

        $this->load->view('public/booking_detail', $data);
    }

    /**
     * Upload Bukti Pembayaran
     */
    public function upload_bukti()
    {
        $booking_id = (int) $this->input->post('booking_id');
        
        $is_guest_logged_in = $this->session->userdata('guest_email');
        $guest_id = $this->session->userdata('guest_id');

        if (!$is_guest_logged_in || !$booking_id) {
            redirect('home');
            return;
        }

        // Verify booking belongs to this customer
        $booking = $this->db->where('booking_id', $booking_id)->get('booking')->row_array();
        if (!$booking || $booking['customer_id'] != $guest_id) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke booking ini.');
            redirect('home');
            return;
        }

        // Upload configuration
        $config['upload_path']   = './assets/img/bukti_transfer/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE; // Rename file randomly

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti_pembayaran')) {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            $update_data = [
                'bukti_pembayaran' => $file_name,
                'booking_status'   => 'menunggu_verifikasi',
                'alasan_penolakan' => NULL // Reset alasan if re-uploaded
            ];

            $this->db->where('booking_id', $booking_id);
            $this->db->update('booking', $update_data);

            // === NOTIFIKASI: Beritahu Admin Reservasi bukti DP diunggah ===
            $this->Notification_model->create(
                'Bukti DP Diunggah',
                'Customer telah mengunggah bukti pembayaran DP untuk Booking #BK-' . str_pad($booking_id, 4, '0', STR_PAD_LEFT) . '. Silakan verifikasi.',
                'reservasi',
                (int) $booking_id,
                'warning'
            );

            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
        }

        redirect('home/booking_detail/' . $booking_id);
    }

    public function upload_pelunasan()
    {
        $booking_id = (int) $this->input->post('booking_id');
        
        $is_guest_logged_in = $this->session->userdata('guest_email');
        $guest_id = $this->session->userdata('guest_id');
        if (!$is_guest_logged_in || !$booking_id) {
            redirect('home');
            return;
        }

        // Verify booking belongs to this customer
        $booking = $this->db->where('booking_id', $booking_id)->get('booking')->row_array();
        if (!$booking || $booking['customer_id'] != $guest_id) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke booking ini.');
            redirect('home');
            return;
        }

        $config['upload_path']   = './assets/img/bukti_transfer/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti_pelunasan')) {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            $update_data = [
                'bukti_pelunasan'  => $file_name,
                'booking_status'   => 'menunggu_pelunasan',
                'alasan_penolakan' => NULL
            ];

            $this->db->where('booking_id', $booking_id);
            $this->db->update('booking', $update_data);

            // === NOTIFIKASI: Beritahu Admin Reservasi bukti pelunasan diunggah ===
            $this->Notification_model->create(
                'Bukti Pelunasan Diunggah',
                'Customer telah mengunggah bukti pelunasan untuk Booking #BK-' . str_pad($booking_id, 4, '0', STR_PAD_LEFT) . '. Silakan verifikasi.',
                'reservasi',
                (int) $booking_id,
                'warning'
            );

            $this->session->set_flashdata('success', 'Bukti pelunasan berhasil diunggah. Menunggu verifikasi admin.');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
        }

        redirect('home/booking_detail/' . $booking_id);
    }

    /**
     * Cetak Kwitansi
     */
    public function cetak_kwitansi($booking_id = null)
    {
        if (!$this->session->userdata('guest_email')) {
            redirect('home/guest_login');
            return;
        }

        if (!$booking_id) {
            redirect('home/my_bookings');
            return;
        }

        $booking_id = (int) $booking_id;

        $customer_id = $this->session->userdata('guest_id');

        $this->db->select('booking.*, bus.bus_nama, bus.kapasitas, bus.tipe_bus, bus.harga_dalam_kota, bus.harga_luar_kota, bus.status as bus_status, customer.nama as customer_nama, customer.tlp as no_telp, customer.alamat');
        $this->db->from('booking');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->where('booking.booking_id', $booking_id);
        $this->db->where('booking.customer_id', $customer_id);
        $data['booking'] = $this->db->get()->row_array();

        if (!$data['booking'] || !in_array($data['booking']['booking_status'], ['uang_muka_dibayarkan', 'menunggu_pelunasan', 'lunas', 'siap_berangkat', 'sedang_berlangsung', 'selesai'])) {
            $this->session->set_flashdata('error', 'Kwitansi belum tersedia atau Anda tidak memiliki akses.');
            redirect('home/my_bookings');
            return;
        }

        $d1 = new DateTime($data['booking']['tanggal_keberangkatan']);
        $d2 = new DateTime($data['booking']['tanggal_pulang']);
        $data['jumlah_hari'] = max($d1->diff($d2)->days, 1);
        $data['dp_amount'] = $data['booking']['dp_nominal'] ?? (0.3 * $data['booking']['total_harga']);
        
        $status = $data['booking']['booking_status'];
        $data['is_lunas'] = in_array($status, ['lunas', 'selesai', 'siap_berangkat', 'sedang_berlangsung']);

        $this->load->view('public/kwitansi', $data);
    }
}
