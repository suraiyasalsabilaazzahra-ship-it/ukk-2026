<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:../login.php");
    exit();
}

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("Location:../dashboard.php?tab=menu5");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $id);
$q_data = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran WHERE id = '$id'");
$data   = mysqli_fetch_assoc($q_data);

if (!$data) {
    echo "<script>alert('Data tahun ajaran tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu5';</script>";
    exit();
}

if (isset($_POST['update'])) {
    $nama            = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tanggal_mulai   = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($koneksi, $_POST['tanggal_selesai']);

    $query = "UPDATE t_tahun_ajaran SET nama = '$nama', tanggal_mulai = '$tanggal_mulai', tanggal_selesai = '$tanggal_selesai' WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data tahun ajaran berhasil diperbarui!'); window.location.href='../dashboard.php?tab=menu5';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal mengedit data tahun ajaran: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Tahun Ajaran - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
  <div class="container" style="max-width: 600px;">
    <form action="" method="POST">
      <div class="card shadow border-0 rounded-3 overflow-hidden">
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Edit Data Tahun Ajaran</h5>
        </div>
        <div class="card-body p-4 bg-white">
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Tahun Ajaran</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama'] ?? ''); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="<?= htmlspecialchars($data['tanggal_mulai'] ?? ''); ?>" required>
          </div>
          <div class="mb-4">
            <label class="form-label fw-bold">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="<?= htmlspecialchars($data['tanggal_selesai'] ?? ''); ?>" required>
          </div>
          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
              <a href="../dashboard.php?tab=menu5" class="btn btn-secondary">Batal</a>
            <button type="submit" name="update" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Update Tahun Ajaran</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>