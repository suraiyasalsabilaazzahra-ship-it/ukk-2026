<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];

if (isset($_POST['simpan'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $poin          = (int)$_POST['poin'];
    $deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_pelanggaran_kategori");
    $r_max = mysqli_fetch_assoc($q_max);
    $new_id = ($r_max['max_id'] ?? 0) + 1;

    $query = "INSERT INTO t_pelanggaran_kategori (id, nama, poin, deskripsi) 
              VALUES ('$new_id', '$nama_kategori', '$poin', '$deskripsi')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berhasil! Kategori pelanggaran baru telah ditambahkan.'); window.location.href='../dashboard.php?tab=menu7';</script>";
        exit();
    } else {
        $err = mysqli_error($koneksi);
        echo "<script>alert('Gagal menambah kategori: " . addslashes($err) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kategori Pelanggaran - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; color: #333; }
    .sidebar { background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%); min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; }
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
          <li class="nav-item"><a href="../dashboard.php?tab=menu4" class="nav-link-custom"><i class="bi bi-people fs-5"></i><span>Data Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu5" class="nav-link-custom"><i class="bi bi-calendar-event fs-5"></i><span>Tahun Ajaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu6" class="nav-link-custom"><i class="bi bi-diagram-3 fs-5"></i><span>Penempatan Siswa</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu7" class="nav-link-custom" style="background-color: #ffc107; color: #0d1b2a; font-weight: 700;"><i class="bi bi-tags fs-5"></i><span>Kategori Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu8" class="nav-link-custom"><i class="bi bi-person-bounding-box fs-5"></i><span>Data Wali Kelas</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu9" class="nav-link-custom"><i class="bi bi-exclamation-triangle fs-5"></i><span>Pencatatan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu10" class="nav-link-custom"><i class="bi bi-file-earmark-text fs-5"></i><span>Laporan Pelanggaran</span></a></li>
          <li class="nav-item"><a href="../dashboard.php?tab=menu_about" class="nav-link-custom"><i class="bi bi-person-circle fs-5"></i><span>About Me</span></a></li>
          <li class="nav-item mt-4"><a href="../logout.php" class="nav-link-custom text-warning fw-bold bg-transparent border border-warning"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
        </ul>
      </div>

      <!-- KONTEN UTAMA (Rata Kiri Penuh) -->
      <main class="col-md-9 col-lg-10 p-4 ms-auto">
        <div class="container-fluid px-0">
          <form action="" method="POST">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden w-100">
              <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-tags-fill me-2 text-warning"></i>Tambah Kategori Pelanggaran Baru</h5>
              </div>
              <div class="card-body p-4 bg-white">
                
                <!-- PILIHAN CEPAT (PRESET PELANGGARAN) -->
                <div class="mb-3 p-3 bg-light rounded-3 border">
                  <label class="form-label fw-bold text-dark small mb-2"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Pilih Cepat Pelanggaran Umum (Opsional):</label>
                  <select id="pilihPreset" class="form-select form-select-sm" onchange="isiOtomatis(this)">
                    <option value="">-- Atau pilih dari daftar standar sekolah --</option>
                    <optgroup label="Ringan (Poin 5 - 15)">
                      <option value="Terlambat datang ke sekolah|5">Terlambat datang ke sekolah (Poin: 5)</option>
                      <option value="Atribut seragam tidak lengkap / tidak sesuai|10">Atribut seragam tidak lengkap / tidak sesuai (Poin: 10)</option>
                      <option value="Tidak memakai atribut upacara|10">Tidak memakai atribut upacara (Poin: 10)</option>
                      <option value="Rambut / Kuku tidak rapi|10">Rambut / Kuku tidak rapi (Poin: 10)</option>
                      <option value="Masuk kelas/ruangan tanpa izin guru|15">Masuk kelas/ruangan tanpa izin guru (Poin: 15)</option>
                    </optgroup>
                    <optgroup label="Sedang (Poin 20 - 50)">
                      <option value="Membolos / keluar sekolah saat jam pelajaran|25">Membolos / keluar sekolah saat jam pelajaran (Poin: 25)</option>
                      <option value="Tidak mengikuti kegiatan upacara sekolah wajib|20">Tidak mengikuti kegiatan upacara sekolah wajib (Poin: 20)</option>
                      <option value="Membuang sampah sembarangan / merusak fasilitas ringan|30">Membuang sampah sembarangan / merusak fasilitas ringan (Poin: 30)</option>
                      <option value="Membuat keributan saat KBM berlangsung|25">Membuat keributan saat KBM berlangsung (Poin: 25)</option>
                      <option value="Membawa atau menggunakan gawai/HP saat jam pelajaran|35">Membawa atau menggunakan gawai/HP saat jam pelajaran (Poin: 35)</option>
                    </optgroup>
                    <optgroup label="Berat (Poin 55 - 100)">
                      <option value="Merokok atau membawa vape di lingkungan sekolah|60">Merokok atau membawa vape di lingkungan sekolah (Poin: 60)</option>
                      <option value="Berkelahi / melakukan tindakan kekerasan / perundungan|80">Berkelahi / melakukan tindakan kekerasan / perundungan (Poin: 80)</option>
                      <option value="Mencuri barang milik teman, guru, atau sekolah|85">Mencuri barang milik teman, guru, atau sekolah (Poin: 85)</option>
                      <option value="Membawa senjata tajam atau barang terlarang|100">Membawa senjata tajam atau barang terlarang (Poin: 100)</option>
                      <option value="Memalsukan tanda tangan orang tua/wali atau guru|55">Memalsukan tanda tangan orang tua/wali atau guru (Poin: 55)</option>
                    </optgroup>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Nama Kategori Pelanggaran</label>
                  <input type="text" name="nama_kategori" id="inputNama" class="form-control" placeholder="Contoh: Terlambat Hadir / Membolos" required>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Jumlah Poin</label>
                  <input type="number" name="poin" id="inputPoin" class="form-control" placeholder="Contoh: 10" required oninput="cekJenisPoin(this.value)">
                  <small class="text-muted">Tip: 1-15 (Ringan), 20-50 (Sedang), 55-100 (Berat). | Deteksi Otomatis Jenis: <span id="badgeJenis" class="badge bg-secondary">Masukkan Poin</span></small>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-bold">Deskripsi / Keterangan</label>
                  <textarea name="deskripsi" class="form-control" rows="2" placeholder="Keterangan opsional..."></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                  <a href="../dashboard.php?tab=menu7" class="btn btn-secondary px-4 fw-bold">Batal</a>
                  <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Kategori</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <!-- SCRIPT JAVASCRIPT UNTUK OTOMATISASI -->
  <script>
    function isiOtomatis(selectElem) {
      let val = selectElem.value;
      if (val !== "") {
        let parts = val.split("|");
        let namaPelanggaran = parts[0];
        let poinPelanggaran = parts[1];

        document.getElementById('inputNama').value = namaPelanggaran;
        document.getElementById('inputPoin').value = poinPelanggaran;
        cekJenisPoin(poinPelanggaran);
      }
    }

    function cekJenisPoin(val) {
      let poin = parseInt(val);
      let badge = document.getElementById('badgeJenis');
      if (isNaN(poin)) {
        badge.className = "badge bg-secondary";
        badge.innerText = "Masukkan Poin";
      } else if (poin >= 1 && poin <= 15) {
        badge.className = "badge bg-info text-dark";
        badge.innerText = "Ringan (Otomatis)";
      } else if (poin >= 20 && poin <= 50) {
        badge.className = "badge bg-warning text-dark";
        badge.innerText = "Sedang (Otomatis)";
      } else {
        badge.className = "badge bg-danger";
        badge.innerText = "Berat (Otomatis)";
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>