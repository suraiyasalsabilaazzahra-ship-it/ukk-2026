<?php
session_start();
include 'koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) \vert{}\vert{}$_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

// Proses Tambah Data Siswa
if (isset($_POST['simpan'])) {
    $nisn         = mysqli_real_escape_string($koneksi, $_POST['nisn']);$nis          = mysqli_real_escape_string($koneksi,$_POST['nis']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);$gender       = mysqli_real_escape_string($koneksi,$_POST['gender']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);$no_telp      = mysqli_real_escape_string($koneksi,$_POST['no_telp']);
    $status_aktif =$_POST['status_aktif'];
    $user_id      =$_POST['user_id'] ?? '';

    // 1. CARI ID TERBESAR AGAR TIDAK DUPLICATE ENTRY '0'
    $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_siswa");
    $r_max = mysqli_fetch_assoc($q_max);
    $new_id = ($r_max['max_id'] ?? 0) + 1;

    // 2. CEK USER_ID AGAR TIDAK NULL
    if (empty($user_id)) {
        $q_get_user = mysqli_query($koneksi, "SELECT id FROM t_users ORDER BY id ASC LIMIT 1");
        if ($row_user = mysqli_fetch_assoc($q_get_user)) {
            $user_id =$row_user['id'];
        } else {
            $user_id = 1;
        }
    }

    // 3. INSERT DENGAN ID MANUAL
    $query = "INSERT INTO t_siswa (id, nisn, nis, nama, gender, alamat, no_telp, status_aktif, user_id) 
              VALUES ('$new_id', '$nisn', '$nis', '$nama', '$gender', '$alamat', '$no_telp', '$status_aktif', '$user_id')";

    if (mysqli_query($koneksi,$query)) {
        echo "<script>
                alert('Berhasil! Data siswa baru telah ditambahkan.'); 
                window.location.href='dashboard.php?tab=menu4';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menambah data siswa: " . mysqli_error($koneksi) . "');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
  <div class="container" style="max-width: 850px;">
    <form action="" method="POST">
      <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        <div class="card-header text-white p-3" style="background-color: #8b0000;">
          <h5 class="mb-0 fw-bold">Tambah Data Siswa Baru</h5>
        </div>
        <div class="card-body p-4 bg-white">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">NISN</label>
              <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN