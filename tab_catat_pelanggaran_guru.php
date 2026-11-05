<?php
// tab_catat_pelanggaran_guru.php - Khusus Form Catat Pelanggaran oleh Guru
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
    $siswa_id    = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $kategori_id = mysqli_real_escape_string($koneksi, $_POST['kategori_id'] ?? '');
    $tanggal     = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
    $keterangan  = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

    if (!empty($siswa_id) && !empty($kategori_id) && !empty($tanggal)) {
        // Ambil poin otomatis dari t_pelanggaran_kategori
        $q_get_poin = mysqli_query($koneksi, "SELECT poin FROM t_pelanggaran_kategori WHERE id = '$kategori_id' LIMIT 1");
        $d_poin = mysqli_fetch_assoc($q_get_poin);
        $poin_val = $d_poin['poin'] ?? 0;

        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_pelanggaran_siswa");
        $r_max = ($q_max) ? mysqli_fetch_assoc($q_max) : ['max_id' => 0];
        $next_id = ($r_max['max_id'] ?? 0) + 1;

        $query_insert = "INSERT INTO t_pelanggaran_siswa (id, siswa_id, pelanggaran_kategori_id, poin, tanggal, keterangan) 
                         VALUES ('$next_id', '$siswa_id', '$kategori_id', '$poin_val', '$tanggal', '$keterangan')";

        $exec = mysqli_query($koneksi, $query_insert);
        if ($exec) {
            echo "<script>
                    alert('Berhasil! Data pelanggaran siswa telah dicatat dan disinkronkan ke sistem.');
                    window.location.href = 'dashboard.php?tab=menu2';
                  </script>";
            exit();
        } else {
            $msg_error = "Gagal Simpan: " . mysqli_error($koneksi);
        }
    } else {
        $msg_error = "Mohon lengkapi Siswa, Kategori Pelanggaran, dan Tanggal!";
    }
}
?>

<div class="container-fluid px-0">
    <?php if (!empty($msg_error)): ?>
        <div class="alert alert-danger shadow-sm mb-3"><?= $msg_error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden w-100">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catat Pelanggaran Siswa (Guru)</h5>
            </div>
            <div class="card-body p-4 bg-white">

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" class="form-select py-2" required>
                        <option value="">-- Pilih Siswa --</option>
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
                    <label class="form-label fw-bold">Kategori Pelanggaran (Poin Otomatis) <span class="text-danger">*</span></label>
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
                    <small class="text-muted mt-1 d-block">Poin akan otomatis terisi berdasarkan kategori yang dipilih: <span id="infoPoin" class="fw-bold text-danger">0 Poin</span></small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Kejadian <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control py-2" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Keterangan / Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan rincian pelanggaran..."></textarea>
                </div>

                <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                    <button type="submit" name="btn_simpan_pelanggaran_guru" class="btn text-white px-4 fw-bold" style="background-color: #1b263b;">Simpan Pelanggaran</button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function updatePoinInfo(selectObj) {
        let selectedOption = selectObj.options[selectObj.selectedIndex];
        let poin = selectedOption.getAttribute('data-poin') || 0;
        document.getElementById('infoPoin').innerText = poin + ' Poin';
    }
</script>