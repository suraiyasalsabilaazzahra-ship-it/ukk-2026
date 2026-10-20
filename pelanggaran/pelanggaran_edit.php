<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../dashboard.php?tab=menu9");
    exit();
}

// Pastikan mengambil id dengan aman
// Ubah dari empty($id) menjadi pengecekan string kosong biasa
$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id === '') {
    echo "<script>alert('ID Pelanggaran tidak valid!'); window.location.href='../dashboard.php?tab=menu9';</script>";
    exit();
}

$id = mysqli_real_escape_string($koneksi, $id);
$q_current = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa WHERE id = '$id'");
$current = mysqli_fetch_assoc($q_current);

if (!$current) {
    echo "<script>alert('Data pelanggaran tidak ditemukan di database!'); window.location.href='../dashboard.php?tab=menu9';</script>";
    exit();
}

$error = "";

if (isset($_POST['update'])) {
    $siswa_id       = $_POST['siswa_id'] ?? '';
    $pelanggaran_id = $_POST['pelanggaran_id'] ?? '';
    $tanggal        = $_POST['tanggal'] ?? '';
    $poin           = $_POST['poin'] ?? 0;
    $keterangan     = $_POST['keterangan'] ?? '';

    if (!empty($siswa_id) && !empty($pelanggaran_id) && !empty($tanggal)) {
        // Ambil nama siswa dan nama pelanggaran otomatis agar sinkron
        $q_s = mysqli_query($koneksi, "SELECT nama FROM t_siswa WHERE id = '$siswa_id'");
        $d_s = mysqli_fetch_assoc($q_s);
        $nama_siswa = $d_s['nama'] ?? '';

        $q_p = mysqli_query($koneksi, "SELECT nama FROM t_pelanggaran WHERE id = '$pelanggaran_id'");
        $d_p = mysqli_fetch_assoc($q_p);
        $nama_pelanggaran = $d_p['nama'] ?? '';

        $siswa_id         = mysqli_real_escape_string($koneksi, $siswa_id);
        $pelanggaran_id   = mysqli_real_escape_string($koneksi, $pelanggaran_id);
        $nama_siswa       = mysqli_real_escape_string($koneksi, $nama_siswa);
        $nama_pelanggaran = mysqli_real_escape_string($koneksi, $nama_pelanggaran);
        $tanggal          = mysqli_real_escape_string($koneksi, $tanggal);
        $poin             = mysqli_real_escape_string($koneksi, $poin);
        $keterangan       = mysqli_real_escape_string($koneksi, $keterangan);

        $query = "UPDATE t_pelanggaran_siswa 
                  SET siswa_id = '$siswa_id', 
                      nama_siswa = '$nama_siswa', 
                      pelanggaran_id = '$pelanggaran_id', 
                      nama_pelanggaran = '$nama_pelanggaran', 
                      tanggal = '$tanggal', 
                      poin = '$poin', 
                      keterangan = '$keterangan' 
                  WHERE id = '$id'";
                  
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                    alert('Data pelanggaran berhasil diperbarui!');
                    window.location.href = '../dashboard.php?tab=menu9';
                  </script>";
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Kolom Siswa, Jenis Pelanggaran, dan Tanggal wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pelanggaran Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .card-form { background: #fff; border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .btn-maroon { background-color: #1b263b; color: #fff; border: none; }
    .btn-maroon:hover { background-color: #0d1b2a; color: #fff; }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-form p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Edit Pelanggaran</h4>
            <a href="../dashboard.php?tab=menu9" class="btn btn-outline-secondary btn-sm rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
          </div>

          <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 mb-3">
              <i class="bi bi-exclamation-octagon-fill me-1"></i> <?= $error; ?>
            </div>
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
              <label class="form-label fw-semibold small">Pilih Jenis Pelanggaran</label>
              <select name="pelanggaran_id" class="form-select" required>
                <option value="">-- Pilih Pelanggaran --</option>
                <?php
                $q_p = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran ORDER BY nama ASC");
                while ($p = mysqli_fetch_assoc($q_p)) {
                    $nm_pelanggaran = $p['nama'] ?? 'Pelanggaran';
                    $poin_default   = $p['poin'] ?? 0;
                    $selected = ($p['id'] == $current['pelanggaran_id']) ? 'selected' : '';
                    echo "<option value='{$p['id']}' {$selected}>[{$p['kode']}] {$nm_pelanggaran} ({$poin_default} Poin)</option>";
                }
                ?>
              </select>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Tanggal Kejadian</label>
                <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($current['tanggal']); ?>" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Jumlah Poin</label>
                <input type="number" name="poin" class="form-control" value="<?= htmlspecialchars($current['poin']); ?>" required>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold small">Keterangan Tambahan</label>
              <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($current['keterangan'] ?? ''); ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-maroon w-100 py-2 fw-semibold rounded-pill mt-3">Perbarui Pelanggaran</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>