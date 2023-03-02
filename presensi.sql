-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Mar 2023 pada 03.39
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_absen`
--

CREATE TABLE `t_absen` (
  `id_absen` int(11) NOT NULL,
  `nip` bigint(30) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `lokasi_absen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_absen`
--

INSERT INTO `t_absen` (`id_absen`, `nip`, `tanggal`, `jam_masuk`, `jam_pulang`, `lokasi_absen`) VALUES
(2, 22011, '2021-10-01', '07:05:00', '16:10:00', '0.888806, 104.580654'),
(3, 22011, '2021-10-04', '07:10:00', '16:20:00', '0.888806, 104.580654'),
(4, 22011, '2021-10-05', '07:40:00', '16:32:00', '0.888806, 104.580654'),
(5, 22011, '2021-10-06', '07:35:00', '16:15:00', '0.888806, 104.580654'),
(6, 22011, '2021-10-07', '07:43:00', '16:08:00', '0.888806, 104.580654'),
(7, 22011, '2021-10-08', '08:05:00', '16:10:00', '0.888806, 104.580654'),
(8, 22011, '2021-10-11', '07:05:00', '15:38:00', '0.888806, 104.580654'),
(9, 22011, '2021-10-12', '07:35:00', '16:15:00', '0.888806, 104.580654'),
(10, 22011, '2021-10-13', '07:42:00', '16:21:00', '0.888806, 104.580654'),
(11, 22011, '2021-10-14', '07:38:00', '16:31:00', '0.888806, 104.580654'),
(12, 22011, '2021-10-15', '07:10:00', '16:10:00', '0.888806, 104.580654'),
(13, 22011, '2021-10-18', '07:05:00', '16:11:00', '0.888806, 104.580654'),
(14, 22011, '2021-10-19', '07:37:00', '16:20:00', '0.888806, 104.580654'),
(15, 22011, '2021-10-21', '07:40:00', '16:35:00', '0.888806, 104.580654'),
(16, 22011, '2021-10-22', '07:02:00', '16:08:00', '0.888806, 104.580654'),
(17, 22011, '2021-10-25', '07:13:00', NULL, '0.888806, 104.580654'),
(19, 10023, '2021-10-18', '07:09:00', '16:45:00', '0.888806, 104.580654'),
(20, 10023, '2021-10-19', '07:15:00', '16:50:00', '0.888806, 104.580654'),
(21, 10023, '2021-10-20', '08:40:00', NULL, '0.888806, 104.580654'),
(22, 10023, '2021-10-21', '07:39:00', '16:35:00', '0.888806, 104.580654'),
(23, 10023, '2021-10-22', '07:33:00', '16:28:00', '0.888806, 104.580654'),
(24, 10023, '2021-10-25', '07:23:00', NULL, '0.888806, 104.580654'),
(28, 10025, '2021-12-27', '11:39:11', NULL, 'No Location'),
(29, 22011, '2021-12-27', '11:47:59', NULL, '1.1300779, 104.0529207'),
(30, 10023, '2022-01-20', NULL, '14:29:31', 'No Location'),
(31, 10023, '2022-02-09', '07:39:28', '19:39:30', '1.1042816, 104.0482304'),
(32, 22011, '2022-02-09', '21:30:15', NULL, 'searching...'),
(33, 10025, '2022-02-10', NULL, '17:48:58', 'No Location'),
(34, 22011, '2022-02-13', '10:58:32', NULL, '1.1246915, 104.0362587'),
(36, 10023, '2022-02-15', NULL, '17:13:41', 'No Location'),
(38, 22011, '2022-02-15', '07:19:03', '17:19:03', 'No Location'),
(39, 10025, '2022-02-15', '08:30:03', '15:19:22', 'No Location'),
(40, 10023, '2022-02-17', '09:24:42', '15:15:36', 'No Location'),
(41, 42020, '2021-12-06', '09:24:42', '15:24:59', 'No Location'),
(42, 42009, '2021-12-01', '07:05:00', '16:10:00', '0.888806, 104.580654'),
(43, 42009, '2021-12-02', '07:10:00', '16:20:00', '0.888806, 104.580654'),
(44, 42009, '2021-12-03', '07:40:00', '16:32:00', '0.888806, 104.580654'),
(45, 42009, '2021-12-06', '07:35:00', '16:15:00', '0.888806, 104.580654'),
(46, 42009, '2021-12-07', '07:43:00', '16:08:00', '0.888806, 104.580654'),
(47, 42009, '2021-12-08', '07:05:00', '16:10:00', '0.888806, 104.580654'),
(48, 42009, '2021-12-09', '07:05:00', '16:10:00', '0.888806, 104.580654'),
(49, 42009, '2021-12-10', '07:35:00', '16:15:00', '0.888806, 104.580654'),
(50, 42009, '2021-12-13', '07:42:00', '16:21:00', '0.888806, 104.580654'),
(51, 42009, '2021-12-14', '07:38:00', '16:31:00', '0.888806, 104.580654'),
(52, 42009, '2021-12-15', '07:10:00', '16:10:00', '0.888806, 104.580654'),
(53, 42009, '2021-12-16', '07:05:00', '16:11:00', '0.888806, 104.580654'),
(54, 42009, '2021-12-17', '07:37:00', '16:20:00', '0.888806, 104.580654'),
(55, 42009, '2021-12-20', '07:40:00', '16:35:00', '0.888806, 104.580654'),
(56, 42009, '2021-12-21', '07:02:00', '16:08:00', '0.888806, 104.580654'),
(57, 42009, '2021-12-22', '07:32:00', '16:17:00', '0.888806, 104.580654'),
(58, 42009, '2021-12-23', '07:22:00', '16:18:00', '0.888806, 104.580654'),
(59, 42009, '2021-12-24', '07:17:00', '16:28:00', '0.888806, 104.580654'),
(60, 42009, '2021-12-27', '07:47:00', '16:38:00', '0.888806, 104.580654'),
(61, 42009, '2021-12-28', '07:51:00', '16:48:00', '0.888806, 104.580654'),
(62, 42009, '2021-12-29', '07:25:00', '16:58:00', '0.888806, 104.580654'),
(63, 42009, '2021-12-30', '07:05:00', '16:30:00', '0.888806, 104.580654'),
(64, 42009, '2021-12-31', '07:13:00', NULL, '0.888806, 104.580654'),
(78, 42020, '2021-12-01', '08:05:00', '15:10:00', '0.888806, 104.580654'),
(79, 42020, '2021-12-02', '08:10:00', '15:20:00', '0.888806, 104.580654'),
(80, 42020, '2021-12-03', '08:40:00', '15:32:00', '0.888806, 104.580654'),
(81, 42020, '2021-12-07', '08:43:00', '15:08:00', '0.888806, 104.580654'),
(82, 42020, '2021-12-08', '08:05:00', '15:10:00', '0.888806, 104.580654'),
(83, 42020, '2021-12-09', '08:05:00', '15:10:00', '0.888806, 104.580654'),
(84, 42020, '2021-12-10', '08:35:00', '15:15:00', '0.888806, 104.580654'),
(87, 42020, '2021-12-20', NULL, '15:20:00', '0.888806, 104.580654'),
(88, 42020, '2021-12-21', '07:40:00', '15:32:00', '0.888806, 104.580654'),
(89, 10023, '2022-02-18', '07:29:38', NULL, 'No Location'),
(90, 22011, '2022-02-18', '07:46:27', NULL, 'No Location'),
(91, 10023, '2022-02-20', NULL, '21:25:28', 'No Location'),
(92, 22011, '2022-02-21', '14:13:52', NULL, 'No Location');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_cuti`
--

