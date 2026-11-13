<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

$msg_error = "";
$nama_guru_login = $_SESSION['nama'] ?? 'Guru Pengajar';

// Proses Simpan Data
if (isset($_POST['btn_simpan_pelanggaran_guru'])) {
    $siswa_id        = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $kategori_id     = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
    $tanggal         = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
    $bentuk_tindakan = mysqli_real_escape_string($koneksi, $_POST['bentuk_tindakan'] ?? '');
    $keterangan      = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

    if (!empty($siswa_id) && !empty($kategori_id) && !empty($bentuk_tindakan)) {
        // Ambil data siswa
        $q_s = mysqli_query($koneksi, "SELECT * FROM t_siswa WHERE id = '$siswa_id' LIMIT 1");
        $d_s = mysqli_fetch_assoc($q_s);
        $nama_siswa  = $d_s['nama'] ?? 'Siswa';
        $raw_kelas_id = $d_s['kelas_id'] ?? 1;
        $kelas_siswa = $d_s['kelas'] ?? '-';

        // Validasi kelas_id agar aman dari Foreign Key Error
        $q_cek_kelas = mysqli_query($koneksi, "SELECT id, nama FROM t_kelas WHERE id = '$raw_kelas_id' LIMIT 1");
        if ($q_cek_kelas && mysqli_num_rows($q_cek_kelas) > 0) {
            $d_ck = mysqli_fetch_assoc($q_cek_kelas);
            $kelas_id = $d_ck['id'];
            if (!empty($d_ck['nama'])) {
                $kelas_siswa = $d_ck['nama'];
            }
        } else {
            // Ambil kelas pertama yang valid jika kelas_id siswa 0 / tidak ditemukan
            $q_def_kelas = mysqli_query($koneksi, "SELECT id, nama FROM t_kelas LIMIT 1");
            if ($d_def = mysqli_fetch_assoc($q_def_kelas)) {
                $kelas_id = $d_def['id'];
                $kelas_siswa = $d_def['nama'];
            } else {
                $kelas_id = 1;
            }
        }

        // Ambil data kategori pelanggaran & poin
        $q_k = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = '$kategori_id' LIMIT 1");
        $d_k = mysqli_fetch_assoc($q_k);
        $nama_pelanggaran = $d_k['nama'] ?? 'Pelanggaran';
        $poin_val = (int)($d_k['poin'] ?? 0);

        // Simpan ke t_pelanggaran_siswa (Tanpa mengisi id secara manual agar menggunakan auto_increment)
        $query_insert = "INSERT INTO t_pelanggaran_siswa 
                         (siswa_id, nama_siswa, kelas_id, nama_kelas, pelanggaran_kategori_id, nama_pelanggaran, nama_guru, tanggal, keterangan, poin, tindakan, status) 
                         VALUES 
                         ('$siswa_id', '$nama_siswa', '$kelas_id', '$kelas_siswa', '$kategori_id', '$nama_pelanggaran', '$nama_guru_login', '$tanggal', '$keterangan', '$poin_val', '$bentuk_tindakan', 'Aktif')";

        $exec = mysqli_query($koneksi, $query_insert);

        if ($exec) {
            $pelanggaran_siswa_id = mysqli_insert_id($koneksi);

            // Simpan ke t_tindakan
            @mysqli_query($koneksi, "INSERT INTO t_tindakan 
                                     (siswa_id, pelanggaran_siswa_id, bentuk_tindakan, tanggal_tindakan, status_penyelesaian) 
                                     VALUES 
                                     ('$siswa_id', '$pelanggaran_siswa_id', '$bentuk_tindakan', '$tanggal', 'Diproses')");

            echo "<script>
                    alert('Berhasil! Pelanggaran dan tindakan berhasil disimpan.');
                    window.location.href = 'dashboard.php?tab=menu2';
                  </script>";
            exit();
        } else {
            $msg_error = "Gagal Simpan ke Database: " . mysqli_error($koneksi);
        }
    } else {
        $msg_error = "Mohon lengkapi Siswa, Kategori Pelanggaran, dan Bentuk Tindakan!";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="container-fluid px-3 pb-5">
    <?php if (!empty($msg_error)): ?>
        <div class="alert alert-danger shadow-sm mb-3"><?= $msg_error; ?></div>
    <?php endif; ?>

    <!-- FORM INPUT -->
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
            <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran & Tindakan Siswa</h5>
        </div>
        <div class="card-body p-4 bg-white">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" id="searchSiswa" class="form-select py-2" required>
                        <option value="">-- Ketik atau Pilih Nama Siswa --</option>
                        <?php
                        $q_siswa = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY nama ASC");
                        if ($q_siswa) {
                            while ($s = mysqli_fetch_assoc($q_siswa)) {
                                echo "<option value='{$s['id']}'>" . htmlspecialchars($s['nama']) . " (Kelas: " . htmlspecialchars($s['kelas'] ?? '-') . ")</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori Pelanggaran <span class="text-danger">*</span></label>
                    <select name="kategori_id" id="pilihKategori" class="form-select py-2" required onchange="updatePoinInfo(this)">
                        <option value="">-- Pilih Jenis Pelanggaran --</option>
                        <?php
                        $q_kat = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC");
                        if ($q_kat) {
                            while ($k = mysqli_fetch_assoc($q_kat)) {
                                $nama_k = $k['nama'] ?? 'Pelanggaran';
                                $poin_k = (int)($k['poin'] ?? 0);
                                echo "<option value='{$k['id']}' data-poin='{$poin_k}'>" . htmlspecialchars($nama_k) . " (+{$poin_k} Poin)</option>";
                            }
                        }
                        ?>
                    </select>
                    <small class="text-muted mt-1 d-block">Poin otomatis: <span id="infoPoin" class="fw-bold text-danger">0 Poin</span></small>
                </div>

                <!-- BENTUK TINDAKAN DIKETIK BEBAS -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Bentuk Tindakan / Sanksi <span class="text-danger">*</span></label>
                    <input type="text" name="bentuk_tindakan" class="form-control py-2" placeholder="Ketik bentuk tindakan / sanksi di sini..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Kejadian <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control py-2" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Keterangan / Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan rincian tambahan jika ada..."></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                    <button type="submit" name="btn_simpan_pelanggaran_guru" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Pelanggaran & Tindakan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL RIWAYAT / REKAP -->
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-list-check text-primary me-2"></i>Daftar Riwayat Pelanggaran & Tindakan</h5>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">Data Lengkap</span>
        </div>
        <div class="card-body p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead style="background-color: #1b263b; color: white;">
                        <tr>
                            <th class="py-3 text-center" style="width: 5%;">NO</th>
                            <th class="py-3">TANGGAL</th>
                            <th class="py-3">SISWA</th>
                            <th class="py-3">KELAS</th>
                            <th class="py-3">JENIS PELANGGARAN</th>
                            <th class="py-3">BENTUK TINDAKAN</th>
                            <th class="py-3 text-center">POIN</th>
                            <th class="py-3">GURU PENCATAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_riwayat = "SELECT ps.*, 
                                                 s.nama AS s_nama, 
                                                 s.kelas AS s_kelas, 
                                                 k.nama AS k_nama, 
                                                 t.bentuk_tindakan AS t_bentuk
                                          FROM t_pelanggaran_siswa ps
                                          LEFT JOIN t_siswa s ON ps.siswa_id = s.id
                                          LEFT JOIN t_pelanggaran_kategori k ON ps.pelanggaran_kategori_id = k.id
                                          LEFT JOIN t_tindakan t ON t.pelanggaran_siswa_id = ps.id
                                          ORDER BY ps.id DESC";

                        $res_riwayat = mysqli_query($koneksi, $query_riwayat);

                        if ($res_riwayat && mysqli_num_rows($res_riwayat) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($res_riwayat)) {
                                $tgl = date('d/m/Y', strtotime($row['tanggal'] ?? date('Y-m-d')));
                                $nama_siswa = !empty($row['s_nama']) ? $row['s_nama'] : ($row['nama_siswa'] ?? 'Siswa');
                                $kelas_siswa = !empty($row['s_kelas']) ? $row['s_kelas'] : ($row['nama_kelas'] ?? '-');
                                $nama_kat = !empty($row['k_nama']) ? $row['k_nama'] : ($row['nama_pelanggaran'] ?? 'Pelanggaran');
                                $bentuk_tindakan = !empty($row['t_bentuk']) ? $row['t_bentuk'] : ($row['tindakan'] ?? '-');
                                $poin = $row['poin'] ?? 0;
                                $nama_guru = $row['nama_guru'] ?? $nama_guru_login;

                                echo "<tr>";
                                echo "<td class='text-center fw-semibold text-secondary'>{$no}</td>";
                                echo "<td><i class='bi bi-calendar-event text-muted me-1'></i> {$tgl}</td>";
                                echo "<td class='fw-bold text-dark'>" . htmlspecialchars($nama_siswa) . "</td>";
                                echo "<td>" . htmlspecialchars($kelas_siswa) . "</td>";
                                echo "<td>" . htmlspecialchars($nama_kat) . "</td>";
                                echo "<td>" . htmlspecialchars($bentuk_tindakan) . "</td>";
                                echo "<td class='text-center'><span class='badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1'>+" . htmlspecialchars($poin) . "</span></td>";
                                echo "<td>" . htmlspecialchars($nama_guru) . "</td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center py-4 text-muted'><i class='bi bi-folder2-open display-6 d-block mb-2'></i>Belum ada data catatan pelanggaran.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchSiswa').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Ketik atau Pilih Nama Siswa --',
            allowClear: true
        });
    });

    function updatePoinInfo(selectObj) {
        let selectedOption = selectObj.options[selectObj.selectedIndex];
        let poin = selectedOption.getAttribute('data-poin') || 0;
        document.getElementById('infoPoin').innerText = poin + ' Poin';
    }
</script>