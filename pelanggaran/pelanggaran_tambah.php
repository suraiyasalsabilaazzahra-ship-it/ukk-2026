<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Perbaikan path koneksi yang aman dari folder manapun file ini diakses
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

if (isset($_POST['btn_simpan_pelanggaran'])) {
  $siswa_id        = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
  $kategori_id     = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
  $tanggal         = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
  $bentuk_tindakan = mysqli_real_escape_string($koneksi, $_POST['bentuk_tindakan'] ?? '');
  $keterangan      = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

  if (!empty($siswa_id) && !empty($kategori_id) && !empty($tanggal) && !empty($bentuk_tindakan)) {
    // Ambil poin otomatis dari t_pelanggaran_kategori
    $q_get_poin = mysqli_query($koneksi, "SELECT poin FROM t_pelanggaran_kategori WHERE id = '$kategori_id' LIMIT 1");
    $d_poin = mysqli_fetch_assoc($q_get_poin);
    $poin_val = $d_poin['poin'] ?? 0;

    // 1. Simpan ke t_pelanggaran_siswa
    $query_insert = "INSERT INTO t_pelanggaran_siswa (siswa_id, pelanggaran_kategori_id, poin, tanggal, keterangan) 
                         VALUES ('$siswa_id', '$kategori_id', '$poin_val', '$tanggal', '$keterangan')";

    $exec = mysqli_query($koneksi, $query_insert);
    if ($exec) {
      // Ambil ID dari data pelanggaran yang baru saja masuk
      $last_pelanggaran_id = mysqli_insert_id($koneksi);

      // 2. Simpan juga bentuk tindakan ke t_tindakan agar sinkron
      mysqli_query($koneksi, "INSERT INTO t_tindakan (pelanggaran_siswa_id, bentuk_tindakan, tanggal_tindakan, status_penyelesaian) 
                                    VALUES ('$last_pelanggaran_id', '$bentuk_tindakan', '$tanggal', 'Diproses')");

      $target_tab = ($role === 'Guru') ? 'menu2' : 'menu9';
      echo "<script>
                    alert('Berhasil! Data pelanggaran dan sanksi tindakan siswa telah dicatat.');
                    window.location.href = '../dashboard.php?tab={$target_tab}';
                  </script>";
      exit();
    } else {
      $msg_error = "Gagal Simpan: " . mysqli_error($koneksi);
    }
  } else {
    $msg_error = "Mohon lengkapi Siswa, Kategori Pelanggaran, Tanggal, dan Bentuk Tindakan!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catat Pelanggaran & Tindakan Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
      width: calc(100% - 250px);
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
            <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <?php endif; ?>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-12 p-4 ms-auto">
        <div class="container-fluid px-0">
          <?php if (!empty($msg_error)): ?>
            <div class="alert alert-danger shadow-sm mb-3"><?= $msg_error; ?></div>
          <?php endif; ?>

          <form action="" method="POST">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden w-100">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran & Tindakan Siswa</h5>
              </div>
              <div class="card-body p-4 bg-white">

                <div class="mb-3">
                  <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                  <select name="siswa_id" class="form-select py-2" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php
                    $q_siswa = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY nama ASC");
                    if ($q_siswa) {
                      while ($s = mysqli_fetch_assoc($q_siswa)) {
                        echo "<option value='{$s['id']}'>" . htmlspecialchars($s['nama']) . " (Kelas: " . htmlspecialchars($s['kelas'] ?? '-') . ")</option>";
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

                <!-- PILIHAN BENTUK TINDAKAN / SANKSI -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Bentuk Tindakan / Sanksi <span class="text-danger">*</span></label>
                  <select name="bentuk_tindakan" class="form-select py-2" required>
                    <option value="">-- Pilih Bentuk Tindakan --</option>
                    <option value="Menunggu 45 menit di luar kelas sebelum masuk">Menunggu 45 menit di luar kelas sebelum masuk</option>
                    <option value="Membersihkan lingkungan sekolah / halaman">Membersihkan lingkungan sekolah / halaman</option>
                    <option value="Membuat surat pernyataan bermaterai">Membuat surat pernyataan bermaterai</option>
                    <option value="Panggilan orang tua / wali murid ke sekolah">Panggilan orang tua / wali murid ke sekolah</option>
                    <option value="Peringatan lisan dan pembinaan guru BK">Peringatan lisan dan pembinaan guru BK</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Tanggal Kejadian <span class="text-danger">*</span></label>
                  <input type="date" name="tanggal" class="form-control py-2" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-bold">Keterangan / Catatan Tambahan</label>
                  <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan rincian pelanggaran..."></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=<?= ($role === 'Guru') ? 'menu2' : 'menu9'; ?>" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="btn_simpan_pelanggaran" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Pelanggaran & Tindakan</button>
                </div>

              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <script>
    function updatePoinInfo(selectObj) {
      let selectedOption = selectObj.options[selectObj.selectedIndex];
      let poin = selectedOption.getAttribute('data-poin') || 0;
      document.getElementById('infoPoin').innerText = poin + ' Poin';
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>