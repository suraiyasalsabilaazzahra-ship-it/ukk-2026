<?php
// Hubungkan ke database
include 'koneksi.php';

// Fitur Tambah Data Kelas
if (isset($_POST['simpan_kelas'])) {
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);
    $tingkat    = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $jurusan    = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    $query_insert = "INSERT INTO t_kelas (nama_kelas, tingkat, jurusan) VALUES ('$nama_kelas', '$tingkat', '$jurusan')";
    $simpan = mysqli_query($koneksi, $query_insert);

    if ($simpan) {
        echo "<script>
                alert('Data kelas berhasil ditambahkan!');
                window.location.href = 'kelas.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambah data: " . mysqli_error($koneksi) . "');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Data Kelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

  <div class="container">
    <h3 class="mb-4">Kelola Data Kelas</h3>

    <!-- CARD FORM INPUT -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-danger text-white fw-bold">
        Form Input Data Kelas
      </div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="row">
            <!-- Nama Kelas -->
            <div class="col-md-4 mb-3">
              <label for="nama_kelas" class="form-label">Nama Kelas</label>
              <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Contoh: XII RPL 1" maxlength="50" required>
            </div>

            <!-- Tingkat -->
            <div class="col-md-4 mb-3">
              <label for="tingkat" class="form-label">Tingkat</label>
              <select name="tingkat" id="tingkat" class="form-select" required>
                <option value="">-- Pilih Tingkat --</option>
                <option value="X">X (Sepuluh)</option>
                <option value="XI">XI (Sebelas)</option>
                <option value="XII">XII (Dua Belas)</option>
              </select>
            </div>

            <!-- Jurusan -->
            <div class="col-md-4 mb-3">
              <label for="jurusan" class="form-label">Jurusan</label>
              <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" maxlength="100" required>
            </div>
          </div>

          <button type="submit" name="simpan_kelas" class="btn btn-danger">Simpan Kelas</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </form>
      </div>
    </div>

    <!-- CARD TABEL DATA KELAS -->
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white fw-bold">
        Daftar Kelas (Tabel t_kelas)
      </div>
      <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
          <thead class="table-danger">
            <tr>
              <th width="10%">ID</th>
              <th>Nama Kelas</th>
              <th>Tingkat</th>
              <th>Jurusan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query_kelas = mysqli_query($koneksi, "SELECT * FROM t_kelas ORDER BY id DESC");

            if ($query_kelas && mysqli_num_rows($query_kelas) > 0) {
                while ($row = mysqli_fetch_assoc($query_kelas)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nama_kelas']}</td>
                            <td>{$row['tingkat']}</td>
                            <td>{$row['jurusan']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center py-3'>Belum ada data kelas di database.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

</body>
</html>