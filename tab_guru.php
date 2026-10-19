<?php
// 1. Tentukan batas data per halaman
$batas = 10; 

// 2. Ambil halaman saat ini dari URL (default ke halaman 1)
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// 3. Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari_guru']) ? mysqli_real_escape_string($koneksi, $_GET['cari_guru']) : '';

// 4. Hitung total seluruh data untuk menentukan jumlah tombol halaman
if ($role === 'Guru') {
    $query_total = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa");
} else {
    if (!empty($cari)) {
        $query_total = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE nama LIKE '%$cari%' OR nip LIKE '%$cari%'");
    } else {
        $query_total = mysqli_query($koneksi, "SELECT * FROM t_guru");
    }
}

$total_data = ($query_total) ? mysqli_num_rows($query_total) : 0;
$total_halaman = ceil($total_data / $batas); // Pembulatan ke atas
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">
      <i class="bi bi-person-workspace me-2 text-warning"></i>
      <?= $role === 'Guru' ? 'Catat Pelanggaran Siswa' : 'Kelola Data Guru '; ?>
    </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="guru_tambah.php" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
        <i class="bi bi-plus-lg me-1"></i>Tambah Guru
      </a>
    <?php endif; ?>
  </div>

  <!-- KOTAK PENCARIAN (Hanya untuk Admin) -->
  <?php if ($role !== 'Guru'): ?>
  <div class="card border-0 shadow-sm mb-4 rounded-3">
    <div class="card-body p-3">
      <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
        <input type="hidden" name="tab" value="menu2"> 
        <div class="col-md-10">
          <div class="input-group">
            <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" name="cari_guru" class="form-control border-start-0 ps-0" placeholder="Cari nama atau NIP guru..." value="<?= htmlspecialchars($cari); ?>">
          </div>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn w-100 fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">Cari</button>
          <?php if (!empty($cari)): ?>
            <a href="dashboard.php?tab=menu2" class="btn btn-outline-warning text-dark" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <?php if ($role === 'Guru'): ?>
            <th>No</th><th>Nama Siswa</th><th>Pelanggaran</th><th>Poin</th>
          <?php else: ?>
            <th>ID</th><th>NIP</th><th>Nama Guru</th><th>Email</th><th>Status</th><th class="text-center">Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if ($role === 'Guru'): ?>
          <?php
          $no = $halaman_awal + 1;
          $q_pelanggaran = mysqli_query($koneksi, "
            SELECT s.nama, p.nama as nama_pelanggaran, p.poin 
            FROM t_pelanggaran_siswa ps
            JOIN t_siswa s ON ps.siswa_id = s.id
            JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
            LIMIT $halaman_awal, $batas
          ");
          if ($q_pelanggaran && mysqli_num_rows($q_pelanggaran) > 0) {
              while ($p = mysqli_fetch_assoc($q_pelanggaran)) {
                  echo "<tr>
                          <td>{$no}</td>
                          <td class='fw-semibold'>{$p['nama']}</td>
                          <td>{$p['nama_pelanggaran']}</td>
                          <td><span class='badge bg-danger'>{$p['poin']} Poin</span></td>
                        </tr>";
                  $no++;
              }
          } else {
              echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada data pelanggaran</td></tr>";
          }
          ?>
        <?php else: ?>
          <?php
          // 5. Query utama guru dengan LIMIT dan pencarian
          if (!empty($cari)) {
              $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE nama LIKE '%$cari%' OR nip LIKE '%$cari%' ORDER BY id DESC LIMIT $halaman_awal, $batas");
          } else {
              $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY id DESC LIMIT $halaman_awal, $batas");
          }

          if ($q_guru && mysqli_num_rows($q_guru) > 0) {
              while ($g = mysqli_fetch_assoc($q_guru)) {
                  $status_badge = ($g['status_aktif'] == 1) ? '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Tidak Aktif</span>';
                  echo "<tr>
                          <td class='text-muted'>#{$g['id']}</td>
                          <td>{$g['nip']}</td>
                          <td class='fw-semibold'>{$g['nama']}</td>
                          <td>{$g['email']}</td>
                          <td>{$status_badge}</td>
                          <td class='text-center'>
                            <a href='guru_edit.php?id={$g['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1 text-white'>Edit</a>
                            <a href='guru_hapus.php?id={$g['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data guru di database</td></tr>";
          }
          ?>
        <?php endif; ?> <!-- <-- PENUTUP ELSE $role === 'Guru' YANG SEBELUMNYA KURANG -->
      </tbody>
    </table>
  </div>

  <!-- NAVIGASI PAGINASI / TOMBOL HALAMAN -->
  <?php if ($total_halaman > 1): ?>
  <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">
      Menampilkan data ke-<?= ($halaman_awal + 1); ?> sampai <?= min($halaman_awal + $batas, $total_data); ?> dari total <?= $total_data; ?> data
    </small>
    
    <nav>
      <ul class="pagination pagination-sm mb-0">
        <!-- Tombol Sebelumnya -->
        <li class="page-item <?= ($halaman <= 1) ? 'disabled' : ''; ?>">
          <a class="page-link" href="dashboard.php?tab=menu2&halaman=<?= $halaman - 1; ?><?= !empty($cari) ? '&cari_guru='.$cari : ''; ?>">
            Sebelumnya
          </a>
        </li>

        <!-- Tombol Angka Halaman (1, 2, 3...) -->
        <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
          <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
            <a class="page-link" style="<?= ($halaman == $x) ? 'background-color: #1b263b; color: white;' : ''; ?>" href="dashboard.php?tab=menu2&halaman=<?= $x; ?><?= !empty($cari) ? '&cari_guru='.$cari : ''; ?>">
              <?= $x; ?>
            </a>
          </li>
        <?php endfor; ?>

        <!-- Tombol Lanjutkan / Selanjutnya -->
        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
          <a class="page-link" href="dashboard.php?tab=menu2&halaman=<?= $halaman + 1; ?><?= !empty($cari) ? '&cari_guru='.$cari : ''; ?>">
            Lanjutkan
          </a>
        </li>
      </ul>
    </nav>
  </div>
  <?php endif; ?>

</div>