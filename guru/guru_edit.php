<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (file_exists('../koneksi.php')) {
    include '../koneksi.php';
} elseif (file_exists('koneksi.php')) {
    include 'koneksi.php';
} else {
    include '../../koneksi.php';
}

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header("Location: ../login.php");
  exit();
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
if (empty($id)) {
    echo "<script>alert('ID Guru tidak valid!'); window.location.href='../dashboard.php?tab=menu2';</script>";
    exit();
}

$q_cek = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE id='$id' LIMIT 1");
$data = mysqli_fetch_assoc($q_cek);

if (!$data) {
  echo "<script>alert('Data guru tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu2';</script>";
  exit();
}

$error = "";

if (isset($_POST['update'])) {
  $nip          = mysqli_real_escape_string($koneksi, $_POST['nip'] ?? '');
  $nama         = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
  $email        = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
  $status_aktif = mysqli_real_escape_string($koneksi, $_POST['status_aktif'] ?? '1');
  $user_id      = mysqli_real_escape_string($koneksi, $_POST['user_id'] ?? '');
  $password     = $_POST['password'] ?? '';

  if (!empty($nip) && !empty($nama) && !empty($email)) {
      // Jika password diisi, update juga password di tabel t_users
      if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if (!empty($user_id)) {
            mysqli_query($koneksi, "UPDATE t_users SET password='$hashed_password' WHERE id='$user_id'");
        }
      }

      $query = "UPDATE t_guru SET nip='$nip', nama='$nama', email='$email', status_aktif='$status_aktif', user_id='$user_id', updated_at=NOW() WHERE id='$id'";

      if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data guru berhasil diperbarui!'); window.location.href = '../dashboard.php?tab=menu2';</script>";
        exit();
      } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
      }
  } else {
      $error = "NIP, Nama Lengkap, dan Email wajib diisi!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data Guru - UKK 2026</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .sidebar { background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%); min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; overflow-y: auto; }
    .sidebar .nav-link-custom { color: rgba(255, 255, 255, 0.85); background-color: rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 10px 16px; margin-bottom: 8px; font-weight: 500; display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .sidebar .nav-link-custom:hover { color: #ffc107; background-color: rgba(255, 193, 7, 0.15); }
    main { margin-left: 250px; padding: 30px; padding-bottom: 100px; }
    @media (max-width: 768px) { main { margin-left: 0; padding: 15px; } }
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
          <span class="badge bg-warning text-dark px-2 py-1 rounded-pill fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Admin</span>
        </div>
        <hr class="text-white-50">
        <ul class="nav flex-column mb-auto">
          <li class="nav-item"><a href="../dashboard.php?tab=menu1" class="nav-link-custom"><i class="bi bi-speedometer2 fs-5"></i><span>Dashboard</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu2" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-person-workspace fs-5"></i><span>Data Guru</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu3" class="nav-link-custom"><i class="bi bi-door-closed fs-5"></i><span>Data Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
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
        <div class="container-fluid px-0" style="max-width: 700px;">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 mb-3"><?= $error; ?></div>
          <?php endif; ?>

          <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
              <h5 class="mb-0 fw-bold"><i class="bi bi-person-workspace text-warning me-2"></i>Edit Data Guru & Password Login</h5>
            </div>
            <div class="card-body p-4 bg-white">
              <form action="" method="POST">
                <div class="mb-3">
                  <label class="form-label fw-bold">NIP</label>
                  <input type="text" name="nip" class="form-control py-2" value="<?= htmlspecialchars($data['nip'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control py-2" value="<?= htmlspecialchars($data['nama'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" name="email" class="form-control py-2" value="<?= htmlspecialchars($data['email'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Ubah Password Login (Opsional)</label>
                  <div class="input-group">
                    <input type="password" name="password" id="passwordEdit" class="form-control py-2" placeholder="Kosongkan jika tidak ingin mengubah password">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('passwordEdit', 'iconEdit')">
                      <i class="bi bi-eye-slash" id="iconEdit"></i>
                    </button>
                  </div>
                  <small class="text-muted">*Masukkan password baru jika guru ingin mengganti sandi loginnya.</small>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Status Aktif</label>
                  <select name="status_aktif" class="form-select py-2">
                    <option value="1" <?= (($data['status_aktif'] ?? 1) == 1) ? 'selected' : ''; ?>>Aktif</option>
                    <option value="0" <?= (($data['status_aktif'] ?? 1) == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                  </select>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold">Akun User (t_users)</label>
                  <select name="user_id" class="form-select py-2">
                    <?php
                    $q_u = mysqli_query($koneksi, "SELECT * FROM t_users");
                    if ($q_u) {
                      while ($u = mysqli_fetch_assoc($q_u)) {
                        $selected = ($u['id'] == ($data['user_id'] ?? '')) ? 'selected' : '';
                        echo "<option value='{$u['id']}' {$selected}>ID: {$u['id']} - {$u['nama']}</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu2" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="update" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Skrip JavaScript untuk Toggle Ikon Mata -->
  <script>
    function togglePass(inputId, iconId) {
      let input = document.getElementById(inputId);
      let icon = document.getElementById(iconId);
      if (input.type === "password") {
        input.type = "text";
        icon.className = "bi bi-eye";
      } else {
        input.type = "password";
        icon.className = "bi bi-eye-slash";
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>