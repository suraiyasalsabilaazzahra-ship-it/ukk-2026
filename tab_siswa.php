<?php
// File komponen untuk Data Siswa
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">
      <i class="bi bi-people me-2 text-danger"></i>Data Siswa 
    </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="siswa_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold">
        <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
      </a>
    <?php endif; ?>
  </div>

  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th width="8%">ID</th>
          <th width="20%">NISN</th>
          <th>Nama Siswa</th>
          <th width="15%" class="text-center">L/P</th>
          <th width="15%" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $q_sis = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY id DESC");
        if ($q_sis && mysqli_num_rows($q_sis) > 0) {
            while ($s = mysqli_fetch_assoc($q_sis)) {
                $jk_badge = ($s['jenis_kelamin'] == 'L') ? '<span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Laki-Laki</span>' : '<span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Perempuan</span>';
                echo "<tr>
                        <td class='text-muted'>#{$s['id']}</td>
                        <td>{$s['nisn']}</td>
                        <td class='fw-semibold'>{$s['nama']}</td>
                        <td class='text-center'>{$jk_badge}</td>
                        <td class='text-center'>
                          <a href='siswa_edit.php?id={$s['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                          <a href='siswa_hapus.php?id={$s['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus siswa ini?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data siswa</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>