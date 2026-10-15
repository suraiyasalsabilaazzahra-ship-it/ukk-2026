<?php
// File komponen untuk Tab Beranda / Dashboard
?>
<!-- Bagian Selamat Datang yang ingin disembunyikan saat di menu About Me -->
<div class="mb-4">
  <h3 class="fw-bold text-dark">Selamat Datang, <?= htmlspecialchars($nama); ?></h3>
  <p class="text-muted small"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($email); ?> Logged in as <strong><?= $role; ?></strong></p>
</div>
<div class="row g-4">
  <div class="col-md-4">
    <div class="card stat-card shadow-sm bg-white border-start border-4 border-danger p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <span class="text-muted fw-medium text-uppercase small">Total Siswa</span>
          <h2 class="fw-bold mb-0 mt-1 text-dark"><?= $total_siswa; ?></h2>
        </div>
        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
          <i class="bi bi-people fs-2"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card stat-card shadow-sm bg-white border-start border-4 border-warning p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <span class="text-muted fw-medium text-uppercase small">Total Guru</span>
          <h2 class="fw-bold mb-0 mt-1 text-dark"><?= $total_guru; ?></h2>
        </div>
        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
          <i class="bi bi-person-workspace fs-2"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card stat-card shadow-sm bg-white border-start border-4 border-success p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <span class="text-muted fw-medium text-uppercase small">Total Kelas</span>
          <h2 class="fw-bold mb-0 mt-1 text-dark"><?= $total_kelas; ?></h2>
        </div>
        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
          <i class="bi bi-building fs-2"></i>
        </div>
      </div>
    </div>
  </div>
</div>