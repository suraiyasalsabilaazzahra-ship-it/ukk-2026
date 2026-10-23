<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];

// Proses Simpan Data Guru & Akun Login Otomatis
if (isset($_POST['simpan'])) {
    $nip          = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password     = $_POST['password'] ?? '123456';
    $status_aktif = $_POST['status_aktif'];

    if (empty($password)) {
        $password = '123456';
    }

    // Validasi NIP Maksimal 18 Digit
    if (strlen($nip) > 18) {
        echo "<script>alert('Gagal: NIP tidak boleh lebih dari 18 digit!'); window.history.back();</script>";
        exit();
    }

    // Cek apakah email sudah terdaftar di t_users
    $cek_email = mysqli_query($koneksi, "SELECT * FROM t_users WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Gagal: Email ini sudah terdaftar sebagai akun login!'); window.history.back();</script>";
        exit();
    }

    // 1. BUAT AKUN LOGIN BARU DI TABEL t_users (Menggunakan kolom 'nama', bukan 'username')
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $q_max_user = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_users");
    $r_max_user = mysqli_fetch_assoc($q_max_user);
    $new_user_id = ($r_max_user['max_id'] ?? 0) + 1;

    $query_user = "INSERT INTO t_users (id, nama, email, password, role) 
                   VALUES ('$new_user_id', '$nama', '$email', '$hashed_password', 'Guru')";
    
    if (mysqli_query($koneksi, $query_user)) {
        // 2. BUAT DATA GURU DI TABEL t_guru
        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_guru");
        $r_max = mysqli_fetch_assoc($q_max);
        $new_id = ($r_max['max_id'] ?? 0) + 1;

        $query_guru = "INSERT INTO t_guru (id, nip, nama, email, status_aktif, user_id) 
                       VALUES ('$new_id', '$nip', '$nama', '$email', '$status_aktif', '$new_user_id')";

        if (mysqli_query($koneksi, $query_guru)) {
            echo "<script>
                    alert('Berhasil! Data guru dan akun login baru telah dibuat.'); 
                    window.location.href='../dashboard.php?tab=menu2';
                  </script>";
            exit();
        } else {
            $err_guru = mysqli_error($koneksi);
            echo "<script>alert('Gagal di t_guru: " . addslashes($err_guru) . "');</script>";
        }
    } else {
        $err_user = mysqli_error($koneksi);
        echo "<script>alert('Gagal di t_users: " . addslashes($err_user) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Guru - UKK 2026</title>
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
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu1" class="nav-link-custom"><i class="bi bi-speedometer2 fs-5"></i><span>Dashboard</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu2" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-person-workspace fs-5"></i><span>Data Guru</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu3" class="nav-link-custom"><i class="bi bi-door-closed fs-5"></i><span>Data Kelas</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu7" class="nav-link-custom"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu9" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a>
          </li>
          <li class="nav-item">
            <a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a>
          </li>
          <li class="nav-item mt-4">
            <a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a>
          </li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container py-4" style="max-width: 850px;">
          <form action="guru_tambah.php" method="POST">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
              <div class="card-header text-white p-3" style="background-color: #1b263b;">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill me-2 text-warning"></i>Tambah Data Guru & Akun Login Baru</h5>
              </div>
              <div class="card-body p-4 bg-white">
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">NIP Guru (Maks. 18 Digit)</label>
                    <input type="text" name="nip" class="form-control" maxlength="18" placeholder="Masukkan NIP" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Guru" required>
                  </div>
                </div>
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Email (Untuk Login)</label>
                    <input type="email" name="email" class="form-control" placeholder="contoh@sekolah.sch.id" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Status Aktif</label>
                    <select name="status_aktif" class="form-select" required>
                      <option value="1">Aktif</option>
                      <option value="0">Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold">Password Akun Login</label>
                  <input type="password" name="password" class="form-control" placeholder="Masukkan password (Default: 123456 jika kosong)">
                  <small class="text-muted">*Akun baru akan otomatis terbuat agar guru bisa langsung login.</small>
                </div>
                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu2" class="btn btn-secondary px-4">Batal</a>
                  <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #1b263b; border-color: #1b263b;">Simpan & Buat Akun</button>
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