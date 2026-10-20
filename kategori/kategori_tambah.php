<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:../login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $poin          = mysqli_real_escape_string($koneksi, $_POST['poin']);
    $deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_pelanggaran_kategori");
    $r_max = mysqli_fetch_assoc($q_max);
    $new_id = ($r_max['max_id'] ?? 0) + 1;

    $query = "INSERT INTO t_pelanggaran_kategori (id, nama_kategori, poin, deskripsi) 
              VALUES ('$new_id', '$nama_kategori', '$poin', '$deskripsi')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berhasil! Kategori pelanggaran baru telah ditambahkan.'); window.location.href='../dashboard.php?tab=menu7';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menambah kategori: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kategori Pelanggaran - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
  <div class="container" style="max-width: 600px;">
    <form action="" method="POST">
      <div class="card shadow border-0 rounded-3 overflow-hidden">
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Tambah Kategori Pelanggaran Baru</h5>
        </div>
        <div class="card-body p-4 bg-white">
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Kategori Pelanggaran</label>
            <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Pelanggaran Ringan" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Jumlah Poin</label>
            <input type="number" name="poin" class="form-control" placeholder="Contoh: 10" required>
          </div>
          <div class="mb-4">
            <label class="form-label fw-bold">Deskripsi / Keterangan</label>
            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Keterangan opsional..."></textarea>
          </div>
          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
            <a href="../dashboard.php?tab=menu7" class="btn btn-secondary px-4 fw-bold">Batal</a>
            <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Kategori</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>