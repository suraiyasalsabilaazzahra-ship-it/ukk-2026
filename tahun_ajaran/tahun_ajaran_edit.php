<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("Location: ../dashboard.php?tab=menu5");
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
        $err = mysqli_error($koneksi);
        echo "<script>alert('Gagal mengedit data tahun ajaran: " . addslashes($err) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Tahun Ajaran - UKK 2026</title>
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
          <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
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
        <div class="container py-4" style="max-width: 750px;">
          <form action="" method="POST">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2 text-warning"></i>Edit Data Tahun Ajaran</h5>
              </div>
              <div class="card-body p-4 bg-white">
                <div class="mb-3">
                  <label class="form-label fw-bold">Pilih Tahun Ajaran</label>
                  <select name="nama" class="form-select" required>
                    <option value="" disabled>-- Pilih Tahun Ajaran --</option>
                    <option value="2025/2026" <?= (($data['nama'] ?? '') == '2025/2026') ? 'selected' : ''; ?>>2025/2026</option>
                    <option value="2026/2027" <?= (($data['nama'] ?? '') == '2026/2027') ? 'selected' : ''; ?>>2026/2027</option>
                    <option value="2027/2028" <?= (($data['nama'] ?? '') == '2027/2028') ? 'selected' : ''; ?>>2027/2028</option>
                    <option value="2028/2029" <?= (($data['nama'] ?? '') == '2028/2029') ? 'selected' : ''; ?>>2028/2029</option>
                  </select>
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
                  <a href="../dashboard.php?tab=menu5" class="btn btn-secondary px-4">Batal</a>
                  <button type="submit" name="update" class="btn text-white px-4 fw-bold" style="background-color: #1b263b; border-color: #1b263b;">Update Tahun Ajaran</button>
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