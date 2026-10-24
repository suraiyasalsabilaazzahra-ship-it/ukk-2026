<?php
// tab_guru.php (Pengelolaan Data Guru & Akun Login)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (file_exists('koneksi.php')) {
    include_once 'koneksi.php';
} elseif (file_exists('../koneksi.php')) {
    include_once '../koneksi.php';
}

$batas = 10; 
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
$cari = isset($_GET['cari_guru']) ? mysqli_real_escape_string($koneksi, $_GET['cari_guru']) : '';
$action = $_GET['action'] ?? '';

// ==========================================
// 1. PROSES TAMBAH GURU & AKUN LOGIN OTOMATIS
// ==========================================
if ($action === 'tambah' && isset($_POST['simpan_guru'])) {
    $nip          = mysqli_real_escape_string($koneksi, $_POST['nip'] ?? '');
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
    $email        = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '123456';
    $status_aktif = $_POST['status_aktif'] ?? '1';

    if (empty($password)) {
        $password = '123456';
    }

    if (strlen($nip) > 18) {
        echo "<script>alert('Gagal: NIP tidak boleh lebih dari 18 digit!'); window.history.back();</script>";
        exit();
    }

    // Cek duplikat email di t_users
    $cek_email = mysqli_query($koneksi, "SELECT * FROM t_users WHERE email = '$email'");
    if ($cek_email && mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Gagal: Email ini sudah terdaftar sebagai akun login!'); window.history.back();</script>";
        exit();
    }

    // Cek kolom tabel t_users secara dinamis (nama atau username)
    $q_col_u = mysqli_query($koneksi, "SHOW COLUMNS FROM t_users");
    $fields_u = [];
    while ($col = mysqli_fetch_assoc($q_col_u)) {
        $fields_u[] = strtolower($col['Field']);
    }
    $nama_col_users = in_array('nama', $fields_u) ? 'nama' : (in_array('username', $fields_u) ? 'username' : 'nama');

    // Buat ID baru untuk t_users
    $q_max_user = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_users");
    $r_max_user = $q_max_user ? mysqli_fetch_assoc($q_max_user) : ['max_id' => 0];
    $new_user_id = ($r_max_user['max_id'] ?? 0) + 1;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query_user = "INSERT INTO t_users (id, {$nama_col_users}, email, password, role) 
                   VALUES ('$new_user_id', '$nama', '$email', '$hashed_password', 'Guru')";
    
    if (mysqli_query($koneksi, $query_user)) {
        // Buat ID baru untuk t_guru
        $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_guru");
        $r_max = $q_max ? mysqli_fetch_assoc($q_max) : ['max_id' => 0];
        $new_id = ($r_max['max_id'] ?? 0) + 1;

        $query_guru = "INSERT INTO t_guru (id, nip, nama, email, status_aktif, user_id) 
                       VALUES ('$new_id', '$nip', '$nama', '$email', '$status_aktif', '$new_user_id')";

        if (mysqli_query($koneksi, $query_guru)) {
            echo "<script>
                    alert('Berhasil! Data guru & akun login baru telah dibuat.'); 
                    window.location.href='dashboard.php?tab=menu2';
                  </script>";
            exit();
        } else {
            $err_guru = mysqli_error($koneksi);
            echo "<script>alert('Gagal menyimpan ke t_guru: " . addslashes($err_guru) . "'); window.history.back();</script>";
            exit();
        }
    } else {
        $err_user = mysqli_error($koneksi);
        echo "<script>alert('Gagal membuat akun di t_users: " . addslashes($err_user) . "'); window.history.back();</script>";
        exit();
    }
}

// ==========================================
// 2. PROSES UPDATE GURU
// ==========================================
if ($action === 'edit' && isset($_POST['update_guru'])) {
    $id_edit      = mysqli_real_escape_string($koneksi, $_GET['id'] ?? '');
    $nip          = mysqli_real_escape_string($koneksi, $_POST['nip'] ?? '');
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
    $email        = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
    $status_aktif = $_POST['status_aktif'] ?? '1';
    $user_id      = $_POST['user_id'] ?? '';

    $query_up = "UPDATE t_guru SET nip='$nip', nama='$nama', email='$email', status_aktif='$status_aktif', user_id='$user_id' WHERE id='$id_edit'";

    if (mysqli_query($koneksi, $query_up)) {
        echo "<script>alert('Data guru berhasil diperbarui!'); window.location.href='dashboard.php?tab=menu2';</script>";
        exit();
    } else {
        $err_up = mysqli_error($koneksi);
        echo "<script>alert('Gagal memperbarui data: " . addslashes($err_up) . "'); window.history.back();</script>";
        exit();
    }
}
?>

