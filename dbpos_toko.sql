-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2024 at 06:51 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpos_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id_backup` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id_bank` int(11) UNSIGNED NOT NULL,
  `faktur` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `pemasukan` int(11) DEFAULT NULL,
  `pengeluaran` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_penjualan` int(11) UNSIGNED DEFAULT NULL,
  `noref_nokartu` varchar(255) DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) DEFAULT NULL,
  `id_bank_akun` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `bank_akun`
--

CREATE TABLE `bank_akun` (
  `id_bank_akun` int(11) NOT NULL,
  `nama_bank` varchar(255) DEFAULT NULL,
  `bank_nama` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `utama` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank_akun`
--

INSERT INTO `bank_akun` (`id_bank_akun`, `nama_bank`, `bank_nama`, `no_rekening`, `utama`, `created_at`, `updated_at`) VALUES
(1, 'BANK 1, Purwokerto', 'John Doe', '123456789', 0, NULL, '2024-01-19 20:24:09'),
(2, 'DANA', 'DANA', '0812345679', 1, '2024-01-19 20:23:40', '2024-01-19 20:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) UNSIGNED NOT NULL,
  `uuid_barang` char(36) NOT NULL DEFAULT '',
  `kode_barang` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_kontak` int(11) UNSIGNED DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(255) NOT NULL DEFAULT '',
  `merk` varchar(255) NOT NULL,
  `harga_beli` int(11) NOT NULL DEFAULT '0',
  `diskon` int(11) NOT NULL DEFAULT '0',
  `diskon_persen` int(11) NOT NULL DEFAULT '0',
  `harga_jual` int(11) NOT NULL DEFAULT '0',
  `harga_jual_grosir` int(11) NOT NULL DEFAULT '0',
  `jumlah_min_grosir` int(11) NOT NULL DEFAULT '0',
  `harga_member` int(11) NOT NULL DEFAULT '0',
  `harga_sales` int(11) NOT NULL DEFAULT '0',
  `margin` float NOT NULL DEFAULT '0',
  `range_harga` varchar(255) DEFAULT NULL,
  `satuan_barang` varchar(255) NOT NULL,
  `satuan_nilai` int(11) NOT NULL DEFAULT '0',
  `deskripsi` text,
  `stok` int(11) NOT NULL DEFAULT '0',
  `stok_min` int(11) NOT NULL DEFAULT '0',
  `stok_gudang` int(11) NOT NULL DEFAULT '0',
  `expired` datetime DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `biaya`
--

CREATE TABLE `biaya` (
  `id_biaya` int(11) UNSIGNED NOT NULL,
  `faktur` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `nominal` int(11) NOT NULL DEFAULT '0',
  `keterangan` varchar(255) DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cashflow`
--

CREATE TABLE `cashflow` (
  `id_cashflow` int(11) UNSIGNED NOT NULL,
  `faktur` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `pemasukan` int(11) NOT NULL DEFAULT '0',
  `pengeluaran` int(11) NOT NULL DEFAULT '0',
  `keterangan` varchar(255) DEFAULT NULL,
  `id_penjualan` int(11) UNSIGNED DEFAULT NULL,
  `id_pembelian` int(11) UNSIGNED DEFAULT NULL,
  `id_biaya` int(11) UNSIGNED DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id_group` int(11) NOT NULL,
  `nama_group` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id_group`, `nama_group`, `permission`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'a:86:{i:0;s:13:\"viewDashboard\";i:1;s:13:\"menuDashboard\";i:2;s:10:\"menuBarang\";i:3;s:10:\"viewBarang\";i:4;s:12:\"createBarang\";i:5;s:12:\"updateBarang\";i:6;s:12:\"deleteBarang\";i:7;s:9:\"viewExcel\";i:8;s:11:\"createExcel\";i:9;s:13:\"viewStokInOut\";i:10;s:15:\"createStokInOut\";i:11;s:15:\"updateStokInOut\";i:12;s:15:\"deleteStokInOut\";i:13;s:14:\"viewStokOpname\";i:14;s:16:\"createStokOpname\";i:15;s:16:\"updateStokOpname\";i:16;s:16:\"deleteStokOpname\";i:17;s:13:\"menuTransaksi\";i:18;s:13:\"viewPenjualan\";i:19;s:15:\"createPenjualan\";i:20;s:15:\"updatePenjualan\";i:21;s:15:\"deletePenjualan\";i:22;s:13:\"viewPembelian\";i:23;s:15:\"createPembelian\";i:24;s:15:\"updatePembelian\";i:25;s:15:\"deletePembelian\";i:26;s:10:\"viewHutang\";i:27;s:12:\"createHutang\";i:28;s:12:\"updateHutang\";i:29;s:12:\"deleteHutang\";i:30;s:11:\"viewPiutang\";i:31;s:13:\"createPiutang\";i:32;s:13:\"updatePiutang\";i:33;s:13:\"deletePiutang\";i:34;s:9:\"viewBiaya\";i:35;s:11:\"createBiaya\";i:36;s:11:\"updateBiaya\";i:37;s:11:\"deleteBiaya\";i:38;s:12:\"menuKeuangan\";i:39;s:12:\"viewCashflow\";i:40;s:14:\"createCashflow\";i:41;s:14:\"updateCashflow\";i:42;s:14:\"deleteCashflow\";i:43;s:8:\"viewBank\";i:44;s:10:\"createBank\";i:45;s:10:\"updateBank\";i:46;s:10:\"deleteBank\";i:47;s:9:\"viewPajak\";i:48;s:11:\"createPajak\";i:49;s:11:\"updatePajak\";i:50;s:11:\"deletePajak\";i:51;s:10:\"menuKontak\";i:52;s:10:\"viewKontak\";i:53;s:12:\"createKontak\";i:54;s:12:\"updateKontak\";i:55;s:12:\"deleteKontak\";i:56;s:8:\"menuUser\";i:57;s:8:\"viewUser\";i:58;s:10:\"createUser\";i:59;s:10:\"updateUser\";i:60;s:10:\"deleteUser\";i:61;s:9:\"viewGroup\";i:62;s:11:\"createGroup\";i:63;s:11:\"updateGroup\";i:64;s:11:\"deleteGroup\";i:65;s:11:\"menuSetting\";i:66;s:11:\"viewSetting\";i:67;s:13:\"updateSetting\";i:68;s:10:\"viewConfig\";i:69;s:10:\"saveConfig\";i:70;s:12:\"updateConfig\";i:71;s:12:\"deleteConfig\";i:72;s:12:\"viewBankAkun\";i:73;s:14:\"createBankAkun\";i:74;s:14:\"updateBankAkun\";i:75;s:14:\"deleteBankAkun\";i:76;s:10:\"viewBackup\";i:77;s:12:\"createBackup\";i:78;s:12:\"deleteBackup\";i:79;s:11:\"viewLaporan\";i:80;s:11:\"menuLaporan\";i:81;s:19:\"viewLaporanLabaRugi\";i:82;s:13:\"viewStatistik\";i:83;s:13:\"menuStatistik\";i:84;s:11:\"updateShift\";i:85;s:11:\"deleteShift\";}', NULL, '2023-12-17 21:17:12'),
(2, 'Manager', 'a:85:{i:0;s:13:\"viewDashboard\";i:1;s:13:\"menuDashboard\";i:2;s:10:\"menuBarang\";i:3;s:10:\"viewBarang\";i:4;s:12:\"createBarang\";i:5;s:12:\"updateBarang\";i:6;s:12:\"deleteBarang\";i:7;s:9:\"viewExcel\";i:8;s:11:\"createExcel\";i:9;s:13:\"viewStokInOut\";i:10;s:15:\"createStokInOut\";i:11;s:15:\"updateStokInOut\";i:12;s:15:\"deleteStokInOut\";i:13;s:14:\"viewStokOpname\";i:14;s:16:\"createStokOpname\";i:15;s:16:\"updateStokOpname\";i:16;s:16:\"deleteStokOpname\";i:17;s:13:\"menuTransaksi\";i:18;s:13:\"viewPenjualan\";i:19;s:15:\"createPenjualan\";i:20;s:15:\"updatePenjualan\";i:21;s:15:\"deletePenjualan\";i:22;s:13:\"viewPembelian\";i:23;s:15:\"createPembelian\";i:24;s:15:\"updatePembelian\";i:25;s:15:\"deletePembelian\";i:26;s:10:\"viewHutang\";i:27;s:12:\"createHutang\";i:28;s:12:\"updateHutang\";i:29;s:12:\"deleteHutang\";i:30;s:11:\"viewPiutang\";i:31;s:13:\"createPiutang\";i:32;s:13:\"updatePiutang\";i:33;s:13:\"deletePiutang\";i:34;s:9:\"viewBiaya\";i:35;s:11:\"createBiaya\";i:36;s:11:\"updateBiaya\";i:37;s:11:\"deleteBiaya\";i:38;s:12:\"menuKeuangan\";i:39;s:12:\"viewCashflow\";i:40;s:14:\"createCashflow\";i:41;s:14:\"updateCashflow\";i:42;s:14:\"deleteCashflow\";i:43;s:8:\"viewBank\";i:44;s:10:\"createBank\";i:45;s:10:\"updateBank\";i:46;s:10:\"deleteBank\";i:47;s:9:\"viewPajak\";i:48;s:11:\"createPajak\";i:49;s:11:\"updatePajak\";i:50;s:11:\"deletePajak\";i:51;s:10:\"menuKontak\";i:52;s:10:\"viewKontak\";i:53;s:12:\"createKontak\";i:54;s:12:\"updateKontak\";i:55;s:12:\"deleteKontak\";i:56;s:8:\"menuUser\";i:57;s:8:\"viewUser\";i:58;s:10:\"createUser\";i:59;s:10:\"updateUser\";i:60;s:10:\"deleteUser\";i:61;s:9:\"viewGroup\";i:62;s:11:\"createGroup\";i:63;s:11:\"updateGroup\";i:64;s:11:\"deleteGroup\";i:65;s:11:\"menuSetting\";i:66;s:11:\"viewSetting\";i:67;s:13:\"updateSetting\";i:68;s:10:\"viewConfig\";i:69;s:10:\"saveConfig\";i:70;s:12:\"updateConfig\";i:71;s:12:\"viewBankAkun\";i:72;s:14:\"createBankAkun\";i:73;s:14:\"updateBankAkun\";i:74;s:14:\"deleteBankAkun\";i:75;s:10:\"viewBackup\";i:76;s:12:\"createBackup\";i:77;s:12:\"deleteBackup\";i:78;s:11:\"viewLaporan\";i:79;s:11:\"menuLaporan\";i:80;s:19:\"viewLaporanLabaRugi\";i:81;s:13:\"viewStatistik\";i:82;s:13:\"menuStatistik\";i:83;s:11:\"updateShift\";i:84;s:11:\"deleteShift\";}', NULL, '2024-04-09 09:28:35'),
(3, 'Kasir', 'a:30:{i:0;s:13:\"viewDashboard\";i:1;s:13:\"menuDashboard\";i:2;s:13:\"menuTransaksi\";i:3;s:13:\"viewPenjualan\";i:4;s:15:\"createPenjualan\";i:5;s:15:\"updatePenjualan\";i:6;s:11:\"viewPiutang\";i:7;s:13:\"createPiutang\";i:8;s:13:\"updatePiutang\";i:9;s:9:\"viewBiaya\";i:10;s:11:\"createBiaya\";i:11;s:11:\"updateBiaya\";i:12;s:12:\"menuKeuangan\";i:13;s:12:\"viewCashflow\";i:14;s:14:\"createCashflow\";i:15;s:10:\"createBank\";i:16;s:9:\"viewPajak\";i:17;s:11:\"createPajak\";i:18;s:10:\"menuKontak\";i:19;s:10:\"viewKontak\";i:20;s:12:\"createKontak\";i:21;s:12:\"updateKontak\";i:22;s:10:\"viewConfig\";i:23;s:10:\"saveConfig\";i:24;s:12:\"viewBankAkun\";i:25;s:11:\"viewLaporan\";i:26;s:11:\"menuLaporan\";i:27;s:13:\"viewStatistik\";i:28;s:13:\"menuStatistik\";i:29;s:11:\"updateShift\";}', NULL, '2024-04-09 09:28:24'),
(4, 'Sales', 'a:10:{i:0;s:13:\"viewDashboard\";i:1;s:13:\"menuDashboard\";i:2;s:10:\"menuKontak\";i:3;s:10:\"viewKontak\";i:4;s:12:\"createKontak\";i:5;s:12:\"updateKontak\";i:6;s:12:\"deleteKontak\";i:7;s:10:\"viewConfig\";i:8;s:10:\"saveConfig\";i:9;s:11:\"updateShift\";}', NULL, '2024-04-09 09:28:13'),
(5, 'Gudang', 'a:17:{i:0;s:13:\"viewDashboard\";i:1;s:13:\"menuDashboard\";i:2;s:10:\"menuBarang\";i:3;s:10:\"viewBarang\";i:4;s:12:\"createBarang\";i:5;s:12:\"updateBarang\";i:6;s:9:\"viewExcel\";i:7;s:11:\"createExcel\";i:8;s:13:\"viewStokInOut\";i:9;s:15:\"createStokInOut\";i:10;s:15:\"updateStokInOut\";i:11;s:14:\"viewStokOpname\";i:12;s:16:\"createStokOpname\";i:13;s:16:\"updateStokOpname\";i:14;s:10:\"viewConfig\";i:15;s:10:\"saveConfig\";i:16;s:11:\"updateShift\";}', NULL, '2024-04-09 09:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `id_hutang` int(11) UNSIGNED NOT NULL,
  `id_pembelian` int(11) UNSIGNED NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `jumlah_hutang` int(11) DEFAULT NULL,
  `jumlah_bayar` int(11) DEFAULT NULL,
  `sisa_hutang` int(11) DEFAULT NULL,
  `status_hutang` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) NOT NULL DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `hutang_bayar`
--

CREATE TABLE `hutang_bayar` (
  `id_hutang_bayar` int(11) UNSIGNED NOT NULL,
  `id_hutang` int(11) UNSIGNED NOT NULL,
  `nominal` int(11) DEFAULT NULL,
  `id_cashflow` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_login` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Kopi', NULL, NULL),
(2, 'Beras', '2022-08-06 15:52:25', '2022-08-06 15:52:25'),
(3, 'Sembako', '2022-08-06 15:54:04', '2022-08-06 15:54:04'),
(4, 'Rokok', '2023-01-01 20:37:40', '2023-01-01 20:37:40'),
(5, 'Software', '2024-01-12 21:24:14', '2024-01-12 21:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` varchar(20) NOT NULL DEFAULT '',
  `id_barang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_kontak` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `harga_beli` int(11) NOT NULL DEFAULT '0',
  `harga_jual` int(11) NOT NULL DEFAULT '0',
  `harga_jual_grosir` int(11) NOT NULL DEFAULT '0',
  `jumlah_min_grosir` int(11) NOT NULL DEFAULT '0',
  `diskon` int(11) NOT NULL DEFAULT '0',
  `diskon_persen` int(11) NOT NULL DEFAULT '0',
  `stok` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `satuan` varchar(255) DEFAULT NULL,
  `hpp` int(11) NOT NULL DEFAULT '0',
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `ppn` int(11) NOT NULL DEFAULT '0',
  `total_laba` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) NOT NULL DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_pending` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_pending`
--

CREATE TABLE `keranjang_pending` (
  `id_pending` varchar(20) NOT NULL DEFAULT '',
  `nama_kontak` varchar(255) DEFAULT NULL,
  `jumlah_item` int(11) NOT NULL DEFAULT '0',
  `subtotal` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) NOT NULL DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_kontak` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `metode_bayar` varchar(255) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) UNSIGNED NOT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `grup` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `perusahaan` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nikktp` varchar(16) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `tipe`, `grup`, `nama`, `perusahaan`, `alamat`, `telepon`, `email`, `nikktp`, `npwp`, `created_at`, `updated_at`) VALUES
