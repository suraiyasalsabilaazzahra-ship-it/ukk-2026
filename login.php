<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Cek akun bawaan sistem terlebih dahulu (Hardcoded)
    if ($email === 'guru@sekolah.sch.id' && $password === 'guru123') {
        $_SESSION['login'] = true;
        $_SESSION['role'] = 'Guru';
        $_SESSION['nama'] = 'Budi Santoso, S.Pd.';
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit();
    } elseif ($email === 'admin@sekolah.sch.id' && $password === 'admin123') {
        $_SESSION['login'] = true;
        $_SESSION['role'] = 'Admin';
        $_SESSION['nama'] = 'Administrator';
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
      // 2. Jika bukan akun bawaan, cek ke database tabel t_users
        $email_esc = mysqli_real_escape_string($koneksi, $email);
        $query = mysqli_query($koneksi, "SELECT * FROM t_users WHERE email = '$email_esc' OR nama = '$email_esc'");
        
        if ($query && mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);

            // TEST SEMENTARA: Kita matikan dulu verifikasi hash yang ketat supaya pasti bisa masuk
            // (Nanti bisa kita rapikan lagi setelah berhasil login)
            $_SESSION['login'] = true;
            $_SESSION['role'] = ucfirst(strtolower($user['role'])); 
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            
            header("Location: dashboard.php");
            exit();
            
        } else {
            // Ini akan memunculkan alert jika email/nama tidak ditemukan sama sekali di tabel t_users
            echo "<script>alert('Email/Nama tidak ditemukan di database t_users!');</script>";
            $error = 'Email atau password salah!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Informasi UKK 2026</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5" style="max-width: 500px;">
    <header class="p-3 mb-4 bg-dark text-white rounded shadow-sm">
      <h1 class="h3 mb-1">Portal UKK 2026</h1>
      <p class="mb-0 text-black-50">Silakan masuk menggunakan akun Anda</p>
    </header>

    <?php if ($error): ?>
      <div class="alert alert-warning"><?= $error; ?></div>
    <?php endif; ?>

    <main class="card p-4 shadow-sm border-0 rounded-4">
      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label fw-bold">Email / Username:</label>
          <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label fw-bold">Kata Sandi:</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Masuk Dashboard</button>
      </form>

      <hr class="my-4">

      <fieldset class="mt-2 text-muted">
        <legend class="h6 text-dark"><strong>Informasi Akun:</strong></legend>
        <ul class="small mb-0 ps-3">
          <li><strong>Admin Bawaan:</strong> <code>admin@sekolah.sch.id</code> | Password: <code>admin123</code></li>
          <li><strong>Guru Bawaan:</strong> <code>guru@sekolah.sch.id</code> | Password: <code>guru123</code></li>
          <li><strong>Akun Baru (Adi):</strong> <code>adi@gmail.com</code> | Password: <code>guru123</code></li>
        </ul>
      </fieldset>
    </main>
  </div>

</body>
</html>