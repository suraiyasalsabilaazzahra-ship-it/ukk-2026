<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$id = $_GET['id'] ?? '';

if (empty($id)) {
    header("Location: ../dashboard.php?tab=menu4");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $id);
$q_data = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id = '$id'");
$data   = mysqli_fetch_assoc($q_data);

if (!$data) {
    echo "<script>alert('Data siswa tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu4';</script>";
    exit();
}

// Proses Update Data Siswa
if (isset($_POST['update'])) {
    $nisn         = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nis          = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas        = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan      = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $jenis_kelamin= mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $status_aktif = mysqli_real_escape_string($koneksi, $_POST['status_aktif']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = "UPDATE t_siswa SET 
                nisn = '$nisn', 
                nis = '$nis', 
                nama = '$nama', 
                kelas = '$kelas', 
                jurusan = '$jurusan', 
                jenis_kelamin = '$jenis_kelamin', 
                status_aktif = '$status_aktif', 
                alamat = '$alamat' 
              WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data siswa berhasil diperbarui!'); window.location.href='../dashboard.php?tab=menu4';</script>";
        exit();
    } else {
        $err = mysqli_error($koneksi);
        echo "<script>alert('Gagal mengedit data siswa: " . addslashes($err) . "');</script>";
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .sidebar { background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%); min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; }
    .sidebar .nav-link-custom { color: rgba(255, 255, 255, 0.85); background-color: rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 10px 16px; margin-bottom: 8px; font-weight: 500; display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .sidebar .nav-link-custom:hover { color: #ffc107; background-color: rgba(255, 193, 7, 0.15); }
    main { margin-left: 250px; }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- SIDEBAR -->
      <div class="col-md-3 col-lg-2 sidebar p-3 text-white">
        <div class="d-flex align-items-center gap-2 mb-2 px-2 mt-2">
          <i class="bi bi-shield-lock-fill fs-3 text-warning"></i>
          <h4 class="mb-0 fw-bold fs-5">UKK System</h4>
        </div>
        <div class="px-2 mb-3">
          <span class="badge bg-warning text-dark px-2 py-1 rounded-pill fw-semibold"><i class="bi bi-person-check-fill me-1"></i><?= $role; ?></span>
        </div>
        <hr class="text-white-50">
        <ul class="nav flex-column mb-auto">
          <li class="nav-item"><a href="../dashboard.php?tab=menu1" class="nav-link-custom"><i class="bi bi-speedometer2 fs-5"></i><span>Dashboard</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu2" class="nav-link-custom"><i class="bi bi-person-workspace fs-5"></i><span>Data Guru</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu3" class="nav-link-custom"><i class="bi bi-door-closed fs-5"></i><span>Data Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container py-4" style="max-width: 850px;">
          <form action="" method="POST">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Siswa</h5>
              </div>
              <div class="card-body p-4 bg-white">
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">NISN (Maks. 10 Digit)</label>
                    <input type="text" name="nisn" class="form-control" maxlength="10" value="<?= htmlspecialchars($data['nisn'] ?? ''); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">NIS (Maks. 10 Digit)</label>
                    <input type="text" name="nis" class="form-control" maxlength="10" value="<?= htmlspecialchars($data['nis'] ?? ''); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama'] ?? ''); ?>" required>
                </div>

                <!-- TINGKAT KELAS & JURUSAN SEJAJAR -->
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Tingkat Kelas</label>
                    <select name="kelas" class="form-select" required>
                      <option value="" disabled>-- Pilih Tingkat Kelas --</option>
                      <option value="X" <?= (($data['kelas'] ?? '') == 'X') ? 'selected' : ''; ?>>X (10)</option>
                      <option value="XI" <?= (($data['kelas'] ?? '') == 'XI') ? 'selected' : ''; ?>>XI (11)</option>
                      <option value="XII" <?= (($data['kelas'] ?? '') == 'XII') ? 'selected' : ''; ?>>XII (12)</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Jurusan</label>
                    <select name="jurusan" class="form-select" required>
                      <option value="" disabled>-- Pilih Jurusan --</option>
                      <?php
                      $q_jur = mysqli_query($koneksi, "SELECT DISTINCT jurusan FROM t_kelas WHERE jurusan IS NOT NULL AND jurusan != '' ORDER BY jurusan ASC");
                      while ($j = mysqli_fetch_assoc($q_jur)) {
                          $selected = (($data['jurusan'] ?? '') == $j['jurusan']) ? 'selected' : '';
                          echo "<option value='{$j['jurusan']}' {$selected}>{$j['jurusan']}</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                      <option value="L" <?= (($data['jenis_kelamin'] ?? '') == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                      <option value="P" <?= (($data['jenis_kelamin'] ?? '') == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Status Aktif</label>
                    <select name="status_aktif" class="form-select" required>
                      <option value="1" <?= (($data['status_aktif'] ?? '') == '1') ? 'selected' : ''; ?>>Aktif</option>
                      <option value="0" <?= (($data['status_aktif'] ?? '') == '0') ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Alamat</label>
                  <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu4" class="btn btn-secondary px-4">Batal</a>
                  <button type="submit" name="update" class="btn px-4 fw-bold text-white" style="background-color: #1b263b; border-color: #1b263b;">
                    Simpan Perubahan
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>