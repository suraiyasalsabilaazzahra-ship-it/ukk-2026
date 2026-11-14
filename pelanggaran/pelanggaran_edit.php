<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../dashboard.php?tab=menu9");
    exit();
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
if (empty($id)) {
    echo "<script>alert('ID Pelanggaran tidak valid!'); window.location.href='../dashboard.php?tab=menu9';</script>";
    exit();
}

$q_current = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa WHERE id = '$id'");
$current = mysqli_fetch_assoc($q_current);

if (!$current) {
    echo "<script>alert('Data pelanggaran tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu9';</script>";
    exit();
}

$error = "";

if (isset($_POST['update'])) {
    $siswa_id        = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $kategori_id     = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
    $tanggal         = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? '');
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

        $q_get_poin = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$kategori_id' LIMIT 1");
        $d_k = mysqli_fetch_assoc($q_get_poin);
        $nama_pelanggaran = !empty($d_k['nama']) ? $d_k['nama'] : 'Pelanggaran';
        $poin_val = (int)($d_k['poin'] ?? 0);

        $query = "UPDATE t_pelanggaran_siswa 
                  SET siswa_id = '$siswa_id', 
                      nama_siswa = '$nama_siswa',
                      kelas_id = '$kelas_id',
                      nama_kelas = '$kelas_siswa',
                      pelanggaran_kategori_id = '$kategori_id', 
                      nama_pelanggaran = '$nama_pelanggaran',
                      poin = '$poin_val', 
                      tanggal = '$tanggal', 
                      keterangan = '$keterangan' 
                  WHERE id = '$id'";
                  
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                    alert('Data pelanggaran berhasil diperbarui!');
                    window.location.href = '../dashboard.php?tab=menu9';
                  </script>";
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Kolom Siswa, Kategori Pelanggaran, dan Tanggal wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pelanggaran Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .sidebar { background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%); min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; }
    .sidebar .nav-link-custom { color: rgba(255, 255, 255, 0.85); background-color: rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 10px 16px; margin-bottom: 8px; font-weight: 500; display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .sidebar .nav-link-custom:hover { color: #ffc107; background-color: rgba(255, 193, 7, 0.15); }
    main { 
      margin-left: 250px; 
      width: calc(100% - 250px);
      padding: 30px;
      padding-bottom: 100px; 
    }
    @media (max-width: 768px) { 
      main { margin-left: 0; width: 100%; padding: 15px; } 
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- SIDEBAR -->
      <div class="col-md-3 col-lg-2 sidebar p-3 text-white d-none d-md-block">
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
          <li class="nav-item"><a href="../dashboard.php?tab=menu2" class="nav-link-custom"><i class="bi bi-person-workspace fs-5"></i><span>Data Guru</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu3" class="nav-link-custom"><i class="bi bi-door-closed fs-5"></i><span>Data Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-12 col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container-fluid px-0">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 mb-3"><?= $error; ?></div>
          <?php endif; ?>

          <form action="" method="POST">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Edit Catatan Pelanggaran</h5>
              </div>
              <div class="card-body p-4 bg-white">
                
                <div class="mb-3">
                  <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                  <select name="siswa_id" class="form-select py-2" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php
                    $q_s = mysqli_query($koneksi, "SELECT s.*, k.nama AS nama_kls 
                                                   FROM t_siswa s 
                                                   LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id 
                                                   LEFT JOIN t_kelas k ON ks.kelas_id = k.id 
                                                   ORDER BY s.nama ASC");
                    while ($s = mysqli_fetch_assoc($q_s)) {
                        $selected = ($s['id'] == $current['siswa_id']) ? 'selected' : '';
                        $nisn_str = !empty($s['nisn']) ? $s['nisn'] : '-';
                        $kelas_str = !empty($s['nama_kls']) ? $s['nama_kls'] : '-';
                        echo "<option value='{$s['id']}' {$selected}>" . htmlspecialchars($s['nama']) . " (NISN: {$nisn_str} - Kelas: {$kelas_str})</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Kategori Pelanggaran (Poin Otomatis) <span class="text-danger">*</span></label>
                  <select name="kategori_id" id="pilihKategori" class="form-select py-2" required onchange="updatePoinInfo(this)">
                    <option value="">-- Pilih Pelanggaran --</option>
                    <?php
                    $q_p = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC");
                    while ($p = mysqli_fetch_assoc($q_p)) {
                        $p_id = $p['id'];
                        $nm_p = !empty($p['nama']) ? $p['nama'] : ($p['nama_kategori'] ?? 'Pelanggaran');
                        $poin_p = $p['poin'] ?? 0;
                        $selected = ($p_id == $current['pelanggaran_kategori_id']) ? 'selected' : '';
                        echo "<option value='{$p_id}' data-poin='{$poin_p}' {$selected}>{$nm_p} (+{$poin_p} Poin)</option>";
                    }
                    ?>
                  </select>
                  <small class="text-muted mt-1 d-block">Poin otomatis: <span id="infoPoin" class="fw-bold text-danger"><?= htmlspecialchars($current['poin'] ?? 0); ?> Poin</span></small>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Tanggal Kejadian <span class="text-danger">*</span></label>
                  <input type="date" name="tanggal" class="form-control py-2" value="<?= htmlspecialchars($current['tanggal']); ?>" required>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-bold">Keterangan / Catatan Tambahan</label>
                  <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan rincian tambahan jika ada..."><?= htmlspecialchars($current['keterangan'] ?? ''); ?></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu9" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="update" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Perbarui Pelanggaran</button>
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