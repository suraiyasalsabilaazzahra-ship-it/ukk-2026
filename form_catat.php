<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// Proses simpan data ke database
if (isset($_POST['simpan_langsung'])) {
    $siswa_id    = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $kategori_id = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
    $tanggal     = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
    $keterangan  = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');
    $user_id     = $_SESSION['user_id'] ?? 1; 

    if (!empty($siswa_id) && !empty($kategori_id)) {
        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_pelanggaran");
        $r_max = mysqli_fetch_assoc($q_max);
        $new_id = ($r_max['max_id'] ?? 0) + 1;

        $query = "INSERT INTO t_pelanggaran (id, siswa_id, kategori_id, tanggal, keterangan, user_id) 
                  VALUES ('$new_id', '$siswa_id', '$kategori_id', '$tanggal', '$keterangan', '$user_id')";
                  
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Berhasil! Catatan pelanggaran tersimpan.'); window.location.href='dashboard.php?tab=menu2';</script>";
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($koneksi) . "</div>";
        }
    }
}
?>

<div class="card shadow-sm border-0 rounded-4 mb-5 p-4 bg-white">
  <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran Siswa</h4>
  
  <form action="" method="POST">
    <!-- Pilihan Siswa -->
    <div class="mb-3">
      <label class="form-label fw-bold small">Pilih Siswa</label>
      <select name="siswa_id" class="form-select" required>
        <option value="">-- Pilih Siswa --</option>
        <?php
        $q_s = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY nama ASC");
        while ($s = mysqli_fetch_assoc($q_s)) {
            echo "<option value='{$s['id']}'>{$s['nama']}</option>";
        }
        ?>
      </select>
    </div>

    <!-- Pilihan Kategori -->
    <div class="mb-3">
      <label class="form-label fw-bold small">Kategori Pelanggaran</label>
      <select name="kategori_id" class="form-select" required>
        <option value="">-- Pilih Kategori --</option>
        <?php
        $q_k = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY nama_kategori ASC");
        while ($k = mysqli_fetch_assoc($q_k)) {
            echo "<option value='{$k['id']}'>{$k['nama_kategori']} (Poin: {$k['poin']})</option>";
        }
        ?>
      </select>
    </div>

    <!-- Tanggal -->
    <div class="mb-3">
      <label class="form-label fw-bold small">Tanggal Kejadian</label>
      <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
    </div>

    <!-- Keterangan -->
    <div class="mb-4">
      <label class="form-label fw-bold small">Keterangan / Catatan Khusus</label>
      <textarea name="keterangan" class="form-control" rows="3" placeholder="Tuliskan keterangan pelanggaran..."></textarea>
    </div>

    <!-- TOMBOL SIMPAN YANG LENGKAP -->
    <div class="pt-3 border-top d-flex justify-content-end gap-2">
      <button type="reset" class="btn btn-light px-4 fw-bold">Reset</button>
      <button type="submit" name="simpan_langsung" class="btn text-white px-4 fw-bold py-2 shadow-sm" style="background-color: #1b263b;">
        <i class="bi bi-save me-1"></i> Simpan Pelanggaran
      </button>
    </div>

  </form>
</div>