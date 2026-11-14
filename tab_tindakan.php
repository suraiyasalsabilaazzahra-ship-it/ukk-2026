<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (file_exists('koneksi.php')) {
  include_once 'koneksi.php';
} elseif (file_exists('../koneksi.php')) {
  include_once '../koneksi.php';
}
?>

<div class="container-fluid py-2">
  <div class="row">
    <div class="col-12">

      <!-- Header Kartu -->
      <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
          <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-shield-exclamation text-danger me-2"></i>Rekap Data Pelanggaran & Tindakan Siswa
          </h5>
          <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold border border-danger border-opacity-25">
            <i class="bi bi-list-check me-1"></i> Data Riwayat Sanksi
          </span>
        </div>

        <div class="card-body p-4 bg-white">
          <div class="table-responsive">
            <table class="table table-hover align-middle border">
              <thead style="background-color: #1b263b; color: white;">
                <tr>
                  <th class="py-3 text-center" style="width: 5%;">NO</th>
                  <th class="py-3">TANGGAL</th>
                  <th class="py-3">NAMA SISWA</th>
                  <th class="py-3">NISN</th>
                  <th class="py-3">JENIS PELANGGARAN</th>
                  <th class="py-3 text-center">POIN</th>
                  <th class="py-3">BENTUK TINDAKAN</th>
                  <th class="py-3">KETERANGAN</th>
                  <th class="py-3 text-center" style="width: 12%;">AKSI</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query_rekap = "SELECT ps.*, 
                                       s.nama AS s_nama, 
                                       s.nisn AS s_nisn,
                                       t.bentuk_tindakan AS t_bentuk,
                                       t.status_penyelesaian AS t_status
                                FROM t_pelanggaran_siswa ps
                                LEFT JOIN t_siswa s ON ps.siswa_id = s.id
                                LEFT JOIN t_tindakan t ON t.pelanggaran_siswa_id = ps.id
                                ORDER BY ps.id DESC";

                $result = mysqli_query($koneksi, $query_rekap);

                if ($result && mysqli_num_rows($result) > 0) {
                  $no = 1;
                  while ($row = mysqli_fetch_assoc($result)) {
                    $tanggal_val = $row['tanggal'] ?? date('Y-m-d');
                    $tanggal_formatted = date('d/m/Y', strtotime($tanggal_val));

                    $nama_s = !empty($row['s_nama']) ? $row['s_nama'] : (!empty($row['nama_siswa']) ? $row['nama_siswa'] : 'Siswa Tidak Ditemukan');
                    $nisn_s = !empty($row['s_nisn']) ? $row['s_nisn'] : '-';
                    $nama_p = !empty($row['nama_pelanggaran']) ? $row['nama_pelanggaran'] : 'Pelanggaran Umum';
                    $poin_p = $row['poin'] ?? 0;

                    if (!empty($row['t_bentuk'])) {
                      $tindakan_display = "<span class='badge bg-warning bg-opacity-10 text-dark border border-warning px-2 py-1'><i class='bi bi-clock-history me-1'></i>" . htmlspecialchars($row['t_bentuk']) . "</span>";
                    } else {
                      $tindakan_display = "<span class='badge bg-light text-secondary border'><i class='bi bi-info-circle me-1'></i>Belum ada tindakan</span>";
                    }

                    $ket = !empty($row['keterangan']) ? $row['keterangan'] : '-';
                    $id_pelanggaran = $row['id'];

                    echo "<tr>";
                    echo "<td class='text-center fw-semibold text-secondary'>{$no}</td>";
                    echo "<td><i class='bi bi-calendar-event text-muted me-1'></i> {$tanggal_formatted}</td>";
                    echo "<td class='fw-bold text-dark'>" . htmlspecialchars($nama_s) . "</td>";
                    echo "<td><span class='badge bg-light text-dark border'>" . htmlspecialchars($nisn_s) . "</span></td>";
                    echo "<td>" . htmlspecialchars($nama_p) . "</td>";
                    echo "<td class='text-center'><span class='badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1'>+" . htmlspecialchars($poin_p) . "</span></td>";
                    echo "<td>{$tindakan_display}</td>";
                    echo "<td class='text-muted small'>" . htmlspecialchars($ket) . "</td>";
                    echo "<td class='text-center'>
                            <a href='tindakan/tindakan_edit.php?id={$id_pelanggaran}' class='btn btn-sm btn-warning text-white px-2 py-1 fw-semibold'>
                              <i class='bi bi-pencil-square me-1'></i>Atur Tindakan
                            </a>
                          </td>";
                    echo "</tr>";
                    $no++;
                  }
                } else {
                  echo "<tr><td colspan='9' class='text-center py-4 text-muted'>
                            <i class='bi bi-folder2-open display-6 d-block mb-2'></i>
                            Belum ada data pelanggaran dan tindakan siswa yang tercatat.
                          </td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>