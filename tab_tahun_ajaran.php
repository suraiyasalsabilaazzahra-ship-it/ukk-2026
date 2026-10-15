<?php
// Tab 5: Data Tahun Ajaran
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-calendar-range me-2 text-danger"></i>Data Tahun Ajaran </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="tahun_ajaran_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold"><i class="bi bi-plus-lg me-1"></i>Tambah Tahun Ajaran</a>
    <?php endif; ?>
  </div>
  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>ID</th><th>Nama Tahun Ajaran</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th class="text-center">Aksi</th></tr>
      </thead>
      <tbody>
        <?php
        $q_ta = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran ORDER BY id DESC");
        if ($q_ta && mysqli_num_rows($q_ta) > 0) {
            while ($ta = mysqli_fetch_assoc($q_ta)) {
                echo "<tr>
                        <td class='text-muted'>#{$ta['id']}</td>
                        <td class='fw-semibold'>{$ta['nama']}</td>
                        <td>{$ta['tanggal_mulai']}</td>
                        <td>{$ta['tanggal_selesai']}</td>
                        <td class='text-center'>
                          <a href='tahun_ajaran_edit.php?id={$ta['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                          <a href='tahun_ajaran_hapus.php?id={$ta['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus tahun ajaran ini?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data tahun ajaran</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>