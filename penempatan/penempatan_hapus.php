<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../dashboard.php?tab=menu6");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    $query = "DELETE FROM t_kelas_siswa WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data penempatan berhasil dihapus!');
                window.location.href = '../dashboard.php?tab=menu6';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menghapus data penempatan!');
                window.location.href = '../dashboard.php?tab=menu6';
              </script>";
        exit();
    }
} else {
    header("Location: ../dashboard.php?tab=menu6");
    exit();
}
?>