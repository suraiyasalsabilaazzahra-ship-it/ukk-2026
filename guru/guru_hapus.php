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

    // (Opsional) Ambil user_id dulu jika ingin menghapus akun loginnya juga di t_users
    $q_guru = mysqli_query($koneksi, "SELECT user_id FROM t_guru WHERE id = '$id'");
    $d_guru = mysqli_fetch_assoc($q_guru);
    $user_id = $d_guru['user_id'] ?? null;

    // Query hapus data guru
    $query = "DELETE FROM t_guru WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        // Jika ingin akun login di t_users ikut terhapus juga, aktifkan baris di bawah ini:
        // if ($user_id) { mysqli_query($koneksi, "DELETE FROM t_users WHERE id = '$user_id'"); }

        echo "<script>
                alert('Data guru berhasil dihapus!');
                window.location.href = '../dashboard.php?tab=menu2';
              </script>";
        exit();
    } else {
        $err = mysqli_error($koneksi);
        echo "<script>
                alert('Gagal menghapus data: " . addslashes($err) . "');
                window.location.href = '../dashboard.php?tab=menu2';
              </script>";
        exit();
    }
} else {
    header("Location: ../dashboard.php?tab=menu2");
    exit();
}
?>