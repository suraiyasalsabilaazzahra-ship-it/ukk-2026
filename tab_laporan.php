<?php
// Ambil filter tanggal jika ada
$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

// Query disesuaikan dengan kolom status_aktif pada tabel t_kelas_siswa
$sql_laporan = "SELECT ps.*, 
                       COALESCE(s.nama, ps.nama_siswa, 'Siswa Tidak Ditemukan') AS nama_mhs, 
                       COALESCE(kls.nama, ps.nama_kelas, '-') AS kelas_mhs, 
                       COALESCE(p.nama, ps.nama_pelanggaran, 'Pelanggaran') AS jenis_plg
                FROM t_pelanggaran_siswa ps
                LEFT JOIN t_siswa s ON ps.siswa_id = s.id
                LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id AND ks.status_aktif = 1
                LEFT JOIN t_kelas kls ON ks.kelas_id = kls.id
                LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
                WHERE 1=1";

if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
    $tgl_mulai = mysqli_real_escape_string($koneksi, $tgl_mulai);
    $tgl_selesai = mysqli_real_escape_string($koneksi, $tgl_selesai);
    $sql_laporan .= " AND ps.tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}

$sql_laporan .= " ORDER BY ps.tanggal DESC";
$query_laporan = mysqli_query($koneksi, $sql_laporan);
?>

<!-- STYLE KHUSUS CETAK -->
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #area-cetak, #area-cetak * {
    visibility: visible;
  }
  #area-cetak {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
  .no-print {
    display: none !important;
  }
}
</style>

<!-- HEADER JUDUL DAN TOMBOL UTAMA -->
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
  <div>
    <h4 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-text text-warning me-2"></i>Laporan Pelanggaran Siswa</h4>
    <p class="text-muted small mb-0">Rekapitulasi data kedisiplinan siswa sekolah</p>
  </div>
  <button onclick="window.print()" class="btn btn-sm px-3 rounded-pill fw-semibold text-white shadow-sm" style="background-color: #1b263b; border-color: #1b263b;">
    <i class="bi bi-printer me-1"></i>Cetak Laporan
  </button>
</div>

<!-- KOTAK FILTER PERIODE TANGGAL -->
<div class="card border-0 shadow-sm mb-4 rounded-3 no-print">
  <div class="card-body p-3">
    <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
      <input type="hidden" name="tab" value="menu10">
      <div class="col-md-4">
        <label class="form-label small fw-semibold text-muted mb-1">Dari Tanggal</label>
        <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="<?= htmlspecialchars($tgl_mulai); ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label small fw-semibold text-muted mb-1">Sampai Tanggal</label>
        <input type="date" name="tgl_selesai" class="form-control form-control-sm" value="<?= htmlspecialchars($tgl_selesai); ?>">
      </div>
      <div class="col-md-4 d-flex align-items-end gap-2 pt-1">
        <button type="submit" class="btn btn-sm w-50 fw-semibold text-white" style="background-color: #1b263b;">Filter</button>
        <a href="dashboard.php?tab=menu10" class="btn btn-sm btn-outline-secondary w-50">Reset</a>
      </div>
    </form>
  </div>
</div>

<!-- AREA CETAK LAPORAN -->
<div class="card border-0 shadow-sm rounded-3 overflow-hidden" id="area-cetak">
  <div class="card-header bg-white py-3 border-bottom text-center">
    <h5 class="fw-bold text-dark mb-1">LAPORAN REKAPITULASI PELANGGARAN SISWA</h5>
    <p class="text-muted small mb-0">Sistem Informasi Disiplin Sekolah - UKK 2026</p>
    <?php if (!empty($tgl_mulai) && !empty($tgl_selesai)): ?>
      <p class="text-muted small mt-1 mb-0">Periode: <strong><?= date('d/m/Y', strtotime($tgl_mulai)); ?></strong> s.d. <strong><?= date('d/m/Y', strtotime($tgl_selesai)); ?></strong></p>
    <?php endif; ?>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle mb-0">
      <thead style="background-color: #1b263b; color: white;">
        <tr>
          <th class="py-3 px-3 text-center" style="width: 5%;">NO</th>
          <th class="py-3">NAMA SISWA</th>
          <th class="py-3">KELAS</th>
          <th class="py-3">JENIS PELANGGARAN</th>
          <th class="py-3 text-center" style="width: 15%;">TANGGAL</th>
          <th class="py-3 text-center" style="width: 12%;">POIN</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($query_laporan && mysqli_num_rows($query_laporan) > 0) {
          $no = 1;
          while ($row = mysqli_fetch_assoc($query_laporan)) {
            $tgl = !empty($row['tanggal']) ? date('d/m/Y', strtotime($row['tanggal'])) : '-';
        ?>
            <tr>
              <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
              <td>
                <span class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_mhs']); ?></span>
              </td>
              <td><span class="fw-semibold text-dark"><?= htmlspecialchars($row['kelas_mhs']); ?></span></td>
              <td>
                <span class="fw-medium text-dark"><?= htmlspecialchars($row['jenis_plg']); ?></span>
                <?php if (!empty($row['keterangan'])): ?>
                  <br><small class="text-muted">Ket: <?= htmlspecialchars($row['keterangan']); ?></small>
                <?php endif; ?>
              </td>
              <td class="text-center text-muted small"><?= $tgl; ?></td>
              <td class="text-center">
                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold">
                  +<?= htmlspecialchars($row['poin'] ?? 0); ?>
                </span>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Tidak ada data laporan pelanggaran untuk periode ini.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  
  <div class="card-footer bg-white py-3 text-end text-muted small">
    Dicetak pada: <?= date('d/m/Y H:i'); ?> WIB
  </div>
</div>