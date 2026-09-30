<?php
session_start();

// Proteksi halaman dashboard
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];
$email = $_SESSION['email'];

// Konfigurasi Menu Berdasarkan Role
if ($role === 'Guru') {$menus = [
      ['id' => 'dashboard', 'name' => '1. Beranda Guru'],
      ['id' => 'menu2', 'name' => '2. Catat Pelanggaran'],
      ['id' => 'menu3', 'name' => '3. Tindakan'],
      ['id' => 'menu4', 'name' => '4. Profil Guru'],
      ['id' => 'menu5', 'name' => 'About Me']
    ];
} else {
    $menus = [
      ['id' => 'dashboard', 'name' => '1. Dashboard Admin'],
      ['id' => 'menu2', 'name' => '2. Data Guru'],
      ['id' => 'menu3', 'name' => '3. Data Kelas & Siswa'],
      ['id' => 'menu4', 'name' => '4. Data Tahun Ajaran'],
      ['id' => 'menu5', 'name' => '5. Penempatan Siswa'],
      ['id' => 'menu6', 'name' => '6. Kategori Pelanggaran'],
      ['id' => 'menu7', 'name' => '7. Data Wali Kelas'],
      ['id' => 'menu8', 'name' => 'About Me']
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Informasi UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <div class="container-fluid">
    <div class="row">

      <!-- SIDEBAR -->
      <div class="col-md-3 col-lg-2 min-vh-100 p-3 text-white" style="background-color: #8b0000;">
        <h4 class="mb-1">My Website</h4>
        <p class="small text-white-50">Log sebagai: <strong><?= $role; ?></strong></p>
        <hr class="text-white">

        <ul class="nav nav-pills flex-column mb-auto">
          <?php foreach ($menus as $index =>$menu): ?>
            <li class="nav-item mb-2">
              <a href="#" onclick="pindahTab('<?= $menu['id']; ?>')" class="nav-link text-white bg-danger mb-1">
                <?= $menu['name']; ?>
              </a>
            </li>
          <?php endforeach; ?>

          <li class="nav-item mt-4">
            <a href="logout.php" class="nav-link text-warning fw-bold">
              Logout
            </a>
          </li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4">

        <div class="mb-4">
          <h2>Selamat Datang, <?= $nama; ?></h2>
          <p class="text-muted">Email: <?= $email; ?></p>
        </div>

        <!-- TAB 1: DASHBOARD -->
        <div id="tab-dashboard" class="tab-content">
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="card shadow-sm border-danger">
                <div class="card-body">
                  <h5 class="card-title">Data Siswa</h5>
                  <h2>120</h2>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card shadow-sm border-danger">
                <div class="card-body">
                  <h5 class="card-title">Data Guru</h5>
                  <h2>25</h2>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card shadow-sm border-danger">
                <div class="card-body">
                  <h5 class="card-title">Kelas</h5>
                  <h2>12</h2>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB 2: DINAMIS -->
        <div id="tab-menu2" class="tab-content" style="display: none;">
          <h4><?= $role === 'Guru' ? 'Catat Pelanggaran Siswa' : 'Kelola Data Guru (Tabel t_guru)'; ?></h4>
          <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <?php if ($role === 'Guru'): ?>
                  <th>No</th><th>Nama Siswa</th><th>Pelanggaran</th><th>Poin</th>
                <?php else: ?>
                  <th>ID</th><th>NIP</th><th>Nama Guru</th><th>Email</th><th>Status</th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php if ($role === 'Guru'): ?>
                <tr><td>1</td><td>Ahmad Rizki</td><td>Terlambat Masuk</td><td>5</td></tr>
                <tr><td>2</td><td>Siti Aminah</td><td>Atribut Tidak Lengkap</td><td>10</td></tr>
              <?php else: ?>
                <tr><td>1</td><td>198501152010011001</td><td>Budi Santoso, S.Pd.</td><td>guru@sekolah.sch.id</td><td>Aktif</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- TAB DUMMY LAINNYA -->
        <div id="tab-menu3" class="tab-content" style="display: none;">
          <h4>Detail Menu 3</h4>
          <p>Halaman konten untuk menu 3.</p>
        </div>

        <!-- TAB ABOUT ME (Guru: menu5 | Admin: menu8) -->
        <div id="tab-<?= $role === 'Guru' ? 'menu5' : 'menu8'; ?>" class="tab-content" style="display: none;">
          <div class="card shadow border-0 overflow-hidden">
            <!-- Header Kartu / Banner -->
            <div class="p-4 bg-danger text-white">
              <h3 class="mb-0 fw-bold">Profil Pengembang / User</h3>
              <p class="mb-0 text-white-50">Sistem Informasi UKK 2026</p>
            </div>

            <!-- Isi Kartu -->
            <div class="card-body p-4">
              <div class="row align-items-center">
                <!-- Foto Profil -->
                <div class="col-md-4 text-center mb-3 mb-md-0">
                  <img src="foto-profil.jpg" alt="Foto Profil" class="img-fluid rounded-circle shadow border border-4 border-danger" style="width: 200px; height: 200px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/200?text=Foto+Profil';">
                  <h5 class="mt-3 mb-0 fw-bold"><?= $nama; ?></h5>
                  <span class="badge bg-danger mt-1"><?= $role; ?></span>
                </div>

                <!-- Detail Biodata -->
                <div class="col-md-8">
                  <h4 class="text-danger fw-bold mb-3">Informasi Biodata</h4>
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <th width="30%">Nama Lengkap</th>
                        <td width="5%">:</td>
                        <td><?= $nama; ?></td>
                      </tr>
                      <tr>
                        <th>Email</th>
                        <td>:</td>
                        <td><?= $email; ?></td>
                      </tr>
                      <tr>
                        <th>Role / Jabatan</th>
                        <td>:</td>
                        <td><?= $role; ?> Sistem</td>
                      </tr>
                      <tr>
                        <th>Kelas / Jurusan</th>
                        <td>:</td>
                        <td>XII Rekayasa Perangkat Lunak (RPL)</td>
                      </tr>
                      <tr>
                        <th>Proyek</th>
                        <td>:</td>
                        <td>Uji Kompetensi Keahlian (UKK) 2026</td>
                      </tr>
                    </tbody>
                  </table>

                  <!-- Keahlian / Tech Stack -->
                  <h5 class="text-danger fw-bold mt-4 mb-2">Keahlian & Teknologi</h5>
                  <div>
                    <span class="badge bg-secondary me-1 p-2">HTML5 & CSS3</span>
                    <span class="badge bg-secondary me-1 p-2">Bootstrap 5</span>
                    <span class="badge bg-secondary me-1 p-2">PHP Native</span>
                    <span class="badge bg-secondary me-1 p-2">MySQL</span>
                    <span class="badge bg-secondary me-1 p-2">JavaScript</span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card-footer bg-light text-muted text-center py-3">
              <small>&copy; 2026 UKK Project - Dikembangkan dengan dedikasi penuh.</small>
            </div>
          </div>
        </div>

      </main>

    </div>
  </div>

  <script>
    function pindahTab(tabId) {
      const allTabs = document.querySelectorAll('.tab-content');
      allTabs.forEach(tab => {
        tab.style.display = 'none';
      });

      const selectedTab = document.getElementById(`tab-${tabId}`);
      if (selectedTab) {
        selectedTab.style.display = 'block';
      }
    }
  </script>

</body>
</html>