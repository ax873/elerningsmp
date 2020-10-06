-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2020 pada 09.40
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esemupaten`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(3) NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT 'administrator',
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL DEFAULT 'admin',
  `alamat` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `blokir` enum('Y','N') NOT NULL DEFAULT 'N',
  `id_session` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `level`, `alamat`, `no_telp`, `email`, `blokir`, `id_session`) VALUES
(4, 'ekoprasetyo', '4fd7245fff490237c08a8f5799f31d37', 'Eko Prasetyo', 'admin', 'Kasih', '085802458328', 'Kieqolby@gmail.com', 'N', 'n9umt2dv8ier7gt5la5qomai1j'),
(3, 'faizalamin', 'c5c453d299d4b338b6460d595be70986', 'Faizal Amin', 'admin', 'Kertanegara', '085865723694', 'faizalamin300799@gmail.com', 'N', '8pqte5qfgvkftqa5819f5h9qs5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
--

CREATE TABLE `chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_materi`
--

CREATE TABLE `file_materi` (
  `id_file` int(7) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `id_matapelajaran` varchar(5) NOT NULL,
  `nama_file` varchar(100) NOT NULL,
  `tgl_posting` date NOT NULL,
  `pembuat` varchar(50) NOT NULL,
  `hits` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `file_materi`
--

INSERT INTO `file_materi` (`id_file`, `judul`, `id_kelas`, `id_matapelajaran`, `nama_file`, `tgl_posting`, `pembuat`, `hits`) VALUES
(78, 'prakarya', 'K7', 'KVII1', '1183-2432-1-PB.pdf', '2020-05-29', '15', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id` int(50) NOT NULL,
  `id_tq` int(50) NOT NULL,
  `id_quiz` int(50) NOT NULL,
  `id_siswa` int(50) NOT NULL,
  `jawaban` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jawaban`
--

INSERT INTO `jawaban` (`id`, `id_tq`, `id_quiz`, `id_siswa`, `jawaban`) VALUES
(5, 28, 77, 5, 'persamaan kata'),
(6, 28, 78, 5, 'perlawanan kata'),
(7, 29, 79, 5, 'persamaan kata'),
(8, 29, 80, 5, 'pelawanaan kata'),
(9, 29, 79, 11, 'persamaan'),
(10, 29, 80, 11, 'perlawanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(5) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_pengajar` int(9) NOT NULL,
  `id_siswa` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `id_kelas`, `nama`, `id_pengajar`, `id_siswa`) VALUES
(55, 'K8', 'VIII', 17, 0),
(56, 'K9', 'IX', 18, 0),
(54, 'K7', 'VII', 15, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(5) NOT NULL,
  `id_matapelajaran` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `id_pengajar` int(9) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `id_matapelajaran`, `nama`, `id_kelas`, `id_pengajar`, `deskripsi`) VALUES
(78, 'KVII2', 'Prakarya', 'K7', 16, ''),
(75, 'KVII4', 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'K7', 21, ''),
(77, 'KVII3', 'Ilmu Pengetahuan Sosial (IPS)', 'K7', 17, ''),
(79, 'KVII1', 'Pendidikan Agama Islam dan Budi Pekerti', 'K7', 15, ''),
(80, 'KVII5', 'Pendidikan Pancasila dan Kewarganegaraan ', 'K7', 12, ''),
(81, 'KVII6', 'Ilmu Pengetahuan Alam (IPA)', 'K7', 14, ''),
(82, 'KVII7', 'Bahasa Inggris', 'K7', 16, ''),
(83, 'KVII8', 'Matematika (Umum)', 'K7', 17, ''),
(84, 'KVII9', 'Bahasa Indonesia', 'K7', 18, ''),
(85, 'KVII10', 'Seni dan Budaya ', 'K7', 14, ''),
(86, 'KVII11', 'Muatan Lokal Bahasa Daerah', 'K7', 15, ''),
(87, 'KVIII1', 'Ilmu Pengetahuan Sosial (IPS)', 'K8', 19, ''),
(88, 'KVIII2', 'Seni dan Budaya ', 'K8', 14, ''),
(89, 'KVIII3', 'Pendidikan Agama Islam dan Budi Pekerti', 'K8', 15, ''),
(90, 'KVIII4', 'Prakarya', 'K8', 16, ''),
(91, 'KVIII5', 'Ilmu Pengetahuan Alam (IPA)', 'K8', 14, ''),
(92, 'KVIII6', 'Matematika (Umum)', 'K8', 17, ''),
(93, 'KVIII7', 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'K8', 21, ''),
(94, 'KVIII8', 'Bahasa Inggris', 'K8', 16, ''),
(95, 'KVIII10', 'Pendidikan Pancasila dan Kewarganegaraan ', 'K8', 12, ''),
(96, 'KVIII11', 'Bahasa Indonesia', 'K8', 18, ''),
(97, 'KVIII12', 'Muatan Lokal Bahasa Daerah', 'K8', 15, ''),
(98, 'KIX1', 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'K9', 21, ''),
(99, 'KIX2', 'Ilmu Pengetahuan Sosial (IPS)', 'K9', 19, ''),
(100, 'KIX3', 'Pendidikan Agama Islam dan Budi Pekerti', 'K9', 15, ''),
(101, 'KIX4', 'Muatan Lokal Bahasa Daerah', 'K9', 18, ''),
(102, 'KIX5', 'Ilmu Pengetahuan Alam (IPA)', 'K9', 14, ''),
(103, 'KIX6', 'Matematika (Umum)', 'K9', 17, ''),
(104, 'KIX7', 'Bahasa Inggris', 'K9', 16, ''),
(105, 'KIX8', 'Bahasa Indonesia', 'K9', 18, ''),
(106, 'KIX9', 'Pendidikan Pancasila dan Kewarganegaraan ', 'K9', 12, ''),
(107, 'KIX10', 'Seni dan Budaya ', 'K9', 14, ''),
(108, 'KIX11', 'Pendidikan Keterampilan', 'K9', 15, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul`
--

CREATE TABLE `modul` (
  `id_modul` int(5) NOT NULL,
  `nama_modul` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `link` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `static_content` text COLLATE latin1_general_ci NOT NULL,
  `gambar` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `publish` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `status` enum('pengajar','admin') COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `urutan` int(5) NOT NULL,
  `link_seo` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `modul`
--

INSERT INTO `modul` (`id_modul`, `nama_modul`, `link`, `static_content`, `gambar`, `publish`, `status`, `aktif`, `urutan`, `link_seo`) VALUES
(2, 'Manajemen Admin', '?module=admin', '', '', 'N', 'admin', 'Y', 2, ''),
(18, 'Materi', '?module=materi', '', '', 'N', 'pengajar', 'Y', 6, 'semua-berita.html'),
(37, 'Manajemen Siswa', '?module=siswa', '', 'gedungku.jpg', 'Y', 'admin', 'Y', 3, 'profil-kami.html'),
(10, 'Manajemen Modul', '?module=modul', '', '', 'N', 'admin', 'N', 1, ''),
(31, 'Mata Pelajaran', '?module=matapelajaran', '', '', 'Y', 'pengajar', 'Y', 5, ''),
(63, 'Manajemen Quiz', '?module=quiz', '', '', 'N', 'pengajar', 'Y', 7, ''),
(41, 'Manajemen Kelas', ' ?module=kelas', '', '', 'N', 'pengajar', 'Y', 4, 'semua-agenda.html'),
(65, 'Registrasi Siswa', '?module=registrasi', '', '', 'Y', 'admin', 'Y', 8, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int(50) NOT NULL,
  `id_tq` int(50) NOT NULL,
  `id_siswa` int(50) NOT NULL,
  `benar` int(10) NOT NULL,
  `salah` int(10) NOT NULL,
  `tidak_dikerjakan` int(50) NOT NULL,
  `persentase` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id`, `id_tq`, `id_siswa`, `benar`, `salah`, `tidak_dikerjakan`, `persentase`) VALUES
