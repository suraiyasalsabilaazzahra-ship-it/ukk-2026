<?php
session_start();
include '../koneksi.php';

// Proteksi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:../login.php");
    exit();
}

// Proses Tambah Data Guru
if (isset($_POST['simpan'])) {
    $nip          = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $status_aktif = $_POST['status_aktif'];
    $user_id      = $_POST['user_id'] ?? '';

    // 1. CARI ID TERBESAR AGAR TIDAK DUPLICATE ENTRY '0'
    $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_guru");
    $r_max = mysqli_fetch_assoc($q_max);
    $new_id = ($r_max['max_id'] ?? 0) + 1; // ID baru = ID tertinggi + 1

    // 2. CEK USER_ID AGAR TIDAK NULL
    if (empty($user_id)) {
        $q_get_user = mysqli_query($koneksi, "SELECT id FROM t_users ORDER BY id ASC LIMIT 1");
        if ($row_user = mysqli_fetch_assoc($q_get_user)) {
            $user_id = $row_user['id'];
        } else {
            $user_id = 1;
        }
    }

    // 3. INSERT DENGAN ID MANUAL YANG SUDAH DIHITUNG
    $query = "INSERT INTO t_guru (id, nip, nama, email, status_aktif, user_id) 
              VALUES ('$new_id', '$nip', '$nama', '$email', '$status_aktif', '$user_id')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Berhasil! Data guru baru telah ditambahkan.'); 
                window.location.href='../dashboard.php?tab=menu2';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menambah data guru: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Guru - UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

  <div class="container" style="max-width: 850px;">
    
    <form action="" method="POST">
      <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        
        <!-- HEADER KARTU -->
        <div class="card-header text-white p-3" style="background-color: #1b263b;">
          <h5 class="mb-0 fw-bold">Tambah Data Guru Baru</h5>
        </div>

        <!-- ISI FORM -->
        <div class="card-body p-4 bg-white">
          
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">NIP Guru</label>
              <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Guru" required>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Email</label>
              <input type="email" name="email" class="form-control" placeholder="contoh@sekolah.sch.id" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Status Aktif</label>
              <select name="status_aktif" class="form-select" required>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Pilih Akun User (Tabel t_users)</label>
            <select name="user_id" class="form-select">
              <option value="">-- Hubungkan Otomatis ke User Default --</option>
              <?php
              $q_user = mysqli_query($koneksi, "SELECT id, email FROM t_users");
              if ($q_user && mysqli_num_rows($q_user) > 0) {
                  while ($u = mysqli_fetch_assoc($q_user)) {
                      echo "<option value='{$u['id']}'>ID: {$u['id']} - {$u['email']}</option>";
                  }
              }
              ?>
            </select>
            <small class="text-muted fs-7">*Kamu bisa pilih akun user yang ada atau biarkan otomatis.</small>
          </div>

          <!-- TOMBOL AKSI UTAMA -->
          <div class="pt-3 border-top d-flex gap-2 justify-content-end">
          <a href="../dashboard.php?tab=menu2" class="btn btn-secondary">Batal</a>
            <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #1b263b; border-color: #1b263b;">
              Simpan Data Guru
            </button>
          </div>

        </div>

      </div>
    </form>

  </div>

</body>
</html>