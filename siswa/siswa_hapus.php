<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';

if (!empty($id)) {
    @mysqli_query($koneksi, "DELETE FROM t_kelas_siswa WHERE siswa_id = '$id'");
    @mysqli_query($koneksi, "DELETE FROM t_pelanggaran_siswa WHERE siswa_id = '$id'");
    @mysqli_query($koneksi, "DELETE FROM t_tindakan WHERE siswa_id = '$id'");

    $query = "DELETE FROM t_siswa WHERE id = '$id'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data siswa berhasil dihapus.');
                window.location.href='../dashboard.php?tab=menu4';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menghapus data siswa: " . mysqli_error($koneksi) . "');
                window.location.href='../dashboard.php?tab=menu4';
              </script>";
        exit();
    }
} else {
    header("Location: ../dashboard.php?tab=menu4");
    exit();
}
?>