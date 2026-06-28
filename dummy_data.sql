INSERT INTO bus (bus_id, bus_nama, kapasitas, tipe_bus, deskripsi, foto, fasilitas, harga_dalam_kota, harga_luar_kota, status) VALUES 
(1, 'Argo Mas Luxury', 45, 'SHD', 'Bus premium dengan suspensi udara, sangat nyaman untuk perjalanan jauh.', '', 'AC, WIFI, TV, TOILET', 2500000, 3000000, 'available'),
(2, 'Bintang Express', 60, 'HDD', 'Bus pariwisata eksekutif untuk rombongan besar.', '', 'AC, TV, KARAOKE', 2000000, 2500000, 'available'),
(3, 'Sinar Jaya VIP', 30, 'Medium Bus', 'Nyaman untuk rombongan kecil atau keluarga.', '', 'AC, AUDIO, RECLINING', 1500000, 1800000, 'available'),
(4, 'Trans Jawa Prima', 45, 'SHD', 'Armada terbaru tahun 2024 dengan fitur keamanan lengkap.', '', 'AC, WIFI, TOILET, USB', 2800000, 3500000, 'available'),
(5, 'Pahala Kencana Elite', 40, 'Executive', 'Tempat duduk ekstra lega untuk kenyamanan maksimal.', '', 'AC, WIFI, TV, TOILET, BAGASI', 3000000, 3800000, 'available'),
(6, 'Laju Prima Double Decker', 50, 'Double Decker', 'Sensasi perjalanan mewah dua tingkat yang tak terlupakan.', '', 'AC, WIFI, TV, TOILET, SNACK', 4500000, 5500000, 'available'),
(7, 'Rosalia Indah Super Top', 36, 'Super Executive', 'Konfigurasi kursi 2-1 yang sangat nyaman.', '', 'AC, WIFI, TV, TOILET, RECLINING', 3500000, 4200000, 'maintenance'),
(8, 'Gunung Harta Solutions', 45, 'SHD', 'Armada hijau bertenaga tangguh untuk berbagai medan jalan.', '', 'AC, WIFI, TV, TOILET', 2700000, 3200000, 'available'),
(9, 'Harapan Jaya Suites', 24, 'Sleeper Bus', 'Rebahkan badan Anda hingga tujuan dengan armada sleeper kami.', '', 'AC, WIFI, TV, TOILET, USB', 4000000, 5000000, 'available'),
(10, 'Maju Lancar Ekonomi', 60, 'Non-AC', 'Pilihan hemat untuk rombongan besar dan rute jarak dekat.', '', 'AUDIO, BAGASI', 1000000, 1200000, 'available');

INSERT INTO driver (driver_id, nama, tlp, status, bus_id) VALUES 
(1, 'Budi Santoso', '081234567890', 'available', 1),
(2, 'Andi Saputra', '081234567891', 'available', 2),
(3, 'Joko Susilo', '081234567892', 'available', 3),
(4, 'Rahmat Hidayat', '081234567893', 'available', 4),
(5, 'Slamet Riyadi', '081234567894', 'available', 5),
(6, 'Hendra Gunawan', '081234567895', 'available', 6),
(7, 'Eko Patrio', '081234567896', 'available', 7),
(8, 'Agus Setiawan', '081234567897', 'available', 8),
(9, 'Wawan Hermawan', '081234567898', 'available', 9),
(10, 'Supriyanto', '081234567899', 'available', 10);