(1, 29, 5, 2, 0, 0, 100),
(2, 30, 7, 4, 1, 0, 80),
(3, 29, 11, 2, 0, 0, 100),
(4, 33, 61, 2, 0, 0, 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_soal_esay`
--

CREATE TABLE `nilai_soal_esay` (
  `id` int(50) NOT NULL,
  `id_tq` int(50) NOT NULL,
  `id_siswa` int(50) NOT NULL,
  `nilai` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nilai_soal_esay`
--

INSERT INTO `nilai_soal_esay` (`id`, `id_tq`, `id_siswa`, `nilai`) VALUES
(14, 29, 5, '80');

-- --------------------------------------------------------

--
-- Struktur dari tabel `online`
--

CREATE TABLE `online` (
  `ip` varchar(20) NOT NULL,
  `id_siswa` int(50) NOT NULL,
  `tanggal` date NOT NULL,
  `online` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `online`
--

INSERT INTO `online` (`ip`, `id_siswa`, `tanggal`, `online`) VALUES
('::1', 7, '2020-05-22', 'T'),
('127.0.0.1', 5, '2011-07-14', 'T'),
('::1', 9, '2011-12-28', 'T'),
('::1', 11, '2020-05-18', 'T'),
('::1', 27, '2020-05-22', 'T'),
('::1', 61, '2020-05-29', 'T'),
('::1', 62, '2020-05-26', 'T');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajar`
--

CREATE TABLE `pengajar` (
  `id_pengajar` int(9) NOT NULL,
  `nip` char(12) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username_login` varchar(100) NOT NULL,
  `password_login` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL DEFAULT 'pengajar',
  `alamat` text NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `jabatan` varchar(200) NOT NULL,
  `blokir` enum('Y','N') NOT NULL DEFAULT 'N',
  `id_session` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengajar`
--

INSERT INTO `pengajar` (`id_pengajar`, `nip`, `nama_lengkap`, `username_login`, `password_login`, `level`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `agama`, `no_telp`, `email`, `foto`, `website`, `jabatan`, `blokir`, `id_session`) VALUES
(14, '873376066113', 'Heny Purwosari', 'henypurwosari', 'd9db3c8e53b22d14a11e5856ca47f564', 'pengajar', 'Kertanegara', 'Purbalingga', '1982-04-01', 'P', 'Islam', '085642532539', 'henypurwosari@ymail.com', '', 'http://', 'Guru', 'N', 'gas3brqtddot9bgv250q7evore'),
(15, '764575866030', 'Musriyati', 'musriyati', '34bc07918873ca472851d63de6d88d70', 'pengajar', 'Kertanegara', 'Purbalingga', '1980-03-13', 'P', 'Islam', '082242064650', 'achmadmuljono@yahoo.co.id', '', 'http://', 'Guru', 'N', 'p46lio8q08u1fr8jhrl6d4lgmr'),
(13, '056075866013', 'Dwi Lestari', 'dwilestari', '28fb5bc77f72dbc500cd5bb72507c31f', 'pengajar', 'Lumpang', 'Purbalingga', '1980-12-28', 'P', 'Islam', '087737177561', 'dwilestari@yahoo.co.id', '', 'http://', 'Guru', 'N', '0560758660130153'),
(12, '843474064220', 'Dimin', 'dimin', '767b289c0adfea104f0514640d641bac', 'pengajar', 'Condong', 'Purbalingga', '1962-11-02', 'L', 'Islam', '081327412299', 'pakdimin@gmail.com', '', 'http://', 'Guru', 'N', 'rro87s6jg69r4abe49bc4isdau'),
(21, '-', 'Fakhrur Rozi', 'fakhrurrozi', '6a4fc0a3e438ea365506614a223af905', 'pengajar', 'Sidotopo', 'Surabaya', '1989-09-01', 'L', 'Islam', '085717513537', 'fahrurrozi@gmail.com', '', 'http://', 'Guru', 'N', '-'),
(16, '665675865930', 'Ratnawati Hidayah', 'ratnawatihidayah', '09006f47fb79affe78f1d4fe90270a58', 'pengajar', 'Kertanegara', 'Purbalingga', '1980-03-24', 'P', 'Islam', '085226444054', 'ratnawatihidayah@yahoo.com', '', 'http://', 'Guru', 'N', '6656758659300042'),
(17, '344177067013', 'Rina Ciptaningsih', 'rinaciptaningsih', '31a93bab078d32c6504ce1a436429258', 'pengajar', 'Tamansari', 'Purbalingga', '1992-01-09', 'P', 'Islam', '085328779837', 'rinaciptaningsih91@gmail.com', '', 'http://', 'Guru', 'N', 'f8hnkeidreo296ob61nrtuovj8'),
(18, '023775565630', 'Septi Andriyani', 'septiandriyani', '3b0bed8595085ca89afc81799a7bd8c6', 'pengajar', 'Kabunderan', 'Purbalingga', '1977-09-05', 'P', 'Islam', '085869664002', 'septiandriyani442@yahoo.com', '', 'http://', 'Guru', 'N', '0237755656300013'),
(19, '744475265430', 'Susanti Dewi Ratnawati', 'susantidewi', '24ee5b4be7fe85e188bd08bcf34b1d03', 'pengajar', 'Sokaraja', 'Purwokerto', '1974-01-12', 'P', 'Islam', '081327531400', 'susantidewi.ratnawati@yahoo.com', '', 'http://', 'Guru', 'N', '7444752654300002'),
(20, '864275565720', 'Sutikno', 'sutikno', '2e173e334419e392e6af7e4743336ea1', 'pengajar', 'Losari', 'Purbalingga', '1977-03-10', 'L', 'Islam', '082325980565', 'ratnatimur@gmail.com', '', 'http://', 'Guru', 'N', '8642755657200002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_esay`
--

CREATE TABLE `quiz_esay` (
  `id_quiz` int(9) NOT NULL,
  `id_tq` int(9) NOT NULL,
  `pertanyaan` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `tgl_buat` date NOT NULL,
  `jenis_soal` varchar(50) NOT NULL DEFAULT 'esay'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `quiz_esay`
--

INSERT INTO `quiz_esay` (`id_quiz`, `id_tq`, `pertanyaan`, `gambar`, `tgl_buat`, `jenis_soal`) VALUES
(79, 29, 'pengertian dari sinonim', '', '2011-07-13', 'esay'),
(80, 29, 'pengertian dari antonim', '', '2011-07-13', 'esay'),
(81, 30, 'kkk', '', '2020-05-23', 'esay'),
(82, 30, 'kkk', '', '2020-05-23', 'esay');

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_pilganda`
--

CREATE TABLE `quiz_pilganda` (
  `id_quiz` int(10) NOT NULL,
  `id_tq` int(9) NOT NULL,
  `pertanyaan` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `pil_a` text NOT NULL,
  `pil_b` text NOT NULL,
  `pil_c` text NOT NULL,
  `pil_d` text NOT NULL,
  `kunci` varchar(1) NOT NULL,
  `tgl_buat` date NOT NULL,
  `jenis_soal` varchar(50) NOT NULL DEFAULT 'pilganda'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `quiz_pilganda`
--

INSERT INTO `quiz_pilganda` (`id_quiz`, `id_tq`, `pertanyaan`, `gambar`, `pil_a`, `pil_b`, `pil_c`, `pil_d`, `kunci`, `tgl_buat`, `jenis_soal`) VALUES
(204, 29, 'pengertian dari antonim<span class=\"Apple-tab-span\" style=\"white-space:pre\">	</span>', '', 'persamaan', 'perlawanan', 'perumpamaan', 'perulangan', 'B', '2011-07-13', 'pilganda'),
(203, 29, 'pengertina dari sinonim', '', 'persamaan', 'perlawanan', 'perumpamaan', 'perulangan', 'A', '2011-07-13', 'pilganda'),
(205, 30, 'adfa', '', 'asda', 'asdf', 'asdf', 'asdf', 'B', '2012-03-10', 'pilganda'),
(206, 30, 'asdfaasd', '', 'asd', 'asd', 'asdfsd', 'asdf', 'B', '2012-03-10', 'pilganda'),
(207, 30, 'asdfasdf', '', 'asdf', 'asd', 'asd', 'asdfasd', 'B', '2012-03-10', 'pilganda'),
(208, 30, 'fgderd', '', 'sdf', 'asdfgasdfg', 'sdfgs', 'sdf', 'B', '2012-03-10', 'pilganda'),
(209, 30, 'jjhljhlj', '', ';kj', 'kjjh', 'jhkjh', 'kjhkjhjkh', 'B', '2012-03-10', 'pilganda'),
(210, 31, 'test pertanyaan', '', 'iya', 'tidak ', 'bukan', 'bukan sekali', 'C', '2012-03-22', 'pilganda'),
(211, 33, 'Apa yang dimaksud pai', '', 'aa', 'aa', 'aa', 'aa=', 'A', '2020-05-29', 'pilganda'),
(212, 33, 'jjjjj', '', 'iii\r\n', 'kk', 'kk', 'kk]][', 'B', '2020-05-29', 'pilganda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi_siswa`
--

CREATE TABLE `registrasi_siswa` (
  `id_registrasi` int(9) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username_login` varchar(50) NOT NULL,
  `password_login` varchar(50) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `jabatan` varchar(200) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `th_masuk` varchar(4) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `blokir` enum('Y','N') NOT NULL,
  `id_session` varchar(100) NOT NULL,
  `id_session_soal` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'siswa'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(9) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username_login` varchar(50) NOT NULL,
  `password_login` varchar(50) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `jabatan` varchar(200) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `th_masuk` varchar(4) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `blokir` enum('Y','N') NOT NULL,
  `id_session` varchar(100) NOT NULL,
  `id_session_soal` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'siswa'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama_lengkap`, `username_login`, `password_login`, `id_kelas`, `jabatan`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `agama`, `nama_ayah`, `nama_ibu`, `th_masuk`, `email`, `no_telp`, `foto`, `blokir`, `id_session`, `id_session_soal`, `level`) VALUES
(61, '2366', 'AGIL DIAS AGUS SAPUTRA', 'agildias', 'a827835ac4f83fadc8f9b1c41934c412', 'K7', 'Siswa', 'Kasih', 'Purbalingga', '2004-08-05', 'L', 'Islam', 'Barudin', 'Endang', '2020', '-', '-', '', 'N', 'r0h1j9ohmloljlp6spqfvai7bf', '2366', 'siswa'),
(62, '2395', 'AL AZRIL AFLAH PUTRA HARYANTO', 'alazril', 'ce541ab15115dae8eb4869b79aaa14d9', 'K7', 'Siswa', 'Gembor', 'Purbalingga', '2006-09-18', 'L', 'Islam', '-', '-', '2020', '-', '-', '', 'N', 'i7l1q2osut7e6eu650afn322e2', '2395', 'siswa'),
(65, '2369', 'DIMAS GINANJAR', 'dimasginanjar', 'a386f2c103f4e2cff485a24b2c205e57', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-12-02', 'L', 'Islam', 'PURWANTO', 'SOLIKHATUN', '2020', '-', '-', '', 'N', '2369', '2369', 'siswa'),
(63, '2367', 'ASFIYA AYU ALMAMUTIA', 'asfiya', 'e7351e2f8c74829898383271eb4fceee', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-04-03', 'P', 'Islam', 'FARID HIDAYAT', 'SANINAH', '2020', '-', '-', '', 'N', '2367', '2367', 'siswa'),
(64, '2368', 'Cakra Ksuma', 'cakraksuma', 'a53d3fe338b2ce5d0085dcdf2a08e0c2', 'K7', 'Siswa', 'Tunjungmuli', 'Purbalingga', '2007-02-18', 'L', 'Islam', 'Syaekhun', 'Ngatiem', '2020', '-', '-', '', 'N', '2368', '2368', 'siswa'),
(66, '2370', 'EZHA SAPUTRA', 'ezhasaputra', '314c22c9a2fc4fd940601f213e054c92', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-10-30', 'L', 'Islam', 'JUMARIS', 'JUMIATI', '2020', '-', '-', '', 'N', '2370', '2370', 'siswa'),
(67, '2372', 'Iwan Faoji', 'iwanfaoji', '6bc8b15790a8e83cc467a7c83f5bb541', 'K7', 'Siswa', 'Karangtengah', 'Purbalingga', '2006-06-07', 'L', 'Islam', 'Achmad Nurohman', 'SUMARNI', '2020', '-', '-', '', 'N', '2372', '2372', 'siswa'),
(68, '2373', 'Kharisma Pramaysheila Putri', 'kharisma', '8d54d98edb4b4ebdb4a2cc0cffe6eb1f', 'K7', 'Siswa', 'Tajug', 'Purbalingga', '2007-06-10', 'P', 'Islam', 'Saiman Nur Sodik', 'Sulimah', '2020', '-', '-', '', 'N', '2373', '2373', 'siswa'),
(69, '2374', 'Levika Intan Kuwati', 'levika', '2435ae1fe4c5593d7475bf9eedcfedbb', 'K7', 'Siswa', 'Tunjungmuli', 'Purbalingga', '2020-05-20', 'P', 'Islam', 'Sanmiarto', 'Sarniati', '2020', '-', '-', '', 'N', '2374', '2374', 'siswa'),
(70, '2375', 'Miswanto', 'miswanto', 'e817aeadf9092dc01717f8c9d0ca7dd6', 'K7', 'Siswa', 'Karangtengah', 'Purbalingga', '2006-06-05', 'L', 'Islam', 'Sutaryo', 'Khanipah', '2020', '-', '-', '', 'N', '2375', '2375', 'siswa'),
(71, '2376', 'MUHAMMAD MAGHFUR BAFADOL', 'maghfurbafadol', 'c36f9f659764fb0407f70c63e99503ef', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-06-25', 'L', 'Islam', 'Basori', 'Nur Laely', '2020', '-', '-', '', 'N', '2376', '2376', 'siswa'),
(72, '2377', 'Muhammad Nanda Saputra', 'nandasaputra', 'f1fde316fcbef65735e92a794af58852', 'K7', 'Siswa', 'Tunjungmuli', 'Purbalingga', '2005-07-12', 'L', 'Islam', 'Muhammad', 'Nuryati', '2020', '-', '-', '', 'N', '2377', '2377', 'siswa'),
(73, '2378', 'NAYFA SYUKURILLAH', 'nayfasyukurillah', 'fc7830e858ad292e9ad1f453b114368d', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-07-03', 'P', 'Islam', 'ABDUS SYUKURILLAH', 'INDAH TRIASTUTI', '2020', '-', '-', '', 'N', '2378', '2378', 'siswa'),
(74, '2379', 'NAYLA SYUKURILLAH', 'naylasyukurillah', '170805af2af30645f546b9c906906333', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-07-03', 'P', 'Islam', 'ABDUS SYUKURILLAH', 'INDAH TRIASTUTI', '2020', '-', '-', '', 'N', '2379', '2379', 'siswa'),
(75, '2380', 'NAZWA AGUSTIANI', 'nazwaagustiani', 'b43839757c37a49227c06d5f2ed7fcde', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-08-26', 'P', 'Islam', 'SUNARYO', 'SUSIATI', '2020', '-', '-', '', 'N', '2380', '2380', 'siswa'),
(76, '2381', 'NOVAN PRAYOGA', 'novanprayoga', '3394c5476a35280a8ea50917b6e6d0f7', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-11-17', 'L', 'Islam', 'NURUL WAHYUDIN', 'HIKMATUN', '2020', '-', '-', '', 'N', '2381', '2381', 'siswa'),
(77, '2382', 'Nur Halizah', 'nurhalizah', 'cb685ef5b83ba0f8840a024c6a8eec98', 'K7', 'Siswa', 'Karangtengah', 'Purbalingga', '2006-08-19', 'P', 'Islam', '-', 'Ropiah', '2020', '-', '-', '', 'N', '2382', '2382', 'siswa'),
(78, '-', 'Restu Riyanto', 'resturiyanto', 'ef571afa3069638ace140b890e927fd2', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-12-07', 'L', 'Islam', 'Admo', 'Turijah', '2020', '-', '-', '', 'N', '-', '-', 'siswa'),
(79, '2384', 'RESTU SISKA PRATAMA', 'restusiska', 'f031523009e9766ae43a02171ed9ec29', 'K7', 'Siswa', 'Kasih', 'Purbalingga', '2007-07-28', 'P', 'Islam', 'Misto Irwanto', 'HOLIFAH', '2020', '-', '-', '', 'N', '2384', '2384', 'siswa'),
(80, '2385', 'RIFQI TRI BAHTIAR', 'rifqitribahtiar', 'b03b0740e00f1df049c611e8bfaaed71', 'K7', 'Siswa', 'Karangtengah', 'Purbalingga', '2006-01-08', 'L', 'Islam', 'Sartono', 'Soimah', '2020', '-', '-', '', 'N', '2385', '2385', 'siswa'),
(81, '2386', 'Rijal Muttaqien', 'rijalmuttaqien', 'd319f6a5de48e7e715d0d32155c42c33', 'K7', 'Siswa', 'Tunjungmuli', 'Purbalingga', '2006-02-02', 'L', 'Islam', 'Chusnul', 'Sri Atun', '2020', '-', '-', '', 'N', '9h8qehkbcrr37diehg0q3vh904', '2386', 'siswa'),
(84, '2396', 'RIZKYA BUNGA SABRINA', 'rizkyabunga', 'be155efdd0ccbb01acb673112f9e4c1d', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-12-13', 'P', 'Islam', 'Munajat', 'Halimah', '2020', '-', '-', '', 'N', '2396', '2396', 'siswa'),
(85, '2387', 'Robingul Zidan', 'robingulzidan', '8562d3cac49cee4f873448177e957031', 'K7', 'Siswa', 'Karangtengah', 'Purbalingga', '2007-08-08', 'L', 'Islam', '-', 'Mutingah', '2020', '-', '-', '', 'N', '2387', '2387', 'siswa'),
(86, '--', 'ROIIKHAN AL FATIH', 'roiikhan', 'e53317138f1122e5fda473e35356e3a6', 'K7', 'Siswa', 'Kramat', 'Purbalingga', '2007-05-15', 'L', 'Islam', 'Fifanudin', 'Maedah', '2020', '-', '-', '', 'N', '--', '--', 'siswa'),
(87, '2388', 'Salma Nuraini', 'salmanuraini', '84f5a4362655399df0b263cfb62636e3', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2007-03-08', 'P', 'Islam', 'Nyuworo', 'Marsini', '2020', '-', '-', '', 'N', '2388', '2388', 'siswa'),
(88, '---', 'Septiono Ade Irmawan', 'septiono', 'f10f2cbe4fb0e080542a70fe49b6ca3f', 'K7', 'Siswa', 'Tamansari', 'Purbalingga', '2006-09-25', 'L', '0', '-', 'Khamsiyah', '2020', '-', '-', '', 'N', '---', '---', 'siswa'),
(89, '2389', 'TIA DWININGSIH', 'tiadwiningsih', '6341dcff1de4feea5679652f8e793c41', 'K7', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-12-31', 'P', 'Islam', 'Abdul Aziz Suwondo', 'Tumiati', '2020', '-', '-', '', 'N', '2389', '2389', 'siswa'),
(90, '2390', 'Trio Febriawan', 'triofebriawan', 'bd560bedc9fa9d9046f3182005b7262f', 'K7', 'Siswa', 'Karangtengah', 'Purbalingga', '2007-02-05', 'L', 'Islam', 'Sobri Yatin', 'Susi', '2020', '-', '-', '', 'N', '2390', '2390', 'siswa'),
(91, '2391', 'Vidia Astuti', 'vidiaastuti', '98f1fb88afe778ffb04584a2e40f9190', 'K7', 'Siswa', 'Tunjungmuli', 'Purbalingga', '2006-03-13', 'P', 'Islam', 'Salimun', 'Fauziah', '2020', '-', '-', '', 'N', '2391', '2391', 'siswa'),
(92, '2394', 'Vita Andriani', 'vitaandriani', 'b4953cee52d56c23b00d134ba0ce4c67', 'K7', 'Siswa', 'Kaliori', 'Purbalingga', '2004-04-13', 'P', 'Islam', 'Faizal Amin', 'Madkosim', 'Rasi', '-', '-', '', 'N', '2394', '2394', 'siswa'),
(93, '2371', 'Vita Aprilia Pratama', 'vitaaprilia', '18a590ba31d5c7219aed0c4bffd411e1', 'K7', 'Siswa', 'Karangtengah', 'Purbalingga', '2007-05-20', 'P', 'Islam', 'Agus Utomo', 'Tusriyah', '2020', '-', '-', '', 'N', '2371', '2371', 'siswa'),
(94, '232', 'Airin', 'airin', '084b4533b471a1e6e27f2195c7990499', 'K8', 'Siswa', 'Bulakan', 'Pemalang', '2006-05-06', 'P', 'Islam', '-', '-', '2019', '-', '-', '', 'N', '232', '232', 'siswa'),
(95, '2330', 'AMAYLIA RIZRIANANDA', 'amayliarizri', 'db24807bd97cdeb35cb5a8662e8df569', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2006-05-06', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2330', '2330', 'siswa'),
(96, '2331', 'ANDIKA MAULANA', 'andika', '7e51eea5fa101ed4dade9ad3a7a072bb', 'K8', 'Siswa', 'Condong', 'Purbalingga', '2006-07-30', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2331', '2331', 'siswa'),
(97, '2332', 'ANITA KUSUMA WARDANI', 'anitakusuma', 'bd7438b6a2ce08eb7f3b9a2593f5b494', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-01-26', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2332', '2332', 'siswa'),
(98, '2333', 'ARIFIN IRHAM', 'arifinirham', '7185b04db1d76e4e90c770845aded658', 'K8', 'Siswa', 'Karangtengah', 'Purbalingga', '2005-08-30', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2333', '2333', 'siswa'),
(99, '2334', 'AULIA NINGSIH', 'aulianingsih', '2e022460bc6069ca2f83562e6603637f', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-09-19', 'P', 'Islam', 'Faizal Amin', '-', '-', '-', '-', '', 'N', '2334', '2334', 'siswa'),
(100, '2335', 'BAYU NUFRIANTO', 'bayunufrianto', 'a5fc6cdc1a05894344326e1d4067c63e', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2005-11-10', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2335', '2335', 'siswa'),
(101, '2393', 'Bintang Sakti Wijaya', 'bintangsakti', '690796b652c95cf0dbc4597274f4fc5c', 'K8', 'Siswa', 'Poros', 'Purbalingga', '2004-09-08', 'L', 'Islam', '-', '--', '-', '-', '-', '', 'N', '2393', '2393', 'siswa'),
(102, '2336', 'DIAN SAFITRI', 'diansafitri', '740e9cd937cc57f9471c13ee8d17a367', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-03-14', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2336', '2336', 'siswa'),
(103, '2337', 'DYAH AYU SARASWATI', 'dyahayu', 'd11a786c9f0fcff4b9b5f1346667cda4', 'K8', 'Siswa', 'Kertanegara', 'Bekasi', '2006-02-19', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2337', '2337', 'siswa'),
(104, '2338', 'EVA WULANDARI', 'evawulandari', '22ce5114727c8b064a34ca751e86c1b4', 'K8', 'Siswa', 'Kasih', 'Brebes', '2006-04-26', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2338', '2338', 'siswa'),
(105, '2339', 'HEKEL FARASTIYO', 'hekelfarastiyo', '30698ab2ebc205b1a5323dce381781b0', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2005-08-02', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2339', '2339', 'siswa'),
(106, '2340', 'Hendi Arya Putra', 'hendiarya', '977c519c3789c1fc53e9243fe1376052', 'K8', 'Siswa', 'Jambudesa', 'Purbalingga', '2005-04-04', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2340', '2340', 'siswa'),
(107, '----', 'Milla Holilah', 'millaholilah', 'e475e88a59c34b4a2d2183e3db5bc63c', 'K8', 'Siswa', 'Kp. Cinompo', 'Rangkas Bitung', '2006-08-07', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '----', '----', 'siswa'),
(108, '2342', 'MOHAMAD EFAN PRAYOGA', 'mohamadefan', '4209d7e9d0b9f71950c1b0723a0de980', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-04-24', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2342', '2342', 'siswa'),
(109, '2343', 'NICKHO SETYO UTOMO', 'nickhosetyo', '6d35760e3d2d6a23ffbdd67e8dcc7830', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-04-02', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2343', '2343', 'siswa'),
(110, '2344', 'NUR CAHAYA NINGSIH', 'nurcahaya', '847ded134911a539b5f0879b234c5981', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2006-10-30', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2344', '2344', 'siswa'),
(111, '2392', 'Prassandra Rafly', 'prassandra', '5d8971f501eb7b48729b6fbd8f1a1933', 'K8', 'Siswa', 'Adiarsa', 'Purbalingga', '2007-05-27', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2392', '2392', 'siswa'),
(112, '2345', 'RIO BAHARI', 'riobahari', '497c4b951cd617ac3679638f877ebdea', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-12-14', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2345', '2345', 'siswa'),
(113, '2346', 'RISKI BAHTIAR', 'riskibahtiar', '549c4edd0593ee9fd3ff53e10e74a0a5', 'K8', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-05-14', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2346', '2346', 'siswa'),
(114, '2347', 'SAKHIRA AZAHRA', 'sakhiraazahra', '6ac5ca3b6af9c16dc0a4c77d5a8dedd4', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2006-09-29', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2347', '2347', 'siswa'),
(115, '2348', 'SALSABILA ROMADONA', 'salsabila', 'fe1e33bb1f71656d0d06d68e0dd2f8f0', 'K8', 'Siswa', 'Condong', 'Purbalingga', '2005-10-25', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2348', '2348', 'siswa'),
(116, '2417', 'SELOMITA PARTAMA PUTRI', 'selomita', '488ba61540b4a05af7052ab27270cf30', 'K8', 'Siswa', 'Salareuma', 'Kuningan', '2007-04-06', 'P', 'Islam', '-', '--', '-', '-', '-', '', 'N', '2417', '2417', 'siswa'),
(117, '2349', 'SERLA APRIYANI', 'serlaapriyani', 'f129150b9ac798dd05c5f9316750a3ba', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2006-04-18', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2349', '2349', 'siswa'),
(118, '2350', 'SERLI APRIYANI', 'serliapriyani', 'e66afbe65801df8298b98726fd231cd3', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2006-04-18', 'P', 'Islam', '-', '--', '-', '-', '-', '', 'N', '2350', '2350', 'siswa'),
(119, '2398', 'Surya Romadon', 'suryaromadon', '561aa0e555facd5b9d00b73a4447011e', 'K8', 'Siswa', 'Karanganyar', 'Purbalingga', '2005-10-02', 'L', 'Islam', '-', '--', '-', '-', '-', '', 'N', '2398', '2398', 'siswa'),
(120, '2351', 'TIFANI YULI ATIN', 'tifaniyuliatin', 'e0407d7b0bfcf7a282a197f4183eb1ce', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2006-07-24', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2351', '2351', 'siswa'),
(121, '2352', 'TIFINA YULI ATIN', 'tifinayuliatin', '7e258d6104ad312f4bb0aaa2f8cfa728', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2006-07-24', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2352', '2352', 'siswa'),
(122, '2354', 'YANTO', 'yanto', '7849816e52e7d1596c51f3e36f21c498', 'K8', 'Siswa', 'Kasih', 'Purbalingga', '2005-01-21', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2354', '2354', 'siswa'),
(123, '2355', 'YUNUS DZIKRUL HAQ', 'yunus', 'a2c9a5d635f96695f809ce5272736ec5', 'K8', 'Siswa', 'Kertanegara', 'Purwokerto', '2006-02-06', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2355', '2355', 'siswa'),
(124, '2356', 'YUSUF DZIKRUL HAQ', 'yusuf', 'dd2eb170076a5dec97cdbbbbff9a4405', 'K8', 'Siswa', 'Kertanegara', 'Purwokerto', '2006-02-06', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2356', '2356', 'siswa'),
(125, '2298', 'A. Basuki Nur Said Febriyanto', 'basuki', 'b4e364bb5eab14eedd9ae3d54437d52f', 'K9', 'Siswa', 'Kalijaran', 'Purbalingga', '2006-02-12', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2298', '2298', 'siswa'),
(126, '2299', 'Aditya Aprilianto', 'aditya', '057829fa5a65fc1ace408f490be486ac', 'K9', 'Siswa', 'Kalijaran', 'Purbalingga', '2005-04-01', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2299', '2299', 'siswa'),
(127, '2357', 'AKBAR FAUZI', 'akbarfauzi', '234c4af9bf94d62fbc288a5ba14ae1f7', 'K9', 'Siswa', 'Adiarsa', 'Purbalingga', '2004-12-13', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2357', '2357', 'siswa'),
(128, '2300', 'ANA SAFITRI', 'anasafitri', 'a4ad0eba70f50a2a89fdf2527be4e444', 'K9', 'Siswa', 'Kertanegara', 'Sampang', '2005-10-21', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2300', '2300', 'siswa'),
(129, '2301', 'Andika Rahman', 'andikarahman', '6ff9eb4a15f73b8eff3d58e4a841ceb3', 'K9', 'Siswa', 'Mergasana', 'Purbalingga', '2004-01-19', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2301', '2301', 'siswa'),
(130, '2358', 'ANDREANA PUTRA', 'andreanaputra', '6c37c123c45b7f82a10c9107b6ffe2a4', 'K9', 'Siswa', 'Adiarsa', 'Purbalingga', '2004-12-19', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2358', '2358', 'siswa'),
(131, '2302', 'Ardik Putra Pratama', 'ardikputra', '5f31de5e4a3bbcc7fdfc1fc7479d2195', 'K9', 'Siswa', 'Mergasana', 'Purbalingga', '2005-07-13', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2302', '2302', 'siswa'),
(132, '2303', 'CANDRA PAMUNGKAS', 'candrapamungkas', '2f793688b433d00a607acdd712c4d207', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-11-11', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2303', '2303', 'siswa'),
(133, '2304', 'DAFA ARSIMAJID', 'dafaarsimajid', '089ef82ed97583a7a5f724fdf395a399', 'K9', 'Siswa', 'Condong', 'Purbalingga', '2005-03-14', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2304', '2304', 'siswa'),
(134, '2306', 'DEA NADILA RISA', 'deanadila', '3f00182a5bb65a5356bc095cc3e83af9', 'K9', 'Siswa', 'Karangtengah', 'Purbalingga', '2005-07-11', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2306', '2306', 'siswa'),
(135, '2308', 'Dhio Bima Aris Saputra', 'dhiobima', '58ea865567b75c8e7cc6cdea7cf576ba', 'K9', 'Siswa', 'Karangsari', 'Purbalingga', '2005-05-27', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2308', '2308', 'siswa'),
(136, '2359', 'DIAZ AULIA RAMDAN', 'diazaulia', '8d64c7f7e8431ccd269aef219fac75b1', 'K9', 'Siswa', 'Jl. Kayu Putih', 'Kertosari', '2004-10-08', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2359', '2359', 'siswa'),
(137, '2307', 'DIMAS AFGHAN RAFSANJANI', 'dimasafghan', '595c893157f012de1c9ecc9be934734e', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-05-13', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2307', '2307', 'siswa'),
(138, '2309', 'INTAN DWI WULANDARI', 'intandwiwulandari', '8083e269dd26eb92c5ee108aec55d270', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-01-26', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2309', '2309', 'siswa'),
(139, '2310', 'IRFAN FANI', 'irfanfani', '42245b672c62afeb802d722f5fc34085', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-06-01', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2310', '2310', 'siswa'),
(140, '2311', 'Jeliyanti', 'jeliyanti', '7c75994523ea5659f1a7fa0cb43f3a11', 'K9', 'Siswa', 'Celeleng', 'Jakarta', '2005-10-08', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2311', '2311', 'siswa'),
(141, '2312', 'Lasmiati', 'lasmiati', '9ae1f6b1d0a4adef8f5a9725c0e9085c', 'K9', 'Siswa', 'Karanganyar', 'Purbalingga', '2005-01-13', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2312', '2312', 'siswa'),
(142, '2329', 'Lisa Dwi Hidayati', 'lisadwihidayati', '03771b2d291974940940fac7fd507f94', 'K9', 'Siswa', 'Kertanegara', 'Bekasi', '2004-08-31', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2329', '2329', 'siswa'),
(143, '2313', 'LITA PUSPITA RINI', 'litapuspita', '17638608cf4504c23eea25b5b8e7ac44', 'K9', 'Siswa', 'Condong', 'Purbalingga', '2005-06-01', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2313', '2313', 'siswa'),
(144, '2314', 'MARSANDA FEBI SABILA', 'marsandafebi', '354f1f3a7b9047b915a82b77b9cbf1c5', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2004-12-29', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2314', '2314', 'siswa'),
(145, '2315', 'Marsita Utami', 'marsitautami', '55df2e31280e9b3faa325fdb99f845a7', 'K9', 'Siswa', 'Kalisoko', 'Kulon Progo', '2005-03-22', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2315', '2315', 'siswa'),
(146, '2360', 'Miftahudin', 'miftahudin', '26778130d305aa283e51e202d79047b0', 'K9', 'Siswa', 'Darma', 'Purbalingga', '2002-05-03', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2360', '2360', 'siswa'),
(147, '2319', 'Mohamad Saefudin', 'mohamadsaefudin', 'a8ef390fbd388a960ce2684de35be6df', 'K9', 'Siswa', 'Buara', 'Purbalingga', '2003-11-20', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2319', '2319', 'siswa'),
(148, '2318', 'MUHAMAD AL FARIZI', 'muhamadalfarizi', '6800129449f0480a2ae8d410a3fa8aa4', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-02-22', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2318', '2318', 'siswa'),
(149, '2320', 'NUR AFIFAH', 'nurafifah', '87a6c8bbb15d690c3d577374ecfe7d42', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-07-30', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2320', '2320', 'siswa'),
(150, '2322', 'RIZQI DWI SAPUTRA', 'rizqidwisaputra', '4d124e95802e690083d49b243c7f04b5', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-10-06', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2322', '2322', 'siswa'),
(151, '2363', 'RYAN BHAKTI GUNAWAN', 'ryanbhakti', '0e5f24a1ed27519729a3f6ca6294d527', 'K9', 'Siswa', 'Kalijaran', 'Purbalingga', '2005-07-26', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2363', '2363', 'siswa'),
(152, '2317', 'SITI NUR HANIFAH', 'sitinurhanifah', '047d51001350a67cdaa6b0ce796c12af', 'K9', 'Siswa', 'Condong', 'Purbalingga', '2005-04-09', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2317', '2317', 'siswa'),
(153, '2364', 'Tegar Ade Irfanda', 'tegaradeirfanda', '413b55c494f6c5a8c9187a31b4c345d6', 'K9', 'Siswa', 'Karanganyar', 'Purbalingga', '2005-05-02', 'L', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2364', '2364', 'siswa'),
(154, '2324', 'TESA PUSPITASARI', 'tesapuspitasari', 'bfd800cf7acc42b769ff7dce873fa263', 'K9', 'Siswa', 'Celeleng', 'Purbalingga', '2004-11-03', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2324', '2324', 'siswa'),
(155, '2325', 'TIARA SELVIAMITA', 'tiaraselviamita', '780e7b2b7ca871cc08bd1d83161879c3', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2004-07-06', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2325', '2325', 'siswa'),
(156, '2326', 'TITIS KUMALA DEWI', 'titiskumala', 'a76d0c395fdf63e772c1f46f62707f7e', 'K9', 'Siswa', 'Karangtengah', 'Bogor', '2005-06-09', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2326', '2326', 'siswa'),
(157, '2327', 'TRIANA ANDRIANI', 'trianaandriani', '826ea287bbd81e6174e489ea648c97de', 'K9', 'Siswa', 'Kertanegara', 'Purbalingga', '2005-04-16', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2327', '2327', 'siswa'),
(158, '2328', 'USWATUN KHASANAH', 'uswatunkhasanah', 'fd5d271b46d2b2cbde3708b0bec683ff', 'K9', 'Siswa', 'Karangtengah', 'Purbalingga', '2002-01-22', 'P', 'Islam', '-', '-', '-', '-', '-', '', 'N', '2328', '2328', 'siswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_sudah_mengerjakan`
--

CREATE TABLE `siswa_sudah_mengerjakan` (
  `id` int(20) NOT NULL,
  `id_tq` int(20) NOT NULL,
  `id_siswa` varchar(200) NOT NULL,
  `dikoreksi` varchar(1) NOT NULL DEFAULT 'B',
  `hits` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `siswa_sudah_mengerjakan`
--

INSERT INTO `siswa_sudah_mengerjakan` (`id`, `id_tq`, `id_siswa`, `dikoreksi`, `hits`) VALUES
(1, 29, '5', 'S', 1),
(2, 30, '7', 'B', 1),
(3, 29, '11', 'B', 1),
(4, 30, '61', 'B', 1),
(5, 33, '61', 'B', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `topik_quiz`
--

CREATE TABLE `topik_quiz` (
  `id_tq` int(9) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `id_matapelajaran` varchar(10) NOT NULL,
  `tgl_buat` date NOT NULL,
  `pembuat` varchar(100) NOT NULL,
  `waktu_pengerjaan` int(50) NOT NULL,
  `info` text NOT NULL,
  `terbit` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `topik_quiz`
--

INSERT INTO `topik_quiz` (`id_tq`, `judul`, `id_kelas`, `id_matapelajaran`, `tgl_buat`, `pembuat`, `waktu_pengerjaan`, `info`, `terbit`) VALUES
(29, 'Tes Ulangan', '7a', 'BI1', '2011-07-13', '6', 3600, 'mohon dikerjakan dengan benar', 'Y'),
(30, 'Ujian Bahasa Indonesia', 'K7', 'KVII9', '2020-05-23', '18', 5400, 'ini test bahasa indonesia', 'Y'),
(31, 'Test Masuk', '7a', 'M1', '2012-03-22', '1', 3000, '', 'Y'),
(32, 'Quis Bahasa Indonesia', '7a', '', '2020-05-23', 'admin', 3600, '', 'Y'),
(33, 'PAI', 'K7', 'KVII1', '2020-05-29', '15', 3600, '', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `file_materi`
--
ALTER TABLE `file_materi`
  ADD PRIMARY KEY (`id_file`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_soal_esay`
--
ALTER TABLE `nilai_soal_esay`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `pengajar`
--
ALTER TABLE `pengajar`
  ADD PRIMARY KEY (`id_pengajar`);

--
-- Indeks untuk tabel `quiz_esay`
--
ALTER TABLE `quiz_esay`
  ADD PRIMARY KEY (`id_quiz`);

--
-- Indeks untuk tabel `quiz_pilganda`
--
ALTER TABLE `quiz_pilganda`
  ADD PRIMARY KEY (`id_quiz`);

--
-- Indeks untuk tabel `registrasi_siswa`
--
ALTER TABLE `registrasi_siswa`
  ADD PRIMARY KEY (`id_registrasi`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `siswa_sudah_mengerjakan`
--
ALTER TABLE `siswa_sudah_mengerjakan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `topik_quiz`
--
ALTER TABLE `topik_quiz`
  ADD PRIMARY KEY (`id_tq`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `file_materi`
--
ALTER TABLE `file_materi`
  MODIFY `id_file` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT untuk tabel `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `nilai_soal_esay`
--
ALTER TABLE `nilai_soal_esay`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pengajar`
--
ALTER TABLE `pengajar`
  MODIFY `id_pengajar` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `quiz_esay`
--
ALTER TABLE `quiz_esay`
  MODIFY `id_quiz` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `quiz_pilganda`
--
ALTER TABLE `quiz_pilganda`
  MODIFY `id_quiz` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT untuk tabel `registrasi_siswa`
--
ALTER TABLE `registrasi_siswa`
  MODIFY `id_registrasi` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT untuk tabel `siswa_sudah_mengerjakan`
--
ALTER TABLE `siswa_sudah_mengerjakan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `topik_quiz`
--
ALTER TABLE `topik_quiz`
  MODIFY `id_tq` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
