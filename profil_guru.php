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

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'] ?? 'guru@sekolah.sch.id';
$user_name  = $_SESSION['nama'] ?? 'Budi Santoso, S.Pd.';

// Cari detail guru dari database
$guru_data = null;
$q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE email = '$user_email' OR nama = '$user_name' LIMIT 1");
if ($q_guru && mysqli_num_rows($q_guru) > 0) {
    $guru_data = mysqli_fetch_assoc($q_guru);
}
?>

<div class="container-fluid px-0">
  <div class="row">
    <div class="col-12">
      
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="p-4 text-white" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
          <h4 class="mb-1 fw-bold"><i class="bi bi-person-badge me-2 text-warning"></i>Profil Guru / Pendidik</h4>
          <p class="mb-0 text-white-50 small">Informasi akun pengguna dan penugasan guru pengajar.</p>
        </div>

        <div class="card-body p-4 bg-white">
          <div class="row align-items-center">
            
            <div class="col-md-4 text-center mb-4 mb-md-0 border-end">
              <img src="foto-profil.jpg" alt="Foto Profil Guru" class="img-fluid rounded-circle shadow border border-4 border-warning mb-3" style="width: 150px; height: 150px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/150?text=Guru';">
              <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($guru_data['nama'] ?? $user_name); ?></h5>
              <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-semibold">
                <i class="bi bi-patch-check-fill me-1"></i> Guru Pengajar / Piket
              </span>
            </div>

            <div class="col-md-8 ps-md-4">
              <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="bi bi-info-circle text-black me-2"></i>Rincian Informasi Akun Guru
              </h5>
              
              <table class="table table-borderless align-middle mb-0">
                <tbody>
                  <tr>
                    <td class="text-secondary fw-semibold" style="width: 35%;"><i class="bi bi-person me-2 text-muted"></i>Nama Lengkap</td>
                    <td style="width: 3%;">:</td>
                    <td class="fw-bold text-dark"><?= htmlspecialchars($guru_data['nama'] ?? $user_name); ?></td>
                  </tr>
                  <tr>
                    <td class="text-secondary fw-semibold"><i class="bi bi-card-text me-2 text-muted"></i>NIP / ID Guru</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($guru_data['nip'] ?? ($guru_data['id'] ?? '19850712 201001 1 003')); ?></td>
                  </tr>
                  <tr>
                    <td class="text-secondary fw-semibold"><i class="bi bi-envelope me-2 text-muted"></i>Email Akun</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($guru_data['email'] ?? $user_email); ?></td>
                  </tr>
                  <tr>
                  <tr>
                    <td class="text-secondary fw-semibold"><i class="bi bi-shield-lock me-2 text-muted"></i>Hak Akses Sistem</td>
                    <td>:</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Guru Piket / Kesiswaan</span></td>
                  </tr>
                </tbody>
              </table>

            </div>

          </div>
        </div>

        <div class="card-footer bg-light py-3 px-4 text-muted small d-flex justify-content-between align-items-center">
          <span><i class="bi bi-clock-history me-1"></i> Sesi Login Aktif</span>
          <span class="fw-semibold text-primary">Sistem Informasi Disiplin UKK-2026</span>
        </div>
      </div>

    </div>
  </div>
</div>