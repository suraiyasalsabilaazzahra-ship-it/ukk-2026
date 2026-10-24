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
                  <th class="py-3">KETERANGAN</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Ambil data langsung dari tabel transaksi tanpa JOIN yang berisiko gagal
                $query_rekap = "SELECT * FROM t_pelanggaran_siswa ORDER BY id DESC";
                $result = mysqli_query($koneksi, $query_rekap);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $tanggal_val = $row['tanggal'] ?? date('Y-m-d');
                        $tanggal_formatted = date('d/m/Y', strtotime($tanggal_val));
                        
                        // 1. Ambil Nama Siswa & NISN
                        $nama_s = !empty($row['nama_siswa']) ? $row['nama_siswa'] : '';
                        $nisn_s = '-';
                        
                        if (empty($nama_s) && !empty($row['siswa_id'])) {
                            $sid = $row['siswa_id'];
                            $q_s = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id = '$sid' LIMIT 1");
                            if ($q_s && $data_s = mysqli_fetch_assoc($q_s)) {
                                $nama_s = $data_s['nama'] ?? 'Siswa Tidak Ditemukan';
                                $nisn_s = $data_s['nisn'] ?? '-';
                            }
                        }
                        if (empty($nama_s)) {
                            $nama_s = 'Siswa Tidak Ditemukan';
                        }

                        // 2. Ambil Jenis Pelanggaran & Poin
                        $nama_p = !empty($row['nama_pelanggaran']) ? $row['nama_pelanggaran'] : '';
                        $poin_p = $row['poin'] ?? 0;

                        if ((empty($nama_p) || $poin_p == 0) && !empty($row['pelanggaran_kategori_id'])) {
                            $kid = $row['pelanggaran_kategori_id'];
                            $q_k = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$kid' LIMIT 1");
                            if ($q_k && $data_k = mysqli_fetch_assoc($q_k)) {
                                if (empty($nama_p)) {
                                    $nama_p = $data_k['nama_kategori'] ?? ($data_k['nama'] ?? 'Pelanggaran Umum');
                                }
                                if ($poin_p == 0) {
                                    $poin_p = $data_k['poin'] ?? 0;
                                }
                            }
                        }
                        if (empty($nama_p)) {
                            $nama_p = 'Pelanggaran Umum';
                        }
                        
                        $ket = !empty($row['keterangan']) ? $row['keterangan'] : '-';
                        
                        echo "<tr>";
                        echo "<td class='text-center fw-semibold text-secondary'>{$no}</td>";
                        echo "<td><i class='bi bi-calendar-event text-muted me-1'></i> {$tanggal_formatted}</td>";
                        echo "<td class='fw-bold text-dark'>" . htmlspecialchars($nama_s) . "</td>";
                        echo "<td><span class='badge bg-light text-dark border'>" . htmlspecialchars($nisn_s) . "</span></td>";
                        echo "<td>" . htmlspecialchars($nama_p) . "</td>";
                        echo "<td class='text-center'><span class='badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1'>+" . htmlspecialchars($poin_p) . "</span></td>";
                        echo "<td class='text-muted small'>" . htmlspecialchars($ket) . "</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center py-4 text-muted'>
                            <i class='bi bi-folder2-open display-6 d-block mb-2'></i>
                            Belum ada data pelanggaran siswa yang tercatat.
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