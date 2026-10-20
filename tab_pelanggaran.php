<?php
// 1. Tentukan batas data per halaman
$batas = 10; 

// 2. Ambil halaman saat ini dari URL
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// 3. Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari_pelanggaran']) ? mysqli_real_escape_string($koneksi, $_GET['cari_pelanggaran']) : '';

// 4. Hitung total seluruh data untuk paginasi
$sql_count = "SELECT COUNT(*) AS total 
              FROM t_pelanggaran_siswa ps
              LEFT JOIN t_siswa s ON ps.siswa_id = s.id
              LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id";

if (!empty($cari)) {
  $sql_count .= " WHERE s.nama LIKE '%$cari%' OR s.nisn LIKE '%$cari%' OR p.nama LIKE '%$cari%' OR p.kode LIKE '%$cari%'";
}

$query_total = mysqli_query($koneksi, $sql_count);
$total_data = ($query_total) ? mysqli_fetch_assoc($query_total)['total'] : 0;
$total_halaman = ceil($total_data / $batas);

// 5. Query data utama
$sql_data = "SELECT ps.*, s.nama AS nama_siswa, s.nisn, 
                    COALESCE(p.nama, 'Pelanggaran') AS nama_pelanggaran,
                    COALESCE(p.kode, '-') AS kode_pelanggaran
             FROM t_pelanggaran_siswa ps
             LEFT JOIN t_siswa s ON ps.siswa_id = s.id
             LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id";

if (!empty($cari)) {
  $sql_data .= " WHERE s.nama LIKE '%$cari%' OR s.nisn LIKE '%$cari%' OR p.nama LIKE '%$cari%' OR p.kode LIKE '%$cari%'";
}

$sql_data .= " ORDER BY ps.id DESC LIMIT $halaman_awal, $batas";
$query_p = mysqli_query($koneksi, $sql_data);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold text-dark mb-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Pencatatan Pelanggaran</h4>
  <a href="pelanggaran/pelanggaran_tambah.php" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
    <i class="bi bi-plus-lg me-1"></i>Tambah Pelanggaran
  </a>
</div>

<!-- KOTAK PENCARIAN -->
<div class="card border-0 shadow-sm mb-4 rounded-3">
  <div class="card-body p-3">
    <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
      <input type="hidden" name="tab" value="menu9">
      <div class="col-md-10">
        <div class="input-group">
          <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
          <input type="text" name="cari_pelanggaran" class="form-control border-start-0 ps-0" placeholder="Cari nama siswa, NISN, atau jenis pelanggaran..." value="<?= htmlspecialchars($cari); ?>">
        </div>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn w-100 fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">Cari</button>
        <?php if (!empty($cari)): ?>
          <a href="dashboard.php?tab=menu9" class="btn btn-outline-warning text-dark" title="Reset Pencarian"><i class="bi bi-arrow-counterclockwise"></i></a>
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
          <th class="py-3">NAMA SISWA</th>
          <th class="py-3">DETAIL PELANGGARAN</th>
          <th class="py-3 text-center" style="width: 15%;">TANGGAL</th>
          <th class="py-3 text-center" style="width: 12%;">POIN</th>
          <th class="py-3 text-center" style="width: 15%;">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($query_p && mysqli_num_rows($query_p) > 0) {
          $no = $halaman_awal + 1;
          while ($row = mysqli_fetch_assoc($query_p)) {
            $tgl = !empty($row['tanggal']) ? date('d/m/Y', strtotime($row['tanggal'])) : '-';
        ?>
            <tr>
              <td class="fw-bold px-3 text-muted"><?= $no++; ?></td>
              <td>
                <span class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_siswa'] ?? 'Siswa Tidak Ditemukan'); ?></span>
                <br><small class="text-muted">NISN: <?= htmlspecialchars($row['nisn'] ?? '-'); ?></small>
              </td>
              <td>
                <span class="fw-medium text-dark"><?= htmlspecialchars($row['nama_pelanggaran']); ?></span>
                <br><small class="badge bg-secondary bg-opacity-10 text-dark border py-1 px-2">Kode: <?= htmlspecialchars($row['kode_pelanggaran']); ?></small>
              </td>
              <td class="text-center text-muted small"><?= $tgl; ?></td>
              <td class="text-center">
                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold">
                  +<?= htmlspecialchars($row['poin'] ?? 0); ?> Poin
                </span>
              </td>
              <td class="text-center">
              <a href="pelanggaran/pelanggaran_edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning text-white px-2 py-1 me-1"><i class="bi bi-pencil-square"></i></a>
                <a href="pelanggaran/pelanggaran_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger px-2 py-1" onclick="return confirm('Yakin ingin menghapus catatan pelanggaran ini?')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Tidak ada data pencatatan pelanggaran ditemukan.</td></tr>";
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
          <a class="page-link" href="dashboard.php?tab=menu9&halaman=<?= $halaman - 1; ?><?= !empty($cari) ? '&cari_pelanggaran='.$cari : ''; ?>">Sebelumnya</a>
        </li>

        <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
          <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
            <a class="page-link" style="<?= ($halaman == $x) ? 'background-color: #1b263b; color: white;' : ''; ?>" href="dashboard.php?tab=menu9&halaman=<?= $x; ?><?= !empty($cari) ? '&cari_pelanggaran='.$cari : ''; ?>">
              <?= $x; ?>
            </a>
          </li>
        <?php endfor; ?>

        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
          <a class="page-link" href="dashboard.php?tab=menu9&halaman=<?= $halaman + 1; ?><?= !empty($cari) ? '&cari_pelanggaran='.$cari : ''; ?>">Lanjutkan</a>
        </li>
      </ul>
    </nav>
  </div>
  <?php endif; ?>

</div>