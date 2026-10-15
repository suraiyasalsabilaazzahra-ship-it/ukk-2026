<?php
// File komponen untuk Data Kelas
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">
      <i class="bi bi-building me-2 text-danger"></i>Data Kelas
    </h5>
    <?php if ($role !== 'Guru'): ?>
      <a href="kelas_tambah.php" class="btn btn-maroon btn-sm px-3 rounded-pill fw-semibold">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kelas
      </a>
    <?php endif; ?>
  </div>

  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th width="10%">ID</th>
          <th>Nama Kelas</th>
          <th width="15%">Tingkat</th>
          <th width="20%">Jurusan</th>
          <th width="15%" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $q_kls = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY id DESC");
        if ($q_kls && mysqli_num_rows($q_kls) > 0) {
            while ($k = mysqli_fetch_assoc($q_kls)) {
                $nama_kelas = $k['nama'] ?? $k['nama_kelas'] ?? '-';
                echo "<tr>
                        <td class='text-muted'>#{$k['id']}</td>
                        <td class='fw-semibold'>{$nama_kelas}</td>
                        <td><span class='badge bg-light text-dark border'>Tingkat {$k['tingkat']}</span></td>
                        <td>{$k['jurusan']}</td>
                        <td class='text-center'>
                          <a href='kelas_edit.php?id={$k['id']}' class='btn btn-warning btn-sm py-1 px-2 rounded-2 me-1'>Edit</a>
                          <a href='kelas_hapus.php?id={$k['id']}' class='btn btn-danger btn-sm py-1 px-2 rounded-2' onclick='return confirm(\"Hapus kelas ini?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data kelas</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>