<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Ambil ID dari URL
$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("Location: ../dashboard.php?tab=menu4");
    exit();
}

// Ambil data siswa berdasarkan ID
$q_siswa = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id = '$id'");
$siswa = mysqli_fetch_assoc($q_siswa);

if (!$siswa) {
    echo "<script>alert('Data siswa tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu4';</script>";
    exit();
}

// Proses Update Data Siswa
if (isset($_POST['update'])) {
    $nisn         = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nis          = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $gender       = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin'] ?? $_POST['gender'] ?? 'L');
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status_aktif = $_POST['status_aktif'];

    // Query UPDATE database
    $query = "UPDATE t_siswa SET 
                nisn = '$nisn', 
                nis = '$nis', 
                nama = '$nama', 
                gender = '$gender', 
                alamat = '$alamat', 
                status_aktif = '$status_aktif' 
              WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Berhasil! Data siswa telah diperbarui.'); 
                window.location.href='dashboard.php?tab=menu4';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal memperbarui data siswa: " . mysqli_error($koneksi) . "');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa - UKK 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 850px;">
        <form action="" method="POST">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                <div class="card-header text-white p-3" style="background-color: #1b263b;">
                    <h5 class="mb-0 fw-bold">Edit Data Siswa</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NISN</label>
                            <input type="text" name="nisn" class="form-control" value="<?= htmlspecialchars($siswa['nisn']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NIS</label>
                            <input type="text" name="nis" class="form-control" value="<?= htmlspecialchars($siswa['nis']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($siswa['nama']); ?>" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" <?= (($siswa['jenis_kelamin'] ?? $siswa['gender'] ?? '') == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?= (($siswa['jenis_kelamin'] ?? $siswa['gender'] ?? '') == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status Aktif</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1" <?= ($siswa['status_aktif'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?= ($siswa['status_aktif'] == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($siswa['alamat']); ?></textarea>
                    </div>

                    <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                       <a href="../dashboard.php?tab=menu4" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="update" class="btn px-4 fw-bold text-white" style="background-color: #1b263b; border-color: #1b263b;">
                            Perbarui Data Siswa
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>