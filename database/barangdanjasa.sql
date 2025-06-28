-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2025 at 04:22 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangdanjasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_barang` int NOT NULL,
  `stok` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bisa_disewa` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `image`, `nama_barang`, `harga_barang`, `stok`, `deskripsi`, `bisa_disewa`, `created_at`, `updated_at`) VALUES
(1, '20240620215737.jpeg', 'Madu', 45000, 13, 'Madu murni 100%, halal, steril, Netto 500 Gr', 0, '2024-06-17 17:15:35', '2024-06-25 00:55:11'),
(2, '20240620215353.jpeg', 'Abon Ikan Tongkol', 14000, 94, 'Halal, Gurih, Pedas Manis, Netto 25 Gr', 0, '2024-06-17 17:16:08', '2024-06-20 13:57:57'),
(3, '20240620220026.jpeg', 'Kopi Galau (Gawah Lauk)', 25000, 48, 'Halal, Steril, Netto 100 Gr', 0, '2024-06-20 14:00:26', '2024-06-26 04:45:06'),
(4, '20240620220405.jpeg', 'HT (Motorola)', 15000, 65, 'Barang Masih Oke 90%, full set (Charger), suara jelas,', 1, '2024-06-20 14:04:05', '2024-06-20 15:00:45'),
(5, '20240620220918.jpeg', 'Tenda', 20000, 29, 'Barang masih oke 90%, ukuran 2x2 referensi luas lantai adalah 2 meter, dan lebar tenda juga 2 meter. Tinggi tenda 1,5 meter.', 1, '2024-06-20 14:09:18', '2024-06-26 03:12:57'),
(6, '20240620221219.jpeg', 'Kursi', 5000, 200, 'Barang masih oke 90%, satu warna, tanpa sarung, bersih siap pakai.', 1, '2024-06-20 14:12:19', '2024-06-20 16:31:07'),
(7, '20240620221935.jpeg', 'Drone DJI Mavic Air Full Set', 425000, 5, 'Barang masih oke 95%, full set, siap pakai.', 1, '2024-06-20 14:19:35', '2024-06-20 14:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan`
--

CREATE TABLE `detail_pemesanan` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pemesanan` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `jumlah` int NOT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_pemesanan`
--

INSERT INTO `detail_pemesanan` (`id`, `id_pemesanan`, `id_barang`, `pelanggan_id`, `user_id`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, NULL, 2, 28000, '2024-06-17 17:56:29', '2024-06-17 17:56:29'),
(2, 2, 2, 2, NULL, 2, 28000, '2024-06-17 18:12:51', '2024-06-17 18:12:51'),
(3, 3, 2, 3, NULL, 1, 14000, '2024-06-20 07:21:32', '2024-06-20 07:21:32'),
(4, 4, 3, 2, NULL, 1, 25000, '2024-06-20 14:31:10', '2024-06-20 14:31:10'),
(5, 5, 3, 6, NULL, 1, 25000, '2024-06-26 04:45:37', '2024-06-26 04:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_produks`
--

CREATE TABLE `keranjang_produks` (
  `id` bigint UNSIGNED NOT NULL,
  `id_barang` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama_barang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_barang` int NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjang_produks`
--

INSERT INTO `keranjang_produks` (`id`, `id_barang`, `pelanggan_id`, `user_id`, `nama_barang`, `harga_barang`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
(2, 2, 1, NULL, 'Abon', 14000, 1, 14000, '2024-06-17 17:59:31', '2024-06-17 17:59:31'),
(7, 1, 5, NULL, 'Madu', 45000, 1, 45000, '2024-06-21 04:13:40', '2024-06-21 04:13:40'),
(8, 1, 2, NULL, 'Madu', 45000, 1, 45000, '2024-06-25 00:55:11', '2024-06-25 00:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `name_metode` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id`, `name_metode`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'Cash on Delivery (COD)', 'Pembayaran langsung ke lokasi', '2024-06-17 17:03:34', '2024-06-17 17:03:34'),
(2, 'Dana', '089876765552', '2024-06-17 17:32:15', '2024-06-17 17:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_08_103114_create_metode_pembayaran_table', 1),
(6, '2024_05_16_080952_create_barang_table', 2),
(7, '2024_05_18_095826_create_pelanggan_table', 2),
(8, '2024_06_16_002902_create_keranjang_produks_table', 2),
(9, '2024_06_16_003036_create_pemesanan_table', 2),
(10, '2024_06_16_003236_create_detail_pemesanan_table', 2),
(11, '2024_06_16_080323_create_penyewaans_table', 3),
(12, '2024_06_16_080534_create_pengembalians_table', 3),
(13, '2024_06_16_125524_create_pengiriman_table', 3),
(14, '2024_06_16_125548_create_pembayaran_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `name`, `no_hp`, `jenis_kelamin`, `alamat`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'pelanggan 1', '089765654442', 'Laki-laki', 'Jln. Contoh Alamat', 'pelanggan1@gmail.com', '$2y$10$v3yKnP3an4DiG6xpkfosWOTF2BbjxWrt8DgFmdMuN1p7AhTkeQoLy', '2024-06-17 17:11:13', '2024-06-17 17:11:13'),
(2, 'pelanggan 2', '089765654441', 'Laki-laki', 'Jln. Contoh Alamat', 'pelanggan2@gmail.com', '$2y$10$WQ4ZLcLlJej/j/J7qGo8qe2oIL9bLIdEnxq19cH0ci0XXxWBrAcbS', '2024-06-17 18:11:17', '2024-06-17 18:11:17'),
(3, 'Pelanggan3', '089765554543', 'Laki-laki', 'Mataram', 'pelanggan3@gmail.com', '$2y$10$XNg4mnpjgjCiQWh/88cOYuwZGCNLSYWmYHdc5NN8rjujWFFRHyNxK', '2024-06-20 07:06:49', '2024-06-20 07:06:49'),
(4, 'pelanggan4', '087821678999', 'Laki-laki', 'Mataram', 'pelanggan4@gmail.com', '$2y$10$iwUWRY9NuiZrsT.7JKi93eQvxonmhSYhRi65qFw5lZVYd40S6pUyW', '2024-06-20 16:21:36', '2024-06-20 16:21:36'),
(5, 'wafa', '087841047842', 'Perempuan', 'mataram', 'wafa@gmail.com', '$2y$10$heBk4ifkxVZxJoQwJvc25ezA/.XoH4OORySSt5tErxgExp9AhfLpO', '2024-06-21 04:13:00', '2024-06-21 04:13:00'),
(6, 'contoh', '089765654443', 'Laki-laki', 'contoh', 'contoh@gmail.com', '$2y$10$gL6Zi6SnlvJ6M.HTT7jzaen/ZzKyrZ6i02YRFdY99whFzX77r5eZ.', '2024-06-26 03:12:29', '2024-06-26 03:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pemesanan` bigint UNSIGNED DEFAULT NULL,
  `penyewaan_id` bigint UNSIGNED DEFAULT NULL,
  `id_metode_pembayaran` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `total_pembayaran` int NOT NULL,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `id_pemesanan`, `penyewaan_id`, `id_metode_pembayaran`, `pelanggan_id`, `user_id`, `total_pembayaran`, `bukti_pembayaran`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 2, 1, NULL, 40000, '1718674547.png', '2024-06-17 17:35:47', '2024-06-17 17:35:47'),
(2, 1, NULL, 2, 1, NULL, 28000, '20240618015714.png', '2024-06-17 17:57:14', '2024-06-17 17:57:14'),
(3, 2, NULL, 2, 2, NULL, 28000, '20240618021417.png', '2024-06-17 18:14:17', '2024-06-17 18:14:17'),
(4, 4, NULL, 2, 2, NULL, 25000, '20240620223444.jpeg', '2024-06-20 14:34:44', '2024-06-20 14:34:44'),
(5, NULL, 3, 1, 2, NULL, 75000, NULL, '2024-06-20 14:52:04', '2024-06-20 14:52:04'),
(6, NULL, 5, 2, 4, 1, 15000, '1718929783.jpg', '2024-06-20 16:29:43', '2024-06-20 16:29:43'),
(7, NULL, 6, 2, 6, NULL, 20000, '20240626111331.jpg', '2024-06-26 03:13:31', '2024-06-26 03:13:31'),
(8, 5, NULL, 2, 6, NULL, 25000, '20240626131017.jpg', '2024-06-26 05:10:17', '2024-06-26 05:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `id_metode_pembayaran` bigint UNSIGNED NOT NULL,
  `total_harga` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pemesanan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `pelanggan_id`, `user_id`, `id_metode_pembayaran`, `total_harga`, `status`, `tgl_pemesanan`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, 28000, 'Selesai', '2024-06-18', '2024-06-17 17:56:29', '2024-06-17 18:01:21'),
(2, 2, NULL, 2, 28000, 'Selesai', '2024-06-18', '2024-06-17 18:12:51', '2024-06-20 14:27:26'),
(3, 3, NULL, 1, 14000, 'Dikirim', '2024-06-20', '2024-06-20 07:21:32', '2024-06-20 14:25:49'),
(4, 2, NULL, 2, 25000, 'Selesai', '2024-06-20', '2024-06-20 14:31:10', '2024-06-20 14:39:38'),
(5, 6, NULL, 2, 25000, 'Selesai', '2024-06-26', '2024-06-26 04:45:37', '2024-06-26 05:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id` bigint UNSIGNED NOT NULL,
  `penyewaan_id` bigint UNSIGNED NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `kondisi_barang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalians`
--

INSERT INTO `pengembalians` (`id`, `penyewaan_id`, `tgl_pengembalian`, `kondisi_barang`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-06-20', 'lecet', '2024-06-17 17:46:55', '2024-06-17 17:46:55'),
(2, 3, '2024-06-23', 'aman', '2024-06-20 15:00:45', '2024-06-20 15:00:45'),
(3, 5, '2024-06-23', 'aman', '2024-06-20 16:31:07', '2024-06-20 16:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pemesanan` bigint UNSIGNED DEFAULT NULL,
  `penyewaan_id` bigint UNSIGNED DEFAULT NULL,
  `pelanggan_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id`, `id_pemesanan`, `penyewaan_id`, `pelanggan_id`, `user_id`, `alamat`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, NULL, 'Jln. Contoh Alamat', '2024-06-17 17:35:47', '2024-06-17 17:35:47'),
(2, 1, NULL, 1, NULL, 'jln. Contoh Alamat', '2024-06-17 17:56:29', '2024-06-17 17:56:29'),
(3, 2, NULL, 2, NULL, 'jln. contoh', '2024-06-17 18:12:51', '2024-06-17 18:12:51'),
(4, 3, NULL, 3, NULL, 'Mataram', '2024-06-20 07:21:32', '2024-06-20 07:21:32'),
(5, 4, NULL, 2, NULL, 'jln. contoh', '2024-06-20 14:31:10', '2024-06-20 14:31:10'),
(6, NULL, 3, 2, NULL, 'jln. contoh', '2024-06-20 14:52:04', '2024-06-20 14:52:04'),
(7, NULL, 5, 4, 1, 'jln. contoh', '2024-06-20 16:29:43', '2024-06-20 16:29:43'),
(8, NULL, 6, 6, NULL, 'contoh', '2024-06-26 03:13:31', '2024-06-26 03:13:31'),
(9, 5, NULL, 6, NULL, 'contoh', '2024-06-26 04:45:37', '2024-06-26 04:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `penyewaans`
--

CREATE TABLE `penyewaans` (
  `id` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `jumlah` int NOT NULL,
  `total_harga` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyewaans`
--

INSERT INTO `penyewaans` (`id`, `pelanggan_id`, `user_id`, `barang_id`, `tgl_mulai`, `tgl_selesai`, `jumlah`, `total_harga`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, '2024-06-18', '2024-06-20', 1, 40000, 'selesai', '2024-06-17 17:20:26', '2024-06-17 17:45:15'),
(2, 3, NULL, 1, '2024-06-20', '2024-06-22', 5, 200000, 'pending', '2024-06-20 07:27:47', '2024-06-20 07:27:47'),
(3, 2, NULL, 4, '2024-06-21', '2024-06-23', 5, 75000, 'selesai', '2024-06-20 14:42:49', '2024-06-20 14:56:11'),
(4, 2, NULL, 4, '2024-06-21', '2024-06-23', 5, 75000, 'pending', '2024-06-20 14:45:17', '2024-06-20 14:45:17'),
(5, 4, 1, 6, '2024-06-21', '2024-06-23', 3, 15000, 'selesai', '2024-06-20 16:27:15', '2024-06-20 16:30:42'),
(6, 6, NULL, 5, '2024-06-26', '2024-06-28', 1, 20000, 'disetujui', '2024-06-26 03:12:57', '2024-06-26 03:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hak_akses` enum('Admin','Pelanggan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `hak_akses`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$YU7M.YLJLlSDij6qBdXACeXFi3IDHrWAFWrRtNi/jZy/SOnoLWMfC', 'Admin', NULL, '2024-06-17 17:08:13', '2024-06-26 05:19:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pemesanan_id_pemesanan_foreign` (`id_pemesanan`),
  ADD KEY `detail_pemesanan_id_barang_foreign` (`id_barang`),
  ADD KEY `detail_pemesanan_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `detail_pemesanan_user_id_foreign` (`user_id`);

--
-- Indexes for table `keranjang_produks`
--
ALTER TABLE `keranjang_produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjang_produks_id_barang_foreign` (`id_barang`),
  ADD KEY `keranjang_produks_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `keranjang_produks_user_id_foreign` (`user_id`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_id_pemesanan_foreign` (`id_pemesanan`),
  ADD KEY `pembayaran_penyewaan_id_foreign` (`penyewaan_id`),
  ADD KEY `pembayaran_id_metode_pembayaran_foreign` (`id_metode_pembayaran`),
  ADD KEY `pembayaran_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `pembayaran_user_id_foreign` (`user_id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemesanan_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `pemesanan_user_id_foreign` (`user_id`),
  ADD KEY `pemesanan_id_metode_pembayaran_foreign` (`id_metode_pembayaran`);

--
-- Indexes for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengembalians_penyewaan_id_foreign` (`penyewaan_id`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengiriman_id_pemesanan_foreign` (`id_pemesanan`),
  ADD KEY `pengiriman_penyewaan_id_foreign` (`penyewaan_id`),
  ADD KEY `pengiriman_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `pengiriman_user_id_foreign` (`user_id`);

--
-- Indexes for table `penyewaans`
--
ALTER TABLE `penyewaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penyewaans_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `penyewaans_user_id_foreign` (`user_id`),
  ADD KEY `penyewaans_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `keranjang_produks`
--
ALTER TABLE `keranjang_produks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `penyewaans`
--
ALTER TABLE `penyewaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD CONSTRAINT `detail_pemesanan_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pemesanan_id_pemesanan_foreign` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pemesanan_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pemesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `keranjang_produks`
--
ALTER TABLE `keranjang_produks`
  ADD CONSTRAINT `keranjang_produks_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_produks_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_produks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_id_metode_pembayaran_foreign` FOREIGN KEY (`id_metode_pembayaran`) REFERENCES `metode_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_id_pemesanan_foreign` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_penyewaan_id_foreign` FOREIGN KEY (`penyewaan_id`) REFERENCES `penyewaans` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_id_metode_pembayaran_foreign` FOREIGN KEY (`id_metode_pembayaran`) REFERENCES `metode_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD CONSTRAINT `pengembalians_penyewaan_id_foreign` FOREIGN KEY (`penyewaan_id`) REFERENCES `penyewaans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_id_pemesanan_foreign` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengiriman_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pengiriman_penyewaan_id_foreign` FOREIGN KEY (`penyewaan_id`) REFERENCES `penyewaans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengiriman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `penyewaans`
--
ALTER TABLE `penyewaans`
  ADD CONSTRAINT `penyewaans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penyewaans_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `penyewaans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
