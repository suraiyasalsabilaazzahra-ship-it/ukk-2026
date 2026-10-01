<?php
$host     = "localhost";
$user     = "root";     // Sesuaikan jika menggunakan username database lain
$password = "";         // Isikan password MySQL jika ada
$database = "db_ukk2026";

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>