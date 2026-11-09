<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$id = $_GET['id'] ?? '';

if (empty($id)) {
    header("Location: ../dashboard.php?tab=menu4");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $id);
$q_data = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id = '$id'");
$data   = mysqli_fetch_assoc($q_data);

if (!$data) {
    echo "<script>alert('Data siswa tidak ditemukan!'); window.location.href='../dashboard.php?tab=menu4';</script>";
    exit();
}

$curr_tingkat = '';
if (!empty($data['kelas_id'])) {
    $q_kls_curr = mysqli_query($koneksi, "SELECT tingkat FROM t_kelas WHERE id = '{$data['kelas_id']}'");
    $d_kls_curr = mysqli_fetch_assoc($q_kls_curr);
    $curr_tingkat = $d_kls_curr['tingkat'] ?? '';
}

if (isset($_POST['update'])) {
    $nisn         = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nis          = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tingkat_pilih= mysqli_real_escape_string($koneksi, $_POST['tingkat_pilih'] ?? '');
    $kelas_pilih  = mysqli_real_escape_string($koneksi, $_POST['kelas_pilih'] ?? '');
    $jenis_kelamin= mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $status_aktif = mysqli_real_escape_string($koneksi, $_POST['status_aktif']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $q_cari_kelas = mysqli_query($koneksi, "SELECT id, nama, jurusan FROM t_kelas WHERE tingkat = '$tingkat_pilih' AND nama = '$kelas_pilih' LIMIT 1");
    
    if ($q_cari_kelas && mysqli_num_rows($q_cari_kelas) > 0) {
        $d_kelas = mysqli_fetch_assoc($q_cari_kelas);
        $kelas_id = $d_kelas['id'];
        $nama_kelas_sync = $d_kelas['nama'];
        $jurusan_sync = $d_kelas['jurusan'];

        $query = "UPDATE t_siswa SET 
                    nisn = '$nisn', 
                    nis = '$nis', 
                    nama = '$nama', 
                    kelas_id = '$kelas_id', 
                    kelas = '$nama_kelas_sync', 
                    jurusan = '$jurusan_sync', 
                    jenis_kelamin = '$jenis_kelamin', 
                    status_aktif = '$status_aktif', 
                    alamat = '$alamat' 
                  WHERE id = '$id'";

        if (mysqli_query($koneksi, $query)) {
            $tahun_sekarang = date('Y');
            $nama_ta_otomatis = $tahun_sekarang . '/' . ($tahun_sekarang + 1);
            $q_ta_auto = mysqli_query($koneksi, "SELECT id FROM t_tahun_ajaran WHERE nama = '$nama_ta_otomatis' LIMIT 1");
            $d_ta_auto = mysqli_fetch_assoc($q_ta_auto);
            $default_ta_id = $d_ta_auto['id'] ?? null;

            if ($default_ta_id) {
                $cek_ps = mysqli_query($koneksi, "SELECT id FROM t_kelas_siswa WHERE siswa_id = '$id' AND tahun_ajaran_id = '$default_ta_id'");
                if (mysqli_num_rows($cek_ps) > 0) {
                    mysqli_query($koneksi, "UPDATE t_kelas_siswa SET kelas_id = '$kelas_id' WHERE siswa_id = '$id' AND tahun_ajaran_id = '$default_ta_id'");
                } else {
                    $q_max_ps = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_kelas_siswa");
                    $r_max_ps = mysqli_fetch_assoc($q_max_ps);
                    $new_id_ps = ($r_max_ps['max_id'] ?? 0) + 1;
                    mysqli_query($koneksi, "INSERT INTO t_kelas_siswa (id, siswa_id, tahun_ajaran_id, kelas_id, status_aktif) VALUES ('$new_id_ps', '$id', '$default_ta_id', '$kelas_id', '1')");
                }
            }

            echo "<script>alert('Data siswa dan penempatan berhasil diperbarui!'); window.location.href='../dashboard.php?tab=menu4';</script>";
            exit();
        } else {
            $err = mysqli_error($koneksi);
            echo "<script>alert('Gagal mengedit data siswa: " . addslashes($err) . "');</script>";
        }
    } else {
        echo "<script>alert('Data kelas tidak ditemukan untuk kombinasi tersebut!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Siswa - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .sidebar { background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%); min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; overflow-y: auto; }
    .sidebar .nav-link-custom { color: rgba(255, 255, 255, 0.85); background-color: rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 10px 16px; margin-bottom: 8px; font-weight: 500; display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .sidebar .nav-link-custom:hover { color: #ffc107; background-color: rgba(255, 193, 7, 0.15); }
    main { margin-left: 250px; }
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
          <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container-fluid py-2 px-0">
          <form action="" method="POST">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden w-100">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Siswa</h5>
              </div>
              <div class="card-body p-4 bg-white">
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">NISN (Maks. 10 Digit)</label>
                    <input type="text" name="nisn" class="form-control" maxlength="10" value="<?= htmlspecialchars($data['nisn'] ?? ''); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">NIS (Maks. 10 Digit)</label>
                    <input type="text" name="nis" class="form-control" maxlength="10" value="<?= htmlspecialchars($data['nis'] ?? ''); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama'] ?? ''); ?>" required>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Tingkat Kelas</label>
                    <select name="tingkat_pilih" id="tingkatPilih" class="form-select" required>
                      <option value="">-- Pilih Tingkat --</option>
                      <option value="X" <?= ($curr_tingkat == 'X') ? 'selected' : ''; ?>>X</option>
                      <option value="XI" <?= ($curr_tingkat == 'XI') ? 'selected' : ''; ?>>XI</option>
                      <option value="XII" <?= ($curr_tingkat == 'XII') ? 'selected' : ''; ?>>XII</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Pilihan Kelas</label>
                    <select name="kelas_pilih" id="kelasPilih" class="form-select" required>
                      <option value="">-- Pilih Nama Kelas --</option>
                    </select>
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                      <option value="L" <?= (($data['jenis_kelamin'] ?? '') == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                      <option value="P" <?= (($data['jenis_kelamin'] ?? '') == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Status Aktif</label>
                    <select name="status_aktif" class="form-select" required>
                      <option value="1" <?= (($data['status_aktif'] ?? '') == '1') ? 'selected' : ''; ?>>Aktif</option>
                      <option value="0" <?= (($data['status_aktif'] ?? '') == '0') ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Alamat</label>
                  <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu4" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="update" class="btn px-4 fw-bold text-white" style="background-color: #1b263b;">
                    Simpan Perubahan
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <script>
    const dataKelas = [
      <?php
      $q_all = mysqli_query($koneksi, "SELECT tingkat, nama FROM t_kelas ORDER BY nama ASC");
      while ($row = mysqli_fetch_assoc($q_all)) {
          echo "{tingkat: '" . trim($row['tingkat']) . "', nama: '" . trim($row['nama']) . "'},";
      }
      ?>
    ];

    const tingkatSelect = document.getElementById('tingkatPilih');
    const kelasSelect = document.getElementById('kelasPilih');
    const selectedKelasValue = "<?= $data['kelas'] ?? ''; ?>";

    function filterKelas(tingkatDipilih, selectedVal = '') {
      kelasSelect.innerHTML = '<option value="">-- Pilih Nama Kelas --</option>';
      if (tingkatDipilih) {
        const filtered = dataKelas.filter(item => item.tingkat.toUpperCase() === tingkatDipilih.toUpperCase());
        filtered.forEach(item => {
          const opt = document.createElement('option');
          opt.value = item.nama;
          opt.textContent = item.nama;
          if (item.nama === selectedVal) {
            opt.selected = true;
          }
          kelasSelect.appendChild(opt);
        });
      }
    }

    tingkatSelect.addEventListener('change', function() {
      filterKelas(this.value);
    });

    window.addEventListener('DOMContentLoaded', (event) => {
      const initialTingkat = tingkatSelect.value;
      if (initialTingkat) {
        filterKelas(initialTingkat, selectedKelasValue);
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>