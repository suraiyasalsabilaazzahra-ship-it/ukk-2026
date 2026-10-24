<?php
session_start();
if (file_exists('koneksi.php')) {
    include 'koneksi.php';
} else {
    include '../koneksi.php';
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header("Location: login.php");
  exit();
}

// Variabel sesi
$role  = $_SESSION['role'] ?? 'Admin';
$nama  = $_SESSION['nama'] ?? 'User';
$email = $_SESSION['email'] ?? '';

// Menentukan tab aktif saat ini dari URL (default tergantung role)
$default_tab = ($role === 'Guru') ? 'dashboard' : 'menu1';
$active_tab  = $_GET['tab'] ?? $default_tab;

// Query hitung total data dengan aman
$total_siswa_q = @mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_siswa");
$total_siswa   = ($total_siswa_q) ? mysqli_fetch_assoc($total_siswa_q)['total'] : 0;

$total_guru_q  = @mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_guru");
$total_guru    = ($total_guru_q) ? mysqli_fetch_assoc($total_guru_q)['total'] : 0;

$total_kelas_q = @mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_kelas");
$total_kelas   = ($total_kelas_q) ? mysqli_fetch_assoc($total_kelas_q)['total'] : 0;

// Konfigurasi Menu Berdasarkan Role
if ($role === 'Guru') {
  $menus = [
    ['id' => 'dashboard', 'name' => '1. Beranda Guru', 'icon' => 'bi-speedometer2'],
    ['id' => 'menu2', 'name' => '2. Catat Pelanggaran', 'icon' => 'bi-exclamation-octagon'],
    ['id' => 'menu3', 'name' => '3. Tindakan', 'icon' => 'bi-shield-check'],
    ['id' => 'menu4', 'name' => '4. Profil Guru', 'icon' => 'bi-person-badge'],
    ['id' => 'menu_about', 'name' => 'About Me', 'icon' => 'bi-info-circle']
  ];
} else {
  $menus = [
    ['id' => 'menu1', 'name' => 'Dashboard', 'icon' => 'bi-speedometer2'],
    ['id' => 'menu2', 'name' => 'Data Guru', 'icon' => 'bi-person-workspace'],
    ['id' => 'menu3', 'name' => 'Data Kelas', 'icon' => 'bi-door-closed'],
    ['id' => 'menu4', 'name' => 'Data Siswa', 'icon' => 'bi-people'],
    ['id' => 'menu5', 'name' => 'Tahun Ajaran', 'icon' => 'bi-calendar-event'],
    ['id' => 'menu6', 'name' => 'Penempatan Siswa', 'icon' => 'bi-diagram-3'],
    ['id' => 'menu7', 'name' => 'Kategori Pelanggaran', 'icon' => 'bi-tags'],
    ['id' => 'menu8', 'name' => 'Data Wali Kelas', 'icon' => 'bi-person-bounding-box'],
    ['id' => 'menu9', 'name' => 'Pencatatan Pelanggaran', 'icon' => 'bi-exclamation-triangle'],
    ['id' => 'menu10', 'name' => 'Laporan Pelanggaran', 'icon' => 'bi-file-earmark-text'],
    ['id' => 'menu_about', 'name' => 'About Me', 'icon' => 'bi-person-circle'], 
  ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Informasi UKK 2026</title>

  <!-- Bootstrap 5 CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f6f9;
      color: #333;
    }

    .sidebar {
      background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%);
      box-shadow: 4px 0 15px rgba(0, 0, 0, 0.08);
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      overflow-y: auto;
      z-index: 1000;
    }

    .sidebar .nav-link-custom {
      color: rgba(255, 255, 255, 0.85);
      background-color: rgba(255, 255, 255, 0.08);
      border-radius: 10px;
      padding: 10px 16px;
      margin-bottom: 8px;
      font-weight: 500;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .sidebar .nav-link-custom:hover {
      color: #ffc107;
      background-color: rgba(255, 193, 7, 0.15);
      transform: translateX(4px);
    }

    .sidebar .nav-link-custom.active-menu {
      background-color: #ffc107;
      color: #0d1b2a !important;
      font-weight: 700;
      box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
    }

    .main-header-card {
      background: #ffffff;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table thead th {
      background-color: #1b263b;
      color: #ffffff;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.82rem;
      letter-spacing: 0.5px;
      padding: 14px 16px;
      border: none;
    }

    .table tbody td {
      padding: 14px 16px;
      vertical-align: middle;
      border-color: #f1f1f1;
    }

    .btn-maroon,
    .btn-primary-blue {
      background-color: #1b263b;
      color: #fff;
      border: none;
    }

    .btn-maroon:hover,
    .btn-primary-blue:hover {
      background-color: #0d1b2a;
      color: #fff;
    }
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
          <span class="badge bg-warning text-dark px-2 py-1 rounded-pill fw-semibold">
            <i class="bi bi-person-check-fill me-1"></i><?= $role; ?>
          </span>
        </div>

        <hr class="text-white-50">

        <ul class="nav flex-column mb-auto">
          <?php foreach ($menus as $menu): ?>
            <?php $is_active = ($active_tab === $menu['id']) ? 'active-menu' : ''; ?>
            <li class="nav-item">
              <a href="dashboard.php?tab=<?= $menu['id']; ?>" id="btn-tab-<?= $menu['id']; ?>" class="nav-link-custom <?= $is_active; ?>">
                <i class="bi <?= $menu['icon']; ?> fs-5"></i>
                <span><?= $menu['name']; ?></span>
              </a>
            </li>
          <?php endforeach; ?>

          <li class="nav-item mt-4">
            <a href="logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
              <i class="bi bi-box-arrow-right fs-5"></i>
              <span>Logout</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-md-auto">

        <!-- TAB 1: BERANDA GURU / DASHBOARD ADMIN -->
        <div id="tab-dashboard" class="tab-content" style="display: <?= ($active_tab === 'dashboard' || $active_tab === 'menu1') ? 'block' : 'none'; ?>;">
          <?>
          <?php 
          if ($role === 'Guru') {
              if (file_exists('tab_beranda_guru.php')) {
                  include 'tab_beranda_guru.php';
              } else {
                  include 'tab_dashboard.php';
              }
          } else {
              if (file_exists('tab_dashboard.php')) {
                  include 'tab_dashboard.php'; 
              } else {
                  echo '<div class="alert alert-info">Dashboard Admin</div>';
              }
          }
          ?>
        </div>
        
        <!-- TAB 2: CATAT PELANGGARAN (Guru) / DATA GURU (Admin) -->
        <div id="tab-menu2" class="tab-content" style="display: <?= ($active_tab === 'menu2') ? 'block' : 'none'; ?>;">
          <?php 
          if ($role === 'Guru') {
              if (file_exists('pelanggaran/pelanggaran_tambah.php')) {
                  include 'pelanggaran/pelanggaran_tambah.php';
              } else {
                  echo '<div class="alert alert-danger">File pelanggaran_tambah.php tidak ditemukan di folder pelanggaran.</div>';
              }
          } else {
              if (file_exists('tab_guru.php')) {
                  include 'tab_guru.php'; 
              } else {
                  echo '<div class="alert alert-warning">File tab_guru.php belum ada.</div>';
              }
          }
          ?>
        </div>

        <!-- TAB 3: TINDAKAN (Guru) / DATA KELAS (Admin) -->
        <div id="tab-menu3" class="tab-content" style="display: <?= ($active_tab === 'menu3') ? 'block' : 'none'; ?>">
            <?php
            if ($role === 'Guru') {
                if (file_exists('tindakan/index.php')) {
                    include 'tindakan/index.php';
                } else {
                    echo '<div class="alert alert-danger">File index.php tidak ditemukan di folder tindakan.</div>';
                }
            } else {
                if (file_exists('tab_kelas.php')) {
                    include 'tab_kelas.php';
                } else {
                    echo '<div class="alert alert-warning">File tab_kelas.php belum ada.</div>';
                }
            }
            ?>
        </div>

        <!-- TAB 4: PROFIL GURU (Guru) / DATA SISWA (Admin) -->
        <div id="tab-menu4" class="tab-content" style="display: <?= ($active_tab === 'menu4') ? 'block' : 'none'; ?>;">
          <?php 
          if ($role === 'Guru') {
              if (file_exists('profil_guru.php')) {
                  include 'profil_guru.php';
              } else {
                  echo '<div class="alert alert-danger">File profil_guru.php belum ada.</div>';
              }
          } else {
              if (file_exists('tab_siswa.php')) {
                  include 'tab_siswa.php'; 
              } else {
                  echo '<div class="alert alert-warning">File tab_siswa.php belum ada.</div>';
              }
          }
          ?>
        </div>

        <!-- TAB 5: TAHUN AJARAN -->
        <div id="tab-menu5" class="tab-content" style="display: <?= ($active_tab === 'menu5') ? 'block' : 'none'; ?>;">
          <?php if (file_exists('tab_tahun_ajaran.php')) include 'tab_tahun_ajaran.php'; ?>
        </div>

        <!-- TAB 6: PENEMPATAN SISWA -->
        <div id="tab-menu6" class="tab-content" style="display: <?= ($active_tab === 'menu6') ? 'block' : 'none'; ?>;">
          <?php if (file_exists('tab_penempatan.php')) include 'tab_penempatan.php'; ?>
        </div>

        <!-- TAB 7: KATEGORI PELANGGARAN -->
        <div id="tab-menu7" class="tab-content" style="display: <?= ($active_tab === 'menu7') ? 'block' : 'none'; ?>;">
          <?php if (file_exists('tab_kategori.php')) include 'tab_kategori.php'; ?>
        </div>

        <!-- TAB 8: WALI KELAS -->
        <div id="tab-menu8" class="tab-content" style="display: <?= ($active_tab === 'menu8') ? 'block' : 'none'; ?>;">
          <?php if (file_exists('tab_wali_kelas.php')) include 'tab_wali_kelas.php'; ?>
        </div>

        <!-- TAB 9: PENCATATAN PELANGGARAN -->
        <div id="tab-menu9" class="tab-content" style="display: <?= ($active_tab === 'menu9') ? 'block' : 'none'; ?>;">
          <?php if (file_exists('tab_pelanggaran.php')) include 'tab_pelanggaran.php'; ?>
        </div>

        <!-- TAB 10: LAPORAN PELANGGARAN -->
        <div id="tab-menu10" class="tab-content" style="display: <?= ($active_tab === 'menu10') ? 'block' : 'none'; ?>;">
          <?php if (file_exists('tab_laporan.php')) include 'tab_laporan.php'; ?>
        </div>
             
        <!-- TAB ABOUT ME -->
        <div id="tab-menu_about" class="tab-content" style="display: <?= ($active_tab === 'menu_about') ? 'block' : 'none'; ?>;">
          <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="p-4 text-white" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
              <h4 class="mb-0 fw-bold"><i class="bi bi-code-slash me-2 text-warning"></i>Profil Pengembang Aplikasi</h4>
              <p class="mb-0 text-white-50 small">Sistem Informasi Disiplin Siswa - UKK 2026</p>
            </div>
            <div class="card-body p-4 bg-white">
              <div class="row align-items-center">
                <div class="col-md-4 text-center mb-3 mb-md-0 border-end border-light">
                  <img src="foto-profil.jpg" alt="Foto Pengembang" class="img-fluid rounded-circle shadow border border-4 border-warning mb-3" style="width: 160px; height: 160px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/160?text=Pengembang';">
                  <h5 class="mb-0 fw-bold text-dark">Suraiya salsabila az-zahra</h5>
                  <span class="badge bg-warning mt-1 px-3 py-1 rounded-pill fw-semibold">Siswa / Programmer UKK</span>
                </div>
                <div class="col-md-8 ps-md-4">
                  <h5 class="text-warning fw-bold mb-3"><i class="bi bi-person-lines-fill me-2"></i>Biodata Pembuat Sistem</h5>
                  <table class="table table-borderless mb-0">
                    <tbody>
                      <tr>
                        <th width="30%" class="text-muted">Nama Lengkap</th>
                        <td width="5%">:</td>
                        <td class="fw-semibold">Suraiya salsabila az-zahra</td>
                      </tr>
                      <tr>
                        <th class="text-muted">NISN / NIS</th>
                        <td>:</td>
                        <td>0012345678</td>
                      </tr>
                      <tr>
                        <th class="text-muted">Kelas / Jurusan</th>
                        <td>:</td>
                        <td>XII Rekayasa Perangkat Lunak (RPL)</td>
                      </tr>
                      <tr>
                        <th class="text-muted">Sekolah</th>
                        <td>:</td>
                        <td>SMK Negeri / Swasta</td>
                      </tr>
                      <tr>
                        <th class="text-muted">Judul Proyek</th>
                        <td>:</td>
                        <td>Sistem Informasi Pelanggaran & Kedisiplinan Siswa (UKK 2026)</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer bg-light text-muted text-center py-3 border-0">
              <small>&copy; 2026 UKK Project - Dikembangkan untuk Uji Kompetensi Keahlian RPL.</small>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>