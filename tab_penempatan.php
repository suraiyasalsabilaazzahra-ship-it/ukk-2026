<?php
// 1. Tentukan batas data per halaman
$batas = 10; 

// 2. Ambil halaman saat ini dari URL (default ke halaman 1)
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// 3. Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari_penempatan']) ? mysqli_real_escape_string($koneksi, $_GET['cari_penempatan']) : '';

// 4. Hitung total seluruh data penempatan siswa dengan join tabel agar bisa dicari berdasarkan nama/kelas
if (!empty($cari)) {
    $query_total = mysqli_query($koneksi, "SELECT ks.* FROM t_kelas_siswa ks 
        JOIN t_siswa s ON ks.siswa_id = s.id 
        JOIN t_tahun_ajaran ta ON ks.tahun_ajaran_id = ta.id 
        JOIN t_kelas k ON ks.kelas_id = k.id 
        WHERE s.nama LIKE '%$cari%' OR ta.nama LIKE '%$cari%' OR k.nama LIKE '%$cari%'");
} else {
    $query_total = mysqli_query($koneksi, "SELECT * FROM t_kelas_siswa");
}

$total_data = ($query_total) ? mysqli_num_rows($query_total) : 0;
$total_halaman = ceil($total_data / $batas); // Pembulatan ke atas
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">
      <i class="bi bi-diagram-3 me-2 text-warning"></i>Data Penempatan Siswa
    </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="penempatan/penempatan_tambah.php" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
        <i class="bi bi-plus-lg me-1"></i>Tambah Penempatan
      </a>
    <?php endif; ?>
  </div>

  <!-- KOTAK PENCARIAN -->
  <div class="card border-0 shadow-sm mb-4 rounded-3">
    <div class="card-body p-3">
      <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
        <input type="hidden" name="tab" value="menu6"> 
        <div class="col-md-10">
          <div class="input-group">
            <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" name="cari_penempatan" class="form-control border-start-0 ps-0" placeholder="Cari nama siswa, tahun ajaran, atau kelas..." value="<?= htmlspecialchars($cari); ?>">
          </div>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn w-100 fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">Cari</button>
          <?php if (!empty($cari)): ?>
            <a href="dashboard.php?tab=menu6" class="btn btn-outline-warning text-dark" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0 align-middle">
      <thead style="background-color: #1b263b; color: white;">
        <tr>
          <th width="6%" class="text-center">NO</th>
          <th>NAMA SISWA</th>
          <th>TAHUN AJARAN</th>
          <th>KELAS</th>
          <th class="text-center">STATUS</th>
          <th class="text-center" width="15%">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // 5. Query data dengan JOIN untuk mengambil status_aktif dari t_siswa dan t_kelas_siswa
        if (!empty($cari)) {
            $q_ps = mysqli_query($koneksi, "SELECT ks.*, s.nama AS nama_siswa, s.status_aktif AS status_siswa, ta.nama AS nama_ta, k.nama AS nama_kelas 
                FROM t_kelas_siswa ks 
                JOIN t_siswa s ON ks.siswa_id = s.id 
                JOIN t_tahun_ajaran ta ON ks.tahun_ajaran_id = ta.id 
                JOIN t_kelas k ON ks.kelas_id = k.id 
                WHERE s.nama LIKE '%$cari%' OR ta.nama LIKE '%$cari%' OR k.nama LIKE '%$cari%' 
                ORDER BY ks.id DESC LIMIT $halaman_awal, $batas");
        } else {
            $q_ps = mysqli_query($koneksi, "SELECT ks.*, s.nama AS nama_siswa, s.status_aktif AS status_siswa, ta.nama AS nama_ta, k.nama AS nama_kelas 
                FROM t_kelas_siswa ks 
                JOIN t_siswa s ON ks.siswa_id = s.id 
                JOIN t_tahun_ajaran ta ON ks.tahun_ajaran_id = ta.id 
                JOIN t_kelas k ON ks.kelas_id = k.id 
                ORDER BY ks.id DESC LIMIT $halaman_awal, $batas");
        }

        if ($q_ps && mysqli_num_rows($q_ps) > 0) {
            $no = $halaman_awal + 1;
            while ($ps = mysqli_fetch_assoc($q_ps)) {
                $status_s = $ps['status_siswa'] ?? 1;
                $status_p = $ps['status_aktif'] ?? 1;

                // Jika di t_siswa atau t_kelas_siswa berstatus 0 (Tidak Aktif), tampilkan Non-Aktif
                if ($status_s == 0 || $status_p == 0) {
                    $st = '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Non-Aktif</span>';
                } else {
                    $st = '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>';
                }

                echo "<tr>
                        <td class='text-center fw-bold text-muted'>{$no}</td>
                        <td class='fw-semibold text-dark'>{$ps['nama_siswa']}</td>
                        <td>{$ps['nama_ta']}</td>
                        <td><span class='badge bg-light text-dark border'>{$ps['nama_kelas']}</span></td>
                        <td class='text-center'>{$st}</td>
                        <td class='text-center'>
                          <a href='penempatan/penempatan_edit.php?id={$ps['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1 text-white'><i class='bi bi-pencil-square'></i></a>
                          <a href='penempatan/penempatan_hapus.php?id={$ps['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus penempatan ini?\")'><i class='bi bi-trash'></i></a>
                        </td>
                      </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data penempatan siswa</td></tr>";
        }
        ?>
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
          <a class="page-link" href="dashboard.php?tab=menu6&halaman=<?= $halaman - 1; ?><?= !empty($cari) ? '&cari_penempatan='.$cari : ''; ?>">
            Sebelumnya
          </a>
        </li>

        <!-- Tombol Angka Halaman (1, 2, 3...) -->
        <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
          <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
            <a class="page-link" style="<?= ($halaman == $x) ? 'background-color: #1b263b; color: white;' : ''; ?>" href="dashboard.php?tab=menu6&halaman=<?= $x; ?><?= !empty($cari) ? '&cari_penempatan='.$cari : ''; ?>">
              <?= $x; ?>
            </a>
          </li>
        <?php endfor; ?>

        <!-- Tombol Lanjutkan / Selanjutnya -->
        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
          <a class="page-link" href="dashboard.php?tab=menu6&halaman=<?= $halaman + 1; ?><?= !empty($cari) ? '&cari_penempatan='.$cari : ''; ?>">
            Lanjutkan
          </a>
        </li>
      </ul>
    </nav>
  </div>
  <?php endif; ?>

</div>