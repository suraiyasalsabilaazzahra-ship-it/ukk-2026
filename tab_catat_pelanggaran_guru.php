<?php
// tab_catat_pelanggaran_guru.php - Form Catat Pelanggaran & Tindakan oleh Guru
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'] ?? 'Guru';
$msg_error = "";

if (isset($_POST['btn_simpan_pelanggaran_guru'])) {
    $siswa_id        = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $kategori_id     = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
    $tanggal         = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
    $bentuk_tindakan = mysqli_real_escape_string($koneksi, $_POST['bentuk_tindakan'] ?? '');
    $keterangan      = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

    if (!empty($siswa_id) && !empty($kategori_id) && !empty($tanggal) && !empty($bentuk_tindakan)) {
        // 1. Ambil poin otomatis dari t_pelanggaran_kategori
        $q_get_poin = mysqli_query($koneksi, "SELECT poin FROM t_pelanggaran_kategori WHERE id = '$kategori_id' LIMIT 1");
        $d_poin = mysqli_fetch_assoc($q_get_poin);
        $poin_val = $d_poin['poin'] ?? 0;

        // 2. Simpan ke t_pelanggaran_siswa
        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_pelanggaran_siswa");
        $r_max = ($q_max) ? mysqli_fetch_assoc($q_max) : ['max_id' => 0];
        $next_id = ($r_max['max_id'] ?? 0) + 1;

        $query_insert = "INSERT INTO t_pelanggaran_siswa (id, siswa_id, pelanggaran_kategori_id, poin, tanggal, keterangan) 
                         VALUES ('$next_id', '$siswa_id', '$kategori_id', '$poin_val', '$tanggal', '$keterangan')";

        $exec = mysqli_query($koneksi, $query_insert);

        if ($exec) {
            // 3. Simpan ke t_tindakan
            $q_max_t = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_tindakan");
            $r_max_t = ($q_max_t) ? mysqli_fetch_assoc($q_max_t) : ['max_id' => 0];
            $next_id_t = ($r_max_t['max_id'] ?? 0) + 1;

            mysqli_query($koneksi, "INSERT INTO t_tindakan (id, pelanggaran_siswa_id, bentuk_tindakan, tanggal_tindakan, status_penyelesaian) 
                                    VALUES ('$next_id_t', '$next_id', '$bentuk_tindakan', '$tanggal', 'Diproses')");

            echo "<script>
                    alert('Berhasil! Pelanggaran dan sanksi tindakan siswa telah dicatat.');
                    window.location.href = 'dashboard.php?tab=menu2';
                  </script>";
            exit();
        } else {
            $msg_error = "Gagal Simpan: " . mysqli_error($koneksi);
        }
    } else {
        $msg_error = "Mohon lengkapi Siswa, Kategori Pelanggaran, Tanggal, dan Bentuk Tindakan!";
    }
}
?>

<!-- Tambahkan CSS & JS Select2 untuk Fitur Cari Nama -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="container-fluid px-0">
    <?php if (!empty($msg_error)): ?>
        <div class="alert alert-danger shadow-sm mb-3"><?= $msg_error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden w-100">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran & Tindakan Siswa (Guru)</h5>
            </div>
            <div class="card-body p-4 bg-white">

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                    <!-- Tambahkan class 'search-siswa' untuk mengaktifkan select2 -->
                    <select name="siswa_id" id="searchSiswa" class="form-select py-2" required>
                        <option value="">-- Ketik atau Pilih Nama Siswa --</option>
                        <?php
                        $q_siswa = mysqli_query($koneksi, "SELECT * FROM t_siswa ORDER BY nama ASC");
                        if ($q_siswa) {
                            while ($s = mysqli_fetch_assoc($q_siswa)) {
                                echo "<option value='{$s['id']}'>" . htmlspecialchars($s['nama']) . " (Kelas: " . htmlspecialchars($s['kelas'] ?? '-') . " - NISN: " . htmlspecialchars($s['nisn'] ?? '-') . ")</option>";
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
                                $nama_k = !empty($k['nama']) ? $k['nama'] : ($k['nama_kategori'] ?? 'Kategori Pelanggaran');
                                $poin_k = (int)($k['poin'] ?? 0);
                                echo "<option value='{$k['id']}' data-poin='{$poin_k}'>" . htmlspecialchars($nama_k) . " (+{$poin_k} Poin)</option>";
                            }
                        }
                        ?>
                    </select>
                    <small class="text-muted mt-1 d-block">Poin otomatis: <span id="infoPoin" class="fw-bold text-danger">0 Poin</span></small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Bentuk Tindakan / Sanksi <span class="text-danger">*</span></label>
                    <select name="bentuk_tindakan" class="form-select py-2" required>
                        <option value="">-- Pilih Bentuk Tindakan --</option>
                        <option value="Menunggu 45 menit di luar kelas sebelum masuk">Menunggu 45 menit di luar kelas sebelum masuk</option>
                        <option value="Membersihkan lingkungan sekolah / halaman">Membersihkan lingkungan sekolah / halaman</option>
                        <option value="Membuat surat pernyataan bermaterai">Membuat surat pernyataan bermaterai</option>
                        <option value="Panggilan orang tua / wali murid ke sekolah">Panggilan orang tua / wali murid ke sekolah</option>
                        <option value="Peringatan lisan dan pembinaan guru BK">Peringatan lisan dan pembinaan guru BK</option>
                    </select>
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

            </div>
        </div>
    </form>
</div>

<!-- Script jQuery & Select2 -->
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