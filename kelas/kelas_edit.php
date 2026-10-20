<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("Location: ../dashboard.php?tab=menu3");
    exit();
}

// Ambil data kelas berdasarkan ID
$id = mysqli_real_escape_string($koneksi, $id);
$q_data = mysqli_query($koneksi, "SELECT * FROM t_kelas WHERE id = '$id'");
$data   = mysqli_fetch_assoc($q_data);

if (!$data) {
    echo "<script>alert('Data kelas tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu3';</script>";
    exit();
}

// Proses Update Data Kelas
if (isset($_POST['update'])) {
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tingkat    = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $jurusan    = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    $query = "UPDATE t_kelas SET nama = '$nama_kelas', tingkat = '$tingkat', jurusan = '$jurusan' WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data kelas berhasil diperbarui!'); 
                window.location.href='../dashboard.php?tab=menu3';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal mengedit data kelas: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data Kelas - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

  <div class="container" style="max-width: 600px;">
    <form action="" method="POST">
      <div class="card shadow border-0 rounded-3 overflow-hidden">
        
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Edit Data Kelas</h5>
        </div>

        <div class="card-body p-4 bg-white">
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Kelas</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama'] ?? ''); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Tingkat</label>
            <select name="tingkat" class="form-select" required>
              <option value="X" <?= (($data['tingkat'] ?? '') == 'X') ? 'selected' : ''; ?>>X</option>
              <option value="XI" <?= (($data['tingkat'] ?? '') == 'XI') ? 'selected' : ''; ?>>XI</option>
              <option value="XII" <?= (($data['tingkat'] ?? '') == 'XII') ? 'selected' : ''; ?>>XII</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Jurusan</label>
            <input type="text" name="jurusan" class="form-control" value="<?= htmlspecialchars($data['jurusan'] ?? ''); ?>" required>
          </div>

          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
            <a href="../dashboard.php?tab=menu3" class="btn btn-secondary">Batal</a>
            <button type="submit" name="update" class="btn text-white px-4 fw-bold" style="background-color: #1b263b; border-color: #1b263b;">
              Update Kelas
            </button>
          </div>
        </div>

      </div>
    </form>
  </div>

</body>
</html>