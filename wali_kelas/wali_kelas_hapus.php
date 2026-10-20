<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../dashboard.php?tab=menu8");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    $query = "DELETE FROM t_wali_kelas WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data wali kelas berhasil dihapus!');
                window.location.href = '../dashboard.php?tab=menu8';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menghapus data wali kelas!');
                window.location.href = '../dashboard.php?tab=menu8';
              </script>";
        exit();
    }
} else {
    header("Location: ../dashboard.php?tab=menu8");
    exit();
}
?>