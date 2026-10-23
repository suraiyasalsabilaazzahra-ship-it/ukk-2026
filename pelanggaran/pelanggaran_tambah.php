<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'] ?? 'Admin';
$msg_error = "";

// PROSES SIMPAN KE TABEL TRANSAKSI: t_pelanggaran_siswa
if (isset($_POST['btn_simpan_pelanggaran'])) {
    $siswa_id    = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $kategori_id = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
    $tanggal     = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
    $keterangan  = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');
    $user_id     = $_SESSION['user_id'] ?? 1; 

    if (!empty($siswa_id) && !empty($kategori_id) && !empty($tanggal)) {
        // Ambil ID maksimum dari t_pelanggaran_siswa
        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_pelanggaran_siswa");
        $r_max = ($q_max) ? mysqli_fetch_assoc($q_max) : ['max_id' => 0];
        $next_id = ($r_max['max_id'] ?? 0) + 1;

        // Cek kolom yang ada di t_pelanggaran_siswa secara dinamis
        $q_cek = mysqli_query($koneksi, "SHOW COLUMNS FROM t_pelanggaran_siswa");
        $kolom_trans = [];
        while ($row = mysqli_fetch_assoc($q_cek)) {
            $kolom_trans[] = strtolower($row['Field']);
        }

        $f_siswa = in_array('siswa_id', $kolom_trans) ? 'siswa_id' : 'id_siswa';
        $f_kat   = in_array('pelanggaran_kategori_id', $kolom_trans) ? 'pelanggaran_kategori_id' : (in_array('kategori_id', $kolom_trans) ? 'kategori_id' : 'id_kategori');
        $f_ket   = in_array('keterangan', $kolom_trans) ? 'keterangan' : 'deskripsi';

        $cols = ['id', $f_siswa, $f_kat, 'tanggal', $f_ket];
        $vals = ["'$next_id'", "'$siswa_id'", "'$kategori_id'", "'$tanggal'", "'$keterangan'"];

        if (in_array('user_id', $kolom_trans)) {
            $cols[] = 'user_id';
            $vals[] = "'$user_id'";
        }

        $query_insert = "INSERT INTO t_pelanggaran_siswa (" . implode(", ", $cols) . ") VALUES (" . implode(", ", $vals) . ")";
        
        try {
            $exec = mysqli_query($koneksi, $query_insert);
            if ($exec) {
                echo "<script>
                        alert('Berhasil! Data pelanggaran siswa telah dicatat.');
                        window.location.href = '../dashboard.php?tab=menu9';
                      </script>";
                exit();
            } else {
                $msg_error = "Gagal Simpan: " . mysqli_error($koneksi);
            }
        } catch (\Throwable $th) {
            $msg_error = "Error DB: " . $th->getMessage();
        }

    } else {
        $msg_error = "Mohon lengkapi Siswa, Kategori Pelanggaran, dan Tanggal!";
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
          <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container py-4" style="max-width: 750px;">
          
          <?php if (!empty($msg_error)): ?>
            <div class="alert alert-danger shadow-sm mb-3" role="alert">
              <i class="bi bi-exclamation-octagon-fill me-2"></i><?= $msg_error; ?>
            </div>
          <?php endif; ?>

          <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran Siswa</h5>
                <a href="../dashboard.php?tab=menu9" class="btn btn-outline-light btn-sm rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
              </div>
            </div>

            <div class="card-body p-4 bg-white">
              <form action="" method="POST">
                
                <!-- Pilih Siswa -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                  <select name="siswa_id" class="form-select py-2" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php
                    $q_siswa = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY nama ASC");
                    if ($q_siswa) {
                        while ($s = mysqli_fetch_assoc($q_siswa)) {
                            $id_s   = $s['id'] ?? ($s['id_siswa'] ?? '');
                            $nama_s = $s['nama'] ?? '';
                            $nisn_s = $s['nisn'] ?? '';
                            echo "<option value='{$id_s}'>" . htmlspecialchars($nama_s) . " (NISN: " . htmlspecialchars($nisn_s) . ")</option>";
                        }
                    }
                    ?>
                  </select>
                </div>

                <!-- Pilih Kategori Sesuai Pengaturan Sistem Poin Otomatis -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Kategori Pelanggaran & Poin <span class="text-danger">*</span></label>
                  <select name="kategori_id" class="form-select py-2" required>
                    <option value="">-- Pilih Jenis Pelanggaran --</option>
                    <?php
                    $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC");
                    if ($q_kat) {
                        while ($k = mysqli_fetch_assoc($q_kat)) {
                            $id_k   = $k['id'] ?? '';
                            $nama_k = $k['nama_kategori'] ?? ($k['nama'] ?? 'Kategori');
                            $poin_k = (int)($k['poin'] ?? 0);
                            
                            // Tentukan jenis secara otomatis berdasarkan poin (sama seperti di tab kategori)
                            if ($poin_k >= 1 && $poin_k <= 15) {
                              $jenis_k = "Ringan";
                            } elseif ($poin_k >= 20 && $poin_k <= 50) {
                              $jenis_k = "Sedang";
                            } else {
                              $jenis_k = "Berat";
                            }
                            
                            echo "<option value='{$id_k}'>" . htmlspecialchars($nama_k) . " | Poin: +" . $poin_k . " (" . $jenis_k . ")</option>";
                        }
                    }
                    ?>
                  </select>
                </div>

                <!-- Tanggal Kejadian -->
                <div class="mb-3">
                  <label class="form-label fw-bold">Tanggal Kejadian <span class="text-danger">*</span></label>
                  <input type="date" name="tanggal" class="form-control py-2" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                  <label class="form-label fw-bold">Keterangan / Catatan Tambahan</label>
                  <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan rincian pelanggaran..."></textarea>
                </div>

                <!-- Tombol Simpan -->
                <div class="pt-3 border-top d-flex justify-content-end gap-2">
                  <button type="reset" class="btn btn-secondary px-4 fw-bold">Reset</button>
                  <button type="submit" name="btn_simpan_pelanggaran" class="btn btn-maroon px-4 fw-bold py-2 shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan Pelanggaran
                  </button>
                </div>

              </form>
            </div>
          </div>

        </div>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>