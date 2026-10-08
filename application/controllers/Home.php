<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $_token_error = '';

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
            $debug_msg = $this->_token_error ?: 'Token Google tidak valid atau sudah kadaluarsa.';
            $this->session->set_flashdata('error', $debug_msg);
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
            $this->_token_error = 'JWT must have 3 parts';
            return false;
        }

        list($header64, $payload64, $signature64) = $parts;

        // Decode the JWT header to get the key ID (kid)
        $header = json_decode($this->_base64url_decode($header64), true);
        if (!$header || !isset($header['kid'])) {
            $this->_token_error = 'Header lacks kid or cannot decode';
            return false;
        }

        // Fetch Google's current public keys
        $google_keys = $this->_get_google_public_keys();
        if (!$google_keys || !isset($google_keys[$header['kid']])) {
            $this->_token_error = 'Public key not found for kid: ' . ($header['kid'] ?? 'none');
            return false;
        }

        // Verify the RSA-SHA256 signature
        $signing_input = $header64 . '.' . $payload64;
        $signature = $this->_base64url_decode($signature64);
        $pem_key = $google_keys[$header['kid']];

        $pub_key = openssl_pkey_get_public($pem_key);
        if (!$pub_key) {
            $this->_token_error = 'Failed to get public key from PEM';
            return false;
        }

        $valid = (openssl_verify($signing_input, $signature, $pub_key, OPENSSL_ALGO_SHA256) === 1);
        openssl_pkey_free($pub_key);

        if (!$valid) {
            $this->_token_error = 'Signature verification failed. openssl_error: ' . openssl_error_string();
            return false;
        }

        // Decode and validate claims
        $payload = json_decode($this->_base64url_decode($payload64), true);
        if (!$payload) {
            $this->_token_error = 'Failed to decode payload';
            return false;
        }

        // Validate issuer
        $valid_issuers = ['accounts.google.com', 'https://accounts.google.com'];
        if (!in_array($payload['iss'] ?? '', $valid_issuers)) {
            $this->_token_error = 'Invalid issuer: ' . ($payload['iss'] ?? 'none');
            return false;
        }

        // Validate expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            $this->_token_error = 'Token expired. exp: ' . $payload['exp'] . ', current time: ' . time() . ', diff: ' . (time() - $payload['exp']) . 's';
            return false;
        }

        // Validate audience (client ID) if configured
        $client_id = $this->config->item('google_client_id');
        if (!empty($client_id) && isset($payload['aud']) && $payload['aud'] !== $client_id) {
            $this->_token_error = 'Audience mismatch. config: ' . $client_id . ', payload: ' . ($payload['aud'] ?? 'none');
            return false;
        }

        // Validate email is present and verified
        if (empty($payload['email']) || !filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
            $this->_token_error = 'Invalid email or email missing';
            return false;
        }

        if (isset($payload['email_verified']) && $payload['email_verified'] !== true) {
            $this->_token_error = 'Email not verified by Google';
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
        // Wrap modulus and exponent in an ASN.1 SEQUENCE (RSAPublicKey)
        $rsa_sequence = "\x30" . $this->_der_length(strlen($modulus_tlv) + strlen($exponent_tlv)) . $modulus_tlv . $exponent_tlv;
        // Wrap the SEQUENCE in a BIT STRING (leading \x00 = 0 unused bits)
        $public_key   = "\x03" . $this->_der_length(1 + strlen($rsa_sequence)) . "\x00" . $rsa_sequence;

        // Algorithm identifier: rsaEncryption (OID 1.2.840.113549.1.1.1) with NULL
        $alg_id = "\x30\x0d\x06\x09\x2a\x86\x48\x86\xf7\x0d\x01\x01\x01\x05\x00";

        $spki = "\x30" . $this->_der_length(strlen($alg_id) + strlen($public_key)) . $alg_id . $public_key;

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

    /**
     * Build raw ESC/POS print data for a booking (without sending to printer).
     *
     * @param array $booking  Booking data from DB
     * @param int   $jumlah_hari
     * @param float $dp_amount
     * @param bool  $is_lunas
     * @return string  Raw binary print data
     */
    private function _build_print_data($booking, $jumlah_hari, $dp_amount, $is_lunas)
    {
        $buffer = new \Mike42\Escpos\PrintConnectors\DummyPrintConnector();
        $printer = new \Mike42\Escpos\Printer($buffer);

        // 1. Header Struk
        $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(\Mike42\Escpos\Printer::MODE_DOUBLE_WIDTH | \Mike42\Escpos\Printer::MODE_DOUBLE_HEIGHT);
        $printer->text("DHEEMOBILINDO\n");
        $printer->selectPrintMode(); // Reset to normal
        $printer->text("Sewa Bus Pariwisata Bandung\n");
        $printer->text("Telp: 0812-3456-7890\n");
        $printer->text("================================\n");

        // 2. Info Transaksi
        $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_LEFT);
        $printer->text("Invoice: #BK-" . str_pad($booking['booking_id'], 4, '0', STR_PAD_LEFT) . "\n");
        $printer->text("Tanggal: " . date('d/m/Y H:i') . "\n");
        $printer->text("Nama   : " . substr($booking['customer_nama'], 0, 22) . "\n");
        $printer->text("Telp   : " . $booking['no_telp'] . "\n");
        $printer->text("================================\n");

        // 3. Detail Sewa
        $printer->text("Armada : " . substr($booking['bus_nama'], 0, 22) . "\n");
        $printer->text("Durasi : " . $jumlah_hari . " Hari (" . date('d M', strtotime($booking['tanggal_keberangkatan'])) . " - " . date('d M', strtotime($booking['tanggal_pulang'])) . ")\n");
        $printer->text("Rute   : " . substr($booking['lokasi_penjemputan'], 0, 10) . " -> " . substr($booking['tempat_tujuan'], 0, 10) . "\n");
        $printer->text("================================\n");

        // 4. Perhitungan Biaya
        $label_total = "Total Harga";
        $val_total   = "Rp " . number_format($booking['total_harga'], 0, ',', '.');
        $space_count = 32 - strlen($label_total) - strlen($val_total);
        if ($space_count < 1) $space_count = 1;
        $printer->text($label_total . str_repeat(" ", $space_count) . $val_total . "\n");

        if (!$is_lunas) {
            $label_dp = "DP 30% (+Kode Unik)";
            $val_dp   = "Rp " . number_format($dp_amount + $booking['kode_unik'], 0, ',', '.');
            $space_dp = 32 - strlen($label_dp) - strlen($val_dp);
            if ($space_dp < 1) $space_dp = 1;
            $printer->text($label_dp . str_repeat(" ", $space_dp) . $val_dp . "\n");

            $label_sisa = "Sisa Pelunasan";
            $val_sisa   = "Rp " . number_format($booking['total_harga'] - $dp_amount, 0, ',', '.');
            $space_sisa = 32 - strlen($label_sisa) - strlen($val_sisa);
            if ($space_sisa < 1) $space_sisa = 1;
            $printer->text($label_sisa . str_repeat(" ", $space_sisa) . $val_sisa . "\n");
            
            $printer->text("--------------------------------\n");
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text("STATUS: BELUM LUNAS (DP PAID)\n");
        } else {
            $label_dp = "DP Dibayarkan";
            $val_dp   = "Rp " . number_format($dp_amount, 0, ',', '.');
            $space_dp = 32 - strlen($label_dp) - strlen($val_dp);
            if ($space_dp < 1) $space_dp = 1;
            $printer->text($label_dp . str_repeat(" ", $space_dp) . $val_dp . "\n");

            $label_pelunasan = "Pelunasan";
            $val_pelunasan   = "Rp " . number_format($booking['total_harga'] - $dp_amount, 0, ',', '.');
            $space_pelunasan = 32 - strlen($label_pelunasan) - strlen($val_pelunasan);
            if ($space_pelunasan < 1) $space_pelunasan = 1;
            $printer->text($label_pelunasan . str_repeat(" ", $space_pelunasan) . $val_pelunasan . "\n");

            if ($booking['denda'] > 0) {
                $label_denda = "Denda Keterlambatan";
                $val_denda   = "Rp " . number_format($booking['denda'], 0, ',', '.');
                $space_denda = 32 - strlen($label_denda) - strlen($val_denda);
                if ($space_denda < 1) $space_denda = 1;
                $printer->text($label_denda . str_repeat(" ", $space_denda) . $val_denda . "\n");
            }

            $printer->text("--------------------------------\n");
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(\Mike42\Escpos\Printer::MODE_DOUBLE_WIDTH);
            $printer->text("LUNAS\n");
            $printer->selectPrintMode();
        }

        $printer->text("================================\n");
        
        // 5. Footer Struk
        $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
        $printer->text("Terima kasih atas kepercayaan\n");
        $printer->text("Anda bersama Dheemobilindo.\n");
        $printer->text("Semoga perjalanan Anda menyenangkan!\n");
        
        $printer->feed(3);
        $printer->cut();
        
        // Ambil data ESC/POS SEBELUM close (karena close akan memicu finalize yg menghapus buffer)
        $data = $buffer->getData();
        $printer->close();

        return $data;
    }

    /**
     * Send raw print data to a Windows printer via multiple methods.
     *
     * @param string $printData    Raw ESC/POS binary data
     * @param string $printerName  Windows printer / share name
     * @return string  Name of the method that successfully sent the data
     * @throws \Exception  If all printing methods fail
     */
    private function _send_to_printer($printData, $printerName = 'PrinterKasir')
    {
        $errors = [];
        $hostname = gethostname();
        if (!$hostname) {
            $hostname = 'localhost';
        }
        $devicePath = "\\\\{$hostname}\\{$printerName}";

        // --- METHOD 1: WindowsPrintConnector (via escpos-php) ---
        try {
            $connector = new \Mike42\Escpos\PrintConnectors\WindowsPrintConnector($printerName);
            $connector->write($printData);
            $connector->finalize();
            return 'ESC/POS (WindowsPrintConnector)';
        } catch (\Throwable $e) {
            $errors[] = 'ESC/POS: ' . $e->getMessage();
        }

        // --- METHOD 2: exec() with print /D: command ---
        try {
            if (function_exists('exec')) {
                $tmpFile = tempnam(sys_get_temp_dir(), 'escpos_');
                if ($tmpFile !== false) {
                    file_put_contents($tmpFile, $printData);
                    $cmd = "print /D:\"{$devicePath}\" \"{$tmpFile}\"";
                    $output = [];
                    $exitCode = -1;
                    exec($cmd, $output, $exitCode);
                    @unlink($tmpFile);
                    if ($exitCode === 0) {
                        return 'Print command (exec)';
                    }
                    $errors[] = 'Print exec: exit ' . $exitCode . ' — ' . implode(' ', $output);
                }
            } else {
                $errors[] = 'Print exec: exec tidak tersedia';
            }
        } catch (\Throwable $e) {
            $errors[] = 'Print exec: ' . $e->getMessage();
        }

        // --- METHOD 3: Direct copy to UNC printer path ---
        try {
            $tmpFile = tempnam(sys_get_temp_dir(), 'escpos_');
            if ($tmpFile !== false) {
                file_put_contents($tmpFile, $printData);
                if (@copy($tmpFile, $devicePath)) {
                    @unlink($tmpFile);
                    return 'Copy to UNC (' . $devicePath . ')';
                }
                @unlink($tmpFile);
            }
            $errors[] = 'Copy: Gagal copy ke ' . $devicePath;
        } catch (\Throwable $e) {
            $errors[] = 'Copy: ' . $e->getMessage();
        }

        // --- METHOD 4: PowerShell Out-Printer ---
        try {
            if (function_exists('exec')) {
                $tmpFile = tempnam(sys_get_temp_dir(), 'escpos_');
                if ($tmpFile !== false) {
                    file_put_contents($tmpFile, $printData);
                    $psCmd = "powershell -Command \"Get-Content -Encoding Byte '{$tmpFile}' | Out-Printer -Name '{$printerName}'\"";
                    $psOutput = [];
                    $psExitCode = -1;
                    exec($psCmd, $psOutput, $psExitCode);
                    @unlink($tmpFile);
                    if ($psExitCode === 0) {
                        return 'PowerShell Out-Printer';
                    }
                    $errors[] = "PowerShell: exit {$psExitCode} — " . implode(' ', $psOutput);
                }
            } else {
                $errors[] = 'PowerShell: exec tidak tersedia';
            }
        } catch (\Throwable $e) {
            $errors[] = 'PowerShell: ' . $e->getMessage();
        }

        // --- METHOD 5: Scheduled Task as INTERACTIVE user ---
        // This runs print /D: as the currently logged-in Windows user (who has printer access)
        try {
            if (function_exists('exec')) {
                $tmpFile = tempnam(sys_get_temp_dir(), 'escpos_');
                if ($tmpFile !== false) {
                    file_put_contents($tmpFile, $printData);
                    $printCmd = "print /D:\"{$devicePath}\" \"{$tmpFile}\"";
                    $taskName = 'ThermalPrint_' . date('YmdHis') . '_' . rand(100, 999);
                    
                    // Create scheduled task (runs as INTERACTIVE user = currently logged on)
                    // Gunakan waktu 2 menit dari sekarang agar trigger tidak expired
                    $startTime = date('H:i', strtotime('+2 minutes'));
                    $startDate = date('Y-m-d');
                    $createCmd = 'schtasks /Create /SC ONCE /TN "' . $taskName . '" /TR "' . $printCmd . '" /ST ' . $startTime . ' /SD ' . $startDate . ' /RU INTERACTIVE /F 2>&1';
                    $createOut = [];
                    $createExit = -1;
                    exec($createCmd, $createOut, $createExit);
                    
                    if ($createExit === 0) {
                        // Run the task immediately (bypass scheduled time)
                        $runCmd = 'schtasks /Run /TN "' . $taskName . '" 2>&1';
                        $runOut = [];
                        $runExit = -1;
                        exec($runCmd, $runOut, $runExit);
                        
                        // Tunggu 3 detik agar task sempat mulai sebelum dihapus
                        sleep(3);
                        
                        // Hapus task dari scheduler
                        $delCmd = 'schtasks /Delete /TN "' . $taskName . '" /F 2>&1';
                        exec($delCmd);
                        @unlink($tmpFile);
                        
                        if ($runExit === 0) {
                            return 'Scheduled Task (INTERACTIVE)';
                        }
                        $errors[] = "SchedTask: run exit {$runExit} — " . implode(' ', $runOut);
                    } else {
                        @unlink($tmpFile);
                        $errors[] = "SchedTask: create exit {$createExit} — " . implode(' ', $createOut);
                    }
                }
            } else {
                $errors[] = 'SchedTask: exec tidak tersedia';
            }
        } catch (\Throwable $e) {
            $errors[] = 'SchedTask: ' . $e->getMessage();
        }

        // --- All methods failed ---
        throw new \Exception(implode(' | ', $errors));
    }

    /**
     * Cetak Struk ke Printer Thermal Kasir (Iware)
     * Mendukung multiple fallback method untuk kompatibilitas maksimal.
     */
    public function cetak_thermal($booking_id = null)
    {
        // Bersihkan output buffer agar response JSON selalu murni
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header('Content-Type: application/json');
        @ini_set('display_errors', 0);

        if (!$booking_id) {
            echo json_encode(['status' => 'error', 'message' => 'ID Booking tidak valid.']);
            return;
        }

        $booking_id = (int) $booking_id;
        $customer_id = $this->session->userdata('guest_id');

        // Query data booking lengkap
        $this->db->select('booking.*, bus.bus_nama, bus.kapasitas, bus.tipe_bus, bus.harga_dalam_kota, bus.harga_luar_kota, customer.nama as customer_nama, customer.tlp as no_telp, customer.alamat');
        $this->db->from('booking');
        $this->db->join('bus', 'bus.bus_id = booking.bus_id', 'left');
        $this->db->join('customer', 'customer.customer_id = booking.customer_id', 'left');
        $this->db->where('booking.booking_id', $booking_id);
        $booking = $this->db->get()->row_array();

        if (!$booking) {
            echo json_encode(['status' => 'error', 'message' => 'Data booking tidak ditemukan atau Anda tidak memiliki akses.']);
            return;
        }

        // Hitung jumlah hari sewa
        $d1 = new DateTime($booking['tanggal_keberangkatan']);
        $d2 = new DateTime($booking['tanggal_pulang']);
        $jumlah_hari = max($d1->diff($d2)->days, 1);
        $dp_amount = $booking['dp_nominal'] ?? (0.3 * $booking['total_harga']);
        
        $status = $booking['booking_status'];
        $is_lunas = in_array($status, ['lunas', 'selesai', 'siap_berangkat', 'sedang_berlangsung']);

        // Step 1: Build print data in memory (without sending to printer yet)
        try {
            $printData = $this->_build_print_data($booking, $jumlah_hari, $dp_amount, $is_lunas);
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyusun data cetak: ' . $e->getMessage()
            ]);
            return;
        }

        // Step 2: Try to send data to printer using all available methods
        $printer_name = 'PrinterKasir';
        try {
            $method = $this->_send_to_printer($printData, $printer_name);
            echo json_encode([
                'status' => 'success',
                'method' => $method,
                'hostname' => gethostname(),
                'device_path' => '\\\\' . gethostname() . '\\' . $printer_name
            ]);
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal mencetak. Semua metode percobaan gagal: ' . $e->getMessage()
            ]);
        }
    }
}
