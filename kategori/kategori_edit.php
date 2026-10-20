<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:../login.php");
    exit();
}

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("Location:../dashboard.php?tab=menu7");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $id);
$q_data = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$id'");
$data   = mysqli_fetch_assoc($q_data);

if (!$data) {
    echo "<script>alert('Data kategori tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu7';</script>";
    exit();
}

if (isset($_POST['update'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $poin          = mysqli_real_escape_string($koneksi, $_POST['poin']);
    $deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $query = "UPDATE t_pelanggaran_kategori SET nama_kategori = '$nama_kategori', poin = '$poin', deskripsi = '$deskripsi' WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Kategori pelanggaran berhasil diperbarui!'); window.location.href='../dashboard.php?tab=menu7';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal mengedit kategori: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Kategori Pelanggaran - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
  <div class="container" style="max-width: 600px;">
    <form action="" method="POST">
      <div class="card shadow border-0 rounded-3 overflow-hidden">
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Edit Kategori Pelanggaran</h5>
        </div>
        <div class="card-body p-4 bg-white">
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Kategori Pelanggaran</label>
            <input type="text" name="nama_kategori" class="form-control" value="<?= htmlspecialchars($data['nama_kategori'] ?? ''); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Jumlah Poin</label>
            <input type="number" name="poin" class="form-control" value="<?= htmlspecialchars($data['poin'] ?? ''); ?>" required>
          </div>
          <div class="mb-4">
            <label class="form-label fw-bold">Deskripsi / Keterangan</label>
            <textarea name="deskripsi" class="form-control" rows="2"><?= htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
          </div>
          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
            <a href="../dashboard.php?tab=menu7" class="btn btn-secondary px-4 fw-bold">Batal</a>
            <button type="submit" name="update" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Update Kategori</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>