<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../dashboard.php?tab=menu8");
    exit();
}

$role = $_SESSION['role'];
$error = "";

$tahun_sekarang = date('Y'); // 2026
$tahun_ajaran_otomatis = $tahun_sekarang . '/' . ($tahun_sekarang + 1);

if (isset($_POST['simpan'])) {
    $guru_id         = mysqli_real_escape_string($koneksi, $_POST['guru_id'] ?? '');
    $tingkat_pilih   = mysqli_real_escape_string($koneksi, $_POST['tingkat_pilih'] ?? '');
    $kelas_pilih     = mysqli_real_escape_string($koneksi, $_POST['kelas_pilih'] ?? ''); // Menggunakan nama kelas / ID kelas
    $tahun_ajaran_id = mysqli_real_escape_string($koneksi, $_POST['tahun_ajaran_id'] ?? '');
    $status_aktif    = mysqli_real_escape_string($koneksi, $_POST['status_aktif'] ?? '1');

    if (!empty($guru_id) && !empty($tingkat_pilih) && !empty($kelas_pilih) && !empty($tahun_ajaran_id)) {
        
        // Cek apakah guru sudah menjadi wali kelas pada tahun ajaran yang sama
        $cek_guru = mysqli_query($koneksi, "SELECT * FROM t_wali_kelas WHERE guru_id = '$guru_id' AND tahun_ajaran_id = '$tahun_ajaran_id' LIMIT 1");
        if ($cek_guru && mysqli_num_rows($cek_guru) > 0) {
            $error = "Gagal! Guru tersebut sudah bertugas sebagai wali kelas di kelas lain pada tahun ajaran ini.";
        } else {
            // Cari ID kelas berdasarkan tingkat dan nama kelas yang dipilih
            $q_cari_kelas = mysqli_query($koneksi, "SELECT id FROM t_kelas WHERE tingkat = '$tingkat_pilih' AND (nama = '$kelas_pilih' OR id = '$kelas_pilih') LIMIT 1");
            
            if ($q_cari_kelas && mysqli_num_rows($q_cari_kelas) > 0) {
                $d_kelas = mysqli_fetch_assoc($q_cari_kelas);
                $kelas_id = $d_kelas['id'];

                // Cek apakah kelas tersebut sudah punya wali kelas di tahun ajaran ini
                $cek_kelas_wk = mysqli_query($koneksi, "SELECT * FROM t_wali_kelas WHERE kelas_id = '$kelas_id' AND tahun_ajaran_id = '$tahun_ajaran_id' LIMIT 1");
                if ($cek_kelas_wk && mysqli_num_rows($cek_kelas_wk) > 0) {
                    $error = "Gagal! Kelas tersebut sudah memiliki wali kelas pada tahun ajaran ini.";
                } else {
                    $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_wali_kelas");
                    $r_max = mysqli_fetch_assoc($q_max);
                    $new_id = ($r_max['max_id'] ?? 0) + 1;

                    $query = "INSERT INTO t_wali_kelas (id, guru_id, kelas_id, tahun_ajaran_id, status_aktif) 
                              VALUES ('$new_id', '$guru_id', '$kelas_id', '$tahun_ajaran_id', '$status_aktif')";
                    $result = mysqli_query($koneksi, $query);

                    if ($result) {
                        echo "<script>alert('Berhasil! Data wali kelas baru telah ditambahkan.'); window.location.href='../dashboard.php?tab=menu8';</script>";
                        exit();
                    } else {
                        $error = "Gagal menyimpan data wali kelas: " . mysqli_error($koneksi);
                    }
                }
            } else {
                $error = "Data kelas tidak ditemukan!";
            }
        }
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Wali Kelas - UKK 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
        .sidebar { background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%); min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; }
        .sidebar .nav-link-custom { color: rgba(255, 255, 255, 0.85); background-color: rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 10px 16px; margin-bottom: 8px; font-weight: 500; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link-custom:hover { color: #ffc107; background-color: rgba(255, 193, 7, 0.15); }
        main { margin-left: 250px; }
        .btn-maroon { background-color: #1b263b; color: #fff; border: none; }
        .btn-maroon:hover { background-color: #0d1b2a; color: #fff; }
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
          <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container-fluid px-0">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden w-100">
                <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-person-bounding-box me-2 text-warning"></i>Tambah Wali Kelas</h5>
                        <a href="../dashboard.php?tab=menu8" class="btn btn-outline-light btn-sm rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>
                </div>
                <div class="card-body p-4 bg-white">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2"><?= $error; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Guru (Wali Kelas)</label>
                            <select name="guru_id" class="form-select" required>
                                <option value="">-- Pilih Guru --</option>
                                <?php
                                $q_g = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY nama ASC");
                                while ($g = mysqli_fetch_assoc($q_g)) {
                                    echo "<option value='{$g['id']}'>{$g['nama']} (NIP: {$g['nip']})</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tingkat Kelas</label>
                                <select name="tingkat_pilih" id="tingkatPilih" class="form-select" required onchange="filterKelasByTingkat()">
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="10">10 (X)</option>
                                    <option value="11">11 (XI)</option>
                                    <option value="12">12 (XII)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pilihan Kelas</label>
                                <select name="kelas_pilih" id="kelasPilih" class="form-select" required>
                                    <option value="">-- Pilih Tingkat Terlebih Dahulu --</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                <?php
                                $q_ta = mysqli_query($koneksi, "SELECT MIN(id) as id, nama FROM t_tahun_ajaran WHERE nama LIKE '%$tahun_sekarang%' OR nama LIKE '%" . ($tahun_sekarang - 1) . "%' GROUP BY nama ORDER BY nama DESC");
                                if (mysqli_num_rows($q_ta) == 0) {
                                    $q_ta = mysqli_query($koneksi, "SELECT MIN(id) as id, nama FROM t_tahun_ajaran GROUP BY nama ORDER BY nama DESC LIMIT 3");
                                }
                                while ($ta = mysqli_fetch_assoc($q_ta)) {
                                    $selected = ($ta['nama'] === $tahun_ajaran_otomatis) ? 'selected' : '';
                                    echo "<option value='{$ta['id']}' {$selected}>{$ta['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>

                        <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                            <a href="../dashboard.php?tab=menu8" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" name="simpan" class="btn btn-maroon px-4 fw-bold">Simpan Wali Kelas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </main>
    </div>
  </div>

  <!-- SCRIPT FILTER KELAS DINAMIS -->
  <script>
    const dataKelas = [
      <?php
      $q_all_kelas = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY nama ASC");
      while ($dk = mysqli_fetch_assoc($q_all_kelas)) {
          $raw_tingkat = trim($dk['tingkat']);
          $norm_tingkat = $raw_tingkat;
          if (strtoupper($raw_tingkat) == 'X' || $raw_tingkat == '10') $norm_tingkat = '10';
          if (strtoupper($raw_tingkat) == 'XI' || $raw_tingkat == '11') $norm_tingkat = '11';
          if (strtoupper($raw_tingkat) == 'XII' || $raw_tingkat == '12') $norm_tingkat = '12';
          
          echo "{ id: '{$dk['id']}', tingkat: '{$norm_tingkat}', nama: '" . addslashes($dk['nama']) . "' },\n";
      }
      ?>
    ];

    function filterKelasByTingkat(selectedKelas = '') {
      let tingkatVal = document.getElementById('tingkatPilih').value;
      let kelasSelect = document.getElementById('kelasPilih');
      
      kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';

      if (tingkatVal !== '') {
        let filtered = dataKelas.filter(k => k.tingkat === tingkatVal);
        if (filtered.length > 0) {
          filtered.forEach(k => {
            let opt = document.createElement('option');
            opt.value = k.nama;
            opt.textContent = k.nama;
            if (k.nama === selectedKelas) {
              opt.selected = true;
            }
            kelasSelect.appendChild(opt);
          });
        } else {
          let opt = document.createElement('option');
          opt.value = '';
          opt.textContent = '-- Tidak ada kelas untuk tingkat ini --';
          kelasSelect.appendChild(opt);
        }
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>