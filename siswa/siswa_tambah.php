<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$error = "";

// Proses Tambah Data Siswa
if (isset($_POST['simpan'])) {
    $nisn         = $_POST['nisn'] ?? '';
    $nis          = $_POST['nis'] ?? '';
    $nama         = $_POST['nama'] ?? '';
    $jenis_kelamin= $_POST['gender'] ?? $_POST['jenis_kelamin'] ?? 'L';
    $alamat       = $_POST['alamat'] ?? '';
    $status_aktif = $_POST['status_aktif'] ?? 1;

    if (!empty($nisn) && !empty($nama)) {
        // Hitung ID manual agar aman jika auto increment bermasalah
        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_siswa");
        $r_max = mysqli_fetch_assoc($q_max);
        $new_id = ($r_max['max_id'] ?? 0) + 1;

        $nisn         = mysqli_real_escape_string($koneksi, $nisn);
        $nis          = mysqli_real_escape_string($koneksi, $nis);
        $nama         = mysqli_real_escape_string($koneksi, $nama);
        $jenis_kelamin= mysqli_real_escape_string($koneksi, $jenis_kelamin);
        $alamat       = mysqli_real_escape_string($koneksi, $alamat);
        $status_aktif = mysqli_real_escape_string($koneksi, $status_aktif);

        // Query INSERT menggunakan kolom jenis_kelamin
        $query = "INSERT INTO t_siswa (id, nisn, nis, nama, jenis_kelamin, alamat, status_aktif) 
                  VALUES ('$new_id', '$nisn', '$nis', '$nama', '$jenis_kelamin', '$alamat', '$status_aktif')";
                  
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                    alert('Berhasil! Data siswa baru telah ditambahkan.');
                    window.location.href = '../dashboard.php?tab=menu4';
                  </script>";
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "NISN dan Nama Siswa wajib diisi!";
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
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger mb-3"><?= $error; ?></div>
    <?php endif; ?>
    
    <form action="" method="POST">
      <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Tambah Data Siswa Baru</h5>
        </div>
        <div class="card-body p-4 bg-white">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">NISN</label>
              <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">NIS</label>
              <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap siswa" required>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Jenis Kelamin</label>
              <select name="gender" class="form-select" required>
                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Status Aktif</label>
              <select name="status_aktif" class="form-select" required>
                <option value="1" selected>Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat siswa"></textarea>
          </div>

          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
            <a href="../dashboard.php?tab=menu4" class="btn btn-secondary">Batal</a>
            <button type="submit" name="simpan" class="btn px-4 fw-bold text-white" style="background-color: #1b263b; border-color: #1b263b;">
              Simpan Data Siswa
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>