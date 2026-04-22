-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table greenlms.book
CREATE TABLE IF NOT EXISTS `buku` (
  `id_buku` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `id_kategori_buku` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `nomor_isbn` varchar(100) NOT NULL,
  `foto_sampul` varchar(200) NOT NULL,
  `nomor_kode` varchar(100) NOT NULL,
  `id_rak` int DEFAULT NULL,
  `nomor_edisi` varchar(100) NOT NULL,
  `tanggal_edisi` datetime DEFAULT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tanggal_terbit` datetime DEFAULT NULL,
  `catatan` text NOT NULL,
  `status` tinyint NOT NULL COMMENT '0= Buku Tersedia, 1= Buku Tidak Tersedia',
  `dihapus_pada` tinyint NOT NULL COMMENT '0= Buku Tersedia, 1=Buku Dihapus ',
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.book: ~0 rows (approximately)
INSERT INTO `buku` (`id_buku`, `nama`, `penulis`, `id_kategori_buku`, `jumlah`, `harga`, `nomor_isbn`, `foto_sampul`, `nomor_kode`, `id_rak`, `nomor_edisi`, `tanggal_edisi`, `penerbit`, `tanggal_terbit`, `catatan`, `status`, `dihapus_pada`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 'Unified Modeling Language', 'Munawar', 1, 2, 50000.00, '1234567', '594b5e9a68270057b5d44939551492377d2fc44095cb53827ab0de699eb7135c6df9cd9ad3c6aa2aaedf67b013f16ab49ac004b51f803c269f05624cbf6900ed.jpg', '200.10.0001', 2, '1', '2025-01-01 00:00:00', 'Informatika', '2025-01-01 00:00:00', '-', 1, 0, '2025-01-14 11:22:38', 1, 1, '2025-01-14 11:22:38', 1, 1);

-- Dumping structure for table greenlms.bookcategory
CREATE TABLE IF NOT EXISTS `kategori_buku` (
  `id_kategori_buku` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_sampul` varchar(255) NOT NULL,
  `status` tinyint NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_kategori_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.bookcategory: ~0 rows (approximately)
INSERT INTO `kategori_buku` (`id_kategori_buku`, `nama`, `deskripsi`, `foto_sampul`, `status`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 'Rekayasa Perangkat Lunak', 'Deskripsi Rekayasa Perangkat Lunak', 'bookcategory.jpg', 1, '2025-01-12 08:45:17', 1, 1, '2025-01-12 08:45:47', 1, 1);

-- Dumping structure for table greenlms.bookissue
CREATE TABLE IF NOT EXISTS `peminjaman_buku` (
  `id_peminjaman` int NOT NULL AUTO_INCREMENT,
  `id_peran` int NOT NULL,
  `id_anggota` int NOT NULL,
  `id_kategori_buku` int NOT NULL,
  `id_buku` int NOT NULL,
  `nomor_buku` int NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kadaluarsa` datetime NOT NULL,
  `diperbarui` tinyint NOT NULL,
  `batas_maksimal_perpanjangan` tinyint NOT NULL,
  `denda_per_hari` decimal(10,2) NOT NULL,
  `jumlah_denda` decimal(10,2) NOT NULL,
  `jumlah_pembayaran` decimal(10,2) NOT NULL,
  `jumlah_diskon` decimal(10,2) NOT NULL,
  `status_pembayaran` tinyint NOT NULL DEFAULT '0' COMMENT '0 = belum lunas,  1 = sebagian, 2 = lunas',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0 = Dipinjam,  1 = Dikembalikan, 2 = Hilang',
  `dihapus_pada` tinyint NOT NULL DEFAULT '0' COMMENT '0 = Tidak Dihapus, 1 = Dihapus',
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_peminjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.bookissue: ~4 rows (approximately)
INSERT INTO `peminjaman_buku` (`id_peminjaman`, `id_peran`, `id_anggota`, `id_kategori_buku`, `id_buku`, `nomor_buku`, `catatan`, `tanggal_pinjam`, `tanggal_kadaluarsa`, `diperbarui`, `batas_maksimal_perpanjangan`, `denda_per_hari`, `jumlah_denda`, `jumlah_pembayaran`, `jumlah_diskon`, `status_pembayaran`, `status`, `dihapus_pada`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 3, 4, 1, 1, 1, '-', '2025-01-01 00:00:00', '2025-01-24 00:00:00', 1, 2, 2000.00, 8000.00, 8000.00, 0.00, 2, 1, 0, '2025-01-14 15:36:45', 3, 2, '2025-01-14 15:36:45', 3, 2),
	(2, 3, 4, 1, 1, 1, '-', '2025-01-31 00:00:00', '2025-02-20 00:00:00', 1, 2, 2000.00, 50000.00, 50000.00, 0.00, 2, 2, 0, '2025-01-14 15:42:15', 3, 2, '2025-01-14 15:42:15', 3, 2),
	(3, 3, 4, 1, 1, 1, '', '2025-01-21 00:00:00', '2025-02-10 00:00:00', 1, 2, 2000.00, 0.00, 0.00, 0.00, 0, 1, 0, '2025-01-21 22:41:11', 1, 1, '2025-01-21 22:41:11', 1, 1),
	(4, 3, 4, 1, 1, 1, '', '2025-01-22 00:00:00', '2025-02-05 00:00:00', 1, 2, 2000.00, 0.00, 0.00, 0.00, 0, 0, 0, '2025-01-21 23:42:24', 1, 1, '2025-01-21 23:42:24', 1, 1),
	(5, 3, 4, 1, 1, 2, '', '2025-01-22 00:00:00', '2025-02-05 00:00:00', 1, 2, 2000.00, 0.00, 0.00, 0.00, 0, 0, 0, '2025-01-21 23:46:30', 1, 1, '2025-01-21 23:46:30', 1, 1);

-- Dumping structure for table greenlms.bookitem
CREATE TABLE IF NOT EXISTS `item_buku` (
  `id_item_buku` int NOT NULL AUTO_INCREMENT,
  `id_buku` int NOT NULL,
  `nomor_buku` int NOT NULL,
  `status` tinyint NOT NULL COMMENT '0= Buku Tersedia, 1= Buku Dipinjam, 2=Buku Hilang',
  `dihapus_pada` tinyint NOT NULL COMMENT '0= Buku Tersedia, 1= Buku Tidak Tersedia',
  PRIMARY KEY (`id_item_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.bookitem: ~2 rows (approximately)
INSERT INTO `item_buku` (`id_item_buku`, `id_buku`, `nomor_buku`, `status`, `dihapus_pada`) VALUES
	(1, 1, 1, 1, 0),
	(2, 1, 2, 1, 0);

-- Dumping structure for table greenlms.chat
CREATE TABLE IF NOT EXISTS `obrolan` (
  `id_obrolan` int NOT NULL AUTO_INCREMENT,
  `pesan` text NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_obrolan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.chat: ~0 rows (approximately)
INSERT INTO `obrolan` (`id_obrolan`, `pesan`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 'Hello', '2025-01-02 20:13:32', 1, 1, '2025-01-02 20:13:32', 1, 1),
	(2, 'Hai admin', '2025-01-13 06:50:44', 3, 2, '2025-01-13 06:50:44', 3, 2);

-- Dumping structure for table greenlms.ebook
CREATE TABLE IF NOT EXISTS `buku_elektronik` (
  `id_buku_elektronik` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `foto_sampul` varchar(200) NOT NULL,
  `file` varchar(200) NOT NULL,
  `nama_file_asli` varchar(200) NOT NULL,
  `catatan` text NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_buku_elektronik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.ebook: ~0 rows (approximately)
INSERT INTO `buku_elektronik` (`id_buku_elektronik`, `nama`, `penulis`, `foto_sampul`, `file`, `nama_file_asli`, `catatan`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 'Software Engineering (Sommerville)', 'Ian Sommerville', '14101636e9d5d4c86cf2d13b5263b44e1ce72b6215cfdf2712c3b1857c9ca0df4f7161b1a1e0414b3055f582b114a1d3fad855030dbb223d39c98aa6a3efe8f5.jpg', '5382d3294fce215c6f40a0ec0f95f103bfeaa1710504a55a673d6786edc55431702220df8df5ddb35edc7c17bff0c262149c91a420abd06b829c28ab9c78dc25.pdf', '', '-', '2025-01-12 09:10:35', 1, 1, '2025-01-14 11:14:13', 1, 1);

-- Dumping structure for table greenlms.emailsend
CREATE TABLE IF NOT EXISTS `kirim_email` (
  `id_kirim_email` int NOT NULL AUTO_INCREMENT,
  `subjek` varchar(200) NOT NULL,
  `pesan` text NOT NULL,
  `nama_pengirim` text NOT NULL,
  `surel` varchar(255) DEFAULT NULL,
  `id_anggota_pengirim` int NOT NULL,
  `id_peran_pengirim` int NOT NULL,
  `id_templat_email` int NOT NULL DEFAULT '0',
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `pada_dihapus` tinyint NOT NULL DEFAULT '0' COMMENT '0=show, 1=delete',
  PRIMARY KEY (`id_kirim_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.emailsend: ~0 rows (approximately)

-- Dumping structure for table greenlms.emailsetting
CREATE TABLE IF NOT EXISTS `pengaturan_surel` (
  `kunci_opsi` varchar(100) NOT NULL,
  `nilai_opsi` text NOT NULL,
  UNIQUE KEY `frontendkey` (`kunci_opsi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.emailsetting: ~6 rows (approximately)
INSERT INTO `pengaturan_surel` (`kunci_opsi`, `nilai_opsi`) VALUES
	('mail_driver', ''),
	('mail_encryption', ''),
	('mail_host', ''),
	('mail_password', ''),
	('mail_port', ''),
	('mail_username', '');

-- Dumping structure for table greenlms.emailtemplate
CREATE TABLE IF NOT EXISTS `templat_surel` (
  `id_templat_email` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(60) NOT NULL,
  `templat` text NOT NULL,
  `prioritas` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_templat_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.emailtemplate: ~0 rows (approximately)

-- Dumping structure for table greenlms.expense
CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id_pengeluaran` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `tanggal` datetime NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `file` varchar(200) DEFAULT NULL,
  `nama_file_asli` varchar(200) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_pengeluaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.expense: ~0 rows (approximately)

-- Dumping structure for table greenlms.finehistory
CREATE TABLE IF NOT EXISTS `riwayat_denda` (
  `id_riwayat_denda` int NOT NULL AUTO_INCREMENT,
  `id_peminjaman_buku` int NOT NULL,
  `id_status_buku` int NOT NULL COMMENT '0 = Issued,  1 = Return, 2 = Lost',
  `diperbarui` tinyint NOT NULL,
  `dari_tanggal` datetime DEFAULT NULL,
  `ke_tanggal` datetime DEFAULT NULL,
  `jumlah_denda` decimal(10,2) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_riwayat_denda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.finehistory: ~8 rows (approximately)
INSERT INTO `riwayat_denda` (`id_riwayat_denda`, `id_peminjaman_buku`, `id_status_buku`, `diperbarui`, `dari_tanggal`, `ke_tanggal`, `jumlah_denda`, `catatan`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 1, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-14 15:36:45', 3, 2, '2025-01-14 15:36:45', 3, 2),
	(2, 1, 1, 1, '2025-01-12 00:00:00', '2025-01-13 00:00:00', 8000.00, '', '2025-01-14 15:38:04', 3, 2, '2025-01-14 15:38:04', 3, 2),
	(3, 2, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-14 15:42:15', 3, 2, '2025-01-14 15:42:15', 3, 2),
	(4, 2, 2, 1, NULL, NULL, 50000.00, '', '2025-01-14 15:43:26', 3, 2, '2025-01-14 15:43:26', 3, 2),
	(5, 3, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-21 22:41:12', 1, 1, '2025-01-21 22:41:12', 1, 1),
	(6, 3, 1, 1, NULL, NULL, 0.00, '', '2025-01-21 22:47:00', 1, 1, '2025-01-21 22:47:00', 1, 1),
	(7, 4, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-21 23:42:24', 1, 1, '2025-01-21 23:42:24', 1, 1),
	(8, 5, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-21 23:46:31', 1, 1, '2025-01-21 23:46:31', 1, 1);

-- Dumping structure for table greenlms.generalsetting
CREATE TABLE IF NOT EXISTS `pengaturan_umum` (
  `kunci_opsi` varchar(100) NOT NULL,
  `nilai_opsi` varchar(250) DEFAULT NULL,
  UNIQUE KEY `frontendkey` (`kunci_opsi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.generalsetting: ~16 rows (approximately)
INSERT INTO `pengaturan_umum` (`kunci_opsi`, `nilai_opsi`) VALUES
	('address', 'Jl Jend. Sudirman No. 21 Pedurungan Semarang Jawa Tengah'),
	('copyright_by', 'Perpustakaan'),
	('delivery_charge', '0'),
	('ebook_download', '1'),
	('email', 'admin@gmail.com'),
	('frontend', '1'),
	('logo', 'db56c739b986b678b346e00f79c8ea95dd147fe493518c7bd04aa57212f3b59e447057c9e32c4f1a763f738875c0dcd9b4a50d7d3e996bd2a8ad51551c58e1f9.png'),
	('paypal_payment_method', '0'),
	('phone', '08884018148'),
	('registration', '1'),
	('settheme', 'green'),
	('sitename', 'PERPUSTAKAAN'),
	('stripe_key', ''),
	('stripe_payment_method', '0'),
	('stripe_secret', ''),
	('web_address', 'http://localhost/greenlms/');

-- Dumping structure for table greenlms.income
CREATE TABLE IF NOT EXISTS `pemasukan` (
  `id_pemasukan` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `tanggal` datetime NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `file` varchar(200) DEFAULT NULL,
  `nama_file_asli` varchar(200) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_pemasukan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.income: ~2 rows (approximately)
INSERT INTO `pemasukan` (`id_pemasukan`, `nama`, `tanggal`, `jumlah`, `file`, `nama_file_asli`, `catatan`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 'Biaya Denda', '2025-01-01 00:00:00', 8000.00, '', '', '', '2025-01-14 15:45:29', 3, 2, '2025-01-14 15:45:29', 3, 2),
	(2, 'Biaya Buku Hilang', '2025-01-01 00:00:00', 50000.00, '', '', '', '2025-01-14 15:45:50', 3, 2, '2025-01-14 15:45:50', 3, 2);

-- Dumping structure for table greenlms.libraryconfigure
CREATE TABLE IF NOT EXISTS `konfigurasi_perpustakaan` (
  `id_konfigurasi_perpustakaan` int NOT NULL AUTO_INCREMENT,
  `id_peran` int NOT NULL,
  `maksimal_buku_pinjaman` int NOT NULL,
  `batas_maksimal_perpanjangan` int NOT NULL,
  `hari_batas_perpanjangan` int NOT NULL,
  `denda_buku_per_hari` decimal(11,0) NOT NULL,
  `jumlah_batas_pinjaman` decimal(11,0) NOT NULL,
  PRIMARY KEY (`id_konfigurasi_perpustakaan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.libraryconfigure: ~4 rows (approximately)
INSERT INTO `konfigurasi_perpustakaan` (`id_konfigurasi_perpustakaan`, `id_peran`, `maksimal_buku_pinjaman`, `batas_maksimal_perpanjangan`, `hari_batas_perpanjangan`, `denda_buku_per_hari`, `jumlah_batas_pinjaman`) VALUES
	(1, 1, 0, 0, 0, 0, 200),
	(2, 2, 0, 0, 0, 0, 150),
	(3, 3, 2, 2, 14, 1000, 100),
	(4, 4, 0, 0, 0, 0, 50);

-- Dumping structure for table greenlms.member
CREATE TABLE IF NOT EXISTS `anggota` (
  `id_anggota` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(60) NOT NULL,
  `tanggal_lahir` datetime DEFAULT NULL,
  `jenis_kelamin` varchar(15) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `surel` varchar(60) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `golongan_darah` varchar(20) NOT NULL,
  `alamat` text,
  `tanggal_bergabung` datetime DEFAULT NULL,
  `foto` varchar(200) NOT NULL,
  `nama_pengguna` varchar(60) NOT NULL,
  `kata_sandi` varchar(128) NOT NULL,
  `id_peran` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=New, 1=active, 2=Block',
  `dihapus_pada` tinyint DEFAULT '0' COMMENT '0 = Not Deleted, 1 = Deleted',
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.member: ~4 rows (approximately)
INSERT INTO `anggota` (`id_anggota`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `surel`, `telepon`, `golongan_darah`, `alamat`, `tanggal_bergabung`, `foto`, `nama_pengguna`, `kata_sandi`, `id_peran`, `status`, `dihapus_pada`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 'admin', '2025-01-01 00:00:00', 'Male', 'Islam', 'admin@admin.com', '08884018148', 'O+', 'Jl Gemah Kencana VI No 2 Gemah Pedurungan Semarang', '2025-01-01 00:00:00', '', 'admin', '0a030acac45b16fc1b9eaa25f8c7201cc316b70c581814c0c08cfba36720d21bd5cd636e547f079b57107df400eb186081f42b41928042a3bb18b73b4e612a68', 1, 1, 0, '2025-01-01 20:50:39', 1, 1, '2025-01-13 06:36:47', 1, 1),
	(2, 'librarian cantik', '2025-01-01 00:00:00', 'Female', 'Islam', 'librarian@gmail.com', '628884018148', 'O+', 'Semarang', '2025-01-01 00:00:00', 'default.png', 'librarian', '747fbf3a7bc7ddc272c209fc90574395517028de5b8e0f3967b55e2b4cf4fbc88e0ca483bff97a518f25df473b5e8da26ecd8efe31133cc1497631a8d11b774a', 2, 1, 0, '2025-01-01 21:51:27', 1, 1, '2025-01-01 21:51:27', 1, 1),
	(3, 'Petugas 001', '2025-01-01 00:00:00', 'Male', 'Islam', 'sasa@gmail.com', '085640565699', 'O+', '-', '2025-01-01 00:00:00', 'default.png', 'petugas', 'c99874f9b883033080cb607fbc372bf47c6a1678cc1d4eb7bc62207154e9171036c37cb73996608f739502a4e2646e26db3ddd0a4fccfbf1d7f26613e8d8866c', 2, 1, 0, '2025-01-13 06:39:48', 1, 1, '2025-01-13 06:39:48', 1, 1),
	(4, 'Susi Similikiti', '2025-01-01 00:00:00', 'Female', 'Islam', 'susi@gmail.com', '62888999111', 'O+', '-', '2025-01-01 00:00:00', '570fc63321fc07ffec6135e78030ebdf834cbb98f74853690c0570631a808962e1e531fe254affe4a564c019771b7272b02d221e94dee2d54df32adcbf271f70.png', 'susi', '5c01ca4b02065ccb46f1c5384aeec5ca99e96bc9da6af6b25676f4bf2ca872c336f163f6a0d330ec62465abab067f238b9d985ac3acc94fe983c12a4db69f850', 3, 1, 0, '2025-01-14 15:31:13', 0, 0, '2025-01-14 15:34:00', 1, 1);

-- Dumping structure for table greenlms.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(128) NOT NULL,
  `tautan_menu` varchar(128) NOT NULL,
  `ikon_menu` varchar(128) DEFAULT NULL,
  `prioritas` int NOT NULL DEFAULT '500',
  `id_menu_induk` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.menu: ~39 rows (approximately)
INSERT INTO `menu` (`id_menu`, `nama_menu`, `tautan_menu`, `ikon_menu`, `prioritas`, `id_menu_induk`, `status`) VALUES
	(1, 'dashboard', 'dashboard', 'fa fa-dashboard', 500, 0, 1),
	(2, 'bookissue', 'bookissue', 'fa lms-educational-book', 500, 0, 1),
	(3, 'member', 'member', 'fa fa-user-plus', 500, 0, 1),
	(4, 'ebook', 'ebook', 'fa lms-study', 500, 0, 1),
	(5, 'books', '#', 'fa lms-book', 500, 0, 1),
	(6, 'book', 'book', 'fa fa-book', 500, 5, 1),
	(7, 'rack', 'rack', 'fa lms-bookshelf', 500, 5, 1),
	(8, 'bookcategory', 'bookcategory', 'fa lms-notebook', 500, 5, 1),
	(9, 'bookbarcode', 'bookbarcode', 'fa fa-barcode', 500, 5, 1),
	(10, 'requestbook', 'requestbook', 'fa lms-professor', 500, 0, 1),
	(11, 'storemanagement', '#', 'fa fa-shopping-cart', 500, 0, 1),
	(12, 'order', 'order', 'fa fa-first-order', 500, 11, 1),
	(13, 'storebook', 'storebook', 'fa fa-book', 0, 11, 1),
	(14, 'storebookcategory', 'storebookcategory', 'fa lms-notebook', 0, 11, 1),
	(15, 'emailsend', 'emailsend', 'fa fa-envelope', 500, 0, 1),
	(16, 'account', '#', 'fa lms-merchant', 500, 0, 1),
	(17, 'income', 'income', 'fa lms-incomes', 500, 16, 1),
	(18, 'expense', 'expense', 'fa lms-salary', 500, 16, 1),
	(19, 'reports', '#', 'fa fa-clipboard', 500, 0, 1),
	(20, 'bookreport', 'bookreport', 'fa lms-library', 500, 19, 1),
	(21, 'bookissuereport', 'bookissuereport', 'fa lms-writing', 500, 19, 1),
	(22, 'memberreport', 'memberreport', 'fa lms-community', 500, 19, 1),
	(23, 'idcardreport', 'idcardreport', 'fa lms-id-card', 500, 19, 1),
	(24, 'transactionreport', 'transactionreport', 'fa fa-credit-card', 500, 19, 1),
	(25, 'bookbarcodereport', 'bookbarcodereport', 'fa fa-barcode', 0, 19, 1),
	(26, 'administrator', '#', 'fa fa-lock', 500, 0, 1),
	(27, 'menu', 'menu', 'fa fa-bars', 500, 26, 1),
	(28, 'role', 'role', 'fa fa-users', 500, 26, 1),
	(29, 'emailtemplate', 'emailtemplate', 'fa lms-template-design', 500, 26, 1),
	(30, 'permissions', 'permissions', 'fa fa-balance-scale', 500, 26, 1),
	(31, 'permissionlog', 'permissionlog', 'fa fa-key', 500, 26, 1),
	(32, 'update', 'update', 'fa fa-upload', 0, 26, 1),
	(33, 'backup', 'backup', 'fa fa-download', 0, 26, 1),
	(34, 'settings', '#', 'fa fa-cogs', 500, 0, 1),
	(35, 'generalsetting', 'generalsetting', 'fa fa-cog', 500, 34, 1),
	(36, 'emailsetting', 'emailsetting', 'fa lms-open-envelope', 500, 34, 1),
	(37, 'libraryconfigure', 'libraryconfigure', 'fa lms-settings', 500, 34, 1),
	(38, 'themesetting', 'themesetting', 'fa fa-paint-brush', 0, 34, 1),
	(39, 'paymentsetting', 'paymentsetting', 'fa fa-credit-card-alt', 0, 34, 1);

-- Dumping structure for table greenlms.newsletter
CREATE TABLE IF NOT EXISTS `buletin` (
  `id_buletin` int NOT NULL AUTO_INCREMENT,
  `surel` varchar(200) NOT NULL,
  `verifikasi` int NOT NULL DEFAULT '0',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_buletin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.newsletter: ~0 rows (approximately)

-- Dumping structure for table greenlms.orderitems
CREATE TABLE IF NOT EXISTS `item_pesanan` (
  `id_item_pesanan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pesanan` bigint unsigned NOT NULL,
  `id_buku_toko` bigint unsigned NOT NULL,
  `jumlah` int unsigned NOT NULL,
  `harga_satuan` double(13,2) unsigned NOT NULL,
  `sub_total` double(13,2) unsigned NOT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT NULL,
  `tanggal_diubah` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_item_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.orderitems: ~0 rows (approximately)
INSERT INTO `item_pesanan` (`id_item_pesanan`, `id_pesanan`, `id_buku_toko`, `jumlah`, `harga_satuan`, `sub_total`, `tanggal_dibuat`, `tanggal_diubah`) VALUES
	(1, 1, 1, 1, 40000.00, 40000.00, '2025-01-14 04:33:07', '2025-01-14 04:33:07');

-- Dumping structure for table greenlms.orders
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id_pesanan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_anggota` bigint unsigned NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seluler` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya_pengiriman` double(13,2) unsigned NOT NULL,
  `sub_total` double(13,2) unsigned NOT NULL,
  `total` double(13,2) unsigned NOT NULL,
  `status_pembayaran` tinyint unsigned NOT NULL COMMENT 'PAID=5, UNPAID=10',
  `metode_pembayaran` tinyint unsigned NOT NULL COMMENT 'CASH_ON_DELIVERY=5',
  `jumlah_dibayar` double(13,2) unsigned NOT NULL,
  `harga_diskon` double(13,2) unsigned NOT NULL DEFAULT '0.00',
  `lainnya` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint unsigned NOT NULL COMMENT 'PENDING = 5, CANCEL = 10, REJECT = 15, ACCEPT = 20, PROCESS = 25, ON_THE_WAY = 30, COMPLETED = 35',
  `catatan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT NULL,
  `tanggal_diubah` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.orders: ~0 rows (approximately)
INSERT INTO `pesanan` (`id_pesanan`, `id_anggota`, `nama`, `alamat`, `seluler`, `surel`, `biaya_pengiriman`, `sub_total`, `total`, `status_pembayaran`, `metode_pembayaran`, `jumlah_dibayar`, `harga_diskon`, `lainnya`, `status`, `catatan`, `tanggal_dibuat`, `tanggal_diubah`) VALUES
	(1, 1, 'Alex', 'Jakarta', '8884018148', 'alex@gmail.com', 0.00, 40000.00, 40000.00, 15, 5, 40000.00, 0.00, NULL, 30, '-', '2025-01-14 04:33:06', '2025-01-14 04:33:06');

-- Dumping structure for table greenlms.paymentanddiscount
CREATE TABLE IF NOT EXISTS `pembayaran_dan_diskon` (
  `id_pembayaran_dan_diskon` int NOT NULL AUTO_INCREMENT,
  `id_peminjaman_buku` int NOT NULL,
  `jumlah_pembayaran` decimal(10,2) NOT NULL,
  `jumlah_diskon` decimal(10,2) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_pembayaran_dan_diskon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.paymentanddiscount: ~2 rows (approximately)
INSERT INTO `pembayaran_dan_diskon` (`id_pembayaran_dan_diskon`, `id_peminjaman_buku`, `jumlah_pembayaran`, `jumlah_diskon`, `catatan`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 1, 8000.00, 0.00, '', '2025-01-14 15:38:59', 3, 2, '2025-01-14 15:38:59', 3, 2),
	(2, 2, 50000.00, 0.00, '', '2025-01-14 15:44:23', 3, 2, '2025-01-14 15:44:23', 3, 2);

-- Dumping structure for table greenlms.permissionlog
CREATE TABLE IF NOT EXISTS `catatan_izin` (
  `id_catatan_izin` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `deskripsi` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `aktif` enum('yes','no') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id_catatan_izin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.permissionlog: ~95 rows (approximately)
INSERT INTO `catatan_izin` (`id_catatan_izin`, `nama`, `deskripsi`, `aktif`) VALUES
	(1, 'dashboard', 'Dashboard', 'yes'),
	(2, 'bookissue', 'Book Issue', 'yes'),
	(3, 'bookissue_add', 'Book Issue Add', 'yes'),
	(4, 'bookissue_edit', 'Book Issue Edit', 'yes'),
	(5, 'bookissue_view', 'Book Issue View', 'yes'),
	(6, 'bookissue_delete', 'Book Issue Delete', 'yes'),
	(7, 'member', 'Member', 'yes'),
	(8, 'member_add', 'Member Add', 'yes'),
	(9, 'member_edit', 'Member Edit', 'yes'),
	(10, 'member_view', 'Member View', 'yes'),
	(11, 'member_delete', 'Member Delete', 'yes'),
	(12, 'ebook', 'Ebook', 'yes'),
	(13, 'ebook_add', 'Ebook Add', 'yes'),
	(14, 'ebook_edit', 'Ebook Edit', 'yes'),
	(15, 'ebook_view', 'Ebook View', 'yes'),
	(16, 'ebook_delete', 'Ebook Delete', 'yes'),
	(17, 'book', 'Book', 'yes'),
	(18, 'book_add', 'Book Add', 'yes'),
	(19, 'book_edit', 'Book Edit', 'yes'),
	(20, 'book_delete', 'Book Delete', 'yes'),
	(21, 'book_view', 'Book View', 'yes'),
	(22, 'rack', 'Rack', 'yes'),
	(23, 'rack_add', 'Rack Add', 'yes'),
	(24, 'rack_edit', 'Rack Edit', 'yes'),
	(25, 'rack_delete', 'Rack Delete', 'yes'),
	(26, 'bookcategory', 'Bool Category', 'yes'),
	(27, 'bookcategory_add', 'Book Category Add', 'yes'),
	(28, 'bookcategory_edit', 'Book Category Edit', 'yes'),
	(29, 'bookcategory_delete', 'Book Category Delete', 'yes'),
	(30, 'requestbook', 'Request Book', 'yes'),
	(31, 'requestbook_add', 'Request Book Add', 'yes'),
	(32, 'requestbook_edit', 'Request Book Edit', 'yes'),
	(33, 'requestbook_view', 'Request Book View', 'yes'),
	(34, 'requestbook_delete', 'Request Book Delete', 'yes'),
	(35, 'emailsend', 'emailsend', 'yes'),
	(36, 'emailsend_add', 'Emailsend Add', 'yes'),
	(37, 'emailsend_view', 'Emailsend View', 'yes'),
	(38, 'emailsend_delete', 'Emailsend Delete', 'yes'),
	(39, 'income', 'Income', 'yes'),
	(40, 'income_add', 'Income Add', 'yes'),
	(41, 'income_edit', 'Income Edit', 'yes'),
	(42, 'income_delete', 'Income Delete', 'yes'),
	(43, 'expense', 'Expense', 'yes'),
	(44, 'expense_add', 'Expense Add', 'yes'),
	(45, 'expense_edit', 'Expense Edit', 'yes'),
	(46, 'expense_delete', 'Expense Delete', 'yes'),
	(47, 'bookreport', 'Book Report', 'yes'),
	(48, 'bookissuereport', 'Book Issue Report', 'yes'),
	(49, 'memberreport', 'Member Report', 'yes'),
	(50, 'idcardreport', 'ID Card Report', 'yes'),
	(51, 'transactionreport', 'Transaction Report', 'yes'),
	(52, 'menu', 'Menu', 'yes'),
	(53, 'menu_add', 'Menu Add', 'yes'),
	(54, 'menu_edit', 'Menu Edit', 'yes'),
	(55, 'menu_delete', 'Menu Delete', 'yes'),
	(56, 'role', 'Role', 'yes'),
	(57, 'role_add', 'Role Add', 'yes'),
	(58, 'role_edit', 'Role Edit', 'yes'),
	(59, 'role_delete', 'Role Delete', 'yes'),
	(60, 'emailsetting', 'Email Setting', 'yes'),
	(61, 'emailtemplate', 'Email template', 'yes'),
	(62, 'emailtemplate_add', 'Email Template Add', 'yes'),
	(63, 'emailtemplate_edit', 'Email Template Edit', 'yes'),
	(64, 'emailtemplate_delete', 'Email Template Delete', 'yes'),
	(65, 'emailtemplate_view', 'Email Template', 'yes'),
	(66, 'permissions', 'Permissions', 'yes'),
	(67, 'permissionlog', 'Permissionlog', 'yes'),
	(68, 'permissionlog_add', 'Permissionlog', 'yes'),
	(69, 'permissionlog_edit', 'Permissionlog', 'yes'),
	(70, 'permissionlog_delete', 'Permissionlog', 'yes'),
	(71, 'generalsetting', 'General Setting', 'yes'),
	(73, 'libraryconfigure', 'Library Configure', 'yes'),
	(74, 'libraryconfigure_add', 'Library Configure Add', 'yes'),
	(75, 'libraryconfigure_edit', 'Library Configure Edit', 'yes'),
	(76, 'libraryconfigure_delete', 'Library Configure Delete', 'yes'),
	(77, 'themesetting', 'Theme Setting', 'yes'),
	(78, 'backup', 'Backup', 'yes'),
	(79, 'update', 'Update', 'yes'),
	(80, 'bookbarcodereport', 'Book Barcode Report', 'yes'),
	(81, 'bookbarcode', 'Book Barcode', 'yes'),
	(82, 'smssetting', 'SMS Setting', 'yes'),
	(83, 'storebookcategory', 'Store Book Category', 'yes'),
	(84, 'storebookcategory_add', 'Store Book Category Add', 'yes'),
	(85, 'storebookcategory_edit', 'Store Book Category Edit', 'yes'),
	(86, 'storebookcategory_view', 'Store Book Category View', 'yes'),
	(87, 'storebookcategory_delete', 'Store Book Category Delete', 'yes'),
	(88, 'storebook', 'Store Book', 'yes'),
	(89, 'storebook_add', 'Store Book Add', 'yes'),
	(90, 'storebook_edit', 'Store Book Edit', 'yes'),
	(91, 'storebook_view', 'Store Book View', 'yes'),
	(92, 'storebook_delete', 'Store Book Delete', 'yes'),
	(93, 'order', 'Order', 'yes'),
	(94, 'order_view', 'Order View', 'yes'),
	(95, 'order_edit', 'Order Edit', 'yes'),
	(96, 'paymentsetting', 'Payment Setting', 'yes');

-- Dumping structure for table greenlms.permissions
CREATE TABLE IF NOT EXISTS `izin` (
  `id_catatan_izin` int NOT NULL,
  `id_peran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table greenlms.permissions: ~186 rows (approximately)
INSERT INTO `izin` (`id_catatan_izin`, `id_peran`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(6, 1),
	(5, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(11, 1),
	(10, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(16, 1),
	(15, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(34, 1),
	(33, 1),
	(35, 1),
	(36, 1),
	(38, 1),
	(37, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(45, 1),
	(46, 1),
	(47, 1),
	(48, 1),
	(49, 1),
	(50, 1),
	(51, 1),
	(52, 1),
	(53, 1),
	(54, 1),
	(55, 1),
	(56, 1),
	(57, 1),
	(58, 1),
	(59, 1),
	(60, 1),
	(61, 1),
	(62, 1),
	(63, 1),
	(64, 1),
	(65, 1),
	(66, 1),
	(67, 1),
	(68, 1),
	(69, 1),
	(70, 1),
	(71, 1),
	(73, 1),
	(74, 1),
	(75, 1),
	(76, 1),
	(77, 1),
	(78, 1),
	(79, 1),
	(80, 1),
	(81, 1),
	(82, 1),
	(83, 1),
	(84, 1),
	(85, 1),
	(87, 1),
	(86, 1),
	(88, 1),
	(89, 1),
	(90, 1),
	(92, 1),
	(91, 1),
	(93, 1),
	(95, 1),
	(94, 1),
	(96, 1),
	(1, 2),
	(2, 2),
	(3, 2),
	(4, 2),
	(6, 2),
	(5, 2),
	(7, 2),
	(8, 2),
	(9, 2),
	(10, 2),
	(12, 2),
	(13, 2),
	(14, 2),
	(16, 2),
	(15, 2),
	(17, 2),
	(18, 2),
	(19, 2),
	(20, 2),
	(21, 2),
	(22, 2),
	(23, 2),
	(24, 2),
	(25, 2),
	(26, 2),
	(27, 2),
	(28, 2),
	(29, 2),
	(30, 2),
	(31, 2),
	(32, 2),
	(34, 2),
	(33, 2),
	(35, 2),
	(36, 2),
	(38, 2),
	(37, 2),
	(39, 2),
	(40, 2),
	(41, 2),
	(42, 2),
	(43, 2),
	(44, 2),
	(45, 2),
	(46, 2),
	(47, 2),
	(48, 2),
	(49, 2),
	(50, 2),
	(51, 2),
	(80, 2),
	(81, 2),
	(83, 2),
	(84, 2),
	(85, 2),
	(87, 2),
	(86, 2),
	(88, 2),
	(89, 2),
	(90, 2),
	(92, 2),
	(91, 2),
	(93, 2),
	(95, 2),
	(94, 2),
	(1, 3),
	(2, 3),
	(5, 3),
	(7, 3),
	(10, 3),
	(12, 3),
	(15, 3),
	(17, 3),
	(21, 3),
	(22, 3),
	(26, 3),
	(30, 3),
	(31, 3),
	(32, 3),
	(34, 3),
	(33, 3),
	(35, 3),
	(36, 3),
	(37, 3),
	(81, 3),
	(83, 3),
	(86, 3),
	(88, 3),
	(91, 3),
	(93, 3),
	(94, 3);

-- Dumping structure for table greenlms.rack
CREATE TABLE IF NOT EXISTS `rak` (
  `rackID` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`rackID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.rack: ~2 rows (approximately)
INSERT INTO `rak` (`rackID`, `nama`, `deskripsi`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, '100', 'Filasat', '2025-01-14 11:16:15', 1, 1, '2025-01-14 11:16:15', 1, 1),
	(2, '200', 'Komputer', '2025-01-14 11:16:31', 1, 1, '2025-01-14 11:16:31', 1, 1);

-- Dumping structure for table greenlms.requestbook
CREATE TABLE IF NOT EXISTS `permintaan_buku` (
  `id_permintaan_buku` int NOT NULL AUTO_INCREMENT,
  `id_anggota` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `foto_sampul` varchar(200) NOT NULL,
  `id_kategori_buku` int NOT NULL,
  `nomor_isbn` varchar(100) DEFAULT NULL,
  `nomor_edisi` varchar(50) DEFAULT NULL,
  `tanggal_edisi` date DEFAULT NULL,
  `penerbit` varchar(50) DEFAULT NULL,
  `tanggal_terbit` date DEFAULT NULL,
  `catatan` text,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0= Request Book, 1= Request Book Accepet, 2= Request Book Rejected',
  `dihapus_pada` tinyint NOT NULL DEFAULT '0' COMMENT '0= Request Book Not Deleted, 1=Request Book Deleted ',
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_permintaan_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.requestbook: ~0 rows (approximately)

-- Dumping structure for table greenlms.resetpassword
CREATE TABLE IF NOT EXISTS `reset_kata_sandi` (
  `id_reset_kata_sandi` int NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(60) NOT NULL,
  `surel` varchar(60) NOT NULL,
  `kode` varchar(11) NOT NULL,
  `id_anggota` int NOT NULL,
  `id_peran` int NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  PRIMARY KEY (`id_reset_kata_sandi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.resetpassword: ~0 rows (approximately)

-- Dumping structure for table greenlms.role
CREATE TABLE IF NOT EXISTS `peran` (
  `id_peran` int unsigned NOT NULL AUTO_INCREMENT,
  `peran` varchar(30) NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `id_peran_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  `id_peran_pengubah` int NOT NULL,
  PRIMARY KEY (`id_peran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.role: ~4 rows (approximately)
INSERT INTO `peran` (`id_peran`, `peran`, `tanggal_dibuat`, `id_anggota_pembuat`, `id_peran_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`, `id_peran_pengubah`) VALUES
	(1, 'Admin', '2019-09-25 20:19:22', 1, 1, '2019-09-25 20:19:22', 1, 1),
	(2, 'Librarian', '2019-09-25 20:19:32', 1, 1, '2020-01-29 23:32:27', 1, 1),
	(3, 'Member', '2019-09-25 20:19:39', 1, 1, '2019-11-03 00:03:22', 1, 1),
	(4, 'Customer', '2019-12-10 20:38:31', 1, 1, '2019-12-10 20:38:31', 1, 1);

-- Dumping structure for table greenlms.storebook
CREATE TABLE IF NOT EXISTS `buku_toko` (
  `id_buku_toko` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `id_kategori_buku_toko` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `nomor_isbn` varchar(100) NOT NULL,
  `foto_sampul` varchar(200) NOT NULL,
  `nomor_kode` varchar(100) NOT NULL,
  `nomor_edisi` varchar(100) NOT NULL,
  `tanggal_edisi` datetime DEFAULT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tanggal_terbit` datetime DEFAULT NULL,
  `catatan` text NOT NULL,
  `deskripsi` text NOT NULL,
  `status` tinyint NOT NULL COMMENT '0= Book Available, 1= Book Not Available',
  `dihapus_pada` tinyint NOT NULL COMMENT '0= Book Available, 1=Book Deleted ',
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  PRIMARY KEY (`id_buku_toko`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.storebook: ~0 rows (approximately)
INSERT INTO `buku_toko` (`id_buku_toko`, `nama`, `penulis`, `id_kategori_buku_toko`, `jumlah`, `harga`, `nomor_isbn`, `foto_sampul`, `nomor_kode`, `nomor_edisi`, `tanggal_edisi`, `penerbit`, `tanggal_terbit`, `catatan`, `deskripsi`, `status`, `dihapus_pada`, `tanggal_dibuat`, `id_anggota_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`) VALUES
	(1, 'Bahasa Inggris Dasar Untuk Mahasiswa', '-', 1, 3, 40000.00, '12345677', 'c6c82b8b2fedc4f2d0c5a4bbbc8d4fdcecaa62ba6c64c053bf0e4c1684a49b8a8051e354b98f0670e18eafef426dcf5e7529904f132883d2f09f198c3bdce65d.png', '100.100.0001', '1', '2025-01-07 00:00:00', 'UN Press', '2025-01-07 00:00:00', '-', '-', 0, 0, '2025-01-14 11:31:14', 1, '2025-01-14 11:31:14', 1);

-- Dumping structure for table greenlms.storebookcategory
CREATE TABLE IF NOT EXISTS `kategori_buku_toko` (
  `id_kategori_buku_toko` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_sampul` varchar(255) NOT NULL,
  `status` tinyint NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `id_anggota_pembuat` int NOT NULL,
  `tanggal_diubah` datetime NOT NULL,
  `id_anggota_pengubah` int NOT NULL,
  PRIMARY KEY (`id_kategori_buku_toko`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.storebookcategory: ~0 rows (approximately)
INSERT INTO `kategori_buku_toko` (`id_kategori_buku_toko`, `nama`, `deskripsi`, `foto_sampul`, `status`, `tanggal_dibuat`, `id_anggota_pembuat`, `tanggal_diubah`, `id_anggota_pengubah`) VALUES
	(1, 'Buku Komputer', '-', 'storebookcategory.jpg', 1, '2025-01-13 06:44:41', 3, '2025-01-13 06:44:41', 3);

-- Dumping structure for table greenlms.storebookimage
CREATE TABLE IF NOT EXISTS `gambar_buku_toko` (
  `id_gambar_buku_toko` int NOT NULL AUTO_INCREMENT,
  `id_buku_toko` int NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `nama_klien` varchar(255) NOT NULL,
  `meta` text NOT NULL,
  PRIMARY KEY (`id_gambar_buku_toko`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.storebookimage: ~0 rows (approximately)

-- Dumping structure for table greenlms.updates
CREATE TABLE IF NOT EXISTS `pembaruan` (
  `id_pembaruan` int NOT NULL AUTO_INCREMENT,
  `versi` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `id_anggota` int NOT NULL,
  `status` tinyint NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_pembaruan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.updates: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
