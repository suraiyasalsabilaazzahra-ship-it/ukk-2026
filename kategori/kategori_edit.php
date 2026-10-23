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
    header("Location: ../dashboard.php?tab=menu7");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $id);
$q_data = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$id'");
$data   = mysqli_fetch_assoc($q_data);

if (!$data) {
    echo "<script>alert('Data kategori tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu7';</script>";
    exit();
}

if (isset($_POST['update'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $poin          = (int)$_POST['poin'];
    $deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Sesuaikan kolom 'nama' dan 'poin' sesuai struktur database Anda
    $query = "UPDATE t_pelanggaran_kategori SET nama = '$nama_kategori', poin = '$poin', deskripsi = '$deskripsi' WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Kategori pelanggaran berhasil diperbarui!'); window.location.href='../dashboard.php?tab=menu7';</script>";
        exit();
    } else {
        $err = mysqli_error($koneksi);
        echo "<script>alert('Gagal mengedit kategori: " . addslashes($err) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Kategori Pelanggaran - UKK 2026</title>
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
          <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container py-4" style="max-width: 700px;">
          <form action="" method="POST">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Kategori Pelanggaran</h5>
              </div>
              <div class="card-body p-4 bg-white">
                <div class="mb-3">
                  <label class="form-label fw-bold">Nama Kategori Pelanggaran</label>
                  <input type="text" name="nama_kategori" class="form-control" value="<?= htmlspecialchars($data['nama'] ?? $data['nama_kategori'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Jumlah Poin</label>
                  <input type="number" name="poin" class="form-control" value="<?= htmlspecialchars($data['poin'] ?? ''); ?>" required>
                  <small class="text-muted">Sistem akan otomatis mengkategorikan ulang jenis pelanggaran berdasarkan poin.</small>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold">Deskripsi / Keterangan</label>
                  <textarea name="deskripsi" class="form-control" rows="2"><?= htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                </div>
                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu7" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="update" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Update Kategori</button>
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