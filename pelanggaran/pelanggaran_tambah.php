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

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header("Location: ../login.php");
  exit();
}

$role = $_SESSION['role'] ?? 'Admin';
$msg_error = "";
$nama_admin_login = $_SESSION['nama'] ?? 'Administrator';

if (isset($_POST['btn_simpan_pelanggaran'])) {
  $siswa_id        = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
  $kategori_id     = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
  $tanggal         = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
  $keterangan      = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

  if (!empty($siswa_id) && !empty($kategori_id) && !empty($tanggal)) {
    $q_s = mysqli_query($koneksi, "SELECT s.*, k.id AS k_id, k.nama AS nama_kls 
                                   FROM t_siswa s 
                                   LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id 
                                   LEFT JOIN t_kelas k ON ks.kelas_id = k.id 
                                   WHERE s.id = '$siswa_id' LIMIT 1");
    $d_s = mysqli_fetch_assoc($q_s);
    $nama_siswa  = $d_s['nama'] ?? 'Siswa';
    $kelas_siswa = $d_s['nama_kls'] ?? '-';
    $kelas_id    = $d_s['k_id'] ?? 1;

    $q_k = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$kategori_id' LIMIT 1");
    $d_k = mysqli_fetch_assoc($q_k);
    $nama_pelanggaran = !empty($d_k['nama']) ? $d_k['nama'] : ($d_k['nama_kategori'] ?? 'Pelanggaran');
    $poin_val = (int)($d_k['poin'] ?? 0);

    $query_insert = "INSERT INTO t_pelanggaran_siswa 
                     (siswa_id, nama_siswa, kelas_id, nama_kelas, pelanggaran_kategori_id, nama_pelanggaran, nama_guru, tanggal, keterangan, poin, status) 
                     VALUES 
                     ('$siswa_id', '$nama_siswa', '$kelas_id', '$kelas_siswa', '$kategori_id', '$nama_pelanggaran', '$nama_admin_login', '$tanggal', '$keterangan', '$poin_val', 'Aktif')";

    $exec = mysqli_query($koneksi, $query_insert);
    if ($exec) {
      $target_tab = ($role === 'Guru') ? 'menu2' : 'menu9';
      echo "<script>
              alert('Berhasil! Data pelanggaran siswa telah dicatat.');
              window.location.href = '../dashboard.php?tab={$target_tab}';
            </script>";
      exit();
    } else {
      $msg_error = "Gagal Simpan ke Database: " . mysqli_error($koneksi);
    }
  } else {
    $msg_error = "Mohon lengkapi Siswa, Kategori Pelanggaran, dan Tanggal Kejadian!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catat Pelanggaran Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f6f9;
      color: #333;
    }

    .sidebar {
      background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%);
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      z-index: 1000;
      overflow-y: auto;
    }

    .sidebar .nav-link-custom {
      color: rgba(255, 255, 255, 0.85);
      background-color: rgba(255, 255, 255, 0.08);
      border-radius: 10px;
      padding: 10px 16px;
      margin-bottom: 8px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .sidebar .nav-link-custom:hover {
      color: #ffc107;
      background-color: rgba(255, 193, 7, 0.15);
    }

    main {
      margin-left: 250px;
    }

    @media (max-width: 768px) {
      main { margin-left: 0; }
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
          <span class="badge bg-warning text-dark px-2 py-1 rounded-pill fw-semibold"><i class="bi bi-person-check-fill me-1"></i><?= $role; ?></span>
        </div>
        <hr class="text-white-50">
        <ul class="nav flex-column mb-auto">
          <li class="nav-item"><a href="../dashboard.php?tab=menu1" class="nav-link-custom"><i class="bi bi-speedometer2 fs-5"></i><span>Dashboard</span></a></li>
          
          <?php if ($role === 'Guru'): ?>
            <li class="nav-item"><a href="../dashboard.php?tab=menu2" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-exclamation-triangle fs-5"></i><span>Catat Pelanggaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu3" class="nav-link-custom"><i class="bi bi-check-circle fs-5"></i><span>Tindakan</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-person-badge fs-5"></i><span>Profil Guru</span></a></li>
          <?php else: ?>
            <li class="nav-item"><a href="../dashboard.php?tab=menu2" class="nav-link-custom"><i class="bi bi-person-workspace fs-5"></i><span>Data Guru</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu3" class="nav-link-custom"><i class="bi bi-door-closed fs-5"></i><span>Data Kelas</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <?php endif; ?>

          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container-fluid px-0 pb-5">
          <?php if (!empty($msg_error)): ?>
            <div class="alert alert-danger shadow-sm mb-3"><?= $msg_error; ?></div>
          <?php endif; ?>

          <form action="" method="POST">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran Siswa</h5>
              </div>
              <div class="card-body p-4 bg-white">

                <div class="mb-3">
                  <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                  <select name="siswa_id" id="searchSiswa" class="form-select py-2" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php
                    $q_siswa = mysqli_query($koneksi, "SELECT s.*, k.nama AS nama_kls 
                                                       FROM t_siswa s 
                                                       LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id 
                                                       LEFT JOIN t_kelas k ON ks.kelas_id = k.id 
                                                       ORDER BY s.nama ASC");
                    if ($q_siswa) {
                      while ($s = mysqli_fetch_assoc($q_siswa)) {
                        $nisn_str = !empty($s['nisn']) ? $s['nisn'] : '-';
                        $kelas_str = !empty($s['nama_kls']) ? $s['nama_kls'] : '-';
                        echo "<option value='{$s['id']}'>" . htmlspecialchars($s['nama']) . " (NISN: {$nisn_str} - Kelas: {$kelas_str})</option>";
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Kategori Pelanggaran (Poin Otomatis) <span class="text-danger">*</span></label>
                  <select name="kategori_id" id="pilihKategori" class="form-select py-2" required onchange="updatePoinInfo(this)">
                    <option value="">-- Pilih Jenis Pelanggaran --</option>
                    <?php
                    $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC");
                    if ($q_kat) {
                      while ($k = mysqli_fetch_assoc($q_kat)) {
                        $nama_k = !empty($k['nama']) ? $k['nama'] : ($k['nama_kategori'] ?? 'Kategori Pelanggaran');
                        $poin_k = (int)($k['poin'] ?? 0);
                        echo "<option value='{$k['id']}' data-poin='{$poin_k}'>" . htmlspecialchars($nama_k) . " (+{$poin_k} Poin)</option>";
                      }
                    }
                    ?>
                  </select>
                  <small class="text-muted mt-1 d-block">Poin akan otomatis terisi berdasarkan kategori yang dipilih: <span id="infoPoin" class="fw-bold text-danger">0 Poin</span></small>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Tanggal Kejadian <span class="text-danger">*</span></label>
                  <input type="date" name="tanggal" class="form-control py-2" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-bold">Keterangan / Catatan Tambahan</label>
                  <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan rincian pelanggaran jika ada..."></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=<?= ($role === 'Guru') ? 'menu2' : 'menu9'; ?>" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="btn_simpan_pelanggaran" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Pelanggaran</button>
                </div>

              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <!-- jQuery & Select2 JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
        $('#searchSiswa').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Siswa --',
            allowClear: true
        });
    });

    function updatePoinInfo(selectObj) {
      let selectedOption = selectObj.options[selectObj.selectedIndex];
      let poin = selectedOption.getAttribute('data-poin') || 0;
      document.getElementById('infoPoin').innerText = poin + ' Poin';
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>