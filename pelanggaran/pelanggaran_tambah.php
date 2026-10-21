<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (file_exists('koneksi.php')) {
    include 'koneksi.php';
} elseif (file_exists('../koneksi.php')) {
    include '../koneksi.php';
} else {
    include '../../koneksi.php';
}

if (!isset($_SESSION['login'] ) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

$msg_error = "";

// PROSES SIMPAN KE TABEL TRANSAKSI YANG BENAR: t_pelanggaran_siswa
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

        // Tentukan nama kolom foreign key siswa & kategori di tabel t_pelanggaran_siswa
        $f_siswa = in_array('siswa_id', $kolom_trans) ? 'siswa_id' : 'id_siswa';
        $f_kat   = in_array('pelanggaran_kategori_id', $kolom_trans) ? 'pelanggaran_kategori_id' : (in_array('kategori_id', $kolom_trans) ? 'kategori_id' : 'id_kategori');
        $f_ket   = in_array('keterangan', $kolom_trans) ? 'keterangan' : 'deskripsi';

        // Susun query insert ke t_pelanggaran_siswa
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
                        alert('Berhasil! Data pelanggaran siswa tersimpan di t_pelanggaran_siswa.');
                        window.location.href = 'dashboard.php?tab=menu2';
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

<div class="row">
  <div class="col-12">
    
    <?php if (!empty($msg_error)): ?>
      <div class="alert alert-danger shadow-sm mb-3" role="alert">
        <i class="bi bi-exclamation-octagon-fill me-2"></i><?= $msg_error; ?>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
      <div class="card-header bg-white py-3 px-4 border-bottom">
        <h5 class="fw-bold mb-0 text-dark">
          <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran Siswa
        </h5>
      </div>

      <div class="card-body p-4 bg-white" style="max-height: 75vh; overflow-y: auto;">
        <form action="" method="POST">
          
          <!-- Pilih Siswa -->
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Pilih Siswa <span class="text-danger">*</span></label>
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

          <!-- Pilih Kategori & Poin -->
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Kategori Pelanggaran & Poin <span class="text-danger">*</span></label>
            <select name="kategori_id" class="form-select py-2" required>
              <option value="">-- Pilih Jenis Pelanggaran --</option>
              <?php
              // Ambil dari t_pelanggaran_kategori
              $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id ASC");
              if ($q_kat) {
                  while ($k = mysqli_fetch_assoc($q_kat)) {
                      $id_k   = $k['id'] ?? '';
                      $nama_k = $k['nama'] ?? ($k['nama_kategori'] ?? 'Pelanggaran');
                      $poin_k = $k['poin'] ?? 0;
                      
                      echo "<option value='{$id_k}'>" . htmlspecialchars($nama_k) . " (Poin: +" . htmlspecialchars($poin_k) . ")</option>";
                  }
              }
              ?>
            </select>
          </div>

          <!-- Tanggal Kejadian -->
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Tanggal Kejadian <span class="text-danger">*</span></label>
            <input type="date" name="tanggal" class="form-control py-2" value="<?= date('Y-m-d'); ?>" required>
          </div>

          <!-- Keterangan -->
          <div class="mb-4">
            <label class="form-label fw-semibold text-secondary small">Keterangan / Catatan Tambahan</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan rincian pelanggaran..."></textarea>
          </div>

          <!-- Tombol Simpan -->
          <div class="pt-3 border-top d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-light px-4 fw-semibold border">Reset</button>
            <button type="submit" name="btn_simpan_pelanggaran" class="btn px-4 fw-semibold py-2 text-white shadow-sm" style="background-color: #1b263b;">
              <i class="bi bi-save me-1"></i> Simpan Pelanggaran
            </button>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>