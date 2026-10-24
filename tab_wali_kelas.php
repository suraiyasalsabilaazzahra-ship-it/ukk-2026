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
      <input type="text" name="search_wk" class="form-control border-start-0" placeholder="Cari berdasarkan ID, Guru ID, Kelas ID, atau Tahun Ajaran..." value="<?= htmlspecialchars($keyword_wk); ?>">
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
          <th>ID</th>
          <th>GURU ID</th>
          <th>KELAS ID</th>
          <th>TAHUN AJARAN ID</th>
          <th>STATUS</th>
          <th class="text-center">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Query filter pencarian
        $sql_wk = "SELECT * FROM t_wali_kelas WHERE 1=1";
        
        if (!empty($keyword_wk)) {
            $keyword_clean = mysqli_real_escape_string($koneksi, $keyword_wk);
            $sql_wk .= " AND (
                id LIKE '%$keyword_clean%' OR 
                guru_id LIKE '%$keyword_clean%' OR 
                kelas_id LIKE '%$keyword_clean%' OR 
                tahun_ajaran_id LIKE '%$keyword_clean%'
            )";
        }
        
        $sql_wk .= " ORDER BY id DESC";
        $q_wk = mysqli_query($koneksi, $sql_wk);

        if ($q_wk && mysqli_num_rows($q_wk) > 0) {
            while ($wk = mysqli_fetch_assoc($q_wk)) {
                $st = ($wk['status_aktif'] == 1) ? '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Non-Aktif</span>';
                echo "<tr>
                        <td class='text-muted'>#{$wk['id']}</td>
                        <td>{$wk['guru_id']}</td>
                        <td>{$wk['kelas_id']}</td>
                        <td>{$wk['tahun_ajaran_id']}</td>
                        <td>{$st}</td>
                        <td class='text-center'>
                          <a href='wali_kelas/wali_kelas_edit.php?id={$wk['id']}' class='btn btn-warning btn-sm p-2 rounded-2 text-white me-1' style='background-color: #ffc107; border: none;' title='Edit'>
                            <i class='bi bi-pencil-square fs-6'></i>
                          </a>
                          <a href='wali_kelas/wali_kelas_hapus.php?id={$wk['id']}' class='btn btn-danger btn-sm p-2 rounded-2' style='background-color: #dc3545; border: none;' onclick='return confirm(\"Hapus wali kelas ini?\")' title='Hapus'>
                            <i class='bi bi-trash fs-6'></i>
                          </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Data wali kelas tidak ditemukan</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>