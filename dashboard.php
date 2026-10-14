<?php
session_start();

// Connect ke file koneksi database
include 'koneksi.php';

// Proteksi halaman dashboard
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];
$email = $_SESSION['email'];

// --- QUERY COUNT UNTUK CARD TAB DASHBOARD ---
$total_siswa_q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_siswa");
$total_siswa   = ($total_siswa_q) ? mysqli_fetch_assoc($total_siswa_q)['total'] : 0;

$total_guru_q  = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_guru");
$total_guru    = ($total_guru_q) ? mysqli_fetch_assoc($total_guru_q)['total'] : 0;

$total_kelas_q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_kelas");
$total_kelas   = ($total_kelas_q) ? mysqli_fetch_assoc($total_kelas_q)['total'] : 0;

// Konfigurasi Menu Berdasarkan Role (Menu Kelas dan Siswa Dipisah)
if ($role === 'Guru') {
    $menus = [
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
    
    /* Sidebar Styling */
    .sidebar {
      background: linear-gradient(180deg, #8b0000 0%, #5a0000 100%);
      box-shadow: 4px 0 15px rgba(0,0,0,0.08);
      min-height: 100vh;
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
          <?php foreach ($menus as $index => $menu): ?>
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

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4">

        <!-- HEADER KONTEN -->
        <div class="main-header-card mb-4 d-flex justify-content-between align-items-center">
          <div>
            <h3 class="mb-1 fw-bold text-dark">Selamat Datang, <?= htmlspecialchars($nama); ?> 👋</h3>
            <p class="text-muted mb-0 small"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($email); ?> | Logged in as <strong><?= $role; ?></strong></p>
          </div>
          <div class="text-end d-none d-md-block">
            <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i>Tahun Ajaran Aktif</span>
            <h6 class="fw-bold mb-0 text-danger">2025 / 2026</h6>
          </div>
        </div>

        <!-- TAB 1: DASHBOARD -->
        <div id="tab-dashboard" class="tab-content">
          <div class="row g-4">
            <div class="col-md-4">
              <div class="card stat-card shadow-sm bg-white border-start border-4 border-danger p-3">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <span class="text-muted fw-medium text-uppercase small">Total Siswa</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark"><?= $total_siswa; ?></h2>
                  </div>
                  <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                    <i class="bi bi-people fs-2"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card stat-card shadow-sm bg-white border-start border-4 border-warning p-3">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <span class="text-muted fw-medium text-uppercase small">Total Guru</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark"><?= $total_guru; ?></h2>
                  </div>
                  <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                    <i class="bi bi-person-workspace fs-2"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card stat-card shadow-sm bg-white border-start border-4 border-success p-3">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <span class="text-muted fw-medium text-uppercase small">Total Kelas</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark"><?= $total_kelas; ?></h2>
                  </div>
                  <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                    <i class="bi bi-building fs-2"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB 2: DATA GURU / CATAT PELANGGARAN -->
        <div id="tab-menu2" class="tab-content" style="display: none;">
          <div class="custom-table-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-workspace me-2 text-danger"></i><?= $role === 'Guru' ? 'Catat Pelanggaran Siswa' : 'Kelola Data Guru (Tabel t_guru)'; ?></h5>
              <?php if ($role !== 'Guru'): ?>
                <a href="guru_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold"><i class="bi bi-plus-lg me-1"></i>Tambah Guru</a>
              <?php endif; ?>
            </div>

            <div class="table-responsive rounded-3 overflow-hidden">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <?php if ($role === 'Guru'): ?>
                      <th>No</th><th>Nama Siswa</th><th>Pelanggaran</th><th>Poin</th>
                    <?php else: ?>
                      <th>ID</th><th>NIP</th><th>Nama Guru</th><th>Email</th><th>Status</th><th class="text-center">Aksi</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($role === 'Guru'): ?>
                    <?php
                    $no = 1;
                    $q_pelanggaran = mysqli_query($koneksi, "
                      SELECT s.nama, p.nama as nama_pelanggaran, p.poin 
                      FROM t_pelanggaran_siswa ps
                      JOIN t_siswa s ON ps.siswa_id = s.id
                      JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
                    ");
                    if ($q_pelanggaran && mysqli_num_rows($q_pelanggaran) > 0) {
                        while ($p = mysqli_fetch_assoc($q_pelanggaran)) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td class='fw-semibold'>{$p['nama']}</td>
                                    <td>{$p['nama_pelanggaran']}</td>
                                    <td><span class='badge bg-danger'>{$p['poin']} Poin</span></td>
                                  </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada data pelanggaran</td></tr>";
                    }
                    ?>
                  <?php else: ?>
                    <?php
                    $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY id DESC");
                    if ($q_guru && mysqli_num_rows($q_guru) > 0) {
                        while ($g = mysqli_fetch_assoc($q_guru)) {
                            $status_badge = ($g['status_aktif'] == 1) ? '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Tidak Aktif</span>';
                            echo "<tr>
                                    <td class='text-muted'>#{$g['id']}</td>
                                    <td>{$g['nip']}</td>
                                    <td class='fw-semibold'>{$g['nama']}</td>
                                    <td>{$g['email']}</td>
                                    <td>{$status_badge}</td>
                                   <td class='text-center'>
                                      <a href='guru_edit.php?id={$g['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                                      <a href='guru_hapus.php?id={$g['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data guru di database</td></tr>";
                    }
                    ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 3: DATA KELAS -->
        <div id="tab-menu3" class="tab-content" style="display: none;">
          <div class="custom-table-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold text-dark mb-0"><i class="bi bi-building me-2 text-danger"></i>Data Kelas (t_kelas)</h5>
              <?php if ($role !== 'Guru'): ?>
                <a href="kelas_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold"><i class="bi bi-plus-lg me-1"></i>Tambah Kelas</a>
              <?php endif; ?>
            </div>

            <div class="table-responsive rounded-3 overflow-hidden">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th width="10%">ID</th>
                    <th>Nama Kelas</th>
                    <th width="15%">Tingkat</th>
                    <th width="20%">Jurusan</th>
                    <th width="15%" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $q_kls = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY id DESC");
                  if ($q_kls && mysqli_num_rows($q_kls) > 0) {
                      while ($k = mysqli_fetch_assoc($q_kls)) {$nama_kelas = $k['nama'] ?? $k['nama_kelas'] ?? '-';
                       echo "<tr>
            <td class='text-muted'>#{$k['id']}</td>
            <td class='fw-semibold'>{$nama_kelas}</td>
            <td><span class='badge bg-light text-dark border'>Tingkat {$k['tingkat']}</span></td>
            <td>{$k['jurusan']}</td>
            <td class='text-center'>
              <a href='kelas_edit.php?id={$k['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'><i class='bi bi-pencil-square'></i> Edit</a>
              <a href='kelas_hapus.php?id={$k['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus kelas ini?\")'><i class='bi bi-trash'></i> Hapus</a>
            </td>
          </tr>";
    }
} else {
                      echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data kelas</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 4: DATA SISWA -->
        <div id="tab-menu4" class="tab-content" style="display: none;">
          <div class="custom-table-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold text-dark mb-0"><i class="bi bi-people me-2 text-danger"></i>Data Siswa (t_siswa)</h5>
              <?php if ($role !== 'Guru'): ?>
                <a href="siswa_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold"><i class="bi bi-plus-lg me-1"></i>Tambah Siswa</a>
              <?php endif; ?>
            </div>

            <div class="table-responsive rounded-3 overflow-hidden">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th width="8%">ID</th>
                    <th width="20%">NISN</th>
                    <th>Nama Siswa</th>
                    <th width="15%" class="text-center">L/P</th>
                    <th width="15%" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
           <?php
                  $q_kls = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY id DESC");
                  if ($q_kls && mysqli_num_rows($q_kls) > 0) {
                      while ($k = mysqli_fetch_assoc($q_kls)) {
                          $nama_kelas = $k['nama'] ?? $k['nama_kelas'] ?? '-';
                          echo "<tr>
                                  <td class='text-muted'>#{$k['id']}</td>
                                  <td class='fw-semibold'>{$nama_kelas}</td>
                                  <td><span class='badge bg-light text-dark border'>Tingkat {$k['tingkat']}</span></td>
                                  <td>{$k['jurusan']}</td>
                                  <td class='text-center'>
                                    <a href='kelas_edit.php?id={$k['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                                    <a href='kelas_hapus.php?id={$k['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus kelas ini?\")'>Hapus</a>
                                  </td>
                                </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data kelas</td></tr>";
                  }
                  ?>
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 5: DATA TAHUN AJARAN -->
        <div id="tab-menu5" class="tab-content" style="display: none;">
          <div class="custom-table-card p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-range me-2 text-danger"></i>Data Tahun Ajaran (t_tahun_ajaran)</h5>
            <div class="table-responsive rounded-3 overflow-hidden">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>ID</th><th>Nama Tahun Ajaran</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th></tr>
                </thead>
                <tbody>
                  <?php
                  $q_ta = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran LIMIT 10");
                  if ($q_ta && mysqli_num_rows($q_ta) > 0) {
                      while ($ta = mysqli_fetch_assoc($q_ta)) {
                          echo "<tr><td class='text-muted'>#{$ta['id']}</td><td class='fw-semibold'>{$ta['nama']}</td><td>{$ta['tanggal_mulai']}</td><td>{$ta['tanggal_selesai']}</td></tr>";
                      }
                  } else {
                      echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada data tahun ajaran</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
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
                  $q_sis = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY id DESC");
                  if ($q_sis && mysqli_num_rows($q_sis) > 0) {
                      while ($s = mysqli_fetch_assoc($q_sis)) {
                          $jk_badge = ($s['jenis_kelamin'] == 'L') ? '<span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Laki-Laki</span>' : '<span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Perempuan</span>';
                          echo "<tr>
                                  <td class='text-muted'>#{$s['id']}</td>
                                  <td>{$s['nisn']}</td>
                                  <td class='fw-semibold'>{$s['nama']}</td>
                                  <td class='text-center'>{$jk_badge}</td>
                                  <td class='text-center'>
                                    <a href='siswa_edit.php?id={$s['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                                    <a href='siswa_hapus.php?id={$s['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus siswa ini?\")'>Hapus</a>
                                  </td>
                                </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data siswa</td></tr>";
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
  </script>

</body>
</html>