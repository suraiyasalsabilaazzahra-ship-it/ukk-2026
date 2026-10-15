<?php
// Tab 6: Penempatan Siswa
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-diagram-3 me-2 text-danger"></i>Data Penempatan Siswa </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="penempatan_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold"><i class="bi bi-plus-lg me-1"></i>Tambah Penempatan</a>
    <?php endif; ?>
  </div>
  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>ID</th><th>Siswa ID</th><th>Tahun Ajaran ID</th><th>Kelas ID</th><th>Status</th><th class="text-center">Aksi</th></tr>
      </thead>
      <tbody>
        <?php
        $q_ps = mysqli_query($koneksi, "SELECT * FROM t_kelas_siswa ORDER BY id DESC");
        if ($q_ps && mysqli_num_rows($q_ps) > 0) {
            while ($ps = mysqli_fetch_assoc($q_ps)) {
                $st = ($ps['status_aktif'] == 1) ? '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Non-Aktif</span>';
                echo "<tr>
                        <td class='text-muted'>#{$ps['id']}</td>
                        <td>{$ps['siswa_id']}</td>
                        <td>{$ps['tahun_ajaran_id']}</td>
                        <td>{$ps['kelas_id']}</td>
                        <td>{$st}</td>
                        <td class='text-center'>
                          <a href='penempatan_edit.php?id={$ps['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                          <a href='penempatan_hapus.php?id={$ps['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus penempatan ini?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data penempatan siswa</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>