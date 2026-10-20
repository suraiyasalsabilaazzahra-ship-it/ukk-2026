<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:../login.php");
    exit();
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query hapus data kelas
    $query = "DELETE FROM t_kelas WHERE id = '$id'";

if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data kelas berhasil dihapus!');
                window.location.href = '../dashboard.php?tab=menu3'; // Tambahkan ../ di sini
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menghapus data kelas: " . mysqli_error($koneksi) . "');
                window.location.href = '../dashboard.php?tab=menu3'; // Dan di sini juga
              </script>";
        exit();
    }
} else {
    header("Location: dashboard.php?tab=menu3");
    exit();
}
?>