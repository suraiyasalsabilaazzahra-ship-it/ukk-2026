<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Hapus terlebih dahulu data relasi terkait di tabel anak agar tidak terkena Foreign Key constraint
    @mysqli_query($koneksi, "DELETE FROM t_kelas_siswa WHERE tahun_ajaran_id = '$id'");
    @mysqli_query($koneksi, "DELETE FROM t_wali_kelas WHERE tahun_ajaran_id = '$id'");
    // Tambahkan tabel lain jika ada relasi lain yang menggunakan tahun_ajaran_id
    // Contoh: @mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE tahun_ajaran_id = '$id'");

    // Setelah relasinya dibersihkan, hapus data tahun ajaran utama
    $query = "DELETE FROM t_tahun_ajaran WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data tahun ajaran beserta relasi terkait berhasil dihapus!'); window.location.href = '../dashboard.php?tab=menu5';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data tahun ajaran: " . mysqli_error($koneksi) . "'); window.location.href = '../dashboard.php?tab=menu5';</script>";
        exit();
    }
} else {
    header("Location: ../dashboard.php?tab=menu5");
    exit();
}
?>