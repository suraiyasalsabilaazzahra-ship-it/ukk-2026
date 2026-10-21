<?php
// Hitung data untuk statistik guru
$q_ts = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_siswa");
$tot_siswa = ($q_ts) ? mysqli_fetch_assoc($q_ts)['total'] : 0;

$q_tp = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_pelanggaran");
$tot_pelanggaran = ($q_tp) ? mysqli_fetch_assoc($q_tp)['total'] : 0;

$q_tk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM t_pelanggaran_kategori");
$tot_kategori = ($q_tk) ? mysqli_fetch_assoc($q_tk)['total'] : 0;
?>

<div class="main-header-card mb-4">
 <h3 class="fw-bold text-dark mb-1">Selamat Datang, Guru!</h3>
  <p class="text-muted mb-0"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($email); ?> | Logged in as <span class="fw-semibold text-dark">Guru</span></p>
</div>

<!-- Kotak Statistik ala Admin -->
<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-danger border-4">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-bold text-uppercase">Total Siswa</span>
          <h2 class="fw-bold mb-0 text-dark mt-1"><?= $tot_siswa; ?></h2>
        </div>
        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger fs-3">
          <i class="bi bi-people"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-warning border-4">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-bold text-uppercase">Catatan Pelanggaran</span>
          <h2 class="fw-bold mb-0 text-dark mt-1"><?= $tot_pelanggaran; ?></h2>
        </div>
        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning fs-3">
          <i class="bi bi-exclamation-triangle"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-4">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-bold text-uppercase">Kategori Pelanggaran</span>
          <h2 class="fw-bold mb-0 text-dark mt-1"><?= $tot_kategori; ?></h2>
        </div>
        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success fs-3">
          <i class="bi bi-tags"></i>
        </div>
      </div>
    </div>
  </div>
</div>