(1, 'Pelanggan', NULL, 'Umum', NULL, 'Purwokerto', '628123456789', 'member@gmail.com', '12314121', NULL, NULL, '2022-06-21 12:59:50'),
(2, 'Vendor', NULL, 'Aksara', 'PT Aksara Karya Utama', 'Purwokerto', '628123456789', 'aksaradelana@gmail.com', '123456789', NULL, '2022-05-09 14:17:28', '2022-06-14 11:02:54'),
(3, 'Pelanggan', NULL, 'Customer', NULL, 'Purwokerto', '62812345678', 'customer@gmail.com', NULL, NULL, '2022-06-14 16:30:12', '2023-02-26 06:47:20'),
(4, 'Pelanggan', 'member', 'Aksara', NULL, 'Purwokerto', '6282133445566', 'Aksara@gmail.com', NULL, NULL, '2023-03-06 11:40:42', '2024-02-07 10:18:47'),
(5, 'Pelanggan', NULL, 'Latisya', NULL, 'pwt', '62812345678', 'Latisya@gmail.com', NULL, NULL, '2023-03-06 13:16:52', '2023-05-05 19:25:15');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `nama` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `id_toko` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `email`, `nama`, `username`, `password`, `id_toko`, `token`, `role`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'Administrator', 'admin', '$2y$10$INo6IRmOXz4YqFhdxnzRjuqgKGaOuOlhBpxClF5V8xd1KPnmhq.9G', 1, NULL, 1, 1, NULL, '2022-05-23 08:26:38'),
(2, 'kasir@gmail.com', 'Kasir', 'kasir', '$2y$10$iTLV.WtmYghGjOSnIHJr8eTF0xFzCJTHOemBLK0tCvlpkeBgOWHk2', 1, NULL, 2, 1, '2022-05-11 09:38:59', '2022-05-26 18:25:53'),
(3, 'manager@gmail.com', 'Manager', 'manager', '$2y$10$dKFJw/2EF/ki.lT5dBz6auWJnVqtBeYHbWPUpNaXq28mTAzR328Hq', 1, NULL, 3, 1, '2023-02-25 14:31:06', '2023-02-25 14:31:06'),
(4, 'sales@gmail.com', 'Sales', 'sales', '$2y$10$4fagP5P0VulbcRe7Tcyq..WEEszuMgkb2MHOzEe4JjPWSGoywjNxC', 1, NULL, 4, 1, '2023-02-25 14:32:03', '2023-02-25 14:32:03'),
(5, 'gudang@gmail.com', 'Gudang', 'gudang', '$2y$10$9fZGZFOqt8bAclgOIvCkcuFUAiL.PSzhrIcWT3n7GmhSg9h6B5y22', 1, NULL, 5, 1, '2023-02-25 14:32:32', '2023-02-25 14:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `login_group`
--

CREATE TABLE `login_group` (
  `id_login_group` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `login_group`
--

INSERT INTO `login_group` (`id_login_group`, `id_login`, `id_group`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 3, NULL, NULL),
(3, 3, 2, NULL, '2023-05-05 15:10:06'),
(4, 4, 4, NULL, NULL),
(5, 5, 5, NULL, '2023-05-06 15:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `id_log_login` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL,
  `loggedin_at` datetime DEFAULT NULL,
  `loggedout_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id_log` int(11) UNSIGNED NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id_log`, `keterangan`, `created_at`) VALUES
(1, 'Administrator (admin@gmail.com) melakukan Logout at: 2024-06-30 18:36:35', '2024-06-30 18:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id_media` int(11) UNSIGNED NOT NULL,
  `media_path` varchar(255) NOT NULL,
  `id_barang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `active` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `id_jenismember` int(11) NOT NULL DEFAULT '0',
  `id_kontak` int(11) UNSIGNED NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `level` varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member_jenis`
--

CREATE TABLE `member_jenis` (
  `id_jenismember` int(11) NOT NULL,
  `diskon` int(11) NOT NULL DEFAULT '0',
  `nama_jenis` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` varchar(20) NOT NULL DEFAULT '',
  `id_barang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_kontak` int(11) UNSIGNED DEFAULT NULL,
  `harga_beli` int(11) NOT NULL DEFAULT '0',
  `harga_jual` int(11) NOT NULL DEFAULT '0',
  `stok` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `satuan` varchar(255) DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) NOT NULL DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pajak`
--

CREATE TABLE `pajak` (
  `id_pajak` int(11) UNSIGNED NOT NULL,
  `faktur` varchar(255) DEFAULT NULL,
  `PPN` char(10) DEFAULT '0',
  `jenis` varchar(255) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `pembulatan` int(11) NOT NULL DEFAULT '0',
  `keterangan` varchar(255) DEFAULT NULL,
  `id_penjualan` int(11) UNSIGNED DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) UNSIGNED NOT NULL,
  `faktur` varchar(255) DEFAULT NULL,
  `id_kontak` int(11) UNSIGNED DEFAULT NULL,
  `id_login` int(11) NOT NULL DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `tanggal` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `subtotal` int(11) NOT NULL DEFAULT '0',
  `biaya` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL DEFAULT '0',
  `status_bayar` int(11) NOT NULL DEFAULT '0',
  `pembayaran` int(11) DEFAULT NULL,
  `catatan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_item`
--

CREATE TABLE `pembelian_item` (
  `id_itempembelian` int(11) UNSIGNED NOT NULL,
  `id_pembelian` int(11) UNSIGNED DEFAULT NULL,
  `id_barang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) UNSIGNED NOT NULL,
  `faktur` varchar(255) DEFAULT NULL,
  `id_kontak` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `PPN` char(10) NOT NULL DEFAULT '0',
  `hpp` int(11) NOT NULL DEFAULT '0',
  `subtotal` int(11) NOT NULL DEFAULT '0',
  `diskon` int(11) NOT NULL DEFAULT '0',
  `diskon_persen` int(11) NOT NULL DEFAULT '0',
  `pajak` int(11) NOT NULL DEFAULT '0',
  `pembulatan` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL DEFAULT '0',
  `bayar` int(11) NOT NULL DEFAULT '0',
  `kembali` int(11) NOT NULL DEFAULT '0',
  `total_laba` int(11) NOT NULL DEFAULT '0',
  `periode` varchar(255) DEFAULT NULL,
  `id_login` int(11) NOT NULL DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `metode_bayar` varchar(255) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_item`
--

CREATE TABLE `penjualan_item` (
  `id_itempenjualan` int(11) UNSIGNED NOT NULL,
  `id_barang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_penjualan` int(11) UNSIGNED DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `harga_jual_grosir` int(11) NOT NULL DEFAULT '0',
  `jumlah_min_grosir` int(11) NOT NULL DEFAULT '0',
  `diskon` int(11) NOT NULL DEFAULT '0',
  `diskon_persen` int(11) NOT NULL DEFAULT '0',
  `stok` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `hpp` int(11) NOT NULL DEFAULT '0',
  `jumlah` int(11) DEFAULT NULL,
  `ppn` int(11) NOT NULL DEFAULT '0',
  `total_laba` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `piutang`
--

CREATE TABLE `piutang` (
  `id_piutang` int(11) UNSIGNED NOT NULL,
  `id_penjualan` int(11) UNSIGNED NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `jumlah_piutang` int(11) DEFAULT NULL,
  `jumlah_bayar` int(11) DEFAULT NULL,
  `sisa_piutang` int(11) DEFAULT NULL,
  `status_piutang` int(11) NOT NULL DEFAULT '0',
  `keterangan` varchar(255) DEFAULT NULL,
  `id_login` int(11) NOT NULL DEFAULT '0',
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `piutang_bayar`
--

CREATE TABLE `piutang_bayar` (
  `id_piutang_bayar` int(11) UNSIGNED NOT NULL,
  `id_piutang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nominal` int(11) DEFAULT NULL,
  `id_cashflow` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_login` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) UNSIGNED NOT NULL,
  `nama_satuan` varchar(255) NOT NULL DEFAULT '',
  `nilai_satuan` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`, `nilai_satuan`, `created_at`, `updated_at`) VALUES
(1, 'pcs', 1, NULL, NULL),
(2, 'buah', 1, NULL, NULL),
(3, 'butir', 1, NULL, NULL),
(4, 'bungkus', 1, '2023-01-01 20:38:07', '2023-01-01 20:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_setting` varchar(100) NOT NULL,
  `variable_setting` varchar(255) NOT NULL,
  `value_setting` text NOT NULL,
  `deskripsi_setting` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group_setting`, `variable_setting`, `value_setting`, `deskripsi_setting`, `updated_at`) VALUES
(1, 'general', 'app_name', 'AksaPOS Toko/Warung', 'App Name', '2022-05-09 06:16:12'),
(2, 'general', 'app_version', '1', 'App Version', '2022-05-26 18:22:10'),
(3, 'general', 'app_release', '2023-01-04 08:24:55', 'App Release', '2023-01-04 08:24:55'),
(4, 'general', 'app_developer', 'PT ITSHOP BISNIS DIGITAL (ITSHOP Purwokerto: itshop.biz.id, Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)', 'App Developer', '2022-05-11 17:05:03'),
(5, 'image', 'img_favicon', 'assets/images/favicon.png', 'Favicon', '2022-11-12 13:14:59'),
(6, 'image', 'img_logo', 'assets/images/logo.png', 'Logo', '2022-11-13 09:47:27'),
(7, 'image', 'img_logo_resize', 'assets/images/res_logo.png', 'Logo Resized', '2022-11-13 09:47:28'),
(8, 'image', 'img_background', 'assets/images/background.jpg', 'Background', '2022-03-10 13:17:10'),
(9, 'app', 'snackbars_position', 'bottom', 'Posisi Snackbars Notification', '2022-12-28 07:22:22'),
(10, 'app', 'limit_loginlog', '2000', 'Limit Login Log (default 2000)', '2023-01-04 08:24:55'),
(11, 'app', 'enable_frontend', 'true', 'Tampilkan Home atau Halaman Login', '2023-02-24 18:22:33'),
(12, 'app', 'cashierpay_position', 'left', 'Posisi Tombol Pay Kasir', '2023-02-26 13:18:48'),
(13, 'app', 'navbar_color', 'primary', 'Navbar Color', '2024-06-30 18:11:57'),
(14, 'app', 'sidebar_color', 'primary', 'Sidebar Color', '2024-06-30 18:12:04'),
(15, 'app', 'pos_position', 'left', 'Posisi Tabel Barang dan Keranjang di Halaman POS', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL,
  `nama_shift` varchar(255) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id_shift`, `nama_shift`, `jam_mulai`, `jam_selesai`, `id_toko`, `created_at`, `updated_at`) VALUES
(1, 'Shift 1', '07:00:00', '15:00:00', 1, NULL, '2023-04-30 12:03:29'),
(2, 'Shift 2', '15:00:00', '21:00:00', 1, NULL, '2023-04-30 12:03:46'),
(3, 'Shift 3', '00:00:00', '00:00:00', 1, NULL, NULL),
(4, 'Shift 1', '07:00:00', '14:00:00', 2, '2023-12-18 14:58:49', '2023-12-18 14:58:49');

-- --------------------------------------------------------

--
-- Table structure for table `shift_openclose`
--

CREATE TABLE `shift_openclose` (
  `id_shift_openclose` int(11) UNSIGNED NOT NULL,
  `id_shift` int(11) NOT NULL,
  `type` char(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `id_login` int(11) NOT NULL DEFAULT '0',
  `supervisor` int(11) NOT NULL DEFAULT '0',
  `jumlah_uang_kertas` int(11) DEFAULT NULL,
  `jumlah_uang_koin` int(11) DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shift_openclose_detail`
--

CREATE TABLE `shift_openclose_detail` (
  `id_shift_openclose_detail` int(11) UNSIGNED NOT NULL,
  `id_shift_openclose` int(11) UNSIGNED NOT NULL,
  `kertas100` int(11) NOT NULL DEFAULT '0',
  `kertas50` int(11) NOT NULL DEFAULT '0',
  `kertas20` int(11) NOT NULL DEFAULT '0',
  `kertas10` int(11) NOT NULL DEFAULT '0',
  `kertas5` int(11) NOT NULL DEFAULT '0',
  `kertas2` int(11) NOT NULL DEFAULT '0',
  `kertas1` int(11) NOT NULL DEFAULT '0',
  `koin1000` int(11) NOT NULL DEFAULT '0',
  `koin500` int(11) NOT NULL DEFAULT '0',
  `koin200` int(11) NOT NULL DEFAULT '0',
  `koin100` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id_stok` int(11) UNSIGNED NOT NULL,
  `id_barang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `jenis` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `nilai` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id_stok_opname` int(11) UNSIGNED NOT NULL,
  `id_barang` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `stok` int(11) DEFAULT NULL,
  `stok_nyata` int(11) DEFAULT NULL,
  `selisih` varchar(255) DEFAULT NULL,
  `nilai` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_toko` int(11) NOT NULL DEFAULT '0',
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `telp` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `NIB` char(15) DEFAULT NULL,
  `PPN` char(10) DEFAULT '0',
  `include_ppn` int(11) NOT NULL DEFAULT '0',
  `kode_barang` varchar(255) DEFAULT NULL,
  `kode_jual` varchar(255) DEFAULT NULL,
  `kode_jual_tahun` int(11) DEFAULT '0',
  `kode_beli` varchar(255) DEFAULT NULL,
  `kode_kas` varchar(255) DEFAULT NULL,
  `kode_bank` varchar(255) DEFAULT NULL,
  `kode_pajak` varchar(255) DEFAULT NULL,
  `kode_biaya` varchar(255) DEFAULT NULL,
  `paper_size` char(10) DEFAULT '0',
  `footer_nota` varchar(255) DEFAULT NULL,
  `printer_usb` int(11) DEFAULT '0',
  `printer_bluetooth` int(11) DEFAULT '0',
  `scan_keranjang` int(11) DEFAULT '0',
  `id_bank_akun` int(11) NOT NULL DEFAULT '0',
  `jatuhtempo_hari_tanggal` int(11) NOT NULL DEFAULT '0',
  `jatuhtempo_keterangan` int(11) NOT NULL DEFAULT '0',
  `jatuhtempo_hari` int(11) NOT NULL DEFAULT '0',
  `jatuhtempo_tanggal` int(11) NOT NULL DEFAULT '0',
  `pembulatan` int(11) NOT NULL DEFAULT '0',
  `pembulatan_keatas` int(11) NOT NULL DEFAULT '0',
  `pembulatan_max` int(11) NOT NULL DEFAULT '0',
  `diskon_member` int(11) NOT NULL DEFAULT '0',
  `footer_invoice_ttd1` text,
  `footer_invoice_ttd2` text,
  `footer_suratjalan_ttd1` text,
  `footer_suratjalan_ttd2` text,
  `footer_keterangan` text,
  `margin_barang` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `nama_toko`, `alamat_toko`, `telp`, `email`, `nama_pemilik`, `NIB`, `PPN`, `include_ppn`, `kode_barang`, `kode_jual`, `kode_jual_tahun`, `kode_beli`, `kode_kas`, `kode_bank`, `kode_pajak`, `kode_biaya`, `paper_size`, `footer_nota`, `printer_usb`, `printer_bluetooth`, `scan_keranjang`, `id_bank_akun`, `jatuhtempo_hari_tanggal`, `jatuhtempo_keterangan`, `jatuhtempo_hari`, `jatuhtempo_tanggal`, `pembulatan`, `pembulatan_keatas`, `pembulatan_max`, `diskon_member`, `footer_invoice_ttd1`, `footer_invoice_ttd2`, `footer_suratjalan_ttd1`, `footer_suratjalan_ttd2`, `footer_keterangan`, `margin_barang`, `created_at`, `updated_at`) VALUES
(1, 'Toko Nita', 'Dukuhwaluh Gg. Manggis RT 1 RW 7', '08123456789', 'warungnita@gmail.com', 'Hari Wicaksono', '012345678', '0', 0, 'BRG-', 'PJ/', 1, 'PI/', 'KAS/', 'BANK/', 'PPN/', 'BYA/', '58', 'Terima kasih sudah berbelanja, Barang yang sudah dibeli tidak dapat dikembalikan', 1, 1, 1, 1, 0, 1, 3, 20, 1, 1, 100, 0, '<p>Hormat Kami</p><p><br></p><p><br></p><p>(...........................................)</p>', '<p>Finance</p><p><br></p><p><br></p><p>(...........................................)</p>', '<p>Bagian Pengiriman</p><p><br></p><p><br></p><p>(...........................................)</p>', '<p>Finance</p><p><br></p><p><br></p><p>(...........................................)</p>', '<ol><li>Surat Jalan ini merupakan bukti resmi penerimaan barang</li><li>Surat Jalan ini bukan bukti penjualan</li><li>Surat Jalan ini dilengkapi Invoice sebagai bukti penjualan</li></ol>', 25, NULL, '2024-05-08 07:42:27'),
(2, 'Toko Test', 'Purwokerto', '08123456789', 'test@gmail.com', 'Hari Wicaksono', NULL, '0', 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '0', NULL, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, '2023-12-18 14:11:07', '2024-01-19 20:24:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id_backup`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`),
  ADD KEY `id_login` (`id_login`),
  ADD KEY `id_toko` (`id_toko`),
  ADD KEY `id_bank_akun` (`id_bank_akun`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `bank_akun`
--
ALTER TABLE `bank_akun`
  ADD PRIMARY KEY (`id_bank_akun`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id_biaya`),
  ADD KEY `id_toko` (`id_toko`),
  ADD KEY `id_login` (`id_login`);

--
-- Indexes for table `cashflow`
--
ALTER TABLE `cashflow`
  ADD PRIMARY KEY (`id_cashflow`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_pembelian` (`id_pembelian`),
  ADD KEY `id_biaya` (`id_biaya`),
  ADD KEY `id_toko` (`id_toko`),
  ADD KEY `id_login` (`id_login`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id_hutang`),
  ADD KEY `id_pembelian` (`id_pembelian`),
  ADD KEY `id_login` (`id_login`),
  ADD KEY `id_toko` (`id_toko`);

--
-- Indexes for table `hutang_bayar`
--
ALTER TABLE `hutang_bayar`
  ADD PRIMARY KEY (`id_hutang_bayar`),
  ADD KEY `id_hutang` (`id_hutang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_kontak` (`id_kontak`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_pending` (`id_pending`);

--
-- Indexes for table `keranjang_pending`
--
ALTER TABLE `keranjang_pending`
  ADD PRIMARY KEY (`id_pending`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `login_group`
--
ALTER TABLE `login_group`
  ADD PRIMARY KEY (`id_login_group`),
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_login` (`id_login`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id_log_login`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `member_jenis`
--
ALTER TABLE `member_jenis`
  ADD PRIMARY KEY (`id_jenismember`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `pajak`
--
ALTER TABLE `pajak`
  ADD PRIMARY KEY (`id_pajak`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  ADD PRIMARY KEY (`id_itempembelian`),
  ADD KEY `id_pembelian` (`id_pembelian`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `penjualan_item`
--
ALTER TABLE `penjualan_item`
  ADD PRIMARY KEY (`id_itempenjualan`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `piutang`
--
ALTER TABLE `piutang`
  ADD PRIMARY KEY (`id_piutang`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_login` (`id_login`),
  ADD KEY `id_toko` (`id_toko`);

--
-- Indexes for table `piutang_bayar`
--
ALTER TABLE `piutang_bayar`
  ADD PRIMARY KEY (`id_piutang_bayar`),
  ADD KEY `id_piutang` (`id_piutang`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`),
  ADD KEY `nama_satuan` (`nama_satuan`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id_shift`);

--
-- Indexes for table `shift_openclose`
--
ALTER TABLE `shift_openclose`
  ADD PRIMARY KEY (`id_shift_openclose`);

--
-- Indexes for table `shift_openclose_detail`
--
ALTER TABLE `shift_openclose_detail`
  ADD PRIMARY KEY (`id_shift_openclose_detail`),
  ADD KEY `id_shift_openclose` (`id_shift_openclose`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id_stok_opname`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`),
  ADD KEY `id_bank_akun` (`id_bank_akun`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id_backup` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_akun`
--
ALTER TABLE `bank_akun`
  MODIFY `id_bank_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id_biaya` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashflow`
--
ALTER TABLE `cashflow`
  MODIFY `id_cashflow` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id_hutang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hutang_bayar`
--
ALTER TABLE `hutang_bayar`
  MODIFY `id_hutang_bayar` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_group`
--
ALTER TABLE `login_group`
  MODIFY `id_login_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id_log_login` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_jenis`
--
ALTER TABLE `member_jenis`
  MODIFY `id_jenismember` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pajak`
--
ALTER TABLE `pajak`
  MODIFY `id_pajak` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  MODIFY `id_itempembelian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan_item`
--
ALTER TABLE `penjualan_item`
  MODIFY `id_itempenjualan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutang`
--
ALTER TABLE `piutang`
  MODIFY `id_piutang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutang_bayar`
--
ALTER TABLE `piutang_bayar`
  MODIFY `id_piutang_bayar` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id_shift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shift_openclose`
--
ALTER TABLE `shift_openclose`
  MODIFY `id_shift_openclose` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shift_openclose_detail`
--
ALTER TABLE `shift_openclose_detail`
  MODIFY `id_shift_openclose_detail` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id_stok_opname` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank`
--
ALTER TABLE `bank`
  ADD CONSTRAINT `bank_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`),
  ADD CONSTRAINT `bank_ibfk_2` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`),
  ADD CONSTRAINT `bank_ibfk_3` FOREIGN KEY (`id_bank_akun`) REFERENCES `bank_akun` (`id_bank_akun`),
  ADD CONSTRAINT `bank_ibfk_4` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `biaya`
--
ALTER TABLE `biaya`
  ADD CONSTRAINT `biaya_ibfk_1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`),
  ADD CONSTRAINT `biaya_ibfk_2` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`);

--
-- Constraints for table `cashflow`
--
ALTER TABLE `cashflow`
  ADD CONSTRAINT `cashflow_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cashflow_ibfk_2` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cashflow_ibfk_3` FOREIGN KEY (`id_biaya`) REFERENCES `biaya` (`id_biaya`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cashflow_ibfk_4` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`),
  ADD CONSTRAINT `cashflow_ibfk_5` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`);

--
-- Constraints for table `hutang`
--
ALTER TABLE `hutang`
  ADD CONSTRAINT `hutang_ibfk_1` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`),
  ADD CONSTRAINT `hutang_ibfk_2` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`),
  ADD CONSTRAINT `hutang_ibfk_3` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`);

--
-- Constraints for table `hutang_bayar`
--
ALTER TABLE `hutang_bayar`
  ADD CONSTRAINT `hutang_bayar_ibfk_1` FOREIGN KEY (`id_hutang`) REFERENCES `hutang` (`id_hutang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_kontak`) REFERENCES `kontak` (`id_kontak`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_ibfk_3` FOREIGN KEY (`id_pending`) REFERENCES `keranjang_pending` (`id_pending`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login_group`
--
ALTER TABLE `login_group`
  ADD CONSTRAINT `login_group_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_group_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pajak`
--
ALTER TABLE `pajak`
  ADD CONSTRAINT `pajak_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  ADD CONSTRAINT `pembelian_item_ibfk_1` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_item_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `penjualan_item`
--
ALTER TABLE `penjualan_item`
  ADD CONSTRAINT `penjualan_item_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_item_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `piutang`
--
ALTER TABLE `piutang`
  ADD CONSTRAINT `piutang_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`),
  ADD CONSTRAINT `piutang_ibfk_2` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`),
  ADD CONSTRAINT `piutang_ibfk_3` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`);

--
-- Constraints for table `piutang_bayar`
--
ALTER TABLE `piutang_bayar`
  ADD CONSTRAINT `piutang_bayar_ibfk_1` FOREIGN KEY (`id_piutang`) REFERENCES `piutang` (`id_piutang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shift_openclose_detail`
--
ALTER TABLE `shift_openclose_detail`
  ADD CONSTRAINT `shift_openclose_detail_ibfk_1` FOREIGN KEY (`id_shift_openclose`) REFERENCES `shift_openclose` (`id_shift_openclose`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD CONSTRAINT `stok_opname_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `toko`
--
ALTER TABLE `toko`
  ADD CONSTRAINT `toko_ibfk_1` FOREIGN KEY (`id_bank_akun`) REFERENCES `bank_akun` (`id_bank_akun`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
