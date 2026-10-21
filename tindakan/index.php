<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (file_exists('koneksi.php')) {
    include 'koneksi.php';
} elseif (file_exists('../koneksi.php')) {
    include '../koneksi.php';
} else {
    include '../../koneksi.php';
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!-- Tambahkan style margin-top agar konten tidak tertutup header dashboard -->
<div class="container-fluid px-4 py-3" style="margin-top: 20px;">
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
              <thead class="table-light text-secondary small text-uppercase">
                <tr>
                  <th class="py-3 text-center" style="width: 5%;">No</th>
                  <th class="py-3">Tanggal</th>
                  <th class="py-3">Nama Siswa</th>
                  <th class="py-3">NISN</th>
                  <th class="py-3">Jenis Pelanggaran</th>
                  <th class="py-3 text-center">Poin</th>
                  <th class="py-3">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query_rekap = "SELECT ts.*, 
                                       s.nama AS s_nama, 
                                       s.nisn AS s_nisn, 
                                       k.nama AS k_nama
                                FROM t_pelanggaran_siswa ts
                                LEFT JOIN t_siswa s ON ts.siswa_id = s.id
                                LEFT JOIN t_pelanggaran_kategori k ON ts.pelanggaran_kategori_id = k.id OR ts.pelanggaran_id = k.id
                                ORDER BY ts.id DESC";
                
                $result = mysqli_query($koneksi, $query_rekap);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $tanggal_val = $row['tanggal'] ?? date('Y-m-d');
                        $tanggal_formatted = date('d/m/Y', strtotime($tanggal_val));
                        
                        $nama_s = $row['s_nama'] ?? 'Siswa Tidak Ditemukan';
                        $nisn_s = $row['s_nisn'] ?? '-';
                        $nama_p = $row['k_nama'] ?? 'Pelanggaran Umum';
                        
                        $poin_p = $row['poin'] ?? ($row['jumlah_poin'] ?? 10);
                        $ket    = $row['keterangan'] ?? '-';
                        
                        echo "<tr>";
                        echo "<td class='text-center fw-semibold text-secondary'>{$no}</td>";
                        echo "<td><i class='bi bi-calendar-event text-muted me-1'></i> {$tanggal_formatted}</td>";
                        echo "<td class='fw-bold text-dark'>" . htmlspecialchars($nama_s) . "</td>";
                        echo "<td><span class='badge bg-light text-dark border'>" . htmlspecialchars($nisn_s) . "</span></td>";
                        echo "<td>" . htmlspecialchars($nama_p) . "</td>";
                        echo "<td class='text-center'><span class='badge bg-danger px-2 py-1'>+" . htmlspecialchars($poin_p) . "</span></td>";
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