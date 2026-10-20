<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:../login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $nama            = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tanggal_mulai   = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($koneksi, $_POST['tanggal_selesai']);

    $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_tahun_ajaran");
    $r_max = mysqli_fetch_assoc($q_max);
    $new_id = ($r_max['max_id'] ?? 0) + 1;

    $query = "INSERT INTO t_tahun_ajaran (id, nama, tanggal_mulai, tanggal_selesai) 
              VALUES ('$new_id', '$nama', '$tanggal_mulai', '$tanggal_selesai')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berhasil! Data tahun ajaran baru telah ditambahkan.'); window.location.href='../dashboard.php?tab=menu5';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menambah data tahun ajaran: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Tahun Ajaran - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
  <div class="container" style="max-width: 600px;">
    <form action="" method="POST">
      <div class="card shadow border-0 rounded-3 overflow-hidden">
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Tambah Data Tahun Ajaran Baru</h5>
        </div>
        <div class="card-body p-4 bg-white">
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Tahun Ajaran</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: 2025/2026" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
          </div>
          <div class="mb-4">
            <label class="form-label fw-bold">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" required>
          </div>
          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
              <a href="../dashboard.php?tab=menu5" class="btn btn-secondary">Batal</a>
            <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Tahun Ajaran</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>