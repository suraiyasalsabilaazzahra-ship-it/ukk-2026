<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Hapus terlebih dahulu data terkait di tabel anak (seperti t_kelas_siswa dan t_wali_kelas)
    @mysqli_query($koneksi, "DELETE FROM t_kelas_siswa WHERE kelas_id = '$id'");
    @mysqli_query($koneksi, "DELETE FROM t_wali_kelas WHERE kelas_id = '$id'");

    // Query hapus data kelas utama
    $query = "DELETE FROM t_kelas WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data kelas dan relasi terkait berhasil dihapus!');
                window.location.href = '../dashboard.php?tab=menu3';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menghapus data kelas: " . mysqli_error($koneksi) . "');
                window.location.href = '../dashboard.php?tab=menu3';
              </script>";
        exit();
    }
} else {
    header("Location: ../dashboard.php?tab=menu3");
    exit();
}
?>