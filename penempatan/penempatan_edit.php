<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("Location: ../dashboard.php?tab=menu6");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $id);
$q_current = mysqli_query($koneksi, "SELECT * FROM t_kelas_siswa WHERE id = '$id'");
$current = mysqli_fetch_assoc($q_current);

if (!$current) {
    echo "<script>alert('Data penempatan tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu6';</script>";
    exit();
}

$error = "";

if (isset($_POST['update'])) {
    $siswa_id        = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $tahun_ajaran_id = mysqli_real_escape_string($koneksi, $_POST['tahun_ajaran_id'] ?? '');
    $kelas_id        = mysqli_real_escape_string($koneksi, $_POST['kelas_id'] ?? '');
    $status_aktif    = mysqli_real_escape_string($koneksi, $_POST['status_aktif'] ?? '1');

    if (!empty($siswa_id) && !empty($tahun_ajaran_id) && !empty($kelas_id)) {
        $query = "UPDATE t_kelas_siswa SET 
                    siswa_id = '$siswa_id', 
                    tahun_ajaran_id = '$tahun_ajaran_id', 
                    kelas_id = '$kelas_id', 
                    status_aktif = '$status_aktif' 
                  WHERE id = '$id'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                    alert('Data penempatan siswa berhasil diperbarui!');
                    window.location.href = '../dashboard.php?tab=menu6';
                  </script>";
            exit();
        } else {
            $error = "Gagal memperbarui data ke database: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Penempatan Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .card-form { background: #fff; border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .btn-maroon { background-color: #1b263b; color: #fff; border: none; }
    .btn-maroon:hover { background-color: #1b263b; color: #fff; }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-form p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-diagram-3 text-warning me-2"></i>Edit Penempatan Siswa</h4>
            <a href="../dashboard.php?tab=menu6" class="btn btn-outline-secondary btn-sm rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
          </div>

          <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2"><?= $error; ?></div>
          <?php endif; ?>

          <form action="" method="POST">
            <div class="mb-3">
              <label class="form-label fw-semibold small">Pilih Siswa</label>
              <select name="siswa_id" class="form-select" required>
                <option value="">-- Pilih Siswa --</option>
                <?php
                $q_s = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY nama ASC");
                while ($s = mysqli_fetch_assoc($q_s)) {
                    $selected = ($s['id'] == $current['siswa_id']) ? 'selected' : '';
                    echo "<option value='{$s['id']}' {$selected}>{$s['nama']} (NISN: {$s['nisn']})</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Pilih Kelas</label>
              <select name="kelas_id" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php
                $q_k = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY nama ASC");
                while ($k = mysqli_fetch_assoc($q_k)) {
                    $nm_kls = $k['nama'] ?? $k['nama_kelas'] ?? '-';
                    $selected = ($k['id'] == $current['kelas_id']) ? 'selected' : '';
                    echo "<option value='{$k['id']}' {$selected}>{$nm_kls} (Tingkat {$k['tingkat']})</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Tahun Ajaran (Dibatasi 2025 - 2027)</label>
              <select name="tahun_ajaran_id" class="form-select" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                <?php
                // Tahun ajaran dibatasi sesuai permintaan
                $q_ta = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran WHERE nama LIKE '%2025%' OR nama LIKE '%2026%' OR nama LIKE '%2027%' ORDER BY id DESC");
                while ($ta = mysqli_fetch_assoc($q_ta)) {
                    $selected = ($ta['id'] == $current['tahun_ajaran_id']) ? 'selected' : '';
                    echo "<option value='{$ta['id']}' {$selected}>{$ta['nama']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold small">Status Penempatan</label>
              <select name="status_aktif" class="form-select" required>
                <option value="1" <?= ($current['status_aktif'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                <option value="0" <?= ($current['status_aktif'] == 0) ? 'selected' : ''; ?>>Non-Aktif</option>
              </select>
            </div>

            <button type="submit" name="update" class="btn btn-maroon w-100 py-2 fw-semibold rounded-pill">Perbarui Penempatan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>