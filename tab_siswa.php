<?php
// 1. Tentukan batas data per halaman
$batas = 10; 

// 2. Ambil halaman saat ini dari URL (default ke halaman 1)
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// 3. Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari_siswa']) ? mysqli_real_escape_string($koneksi, $_GET['cari_siswa']) : '';

// 4. Hitung total seluruh data siswa
if (!empty($cari)) {
    $query_total = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE nama LIKE '%$cari%' OR nisn LIKE '%$cari%' OR kelas LIKE '%$cari%'");
} else {
    $query_total = mysqli_query($koneksi, "SELECT * FROM t_siswa");
}

$total_data = ($query_total) ? mysqli_num_rows($query_total) : 0;
$total_halaman = ceil($total_data / $batas); 
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">
      <i class="bi bi-people me-2 text-warning"></i>Data Siswa
    </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="siswa/siswa_tambah.php" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
        <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
      </a>
    <?php endif; ?>
  </div>

  <!-- KOTAK PENCARIAN -->
  <div class="card border-0 shadow-sm mb-4 rounded-3">
    <div class="card-body p-3">
      <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
        <input type="hidden" name="tab" value="menu4"> 
        <div class="col-md-10">
          <div class="input-group">
            <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" name="cari_siswa" class="form-control border-start-0 ps-0" placeholder="Cari nama siswa, NISN, atau kelas..." value="<?= htmlspecialchars($cari); ?>">
          </div>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn w-100 fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">Cari</button>
          <?php if (!empty($cari)): ?>
            <a href="dashboard.php?tab=menu4" class="btn btn-outline-warning text-dark" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <!-- TABEL DATA SISWA -->
  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead style="background-color: #1b263b; color: white;">
        <tr>
          <th width="6%">NO</th>
          <th width="15%">NISN</th>
          <th>NAMA SISWA</th>
          <th width="15%">KELAS</th>
          <th width="15%">JURUSAN</th>
          <th width="10%" class="text-center">L/P</th>
          <th width="12%" class="text-center">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($cari)) {
            $q_sis = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE nama LIKE '%$cari%' OR nisn LIKE '%$cari%' OR kelas LIKE '%$cari%' ORDER BY id DESC LIMIT $halaman_awal, $batas");
        } else {
            $q_sis = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY id DESC LIMIT $halaman_awal, $batas");
        }

        if ($q_sis && mysqli_num_rows($q_sis) > 0) {
            $no = $halaman_awal + 1;
            while ($s = mysqli_fetch_assoc($q_sis)) {
                $jk = $s['jenis_kelamin'] ?? '-';
                $jk_badge = ($jk == 'L') ? '<span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Laki-Laki</span>' : '<span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Perempuan</span>';
                
                // Mengambil data kelas dan jurusan jika ada di database
                $kelas_siswa = $s['kelas'] ?? '-';
                $jurusan_siswa = $s['jurusan'] ?? '-';

                echo "<tr>
                        <td class='fw-bold text-muted'>{$no}</td>
                        <td>{$s['nisn']}</td>
                        <td class='fw-semibold'>{$s['nama']}</td>
                        <td><span class='badge bg-light text-dark border'>{$kelas_siswa}</span></td>
                        <td>{$jurusan_siswa}</td>
                        <td class='text-center'>{$jk_badge}</td>
                        <td class='text-center'>
                          <a href='siswa/siswa_edit.php?id={$s['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1 text-white'><i class='bi bi-pencil-square'></i></a>
                          <a href='siswa/siswa_hapus.php?id={$s['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus siswa ini?\")'><i class='bi bi-trash'></i></a>
                        </td>
                      </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Belum ada data siswa ditemukan</td></tr>";
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
          <a class="page-link" href="dashboard.php?tab=menu4&halaman=<?= $halaman - 1; ?><?= !empty($cari) ? '&cari_siswa='.$cari : ''; ?>">Sebelumnya</a>
        </li>
        <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
          <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
            <a class="page-link" style="<?= ($halaman == $x) ? 'background-color: #1b263b; color: white;' : ''; ?>" href="dashboard.php?tab=menu4&halaman=<?= $x; ?><?= !empty($cari) ? '&cari_siswa='.$cari : ''; ?>"><?= $x; ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
          <a class="page-link" href="dashboard.php?tab=menu4&halaman=<?= $halaman + 1; ?><?= !empty($cari) ? '&cari_siswa='.$cari : ''; ?>">Lanjutkan</a>
        </li>
      </ul>
    </nav>
  </div>
  <?php endif; ?>
</div>