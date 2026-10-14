<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'] ?? '';
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM t_guru WHERE id='$id'"));

if (!$data) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['update'])) {
    $nip          = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $status_aktif = $_POST['status_aktif'];
    $user_id      = $_POST['user_id'];

    $query = "UPDATE t_guru SET nip='$nip', nama='$nama', email='$email', status_aktif='$status_aktif', user_id='$user_id', updated_at=NOW() WHERE id='$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data guru berhasil diperbarui!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Guru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
  <div class="container style="max-width: 600px;">
    <div class="card shadow-sm border-0">
      <div class="card-header text-white fw-bold" style="background-color: #8b0000;">
        Edit Data Guru
      </div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control" value="<?= $data['nip']; ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data['email']; ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status Aktif</label>
            <select name="status_aktif" class="form-select">
              <option value="1" <?= $data['status_aktif'] == 1 ? 'selected' : ''; ?>>Aktif</option>
              <option value="0" <?= $data['status_aktif'] == 0 ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Akun User (t_users)</label>
            <select name="user_id" class="form-select">
              <?php
              $q_u = mysqli_query($koneksi, "SELECT * FROM t_users");
              while ($u = mysqli_fetch_assoc($q_u)) {
                  $selected = ($u['id'] == $data['user_id']) ? 'selected' : '';
                  echo "<option value='{$u['id']}' {$selected}>{$u['id']} - {$u['nama']}</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" name="update" class="btn btn-danger">Simpan Perubahan</button>
          <a href="dashboard.php" class="btn btn-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>