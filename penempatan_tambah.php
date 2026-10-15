<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: dashboard.php?tab=menu6");
    exit();
}

$error = "";

if (isset($_POST['simpan'])) {
    $siswa_id        = $_POST['siswa_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $kelas_id        = $_POST['kelas_id'];
    $status_aktif    = $_POST['status_aktif'];

    if (!empty($siswa_id) && !empty($tahun_ajaran_id) && !empty($kelas_id)) {
        $query = "INSERT INTO t_kelas_siswa (siswa_id, tahun_ajaran_id, kelas_id, status_aktif) VALUES ('$siswa_id', '$tahun_ajaran_id', '$kelas_id', '$status_aktif')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            // Redirect kembali ke dashboard dan langsung buka tab menu6 (Penempatan Siswa)
            header("Location: dashboard.php?tab=menu6");
            exit();
        } else {
            $error = "Gagal menyimpan data ke database!";
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
  <title>Tambah Penempatan Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .card-form { background: #fff; border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .btn-maroon { background-color: #8b0000; color: #fff; border: none; }
    .btn-maroon:hover { background-color: #6d0000; color: #fff; }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-form p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-diagram-3 text-danger me-2"></i>Tambah Penempatan Siswa</h4>
            <a href="dashboard.php?tab=menu6" class="btn btn-outline-secondary btn-sm rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
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
                    echo "<option value='{$s['id']}'>{$s['nama']} (NISN: {$s['nisn']})</option>";
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
                    echo "<option value='{$k['id']}'>{$nm_kls} (Tingkat {$k['tingkat']})</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Tahun Ajaran (Maksimal 2027)</label>
              <select name="tahun_ajaran_id" class="form-select" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                <?php
                // Filter agar hanya menampilkan tahun ajaran yang mengandung angka 2025, 2026, atau 2027
                $q_ta = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran WHERE nama LIKE '%2025%' OR nama LIKE '%2026%' OR nama LIKE '%2027%' ORDER BY id DESC");
                while ($ta = mysqli_fetch_assoc($q_ta)) {
                    echo "<option value='{$ta['id']}'>{$ta['nama']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold small">Status Penempatan</label>
              <select name="status_aktif" class="form-select" required>
                <option value="1">Aktif</option>
                <option value="0">Non-Aktif</option>
              </select>
            </div>

            <button type="submit" name="simpan" class="btn btn-maroon w-100 py-2 fw-semibold rounded-pill">Simpan Penempatan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>