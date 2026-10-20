<?php
session_start();
include '../koneksi.php';

// Perbaikan: Jika belum login, arahkan ke login.php
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

$error = "";

if (isset($_POST['simpan'])) {
    $guru_id         = $_POST['guru_id'];
    $kelas_id        = $_POST['kelas_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $status_aktif    = $_POST['status_aktif'];

    if (!empty($guru_id) && !empty($kelas_id) && !empty($tahun_ajaran_id)) {
        
        // Opsional: Hitung ID manual jika tabel t_wali_kelas tidak menggunakan AUTO_INCREMENT
        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_wali_kelas");
        $r_max = mysqli_fetch_assoc($q_max);
        $new_id = ($r_max['max_id'] ?? 0) + 1;

        $query = "INSERT INTO t_wali_kelas (id, guru_id, kelas_id, tahun_ajaran_id, status_aktif) VALUES ('$new_id', '$guru_id', '$kelas_id', '$tahun_ajaran_id', '$status_aktif')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            header("Location: ../dashboard.php?tab=menu8");
            exit();
        } else {
            $error = "Gagal menyimpan data wali kelas: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Wali Kelas - UKK 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .card-form {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .btn-maroon {
            background-color: #1b263b;
            color: #fff;
            border: none;
        }

        .btn-maroon:hover {
            background-color: #0d1b2a;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-form p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-person-bounding-box text-warning me-2"></i>Tambah Wali Kelas</h4>
                        <!-- Perbaikan arah kembali ke tab=menu8 -->
                        <a href="dashboard.php?tab=menu8" class="btn btn-outline-secondary btn-sm rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2"><?= $error; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Pilih Guru (Wali Kelas)</label>
                            <select name="guru_id" class="form-select" required>
                                <option value="">-- Pilih Guru --</option>
                                <?php
                                $q_g = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY nama ASC");
                                while ($g = mysqli_fetch_assoc($q_g)) {
                                    echo "<option value='{$g['id']}'>{$g['nama']} (NIP: {$g['nip']})</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Pilih Kelas Binaan</label>
                            <select name="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php
                                $q_k = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY nama ASC");
                                while ($k = mysqli_fetch_assoc($q_k)) {
                                    $nm_kls = $k['nama'] ?? $k['nama_kelas'] ?? '-';
                                    echo "<option value='{$k['id']}'>{$nm_kls} (Tingkat {$k['tingkat']})</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                <?php
                               $q_ta = mysqli_query($koneksi, "SELECT * FROM t_tahun_ajaran WHERE nama LIKE '%2025%' OR nama LIKE '%2026%' OR nama LIKE '%2027%' ORDER BY id DESC");
                                while ($ta = mysqli_fetch_assoc($q_ta)) {
                                    echo "<option value='{$ta['id']}'>{$ta['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>

                        <button type="submit" name="simpan" class="btn btn-maroon w-100 py-2 fw-semibold rounded-pill">Simpan Wali Kelas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>