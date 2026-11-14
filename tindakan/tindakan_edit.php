<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../dashboard.php?tab=menu3");
    exit();
}

$role = $_SESSION['role'] ?? 'Admin';
$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
if (empty($id)) {
    echo "<script>alert('ID Data tidak valid!'); window.location.href='../dashboard.php?tab=menu3';</script>";
    exit();
}

// Ambil data pelanggaran siswa
$q_p = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa WHERE id = '$id' LIMIT 1");
$pelanggaran = mysqli_fetch_assoc($q_p);

if (!$pelanggaran) {
    echo "<script>alert('Data pelanggaran tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu3';</script>";
    exit();
}

// Ambil data tindakan jika sudah ada
$q_t = mysqli_query($koneksi, "SELECT * FROM t_tindakan WHERE pelanggaran_siswa_id = '$id' LIMIT 1");
$tindakan = mysqli_fetch_assoc($q_t);
$current_bentuk = $tindakan['bentuk_tindakan'] ?? '';
$current_status = $tindakan['status_penyelesaian'] ?? 'Diproses';

$error = "";

if (isset($_POST['update_tindakan'])) {
    $siswa_id            = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $kategori_id         = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
    $bentuk_tindakan     = mysqli_real_escape_string($koneksi, $_POST['bentuk_tindakan'] ?? '');
    $status_penyelesaian = mysqli_real_escape_string($koneksi, $_POST['status_penyelesaian'] ?? 'Diproses');
    $tanggal_tindakan    = date('Y-m-d');

    if (!empty($siswa_id) && !empty($kategori_id) && !empty($bentuk_tindakan)) {
        // Ambil nama siswa terbaru
        $q_s = mysqli_query($koneksi, "SELECT nama FROM t_siswa WHERE id = '$siswa_id' LIMIT 1");
        $d_s = mysqli_fetch_assoc($q_s);
        $nama_siswa_baru = $d_s['nama'] ?? 'Siswa';

        // Ambil nama pelanggaran & poin terbaru dari kategori
        $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$kategori_id' LIMIT 1");
        $d_kat = mysqli_fetch_assoc($q_kat);
        $nama_pelanggaran_baru = !empty($d_kat['nama']) ? $d_kat['nama'] : ($d_kat['nama_kategori'] ?? 'Pelanggaran');
        $poin_baru = (int)($d_kat['poin'] ?? 0);

        // Update ke t_pelanggaran_siswa
        mysqli_query($koneksi, "UPDATE t_pelanggaran_siswa 
                                SET siswa_id = '$siswa_id', 
                                    nama_siswa = '$nama_siswa_baru', 
                                    pelanggaran_kategori_id = '$kategori_id', 
                                    nama_pelanggaran = '$nama_pelanggaran_baru', 
                                    poin = '$poin_baru' 
                                WHERE id = '$id'");

        // Update atau Insert ke t_tindakan
        if ($tindakan) {
            $query = "UPDATE t_tindakan 
                      SET siswa_id = '$siswa_id', 
                          bentuk_tindakan = '$bentuk_tindakan', 
                          status_penyelesaian = '$status_penyelesaian', 
                          tanggal_tindakan = '$tanggal_tindakan' 
                      WHERE pelanggaran_siswa_id = '$id'";
        } else {
            $query = "INSERT INTO t_tindakan (siswa_id, pelanggaran_siswa_id, bentuk_tindakan, tanggal_tindakan, status_penyelesaian) 
                      VALUES ('$siswa_id', '$id', '$bentuk_tindakan', '$tanggal_tindakan', '$status_penyelesaian')";
        }

        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Data tindakan dan pelanggaran berhasil diperbarui!'); window.location.href='../dashboard.php?tab=menu3';</script>";
            exit();
        } else {
            $error = "Gagal menyimpan tindakan: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Pilih Siswa, Kategori Pelanggaran, dan Bentuk Tindakan wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Tindakan Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .sidebar { background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%); min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; overflow-y: auto; }
    .sidebar .nav-link-custom { color: rgba(255, 255, 255, 0.85); background-color: rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 10px 16px; margin-bottom: 8px; font-weight: 500; display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .sidebar .nav-link-custom:hover { color: #ffc107; background-color: rgba(255, 193, 7, 0.15); }
    main { margin-left: 250px; }
    @media (max-width: 768px) { main { margin-left: 0; } }
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
            <li class="nav-item"><a href="../dashboard.php?tab=menu2" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Catat Pelanggaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu3" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-check-circle fs-5"></i><span>Tindakan</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-person-badge fs-5"></i><span>Profil Guru</span></a></li>
          <?php else: ?>
            <li class="nav-item"><a href="../dashboard.php?tab=menu2" class="nav-link-custom"><i class="bi bi-person-workspace fs-5"></i><span>Data Guru</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu3" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-door-closed fs-5"></i><span>Data Kelas</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
            <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <?php endif; ?>

          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container-fluid py-2 px-0">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger shadow-sm mb-3"><?= $error; ?></div>
          <?php endif; ?>

          <form action="" method="POST">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-shield-check text-warning me-2"></i>Kelola Bentuk Tindakan / Sanksi</h5>
              </div>
              <div class="card-body p-4 bg-white">
                
                <div class="mb-3">
                  <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                  <select name="siswa_id" id="searchSiswa" class="form-select py-2" required>
                    <option value="">-- Ketik atau Pilih Nama Siswa --</option>
                    <?php
                    $q_siswa = mysqli_query($koneksi, "SELECT s.*, k.nama AS nama_kls 
                                                       FROM t_siswa s 
                                                       LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id 
                                                       LEFT JOIN t_kelas k ON ks.kelas_id = k.id 
                                                       ORDER BY s.nama ASC");
                    if ($q_siswa) {
                        while ($s = mysqli_fetch_assoc($q_siswa)) {
                            $selected = ($s['id'] == $pelanggaran['siswa_id']) ? 'selected' : '';
                            $nisn_str = !empty($s['nisn']) ? $s['nisn'] : '-';
                            $kelas_str = !empty($s['nama_kls']) ? $s['nama_kls'] : '-';
                            echo "<option value='{$s['id']}' {$selected}>" . htmlspecialchars($s['nama']) . " (NISN: {$nisn_str} - Kelas: {$kelas_str})</option>";
                        }
                    }
                    ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Jenis Pelanggaran <span class="text-danger">*</span></label>
                  <select name="kategori_id" id="pilihKategori" class="form-select py-2" required onchange="updatePoinInfo(this)">
                    <option value="">-- Pilih Jenis Pelanggaran --</option>
                    <?php
                    $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC");
                    if ($q_kat) {
                        while ($k = mysqli_fetch_assoc($q_kat)) {
                            $selected = ($k['id'] == $pelanggaran['pelanggaran_kategori_id']) ? 'selected' : '';
                            $nama_k = !empty($k['nama']) ? $k['nama'] : ($k['nama_kategori'] ?? 'Pelanggaran');
                            $poin_k = (int)($k['poin'] ?? 0);
                            echo "<option value='{$k['id']}' data-poin='{$poin_k}' {$selected}>" . htmlspecialchars($nama_k) . " (+{$poin_k} Poin)</option>";
                        }
                    }
                    ?>
                  </select>
                  <small class="text-muted mt-1 d-block">Poin otomatis: <span id="infoPoin" class="fw-bold text-danger"><?= htmlspecialchars($pelanggaran['poin'] ?? 0); ?> Poin</span></small>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Bentuk Tindakan / Sanksi <span class="text-danger">*</span></label>
                  <input type="text" name="bentuk_tindakan" class="form-control py-2" value="<?= htmlspecialchars($current_bentuk); ?>" placeholder="Contoh: Diberi surat peringatan / Dihukum membersihkan halaman..." required>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-bold">Status Penyelesaian</label>
                  <select name="status_penyelesaian" class="form-select py-2">
                    <option value="Diproses" <?= ($current_status == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                    <option value="Selesai" <?= ($current_status == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                  </select>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu3" class="btn btn-secondary px-4 fw-bold">Kembali</a>
                  <button type="submit" name="update_tindakan" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Tindakan</button>
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
            placeholder: '-- Ketik atau Pilih Nama Siswa --',
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