CREATE TABLE `t_cuti` (
  `time` datetime NOT NULL,
  `nip` bigint(30) NOT NULL,
  `tgl_dari` date NOT NULL,
  `tgl_sampai` date NOT NULL,
  `jenis_cuti` int(11) NOT NULL,
  `alasan` varchar(200) NOT NULL,
  `status_cuti` int(11) NOT NULL,
  `bukti` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_cuti`
--

INSERT INTO `t_cuti` (`time`, `nip`, `tgl_dari`, `tgl_sampai`, `jenis_cuti`, `alasan`, `status_cuti`, `bukti`) VALUES
('2022-02-22 16:28:08', 22011, '2022-02-22', '2022-03-31', 2, 'kelahiran anak pertama', 2, '1645515835_8151.png'),
('2022-02-22 16:52:40', 22011, '2022-03-02', '2022-03-16', 3, 'cuti nikahan sodara', 1, '1645523560_5245.pdf'),
('2022-02-22 17:46:39', 10023, '2022-02-23', '2022-02-25', 4, 'asd', 2, '1645526747_5325.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_desk_kegiatan`
--

CREATE TABLE `t_desk_kegiatan` (
  `id_deskripsi` int(11) NOT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `jam_dari` time NOT NULL,
  `jam_sampai` time NOT NULL,
  `lampiran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_desk_kegiatan`
--

INSERT INTO `t_desk_kegiatan` (`id_deskripsi`, `id_kegiatan`, `title`, `deskripsi`, `jam_dari`, `jam_sampai`, `lampiran`) VALUES
(9, 9, 'ujian', 'asdf', '09:14:00', '10:14:00', '1632708906_7797.pdf'),
(13, 5, 'asd', 'asd', '01:39:00', '01:39:00', '1635356436_5582.png'),
(14, 6, 'qwe', 'qwe', '01:42:00', '01:42:00', '1635356547_6056.jpg'),
(15, 8, 'perjusami', 'acara perjusami', '08:13:00', '20:13:00', '1635686033_4679.png'),
(16, 8, 'pbm', 'mengajar  pemdas', '09:30:00', '10:30:00', '1635821609_4139.jpg'),
(17, 9, 'pbm', 'Mata pelajaran Web', '10:36:00', '11:15:00', '1635824272_3603.jpg'),
(19, 10, 'pbm', 'kegiatan mengajar', '09:00:00', '10:15:00', '1635992624_4512.png'),
(20, 10, 'pbm', 'mengajar web', '11:00:00', '12:00:00', '1635994355_6110.png'),
(21, 9, 'pbm web', 'mengajar pelajaran web', '13:15:00', '14:15:00', '1636039455_7765.jpg'),
(22, 11, 'mengajar', 'mengajar bahasa indonesia', '08:40:00', '10:40:00', '1640580632_3165.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_dl`
--

CREATE TABLE `t_dl` (
  `time` datetime NOT NULL,
  `no_spt` varchar(30) DEFAULT NULL,
  `nip1` bigint(30) NOT NULL,
  `nip2` bigint(30) DEFAULT NULL,
  `nip3` bigint(30) DEFAULT NULL,
  `nip4` bigint(30) DEFAULT NULL,
  `nip5` bigint(30) DEFAULT NULL,
  `tgl_berangkat` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status_dl` int(11) NOT NULL,
  `bukti` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_dl`
--

INSERT INTO `t_dl` (`time`, `no_spt`, `nip1`, `nip2`, `nip3`, `nip4`, `nip5`, `tgl_berangkat`, `tgl_kembali`, `status_dl`, `bukti`) VALUES
('2022-02-22 16:28:13', '12345', 22011, 20045, NULL, NULL, NULL, '2022-02-17', '2022-02-18', 2, '1645461927_2172.pdf'),
('2022-02-22 17:46:48', '321321', 10023, 20369, 12016, NULL, NULL, '2022-02-23', '2022-02-24', 2, '1645526771_6047.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_jabatan`
--

CREATE TABLE `t_jabatan` (
  `id_jbtn` int(11) NOT NULL,
  `nama_jbtn` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_jabatan`
--

INSERT INTO `t_jabatan` (`id_jbtn`, `nama_jbtn`) VALUES
(1, 'Kepala Sekolah'),
(2, 'Guru Pegawai Negeri Sipil'),
(3, 'Staff Tata Usaha'),
(4, 'Administrator'),
(5, 'Guru Tidak Tetap Provinsi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_jenis_cuti`
--

CREATE TABLE `t_jenis_cuti` (
  `id_jenis_cuti` int(11) NOT NULL,
  `jenis_cuti` varchar(30) NOT NULL,
  `kedaluwarsa` int(11) NOT NULL,
  `max_bulan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_jenis_cuti`
--

INSERT INTO `t_jenis_cuti` (`id_jenis_cuti`, `jenis_cuti`, `kedaluwarsa`, `max_bulan`) VALUES
(1, 'cuti alasan penting', 3, 1),
(2, 'cuti bersalin', 1, 3),
(3, 'cuti besar', 1, 3),
(4, 'cuti sakit', 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kegiatan`
--

CREATE TABLE `t_kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `nip` bigint(30) NOT NULL,
  `tanggal_kegiatan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_kegiatan`
--

INSERT INTO `t_kegiatan` (`id_kegiatan`, `nip`, `tanggal_kegiatan`) VALUES
(3, 22011, '2021-10-20'),
(5, 22011, '2021-10-28'),
(6, 22003, '2021-10-28'),
(7, 22011, '2021-10-31'),
(8, 22011, '2021-11-22'),
(9, 22003, '2021-11-04'),
(10, 22011, '2021-11-04'),
(11, 22011, '2021-12-27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_ph`
--

CREATE TABLE `t_ph` (
  `tanggal` date NOT NULL,
  `keterangan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_ph`
--

INSERT INTO `t_ph` (`tanggal`, `keterangan`) VALUES
('2020-01-01', 'Tahun Baru 2020'),
('2021-01-01', 'Tahun Baru 2021'),
('2021-08-11', 'Tahun Baru Islam'),
('2021-08-17', 'Hari Kemerdekaan'),
('2022-02-17', 'Hari Teh Tarik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_setting`
--

CREATE TABLE `t_setting` (
  `status_setting` int(1) NOT NULL,
  `absen_datang` time NOT NULL,
  `absen_pulang` time NOT NULL,
  `logo` varchar(50) NOT NULL,
  `lokasi` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_setting`
--

INSERT INTO `t_setting` (`status_setting`, `absen_datang`, `absen_pulang`, `logo`, `lokasi`) VALUES
(1, '08:00:00', '16:00:00', 'logo.png', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_status_pengajuan`
--

CREATE TABLE `t_status_pengajuan` (
  `id_status_pengajuan` int(11) NOT NULL,
  `status_pengajuan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_status_pengajuan`
--

INSERT INTO `t_status_pengajuan` (`id_status_pengajuan`, `status_pengajuan`) VALUES
(1, 'pengajuan'),
(2, 'setuju'),
(3, 'tolak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `nip` bigint(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `akses` enum('admin','kepala','pegawai') NOT NULL,
  `gol` varchar(10) NOT NULL,
  `jk` enum('laki-laki','perempuan') NOT NULL,
  `jbtn` int(11) NOT NULL,
  `gambar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`nip`, `pass`, `nama`, `akses`, `gol`, `jk`, `jbtn`, `gambar`) VALUES
(10023, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Briyan', 'pegawai', '-', 'laki-laki', 5, '1636304018_8316.png'),
(10025, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Yoga', 'pegawai', '-', 'laki-laki', 5, '1636304018_1502.png'),
(10026, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Febri', 'pegawai', '-', 'laki-laki', 5, '1636304018_1855.png'),
(10037, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Parizal', 'pegawai', '-', 'perempuan', 3, '1636304018_4908.png'),
(10039, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Lena', 'pegawai', '-', 'perempuan', 5, '1636304018_7675.png'),
(10049, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Tika', 'pegawai', '-', 'perempuan', 5, '1636304018_8224.png'),
(10050, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Yarsini', 'pegawai', '-', 'perempuan', 5, '1636304018_7914.png'),
(10069, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Rian', 'pegawai', '-', 'laki-laki', 5, '1636304018_7349.png'),
(10071, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Adi Fikri', 'pegawai', '-', 'laki-laki', 3, '1636304018_2679.png'),
(11007, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Yanto', 'pegawai', 'III/B', 'laki-laki', 2, '1636304017_1957.png'),
(11009, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Dede', 'pegawai', 'III/A', 'laki-laki', 2, '1636304018_8122.png'),
(11010, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Risal', 'pegawai', 'III/B', 'laki-laki', 2, '1636304017_6996.png'),
(12005, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Sartika', 'pegawai', 'III/A', 'perempuan', 2, '1636304018_3669.png'),
(12016, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Nia Arsi', 'pegawai', 'III/B', 'perempuan', 2, '1636304017_4184.png'),
(12024, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Ela', 'pegawai', 'III/B', 'perempuan', 2, '1636304017_5674.png'),
(12034, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Imah', 'pegawai', 'III/C', 'perempuan', 2, '1636304017_4675.png'),
(12345, 'd74682ee47c3fffd5dcd749f840fcdd4', 'admin', 'admin', '-', 'laki-laki', 4, '1629539520_1769.jpg'),
(20045, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Hardi', 'pegawai', '-', 'laki-laki', 3, '1639315709_5110.png'),
(20058, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Rani', 'pegawai', '-', 'perempuan', 3, '1639315709_8933.png'),
(20368, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Ame', 'pegawai', '-', 'laki-laki', 3, '1636304018_1512.png'),
(20369, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Sidik', 'pegawai', '-', 'perempuan', 3, '1636304018_7501.png'),
(20371, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Astuti', 'pegawai', '-', 'laki-laki', 3, '1636304018_5336.png'),
(20388, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Santoso', 'pegawai', '-', 'laki-laki', 3, '1636304018_1173.png'),
(20409, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Wawan', 'pegawai', '-', 'perempuan', 3, '1636304018_2284.png'),
(20410, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Ira Astuti', 'pegawai', '-', 'laki-laki', 3, '1636304018_5487.png'),
(20417, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Dodi Slamet', 'pegawai', '-', 'laki-laki', 3, '1636304019_9040.png'),
(22001, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Wahyu', 'pegawai', 'III/C', 'laki-laki', 2, '1636304017_6071.png'),
(22003, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Uniza', 'pegawai', 'III/C', 'perempuan', 2, '1622210404_1817.png'),
(22007, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Sisi', 'pegawai', 'III/C', 'perempuan', 2, '1636304017_6756.png'),
(22011, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Sriani', 'kepala', 'IV/B', 'perempuan', 1, '1635437546_2523.jpg'),
(31003, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Berto', 'pegawai', 'III/A', 'laki-laki', 2, '1636304018_6438.png'),
(32002, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Rianty', 'pegawai', 'III/B', 'perempuan', 2, '1636304017_4984.png'),
(32003, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Juju', 'pegawai', 'III/B', 'perempuan', 2, '1636304017_7270.png'),
(32005, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Yati', 'pegawai', 'III/B', 'perempuan', 2, '1636304017_5732.png'),
(41013, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Hari', 'pegawai', 'III/C', 'laki-laki', 2, '1636304017_4756.png'),
(42009, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Wati', 'pegawai', 'III/C', 'perempuan', 2, '1636304017_8231.png'),
(42020, 'd74682ee47c3fffd5dcd749f840fcdd4', 'Miarsih', 'pegawai', 'III/A', 'perempuan', 2, '1636304018_6695.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_absen`
--
ALTER TABLE `t_absen`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `nip` (`nip`);

--
-- Indeks untuk tabel `t_cuti`
--
ALTER TABLE `t_cuti`
  ADD PRIMARY KEY (`time`),
  ADD KEY `nip` (`nip`),
  ADD KEY `jenis_cuti` (`jenis_cuti`),
  ADD KEY `status_cuti` (`status_cuti`);

--
-- Indeks untuk tabel `t_desk_kegiatan`
--
ALTER TABLE `t_desk_kegiatan`
  ADD PRIMARY KEY (`id_deskripsi`),
  ADD KEY `id_kegiatan` (`id_kegiatan`);

--
-- Indeks untuk tabel `t_dl`
--
ALTER TABLE `t_dl`
  ADD PRIMARY KEY (`time`),
  ADD KEY `nip1` (`nip1`),
  ADD KEY `nip2` (`nip2`),
  ADD KEY `nip3` (`nip3`),
  ADD KEY `nip4` (`nip4`),
  ADD KEY `nip5` (`nip5`),
  ADD KEY `status_dl` (`status_dl`);

--
-- Indeks untuk tabel `t_jabatan`
--
ALTER TABLE `t_jabatan`
  ADD PRIMARY KEY (`id_jbtn`);

--
-- Indeks untuk tabel `t_jenis_cuti`
--
ALTER TABLE `t_jenis_cuti`
  ADD PRIMARY KEY (`id_jenis_cuti`);

--
-- Indeks untuk tabel `t_kegiatan`
--
ALTER TABLE `t_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `nip` (`nip`);

--
-- Indeks untuk tabel `t_ph`
--
ALTER TABLE `t_ph`
  ADD PRIMARY KEY (`tanggal`);

--
-- Indeks untuk tabel `t_setting`
--
ALTER TABLE `t_setting`
  ADD PRIMARY KEY (`status_setting`);

--
-- Indeks untuk tabel `t_status_pengajuan`
--
ALTER TABLE `t_status_pengajuan`
  ADD PRIMARY KEY (`id_status_pengajuan`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `jbtn` (`jbtn`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_absen`
--
ALTER TABLE `t_absen`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT untuk tabel `t_desk_kegiatan`
--
ALTER TABLE `t_desk_kegiatan`
  MODIFY `id_deskripsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `t_jabatan`
--
ALTER TABLE `t_jabatan`
  MODIFY `id_jbtn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `t_jenis_cuti`
--
ALTER TABLE `t_jenis_cuti`
  MODIFY `id_jenis_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `t_kegiatan`
--
ALTER TABLE `t_kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `t_status_pengajuan`
--
ALTER TABLE `t_status_pengajuan`
  MODIFY `id_status_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_absen`
--
ALTER TABLE `t_absen`
  ADD CONSTRAINT `t_absen_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_cuti`
--
ALTER TABLE `t_cuti`
  ADD CONSTRAINT `t_cuti_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_cuti_ibfk_2` FOREIGN KEY (`jenis_cuti`) REFERENCES `t_jenis_cuti` (`id_jenis_cuti`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_cuti_ibfk_3` FOREIGN KEY (`status_cuti`) REFERENCES `t_status_pengajuan` (`id_status_pengajuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_desk_kegiatan`
--
ALTER TABLE `t_desk_kegiatan`
  ADD CONSTRAINT `t_desk_kegiatan_ibfk_1` FOREIGN KEY (`id_kegiatan`) REFERENCES `t_kegiatan` (`id_kegiatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_dl`
--
ALTER TABLE `t_dl`
  ADD CONSTRAINT `t_dl_ibfk_1` FOREIGN KEY (`nip1`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_dl_ibfk_2` FOREIGN KEY (`nip2`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_dl_ibfk_3` FOREIGN KEY (`nip3`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_dl_ibfk_4` FOREIGN KEY (`nip4`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_dl_ibfk_5` FOREIGN KEY (`nip5`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_dl_ibfk_6` FOREIGN KEY (`status_dl`) REFERENCES `t_status_pengajuan` (`id_status_pengajuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_kegiatan`
--
ALTER TABLE `t_kegiatan`
  ADD CONSTRAINT `t_kegiatan_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `t_user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`jbtn`) REFERENCES `t_jabatan` (`id_jbtn`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
