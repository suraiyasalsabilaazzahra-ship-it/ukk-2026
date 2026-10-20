<?php
// Tab 8: Data Wali Kelas
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-bounding-box me-2 text-warning"></i>Data Wali Kelas </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="wali_kelas/wali_kelas_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold"><i class="bi bi-plus-lg me-1"></i>Tambah Wali Kelas</a>
    <?php endif; ?>
  </div>
  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>ID</th><th>Guru ID</th><th>Kelas ID</th><th>Tahun Ajaran ID</th><th>Status</th><th class="text-center">Aksi</th></tr>
      </thead>
      <tbody>
        <?php
        $q_wk = mysqli_query($koneksi, "SELECT * FROM t_wali_kelas ORDER BY id DESC");
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
                          <a href='wali_kelas/wali_kelas_edit.php?id={$wk['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                          <a href='wali_kelas/wali_kelas_hapus.php?id={$wk['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus wali kelas ini?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data wali kelas</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>