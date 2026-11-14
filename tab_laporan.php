<?php
// tab_laporan.php
$tgl_mulai   = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

// Mengambil data pelanggaran dan digabungkan dengan tabel t_tindakan serta t_siswa & kelas
$sql_laporan = "SELECT ps.*, 
                    t.bentuk_tindakan AS t_bentuk,
                    s.nisn AS nisn_siswa,
                    k.nama AS nama_kelas_siswa
             FROM t_pelanggaran_siswa ps
             LEFT JOIN t_tindakan t ON t.pelanggaran_siswa_id = ps.id
             LEFT JOIN t_siswa s ON ps.siswa_id = s.id
             LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
             LEFT JOIN t_kelas k ON ks.kelas_id = k.id
             ORDER BY ps.tanggal DESC, ps.id DESC";

$query_laporan = mysqli_query($koneksi, $sql_laporan);

$data_laporan = [];
if ($query_laporan) {
    while ($row = mysqli_fetch_assoc($query_laporan)) {
        // Filter tanggal jika diisi
        if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
            if ($row['tanggal'] < $tgl_mulai || $row['tanggal'] > $tgl_selesai) {
                continue;
            }
        }

        // Nama Siswa & NISN
        $nama_s = !empty($row['nama_siswa']) ? $row['nama_siswa'] : (!empty($row['nama_s']) ? $row['nama_s'] : 'Siswa Tidak Ditemukan');
        $nisn_s = !empty($row['nisn_siswa']) ? $row['nisn_siswa'] : '-';

        // Kelas Siswa
        $kelas_Siswa = !empty($row['nama_kelas_siswa']) ? $row['nama_kelas_siswa'] : (!empty($row['nama_kelas']) ? $row['nama_kelas'] : '-');

        // Jenis Pelanggaran & Poin
        $nama_p = !empty($row['nama_pelanggaran']) ? $row['nama_pelanggaran'] : '';
        $poin_p = $row['poin'] ?? 0;

        $kid = !empty($row['pelanggaran_kategori_id']) ? $row['pelanggaran_kategori_id'] : '';
        if ((empty($nama_p) || $poin_p == 0) && !empty($kid)) {
            $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$kid' LIMIT 1");
            if ($q_kat && $data_kat = mysqli_fetch_assoc($q_kat)) {
                if (empty($nama_p)) {
                    $nama_p = $data_kat['nama'] ?? ($data_kat['nama_kategori'] ?? 'Pelanggaran Umum');
                }
                if ($poin_p == 0) {
                    $poin_p = $data_kat['poin'] ?? 0;
                }
            }
        }
        if (empty($nama_p)) $nama_p = 'Pelanggaran Umum';

        // Bentuk Tindakan
        $bentuk_tindakan = !empty($row['t_bentuk']) ? $row['t_bentuk'] : ($row['tindakan'] ?? '');

        $row['computed_nama_siswa'] = $nama_s;
        $row['computed_nisn'] = $nisn_s;
        $row['computed_kelas'] = $kelas_Siswa;
        $row['computed_nama_pelanggaran'] = $nama_p;
        $row['computed_poin'] = $poin_p;
        $row['computed_tindakan'] = $bentuk_tindakan;

        // Hindari duplikasi data jika ada join ganda dari t_kelas_siswa
        $unik_key = $row['id'] . '-' . $nama_s;
        $data_laporan[$unik_key] = $row;
    }
    // Ubah kembali ke array biasa
    $data_laporan = array_values($data_laporan);
}
?>

<!-- STYLE KHUSUS CETAK -->
<style>
@media print {
  body * { visibility: hidden; }
  #area-cetak, #area-cetak * { visibility: visible; }
  #area-cetak { position: absolute; left: 0; top: 0; width: 100%; }
  .no-print { display: none !important; }
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
          <th class="py-3">JENIS PELANGGARAN & TINDAKAN</th>
          <th class="py-3 text-center" style="width: 15%;">TANGGAL</th>
          <th class="py-3 text-center" style="width: 12%;">POIN</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($data_laporan)) {
          $no = 1;
          foreach ($data_laporan as $row) {
            $tgl = !empty($row['tanggal']) ? date('d/m/Y', strtotime($row['tanggal'])) : '-';
        ?>
            <tr>
              <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
              <td>
                <span class="fw-semibold text-dark"><?= htmlspecialchars($row['computed_nama_siswa']); ?></span>
                <br><small class="text-muted">NISN: <?= htmlspecialchars($row['computed_nisn']); ?></small>
              </td>
              <td><span class="fw-semibold text-dark"><?= htmlspecialchars($row['computed_kelas']); ?></span></td>
              <td>
                <span class="fw-medium text-dark"><?= htmlspecialchars($row['computed_nama_pelanggaran']); ?></span>
                <?php if (!empty($row['computed_tindakan'])): ?>
                  <br><small class="text-primary fw-semibold"><i class="bi bi-shield-check me-1"></i>Tindakan: <?= htmlspecialchars($row['computed_tindakan']); ?></small>
                <?php endif; ?>
                <?php if (!empty($row['keterangan'])): ?>
                  <br><small class="text-muted">Ket: <?= htmlspecialchars($row['keterangan']); ?></small>
                <?php endif; ?>
              </td>
              <td class="text-center text-muted small"><?= $tgl; ?></td>
              <td class="text-center">
                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold">
                  +<?= htmlspecialchars($row['computed_poin']); ?>
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