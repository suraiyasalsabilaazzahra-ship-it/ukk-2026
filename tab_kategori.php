<?php
// Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari_kategori']) ? mysqli_real_escape_string($koneksi, $_GET['cari_kategori']) : '';

// Query dengan filter pencarian yang aman (berdasarkan nama dan deskripsi)
if (!empty($cari)) {
    $query_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE nama LIKE '%$cari%' OR deskripsi LIKE '%$cari%' ORDER BY id DESC");
} else {
    $query_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold text-dark mb-0"><i class="bi bi-tags text-warning me-2"></i>Kategori Pelanggaran</h4>
  <a href="kategori_tambah.php" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
    <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
  </a>
</div>

<!-- KOTAK PENCARIAN -->
<div class="card border-0 shadow-sm mb-4 rounded-3">
  <div class="card-body p-3">
    <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
      <!-- Wajib menyertakan parameter tab agar tetap berada di menu Kategori Pelanggaran -->
      <input type="hidden" name="tab" value="menu7"> 
      <div class="col-md-10">
        <div class="input-group">
          <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
          <input type="text" name="cari_kategori" class="form-control border-start-0 ps-0" placeholder="Cari nama kategori atau deskripsi..." value="<?= htmlspecialchars($cari); ?>">
        </div>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn w-100 fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">Cari</button>
        <?php if (!empty($cari)): ?>
          <a href="dashboard.php?tab=menu7" class="btn btn-outline-warning text-dark" title="Reset Pencarian"><i class="bi bi-arrow-counterclockwise"></i></a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<!-- TABEL DATA -->
<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead style="background-color: #1b263b; color: white;">
        <tr>
          <th class="py-3 px-3" style="width: 5%;">NO</th>
          <th class="py-3">NAMA KATEGORI PELANGGARAN</th>
          <th class="py-3">DESKRIPSI</th>
          <th class="py-3 text-center" style="width: 15%;">JENIS</th>
          <th class="py-3 text-center" style="width: 12%;">STATUS</th>
          <th class="py-3 text-center" style="width: 15%;">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        if ($query_kat && mysqli_num_rows($query_kat) > 0) {
            $no = 1; // Nomor urut berurutan 1, 2, 3...
            while ($row = mysqli_fetch_assoc($query_kat)) {
                // Tentukan warna badge dengan aksen kuning/biru
                $jenis = $row['jenis'] ?? 'Sedang';
                $badge_bg = 'bg-warning text-dark';
                if (stripos($jenis, 'Ringan') !== false) {
                    $badge_bg = 'bg-info bg-opacity-10 text-info';
                } elseif (stripos($jenis, 'Tinggi') !== false || stripos($jenis, 'Berat') !== false) {
                    $badge_bg = 'bg-danger bg-opacity-10 text-danger';
                } else {
                    $badge_bg = 'bg-warning bg-opacity-10 text-warning text-dark';
                }
        ?>
        <tr>
          <td class="fw-bold px-3 text-muted"><?= $no++; ?></td>
          <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama'] ?? $row['nama_kategori']); ?></td>
          <td class="text-muted small"><?= htmlspecialchars($row['deskripsi']); ?></td>
          <td class="text-center">
            <span class="badge <?= $badge_bg; ?> px-3 py-2"><?= htmlspecialchars($jenis); ?></span>
          </td>
          <td class="text-center">
            <?php if (($row['status_aktif'] ?? 1) == 1): ?>
              <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Aktif</span>
            <?php else: ?>
              <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Tidak Aktif</span>
            <?php endif; ?>
          </td>
          <td class="text-center">
            <a href="kategori_edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning text-white px-2 py-1 me-1"><i class="bi bi-pencil-square"></i></a>
            <a href="kategori_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger px-2 py-1" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Tidak ada data kategori ditemukan.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>