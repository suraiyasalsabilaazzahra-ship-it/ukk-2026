<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

// Variabel sesi harus didefinisikan di sini sebelum bagian HTML / include tab
$role = $_SESSION['role'];
$nama = $_SESSION['nama'];
$email = $_SESSION['email'];


// Query hitung total harus ada DI ATAS sebelum file tab dipanggil
$total_siswa_q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_siswa");
$total_siswa   = ($total_siswa_q) ? mysqli_fetch_assoc($total_siswa_q)['total'] : 0;

$total_guru_q  = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_guru");
$total_guru    = ($total_guru_q) ? mysqli_fetch_assoc($total_guru_q)['total'] : 0;

$total_kelas_q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_kelas");
$total_kelas   = ($total_kelas_q) ? mysqli_fetch_assoc($total_kelas_q)['total'] : 0;


// Konfigurasi Menu Berdasarkan Role
if ($role === 'Guru') {$menus = [
      ['id' => 'dashboard', 'name' => '1. Beranda Guru', 'icon' => 'bi-speedometer2'],
      ['id' => 'menu2', 'name' => '2. Catat Pelanggaran', 'icon' => 'bi-exclamation-octagon'],
      ['id' => 'menu3', 'name' => '3. Tindakan', 'icon' => 'bi-shield-check'],
      ['id' => 'menu4', 'name' => '4. Profil Guru', 'icon' => 'bi-person-badge'],
      ['id' => 'menu5', 'name' => 'About Me', 'icon' => 'bi-info-circle']
    ];
} else {
    $menus = [
      ['id' => 'dashboard', 'name' => '1. Dashboard Admin', 'icon' => 'bi-speedometer2'],
      ['id' => 'menu2', 'name' => '2. Data Guru', 'icon' => 'bi-person-workspace'],
      ['id' => 'menu3', 'name' => '3. Data Kelas', 'icon' => 'bi-building'],
      ['id' => 'menu4', 'name' => '4. Data Siswa', 'icon' => 'bi-people'],
      ['id' => 'menu5', 'name' => '5. Data Tahun Ajaran', 'icon' => 'bi-calendar-range'],
      ['id' => 'menu6', 'name' => '6. Penempatan Siswa', 'icon' => 'bi-diagram-3'],
      ['id' => 'menu7', 'name' => '7. Kategori Pelanggaran', 'icon' => 'bi-tags'],
      ['id' => 'menu8', 'name' => '8. Data Wali Kelas', 'icon' => 'bi-person-bounding-box'],
      ['id' => 'menu9', 'name' => 'About Me', 'icon' => 'bi-info-circle']
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
    
    /* Sidebar Styling - Menempel/Sticky di Kiri */
    .sidebar {
      background: linear-gradient(180deg, #8b0000 0%, #5a0000 100%);
      box-shadow: 4px 0 15px rgba(0,0,0,0.08);
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
      color: #fff;
      background-color: rgba(255, 255, 255, 0.22);
      transform: translateX(4px);
    }

    .sidebar .nav-link-custom.active-menu {
      background-color: #ffffff;
      color: #8b0000 !important;
      font-weight: 700;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    /* Cards & Glassmorphism Header */
    .main-header-card {
      background: #ffffff;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
      border: 1px solid rgba(0,0,0,0.05);
    }

    .stat-card {
      border: none;
      border-radius: 16px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      overflow: hidden;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }

    /* Table Styling */
    .custom-table-card {
      background: #ffffff;
      border-radius: 16px;
      border: none;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .table thead th {
      background-color: #8b0000;
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

    .btn-maroon {
      background-color: #8b0000;
      color: #fff;
      border: none;
    }
    .btn-maroon:hover {
      background-color: #6d0000;
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
          <?php foreach ($menus as $index =>$menu): ?>
            <li class="nav-item">
              <a href="#" id="btn-tab-<?= $menu['id']; ?>" onclick="pindahTab('<?= $menu['id']; ?>')" class="nav-link-custom <?= $index === 0 ? 'active-menu' : ''; ?>">
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

      <!-- KONTEN UTAMA (Dengan kelas sticky ms-md-auto sesuai permintaan) -->
      <main class="col-md-9 col-lg-10 p-4 ms-md-auto">

        <!-- HEADER KONTEN -->
      

       <!-- TAB 1: DASHBOARD -->
        <div id="tab-dashboard" class="tab-content">
          <?php include 'tab_dashboard.php'; ?>
        </div>

        <!-- TAB 2: DATA GURU / CATAT PELANGGARAN -->
        <div id="tab-menu2" class="tab-content" style="display: none;">
          <?php include 'tab_guru.php'; ?>
        </div>

        <!-- TAB 3: DATA KELAS -->
        <div id="tab-menu3" class="tab-content" style="display: none;">
          <?php include 'tab_kelas.php'; ?>
        </div>

        <!-- TAB 4: DATA SISWA -->
        <div id="tab-menu4" class="tab-content" style="display: none;">
          <?php include 'tab_siswa.php'; ?>
        </div>

        <!-- TAB 5: DATA TAHUN AJARAN -->
        <div id="tab-menu5" class="tab-content" style="display: none;">
          <?php include 'tab_tahun_ajaran.php'; ?>
        </div>

        <!-- TAB 6: PENEMPATAN SISWA -->
        <div id="tab-menu6" class="tab-content" style="display: none;">
          <?php include 'tab_penempatan.php'; ?>
        </div>

        <!-- TAB 7: KATEGORI PELANGGARAN -->
        <div id="tab-menu7" class="tab-content" style="display: none;">
          <?php include 'tab_kategori.php'; ?>
        </div>

        <!-- TAB 8: DATA WALI KELAS -->
        <div id="tab-menu8" class="tab-content" style="display: none;">
          <?php include 'tab_wali_kelas.php'; ?>
        </div>

      

        <!-- TAB 6: PENEMPATAN SISWA -->
        <div id="tab-menu6" class="tab-content" style="display: none;">
          <div class="custom-table-card p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-diagram-3 me-2 text-danger"></i>Data Penempatan Siswa (t_kelas_siswa)</h5>
            <div class="table-responsive rounded-3 overflow-hidden">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>ID</th><th>Siswa ID</th><th>Tahun Ajaran ID</th><th>Kelas ID</th><th>Status</th></tr>
                </thead>
                <tbody>
                  <?php
                  $q_ps = mysqli_query($koneksi, "SELECT * FROM t_kelas_siswa");
                  if ($q_ps && mysqli_num_rows($q_ps) > 0) {
                      while ($ps = mysqli_fetch_assoc($q_ps)) {
                          $st = ($ps['status_aktif'] == 1) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Non-Aktif</span>';
                          echo "<tr><td class='text-muted'>#{$ps['id']}</td><td>{$ps['siswa_id']}</td><td>{$ps['tahun_ajaran_id']}</td><td>{$ps['kelas_id']}</td><td>{$st}</td></tr>";
                      }
                  } else {
                      echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data penempatan siswa</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 7: KATEGORI PELANGGARAN -->
        <div id="tab-menu7" class="tab-content" style="display: none;">
          <div class="custom-table-card p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-tags me-2 text-danger"></i>Kategori Pelanggaran (t_pelanggaran_kategori)</h5>
            <div class="table-responsive rounded-3 overflow-hidden">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>ID</th><th>Nama Kategori</th><th>Deskripsi</th><th>Status</th></tr>
                </thead>
                <tbody>
                  <?php
                  $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori LIMIT 10");
                  if ($q_kat && mysqli_num_rows($q_kat) > 0) {
                      while ($kat = mysqli_fetch_assoc($q_kat)) {
                          $st = ($kat['status_aktif'] == 1) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Non-Aktif</span>';
                          echo "<tr><td class='text-muted'>#{$kat['id']}</td><td class='fw-semibold'>{$kat['nama']}</td><td>{$kat['deskripsi']}</td><td>{$st}</td></tr>";
                      }
                  } else {
                      echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada kategori pelanggaran</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 8: DATA WALI KELAS -->
        <div id="tab-menu8" class="tab-content" style="display: none;">
          <div class="custom-table-card p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-person-bounding-box me-2 text-danger"></i>Data Wali Kelas (t_wali_kelas)</h5>
            <div class="table-responsive rounded-3 overflow-hidden">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>ID</th><th>Guru ID</th><th>Kelas ID</th><th>Tahun Ajaran ID</th><th>Status</th></tr>
                </thead>
                <tbody>
                  <?php
                  $q_wk = mysqli_query($koneksi, "SELECT * FROM t_wali_kelas");
                  if ($q_wk && mysqli_num_rows($q_wk) > 0) {
                      while ($wk = mysqli_fetch_assoc($q_wk)) {
                          $st = ($wk['status_aktif'] == 1) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Non-Aktif</span>';
                          echo "<tr><td class='text-muted'>#{$wk['id']}</td><td>{$wk['guru_id']}</td><td>{$wk['kelas_id']}</td><td>{$wk['tahun_ajaran_id']}</td><td>{$st}</td></tr>";
                      }
                  } else {
                      echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data wali kelas</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB ABOUT ME -->
        <div id="tab-<?= $role === 'Guru' ? 'menu5' : 'menu9'; ?>" class="tab-content" style="display: none;">
          <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="p-4 bg-maroon text-white" style="background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);">
              <h4 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i>Profil Pengembang / User</h4>
              <p class="mb-0 text-white-50 small">Sistem Informasi UKK 2026</p>
            </div>
            <div class="card-body p-4 bg-white">
              <div class="row align-items-center">
                <div class="col-md-4 text-center mb-3 mb-md-0 border-end border-light">
                  <img src="foto-profil.jpg" alt="Foto Profil" class="img-fluid rounded-circle shadow border border-4 border-danger mb-3" style="width: 160px; height: 160px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/160?text=Foto+Profil';">
                  <h5 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($nama); ?></h5>
                  <span class="badge bg-danger mt-1 px-3 py-1 rounded-pill"><?= $role; ?></span>
                </div>
                <div class="col-md-8 ps-md-4">
                  <h5 class="text-danger fw-bold mb-3"><i class="bi bi-info-square me-2"></i>Informasi Biodata</h5>
                  <table class="table table-borderless mb-0">
                    <tbody>
                      <tr><th width="30%" class="text-muted">Nama Lengkap</th><td width="5%">:</td><td class="fw-semibold"><?= htmlspecialchars($nama); ?></td></tr>
                      <tr><th class="text-muted">Email</th><td>:</td><td><?= htmlspecialchars($email); ?></td></tr>
                      <tr><th class="text-muted">Role / Jabatan</th><td>:</td><td><?= $role; ?> Sistem</td></tr>
                      <tr><th class="text-muted">Kelas / Jurusan</th><td>:</td><td>XII Rekayasa Perangkat Lunak (RPL)</td></tr>
                      <tr><th class="text-muted">Proyek</th><td>:</td><td>Uji Kompetensi Keahlian (UKK) 2026</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer bg-light text-muted text-center py-3 border-0">
              <small>&copy; 2026 UKK Project - Dikembangkan dengan dedikasi penuh.</small>
            </div>
          </div>
        </div>

      </main>

    </div>
  </div>

 <script>
    function pindahTab(tabId) {
      // Sembunyikan semua tab
      const allTabs = document.querySelectorAll('.tab-content');
      allTabs.forEach(tab => {
        tab.style.display = 'none';
      });

      // Tampilkan tab terpilih
      const selectedTab = document.getElementById(`tab-${tabId}`);
      if (selectedTab) {
        selectedTab.style.display = 'block';
      }

      // Reset class active pada menu sidebar
      const allMenuButtons = document.querySelectorAll('.nav-link-custom');
      allMenuButtons.forEach(btn => {
        btn.classList.remove('active-menu');
      });

      // Tambahkan highlight active pada menu yang diklik
      const activeBtn = document.getElementById(`btn-tab-${tabId}`);
      if (activeBtn) {
        activeBtn.classList.add('active-menu');
      }
    }

    // Otomatis buka tab sesuai URL parameter (misal ?tab=menu6) setelah halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
      <?php if (isset($_GET['tab'])): ?>
        pindahTab('<?= htmlspecialchars($_GET['tab']); ?>');
      <?php endif; ?>
    });
  </script>
</body>
</html>