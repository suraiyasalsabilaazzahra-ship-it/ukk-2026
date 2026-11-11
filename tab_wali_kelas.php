<?php
// Tab 8: Data Wali Kelas
$keyword_wk = isset($_GET['search_wk']) ? trim($_GET['search_wk']) : '';
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-bounding-box me-2 text-warning"></i>Data Wali Kelas</h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="wali_kelas/wali_kelas_tambah.php" class="btn btn-dark btn-sm px-3 rounded-pill fw-semibold" style="background-color: #1b263b;"><i class="bi bi-plus-lg me-1"></i>Tambah Wali Kelas</a>
    <?php endif; ?>
  </div>

  <!-- FORM PENCARIAN -->
  <form action="dashboard.php" method="GET" class="mb-3">
    <input type="hidden" name="tab" value="menu8">
    <div class="input-group">
      <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
      <input type="text" name="search_wk" class="form-control border-start-0" placeholder="Cari berdasarkan nama guru, kelas, atau tahun ajaran..." value="<?= htmlspecialchars($keyword_wk); ?>">
      <button class="btn btn-dark px-4" type="submit" style="background-color: #1b263b;">Cari</button>
      <?php if (!empty($keyword_wk)): ?>
        <a href="dashboard.php?tab=menu8" class="btn btn-outline-secondary">Reset</a>
      <?php endif; ?>
    </div>
  </form>

  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0 align-middle">
      <thead style="background-color: #1b263b; color: white;">
        <tr>
          <th width="6%" class="text-center">NO</th>
          <th>GURU</th>
          <th>KELAS</th>
          <th>TAHUN AJARAN</th>
          <th class="text-center">STATUS</th>
          <th class="text-center" width="15%">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Menggunakan LEFT JOIN agar data tetap aman jika ada relasi kosong
        $sql_wk = "SELECT wk.*, g.nama AS nama_guru, k.nama AS nama_kelas, ta.nama AS nama_ta 
                   FROM t_wali_kelas wk 
                   LEFT JOIN t_guru g ON wk.guru_id = g.id 
                   LEFT JOIN t_kelas k ON wk.kelas_id = k.id 
                   LEFT JOIN t_tahun_ajaran ta ON wk.tahun_ajaran_id = ta.id 
                   WHERE 1=1";
        
        if (!empty($keyword_wk)) {
            $keyword_clean = mysqli_real_escape_string($koneksi, $keyword_wk);
            $sql_wk .= " AND (
                g.nama LIKE '%$keyword_clean%' OR 
                k.nama LIKE '%$keyword_clean%' OR 
                ta.nama LIKE '%$keyword_clean%'
            )";
        }
        
        $sql_wk .= " ORDER BY wk.id DESC";
        $q_wk = mysqli_query($koneksi, $sql_wk);

        if ($q_wk && mysqli_num_rows($q_wk) > 0) {
            $no = 1;
            while ($wk = mysqli_fetch_assoc($q_wk)) {
                $st = ($wk['status_aktif'] == 1) ? '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Non-Aktif</span>';
                
                $nama_guru  = htmlspecialchars($wk['nama_guru'] ?? 'Guru Dihapus');
                $nama_kelas = htmlspecialchars($wk['nama_kelas'] ?? '-');
                $nama_ta    = htmlspecialchars($wk['nama_ta'] ?? '-');

                echo "<tr>
                        <td class='text-center fw-bold text-muted'>{$no}</td>
                        <td class='fw-semibold text-dark'>{$nama_guru}</td>
                        <td><span class='badge bg-light text-dark border'>{$nama_kelas}</span></td>
                        <td>{$nama_ta}</td>
                        <td class='text-center'>{$st}</td>
                        <td class='text-center'>
                          <a href='wali_kelas/wali_kelas_edit.php?id={$wk['id']}' class='btn btn-warning btn-sm p-2 rounded-2 text-white me-1' style='background-color: #ffc107; border: none;' title='Edit'>
                            <i class='bi bi-pencil-square fs-6'></i>
                          </a>
                          <a href='wali_kelas/wali_kelas_hapus.php?id={$wk['id']}' class='btn btn-danger btn-sm p-2 rounded-2' style='background-color: #dc3545; border: none;' onclick='return confirm(\"Hapus wali kelas ini?\")' title='Hapus'>
                            <i class='bi bi-trash fs-6'></i>
                          </a>
                        </td>
                      </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Data wali kelas tidak ditemukan</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>