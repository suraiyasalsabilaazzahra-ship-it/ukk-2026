<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // Ambil data yang dikirim dari form
    $nip          = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $status_aktif = $_POST['status_aktif'];
    $user_id      = $_POST['user_id'];

    // Query simpan ke tabel t_guru
    $query = "INSERT INTO t_guru (nip, nama, email, status_aktif, user_id) 
              VALUES ('$nip', '$nama', '$email', '$status_aktif', '$user_id')";

    $simpan = mysqli_query($koneksi, $query);

    if ($simpan) {
        echo "<script>
                alert('Data guru berhasil disimpan!');
                window.location.href = 'guru_form.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');
                window.location.href = 'guru_form.php';
              </script>";
    }
} else {
    // Jika mencoba akses langsung file proses_guru.php tanpa kirim form
    header('Location: guru_form.php');
}
?>