<?php
$host     = "if0_43399594_XXX";
$user     = "if0_43399594";     // Sesuaikan jika menggunakan username database lain
$password = "RK338IchwwyhRky";         // Isikan password MySQL jika ada
$database = "if0_43399594_db_ukk2026";

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