<!-- TAMPILAN ANTARMUKA -->
<div class="container-fluid py-2">
  <?php if ($action === 'tambah'): ?>
    <!-- FORM TAMBAH GURU -->
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <form action="dashboard.php?tab=menu2&action=tambah" method="POST">
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
              <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill me-2 text-warning"></i>Tambah Data Guru & Akun Login Baru</h5>
            </div>
            <div class="card-body p-4 bg-white">
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">NIP Guru (Maks. 18 Digit)</label>
                  <input type="text" name="nip" class="form-control" maxlength="18" placeholder="Masukkan NIP (Maks 18 angka)" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Guru" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Email (Untuk Login)</label>
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
                <label class="form-label fw-bold">Password Akun Login Guru</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password (Default: 123456 jika kosong)">
                <small class="text-muted">*Akun login baru akan otomatis terdaftar dan bisa langsung dipakai guru untuk masuk ke sistem.</small>
              </div>

              <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                <a href="dashboard.php?tab=menu2" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" name="simpan_guru" class="btn text-white px-4 fw-bold" style="background-color: #1b263b; border-color: #1b263b;">Simpan & Buat Akun</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  <?php elseif ($action === 'edit'): 
      $id_edit = mysqli_real_escape_string($koneksi, $_GET['id'] ?? '');
      $q_data = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE id = '$id_edit'");
      $data_edit = mysqli_fetch_assoc($q_data);
  ?>
    <!-- FORM EDIT GURU -->
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <form action="dashboard.php?tab=menu2&action=edit&id=<?= $id_edit; ?>" method="POST">
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 100%);">
              <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Guru</h5>
            </div>
            <div class="card-body p-4 bg-white">
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">NIP (Maks. 18 Digit)</label>
                  <input type="text" name="nip" class="form-control" maxlength="18" value="<?= htmlspecialchars($data_edit['nip'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data_edit['nama'] ?? ''); ?>" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data_edit['email'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Status Aktif</label>
                  <select name="status_aktif" class="form-select">
                    <option value="1" <?= (($data_edit['status_aktif'] ?? 1) == 1) ? 'selected' : ''; ?>>Aktif</option>
                    <option value="0" <?= (($data_edit['status_aktif'] ?? 1) == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Akun User Terhubung (t_users)</label>
                <select name="user_id" class="form-select">
                  <?php
                  $q_u = mysqli_query($koneksi, "SELECT * FROM t_users");
                  while ($u = mysqli_fetch_assoc($q_u)) {
                      $selected = ($u['id'] == ($data_edit['user_id'] ?? '')) ? 'selected' : '';
                      $uname = $u['nama'] ?? ($u['username'] ?? 'User');
                      echo "<option value='{$u['id']}' {$selected}>ID: {$u['id']} - {$uname} ({$u['email']})</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                <a href="dashboard.php?tab=menu2" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" name="update_guru" class="btn text-white px-4 fw-bold" style="background-color: #1b263b; border-color: #1b263b;">Simpan Perubahan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  <?php else: 
      // TABEL UTAMA DATA GURU
      if (!empty($cari)) {
          $query_total = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE nama LIKE '%$cari%' OR nip LIKE '%$cari%'");
      } else {
          $query_total = mysqli_query($koneksi, "SELECT * FROM t_guru");
      }

      $total_data = ($query_total) ? mysqli_num_rows($query_total) : 0;
      $total_halaman = ceil($total_data / $batas);
  ?>
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
      <h5 class="fw-bold mb-0 text-dark">
        <i class="bi bi-person-workspace me-2 text-warning"></i>Kelola Data Guru
      </h5>
      <a href="dashboard.php?tab=menu2&action=tambah" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
        <i class="bi bi-plus-lg me-1"></i>Tambah Guru
      </a>
    </div>

    <div class="card-body p-4 bg-white">
      <!-- Pencarian -->
      <div class="card border-0 shadow-sm mb-4 rounded-3 bg-light">
        <div class="card-body p-3">
          <form action="dashboard.php" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="tab" value="menu2"> 
            <div class="col-md-10">
              <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="cari_guru" class="form-control border-start-0 ps-0" placeholder="Cari nama atau NIP guru..." value="<?= htmlspecialchars($cari); ?>">
              </div>
            </div>
            <div class="col-md-2 d-flex gap-2">
              <button type="submit" class="btn w-100 fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">Cari</button>
              <?php if (!empty($cari)): ?>
                <a href="dashboard.php?tab=menu2" class="btn btn-outline-warning text-dark" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>

      <div class="table-responsive rounded-3 overflow-hidden border">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th class="py-3 text-center" style="width: 5%;">NO</th>
              <th class="py-3">NIP</th>
              <th class="py-3">NAMA GURU</th>
              <th class="py-3">EMAIL</th>
              <th class="py-3">STATUS</th>
              <th class="py-3 text-center" style="width: 15%;">AKSI</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($cari)) {
                $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE nama LIKE '%$cari%' OR nip LIKE '%$cari%' ORDER BY id DESC LIMIT $halaman_awal, $batas");
            } else {
                $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY id DESC LIMIT $halaman_awal, $batas");
            }

            if ($q_guru && mysqli_num_rows($q_guru) > 0) {
                $no = $halaman_awal + 1;
                while ($g = mysqli_fetch_assoc($q_guru)) {
                    $status_badge = (($g['status_aktif'] ?? 1) == 1) ? '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Tidak Aktif</span>';
            ?>
                    <tr>
                      <td class="text-center fw-semibold text-secondary"><?= $no; ?></td>
                      <td><?= htmlspecialchars($g['nip'] ?? '-'); ?></td>
                      <td class="fw-bold text-dark"><?= htmlspecialchars($g['nama'] ?? '-'); ?></td>
                      <td><?= htmlspecialchars($g['email'] ?? '-'); ?></td>
                      <td><?= $status_badge; ?></td>
                      <td class="text-center">
                        <a href="dashboard.php?tab=menu2&action=edit&id=<?= $g['id']; ?>" class="btn btn-warning btn-sm text-white px-2 py-1 rounded-2 me-1" title="Edit">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="guru/guru_hapus.php?id=<?= $g['id']; ?>" class="btn btn-danger btn-sm px-2 py-1 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data guru ini?')">
                          <i class="bi bi-trash"></i>
                        </a>
                      </td>
                    </tr>
            <?php
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6' class='text-center py-4 text-muted'>
                        <i class='bi bi-folder2-open display-6 d-block mb-2'></i>
                        Belum ada data guru di database.
                      </td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <?php if ($total_halaman > 1): ?>
      <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <small class="text-muted">
          Menampilkan data ke-<?= ($halaman_awal + 1); ?> sampai <?= min($halaman_awal + $batas, $total_data); ?> dari total <?= $total_data; ?> data
        </small>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item <?= ($halaman <= 1) ? 'disabled' : ''; ?>">
              <a class="page-link" href="dashboard.php?tab=menu2&halaman=<?= $halaman - 1; ?><?= !empty($cari) ? '&cari_guru='.$cari : ''; ?>">Sebelumnya</a>
            </li>
            <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
              <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
                <a class="page-link" style="<?= ($halaman == $x) ? 'background-color: #1b263b; color: white;' : ''; ?>" href="dashboard.php?tab=menu2&halaman=<?= $x; ?><?= !empty($cari) ? '&cari_guru='.$cari : ''; ?>"><?= $x; ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
              <a class="page-link" href="dashboard.php?tab=menu2&halaman=<?= $halaman + 1; ?><?= !empty($cari) ? '&cari_guru='.$cari : ''; ?>">Lanjutkan</a>
            </li>
          </ul>
        </nav>
      </div>
      <?php endif; ?>

    </div>
  </div>
  <?php endif; ?>
</div>