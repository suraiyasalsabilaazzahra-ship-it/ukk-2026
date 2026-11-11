<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    $query = "DELETE FROM t_tahun_ajaran WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data tahun ajaran berhasil dihapus!'); window.location.href = '../dashboard.php?tab=menu5';</script>";
        exit();
    } else {
        // Menangkap error database dan menampilkan pesan peringatan yang ramah
        echo "<script>alert('Gagal menghapus! Data tahun ajaran ini masih terhubung dengan data kelas atau siswa.'); window.location.href = '../dashboard.php?tab=menu5';</script>";
        exit();
    }
} else {
    header("Location: ../dashboard.php?tab=menu5");
    exit();
}
?>