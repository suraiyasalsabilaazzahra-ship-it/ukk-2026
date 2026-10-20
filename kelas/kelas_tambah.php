<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Proses Tambah Data Kelas
if (isset($_POST['simpan'])) {
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tingkat    = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $jurusan    = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    // Hitung ID manual agar aman dari error primary key
    $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_kelas");
    $r_max = mysqli_fetch_assoc($q_max);
    $new_id = ($r_max['max_id'] ?? 0) + 1;

    // Query INSERT ke t_kelas
    $query = "INSERT INTO t_kelas (id, nama, tingkat, jurusan) 
              VALUES ('$new_id', '$nama_kelas', '$tingkat', '$jurusan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Berhasil! Data kelas baru telah ditambahkan.'); 
                window.location.href='../dashboard.php?tab=menu3';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menambah data kelas: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Kelas - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

  <div class="container" style="max-width: 600px;">
    <form action="" method="POST">
      <div class="card shadow border-0 rounded-3 overflow-hidden">
        
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Tambah Data Kelas Baru</h5>
        </div>

        <div class="card-body p-4 bg-white">
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Kelas</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: XII RPL 1" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Tingkat</label>
            <select name="tingkat" class="form-select" required>
              <option value="">-- Pilih Tingkat --</option>
              <option value="X">X</option>
              <option value="XI">XI</option>
              <option value="XII">XII</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Jurusan</label>
            <input type="text" name="jurusan" class="form-control" placeholder="Contoh: RPL / TKJ / AKL" required>
          </div>

          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
           <a href="../dashboard.php?tab=menu3" class="btn btn-secondary">Batal</a>
            <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #1b263b; border-color: #1b263b;">
              Simpan Kelas
            </button>
          </div>
        </div>

      </div>
    </form>
  </div>

</body>
</html>