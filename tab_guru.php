<?php
// 1. Konfigurasi Paginasi & Pencarian
$batas = 10; 
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
$cari = isset($_GET['cari_guru']) ? mysqli_real_escape_string($koneksi, $_GET['cari_guru']) : '';

// 2. Tangkap Aksi (tambah / edit / default tampil tabel)
$action = $_GET['action'] ?? '';

if ($action === 'tambah') {
    // ==========================================
    // PROSES & FORM TAMBAH GURU + BUAT AKUN LOGIN OTOMATIS
    // ==========================================
    if (isset($_POST['simpan_guru'])) {
        $nip          = mysqli_real_escape_string($koneksi, $_POST['nip']);
        $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
        $password     = $_POST['password'] ?? '123456';
        $status_aktif = $_POST['status_aktif'];

        // Validasi NIP Maksimal 18 Digit
        if (strlen($nip) > 18) {
            echo "<script>alert('Gagal: NIP tidak boleh lebih dari 18 digit!'); window.history.back();</script>";
            exit();
        }

        // Cek email duplikat di t_users
        $cek_email = mysqli_query($koneksi, "SELECT * FROM t_users WHERE email = '$email'");
        if (mysqli_num_rows($cek_email) > 0) {
            echo "<script>alert('Gagal: Email ini sudah terdaftar sebagai akun login!'); window.history.back();</script>";
            exit();
        }

        // A. Buat akun login baru di t_users secara otomatis
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $q_max_user = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_users");
        $r_max_user = mysqli_fetch_assoc($q_max_user);
        $new_user_id = ($r_max_user['max_id'] ?? 0) + 1;

        $query_user = "INSERT INTO t_users (id, username, email, password, role) 
                       VALUES ('$new_user_id', '$nama', '$email', '$hashed_password', 'Guru')";
        
        if (mysqli_query($koneksi, $query_user)) {
            // B. Buat data guru di t_guru
            $q_max = mysqli_query($koneksi, "SELECT MAX(id) AS max_id FROM t_guru");
            $r_max = mysqli_fetch_assoc($q_max);
            $new_id = ($r_max['max_id'] ?? 0) + 1;

            $query_guru = "INSERT INTO t_guru (id, nip, nama, email, status_aktif, user_id) 
                           VALUES ('$new_id', '$nip', '$nama', '$email', '$status_aktif', '$new_user_id')";

            if (mysqli_query($koneksi, $query_guru)) {
                echo "<script>alert('Berhasil! Data guru & akun login baru telah dibuat.'); window.location.href='dashboard.php?tab=menu2';</script>";
                exit();
            } else {
                echo "<script>alert('Gagal menyimpan data guru: " . mysqli_error($koneksi) . "');</script>";
            }
        } else {
            echo "<script>alert('Gagal membuat akun login: " . mysqli_error($koneksi) . "');</script>";
        }
    }
?>
    <!-- FORM TAMBAH GURU (SIDEBAR AMAN TETAP MUNCUL) -->
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

<?php 
} elseif ($action === 'edit') {
    // ==========================================
    // PROSES & FORM EDIT GURU
    // ==========================================
    $id_edit = mysqli_real_escape_string($koneksi, $_GET['id'] ?? '');
    $q_data = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE id = '$id_edit'");
    $data_edit = mysqli_fetch_assoc($q_data);

    if (!$data_edit) {
        echo "<script>alert('Data guru tidak ditemukan!'); window.location.href='dashboard.php?tab=menu2';</script>";
        exit();
    }

    if (isset($_POST['update_guru'])) {
        $nip          = mysqli_real_escape_string($koneksi, $_POST['nip']);
        $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
        $status_aktif = $_POST['status_aktif'];
        $user_id      = $_POST['user_id'];

        if (strlen($nip) > 18) {
            echo "<script>alert('Gagal: NIP tidak boleh lebih dari 18 digit!'); window.history.back();</script>";
            exit();
        }

        $query_up = "UPDATE t_guru SET nip='$nip', nama='$nama', email='$email', status_aktif='$status_aktif', user_id='$user_id', updated_at=NOW() WHERE id='$id_edit'";

        if (mysqli_query($koneksi, $query_up)) {
            echo "<script>alert('Data guru berhasil diperbarui!'); window.location.href='dashboard.php?tab=menu2';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal memperbarui data: " . mysqli_real_escape_string($koneksi, mysqli_error($koneksi)) . "');</script>";
        }
    }
?>
    <!-- FORM EDIT GURU (SIDEBAR AMAN TETAP MUNCUL) -->
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
                  <input type="text" name="nip" class="form-control" maxlength="18" value="<?= htmlspecialchars($data_edit['nip']); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data_edit['nama']); ?>" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data_edit['email']); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Status Aktif</label>
                  <select name="status_aktif" class="form-select">
                    <option value="1" <?= $data_edit['status_aktif'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                    <option value="0" <?= $data_edit['status_aktif'] == 0 ? 'selected' : ''; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Akun User Terhubung (t_users)</label>
                <select name="user_id" class="form-select">
                  <?php
                  $q_u = mysqli_query($koneksi, "SELECT * FROM t_users");
                  while ($u = mysqli_fetch_assoc($q_u)) {
                      $selected = ($u['id'] == $data_edit['user_id']) ? 'selected' : '';
                      echo "<option value='{$u['id']}' {$selected}>ID: {$u['id']} - {$u['username']} ({$u['email']})</option>";
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

<?php 
} else {
    // ==========================================
    // TAMPILAN UTAMA TABEL DATA GURU
    // ==========================================
    if ($role === 'Guru') {
        $query_total = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa");
    } else {
        if (!empty($cari)) {
            $query_total = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE nama LIKE '%$cari%' OR nip LIKE '%$cari%'");
        } else {
            $query_total = mysqli_query($koneksi, "SELECT * FROM t_guru");
        }
    }

    $total_data = ($query_total) ? mysqli_num_rows($query_total) : 0;
    $total_halaman = ceil($total_data / $batas);
?>
<div class="custom-table-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">
      <i class="bi bi-person-workspace me-2 text-warning"></i>
      <?= $role === 'Guru' ? 'Catat Pelanggaran Siswa' : 'Kelola Data Guru'; ?>
    </h5>
    <?php if ($role !== 'Guru'): ?>
      <!-- TOMBOL TAMBAH GURU (MENGARAH KE DALAM DASHBOARD & SIDEBAR MUNCUL) -->
      <a href="dashboard.php?tab=menu2&action=tambah" class="btn btn-sm px-3 rounded-pill fw-semibold text-white" style="background-color: #1b263b; border-color: #1b263b;">
        <i class="bi bi-plus-lg me-1"></i>Tambah Guru
      </a>
    <?php endif; ?>
  </div>

  <?php if ($role !== 'Guru'): ?>
  <div class="card border-0 shadow-sm mb-4 rounded-3">
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
  <?php endif; ?>

  <div class="table-responsive rounded-3 overflow-hidden">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <?php if ($role === 'Guru'): ?>
            <th>No</th><th>Nama Siswa</th><th>Pelanggaran</th><th>Poin</th>
          <?php else: ?>
            <th>ID</th><th>NIP</th><th>Nama Guru</th><th>Email</th><th>Status</th><th class="text-center">AKSI</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if ($role === 'Guru'): ?>
          <?php
          $no = $halaman_awal + 1;
          $q_pelanggaran = mysqli_query($koneksi, "
            SELECT s.nama, p.nama as nama_pelanggaran, p.poin 
            FROM t_pelanggaran_siswa ps
            JOIN t_siswa s ON ps.siswa_id = s.id
            JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
            LIMIT $halaman_awal, $batas
          ");
          if ($q_pelanggaran && mysqli_num_rows($q_pelanggaran) > 0) {
              while ($p = mysqli_fetch_assoc($q_pelanggaran)) {
                  echo "<tr>
                          <td>{$no}</td>
                          <td class='fw-semibold'>{$p['nama']}</td>
                          <td>{$p['nama_pelanggaran']}</td>
                          <td><span class='badge bg-danger'>{$p['poin']} Poin</span></td>
                        </tr>";
                  $no++;
              }
          } else {
              echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada data pelanggaran</td></tr>";
          }
          ?>
        <?php else: ?>
          <?php
          if (!empty($cari)) {
              $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru WHERE nama LIKE '%$cari%' OR nip LIKE '%$cari%' ORDER BY id DESC LIMIT $halaman_awal, $batas");
          } else {
              $q_guru = mysqli_query($koneksi, "SELECT * FROM t_guru ORDER BY id DESC LIMIT $halaman_awal, $batas");
          }

          if ($q_guru && mysqli_num_rows($q_guru) > 0) {
              while ($g = mysqli_fetch_assoc($q_guru)) {
                  $status_badge = ($g['status_aktif'] == 1) ? '<span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Aktif</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">Tidak Aktif</span>';
          ?>
                  <tr>
                    <td class='text-muted'>#<?= $g['id']; ?></td>
                    <td><?= $g['nip']; ?></td>
                    <td class='fw-semibold'><?= $g['nama']; ?></td>
                    <td><?= $g['email']; ?></td>
                    <td><?= $status_badge; ?></td>
                    <td class='text-center'>
                      <!-- Tombol Aksi Seragam sesuai Gambar 3 -->
                      <a href="dashboard.php?tab=menu2&action=edit&id=<?= $g['id']; ?>" class="btn btn-warning btn-sm text-white px-2 py-1 rounded-2 me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      <a href="guru/guru_hapus.php?id=<?= $g['id']; ?>" class="btn btn-danger btn-sm px-2 py-1 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data guru ini?')">
                        <i class="bi bi-trash"></i>
                      </a>
                    </td>
                  </tr>
          <?php
              }
          } else {
              echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data guru di database</td></tr>";
          }
          ?>
        <?php endif; ?>
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
<?php } ?>