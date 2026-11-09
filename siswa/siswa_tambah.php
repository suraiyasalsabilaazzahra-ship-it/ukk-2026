<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$error = "";

$tahun_sekarang = date('Y');
$nama_ta_otomatis = $tahun_sekarang . '/' . ($tahun_sekarang + 1);
$q_ta_auto = mysqli_query($koneksi, "SELECT id FROM t_tahun_ajaran WHERE nama = '$nama_ta_otomatis' LIMIT 1");
$d_ta_auto = mysqli_fetch_assoc($q_ta_auto);
$default_ta_id = $d_ta_auto['id'] ?? null;

if (isset($_POST['simpan'])) {
    $nisn         = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nis          = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tingkat_pilih= mysqli_real_escape_string($koneksi, $_POST['tingkat_pilih'] ?? '');
    $kelas_pilih  = mysqli_real_escape_string($koneksi, $_POST['kelas_pilih'] ?? '');
    $jenis_kelamin= mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $status_aktif = mysqli_real_escape_string($koneksi, $_POST['status_aktif']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    if (strlen($nisn) > 10) {
        echo "<script>alert('Gagal: NISN tidak boleh lebih dari 10 digit!'); window.history.back();</script>";
        exit();
    }

    if (!empty($nisn) && !empty($nama) && !empty($tingkat_pilih) && !empty($kelas_pilih)) {
        $q_cari_kelas = mysqli_query($koneksi, "SELECT id, nama, jurusan FROM t_kelas WHERE tingkat = '$tingkat_pilih' AND nama = '$kelas_pilih' LIMIT 1");
        
        if ($q_cari_kelas && mysqli_num_rows($q_cari_kelas) > 0) {
            $d_kelas = mysqli_fetch_assoc($q_cari_kelas);
            $kelas_id = $d_kelas['id'];
            $nama_kelas_sync = $d_kelas['nama'];
            $jurusan_sync = $d_kelas['jurusan'];

            $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_siswa");
            $r_max = mysqli_fetch_assoc($q_max);
            $new_id = ($r_max['max_id'] ?? 0) + 1;

            $query = "INSERT INTO t_siswa (id, nisn, nis, nama, kelas_id, kelas, jurusan, jenis_kelamin, status_aktif, alamat) 
                      VALUES ('$new_id', '$nisn', '$nis', '$nama', '$kelas_id', '$nama_kelas_sync', '$jurusan_sync', '$jenis_kelamin', '$status_aktif', '$alamat')";
                      
            if (mysqli_query($koneksi, $query)) {
                if ($default_ta_id) {
                    $q_max_ps = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_kelas_siswa");
                    $r_max_ps = mysqli_fetch_assoc($q_max_ps);
                    $new_id_ps = ($r_max_ps['max_id'] ?? 0) + 1;

                    mysqli_query($koneksi, "INSERT INTO t_kelas_siswa (id, siswa_id, tahun_ajaran_id, kelas_id, status_aktif) 
                                            VALUES ('$new_id_ps', '$new_id', '$default_ta_id', '$kelas_id', '$status_aktif')");
                }

                echo "<script>
                        alert('Berhasil! Data siswa dan penempatan kelas telah tersimpan otomatis.');
                        window.location.href = '../dashboard.php?tab=menu4';
                      </script>";
                exit();
            } else {
                $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
            }
        } else {
            $error = "Data kelas tidak ditemukan untuk kombinasi Tingkat dan Nama Kelas tersebut!";
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
  <title>Tambah Data Siswa - UKK 2026</title>
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
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger mb-3"><?= $error; ?></div>
          <?php endif; ?>
          
          <form action="" method="POST">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden w-100">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill me-2 text-warning"></i>Tambah Data Siswa Baru</h5>
              </div>
              <div class="card-body p-4 bg-white">
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">NISN (Maks. 10 Digit)</label>
                    <input type="text" name="nisn" class="form-control" maxlength="10" placeholder="Contoh: 0051234050" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">NIS (Maks. 10 Digit)</label>
                    <input type="text" name="nis" class="form-control" maxlength="10" placeholder="Contoh: 12345" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap siswa" required>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Tingkat Kelas</label>
                    <select name="tingkat_pilih" id="tingkatPilih" class="form-select" required>
                      <option value="">-- Pilih Tingkat --</option>
                      <option value="X">X</option>
                      <option value="XI">XI</option>
                      <option value="XII">XII</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Pilihan Kelas</label>
                    <select name="kelas_pilih" id="kelasPilih" class="form-select" required>
                      <option value="">-- Pilih Tingkat Terlebih Dahulu --</option>
                    </select>
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                      <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Status Aktif</label>
                    <select name="status_aktif" class="form-select" required>
                      <option value="1" selected>Aktif</option>
                      <option value="0">Tidak Aktif</option>
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Alamat</label>
                  <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat siswa"></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu4" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="simpan" class="btn px-4 fw-bold text-white" style="background-color: #1b263b;">
                    Simpan Data Siswa
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

    tingkatSelect.addEventListener('change', function() {
      const selectedTingkat = this.value;
      kelasSelect.innerHTML = '<option value="">-- Pilih Nama Kelas --</option>';

      if (selectedTingkat) {
        const filtered = dataKelas.filter(item => item.tingkat.toUpperCase() === selectedTingkat.toUpperCase());
        filtered.forEach(item => {
          const opt = document.createElement('option');
          opt.value = item.nama;
          opt.textContent = item.nama;
          kelasSelect.appendChild(opt);
        });
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>