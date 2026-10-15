<?php
// File komponen untuk Data Guru / Catat Pelanggaran
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">
      <i class="bi bi-person-workspace me-2 text-danger"></i>
      <?= $role === 'Guru' ? 'Catat Pelanggaran Siswa' : 'Kelola Data Guru '; ?>
    </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="guru_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold">
        <i class="bi bi-plus-lg me-1"></i>Tambah Guru
      </a>
    <?php endif; ?>
  </div>

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
          $no = 1;
          $q_pelanggaran = mysqli_query($koneksi, "
            SELECT s.nama, p.nama as nama_pelanggaran, p.poin 
            FROM t_pelanggaran_siswa ps
            JOIN t_siswa s ON ps.siswa_id = s.id
            JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
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
          $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY id DESC");
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
                            <a href='guru_edit.php?id={$g['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                            <a href='guru_hapus.php?id={$g['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data guru di database</td></tr>";
          }
          ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>