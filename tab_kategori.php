<?php
// 1. Tentukan batas data per halaman
$batas = 10; 

// 2. Ambil halaman saat ini dari URL (default ke halaman 1)
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// 3. Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari_kategori']) ? mysqli_real_escape_string($koneksi, $_GET['cari_kategori']) : '';

// 4. Hitung total seluruh data untuk menentukan jumlah tombol halaman
if (!empty($cari)) {
  $query_total = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE nama_kategori LIKE '%$cari%' OR deskripsi LIKE '%$cari%'");
} else {
  $query_total = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori");
}

$total_data = ($query_total) ? mysqli_num_rows($query_total) : 0;
$total_halaman = ceil($total_data / $batas); // Pembulatan ke atas

// 5. Query data dengan limit paginasi dan pencarian
if (!empty($cari)) {
  $query_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE nama_kategori LIKE '%$cari%' OR deskripsi LIKE '%$cari%' ORDER BY id DESC LIMIT $halaman_awal, $batas");
} else {
  $query_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC LIMIT $halaman_awal, $batas");
}
?>

<!-- KOTAK KETERANGAN / PANDUAN KATEGORI & POIN OTOMATIS -->
<div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
  <div class="card-header text-white p-3" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
    <h5 class="mb-0 fw-bold fs-6"><i class="bi bi-info-circle-fill text-warning me-2"></i>Panduan Sistem Poin & Kategori Pelanggaran Sekolah</h5>
  </div>
  <div class="card-body bg-white p-3">
    <div class="row text-center g-2">
      <div class="col-md-4">
        <div class="p-2 border rounded-3 bg-light">
          <span class="badge bg-info text-dark mb-1 px-2 py-1">RINGAN</span>
          <p class="mb-0 small fw-bold text-muted">Poin: 5 s.d. 15</p>
          <small class="text-secondary" style="font-size: 11px;">Contoh: Terlambat, atribut tidak lengkap</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-2 border rounded-3 bg-light">
          <span class="badge bg-warning text-dark mb-1 px-2 py-1">SEDANG</span>
          <p class="mb-0 small fw-bold text-muted">Poin: 20 s.d. 50</p>
          <small class="text-secondary" style="font-size: 11px;">Contoh: Membolos, merusak fasilitas ringan</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-2 border rounded-3 bg-light">
          <span class="badge bg-danger mb-1 px-2 py-1">BERAT</span>
          <p class="mb-0 small fw-bold text-muted">Poin: 55 s.d. 100</p>
          <small class="text-secondary" style="font-size: 11px;">Contoh: Berkelahi, membawa senjata/barang terlarang</small>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold text-dark mb-0"><i class="bi bi-tags text-warning me-2"></i>Kategori Pelanggaran</h4>
  <a href="kategori/kategori_tambah.php" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
    <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
  </a>
</div>

<!-- KOTAK PENCARIAN -->
<div class="card border-0 shadow-sm mb-4 rounded-3">
  <div class="card-body p-3">
    <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
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
          <th class="py-3 text-center" style="width: 10%;">POIN</th>
          <th class="py-3">DESKRIPSI</th>
          <th class="py-3 text-center" style="width: 15%;">JENIS (OTOMATIS)</th>
          <th class="py-3 text-center" style="width: 15%;">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($query_kat && mysqli_num_rows($query_kat) > 0) {
          $no = $halaman_awal + 1;
          while ($row = mysqli_fetch_assoc($query_kat)) {
            $poin = (int)($row['poin'] ?? 0);
            
            // Sistem otomatis menentukan jenis berdasarkan jumlah poin
            if ($poin >= 1 && $poin <= 15) {
              $jenis = "Ringan";
              $badge_bg = "bg-info bg-opacity-10 text-info border border-info";
            } elseif ($poin >= 20 && $poin <= 50) {
              $jenis = "Sedang";
              $badge_bg = "bg-warning bg-opacity-10 text-warning text-dark border border-warning";
            } else {
              $jenis = "Berat";
              $badge_bg = "bg-danger bg-opacity-10 text-danger border border-danger";
            }
        ?>
            <tr>
              <td class="fw-bold px-3 text-muted"><?= $no++; ?></td>
              <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_kategori'] ?? ''); ?></td>
              <td class="text-center fw-bold text-primary"><?= $poin; ?></td>
              <td class="text-muted small"><?= htmlspecialchars($row['deskripsi'] ?? '-'); ?></td>
              <td class="text-center">
                <span class="badge <?= $badge_bg; ?> px-3 py-1 fw-bold"><?= $jenis; ?></span>
              </td>
              <td class="text-center">
                <a href="kategori/kategori_edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning text-white px-2 py-1 me-1"><i class="bi bi-pencil-square"></i></a>
                <a href="kategori/kategori_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger px-2 py-1" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
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

  <!-- NAVIGASI PAGINASI -->
  <?php if ($total_halaman > 1): ?>
  <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">
      Menampilkan data ke-<?= ($halaman_awal + 1); ?> sampai <?= min($halaman_awal + $batas, $total_data); ?> dari total <?= $total_data; ?> data
    </small>
    
    <nav>
      <ul class="pagination pagination-sm mb-0">
        <li class="page-item <?= ($halaman <= 1) ? 'disabled' : ''; ?>">
          <a class="page-link" href="dashboard.php?tab=menu7&halaman=<?= $halaman - 1; ?><?= !empty($cari) ? '&cari_kategori='.$cari : ''; ?>">Sebelumnya</a>
        </li>
        <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
          <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
            <a class="page-link" style="<?= ($halaman == $x) ? 'background-color: #1b263b; color: white;' : ''; ?>" href="dashboard.php?tab=menu7&halaman=<?= $x; ?><?= !empty($cari) ? '&cari_kategori='.$cari : ''; ?>"><?= $x; ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
          <a class="page-link" href="dashboard.php?tab=menu7&halaman=<?= $halaman + 1; ?><?= !empty($cari) ? '&cari_kategori='.$cari : ''; ?>">Lanjutkan</a>
        </li>
      </ul>
    </nav>
  </div>
  <?php endif; ?>
</div>