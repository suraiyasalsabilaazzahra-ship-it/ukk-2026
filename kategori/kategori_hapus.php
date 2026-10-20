<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $query = "DELETE FROM t_pelanggaran_kategori WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Kategori pelanggaran berhasil dihapus!'); window.location.href = '../dashboard.php?tab=menu7';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menghapus kategori: " . mysqli_error($koneksi) . "'); window.location.href = '../dashboard.php?tab=menu7';</script>";
        exit();
    }
} else {
    header("Location:../dashboard.php?tab=menu7");
    exit();
}
?>