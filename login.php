<?php
session_start();

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

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
        $error = 'Email atau password salah!';
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
    <header class="p-3 mb-4 bg-success text-white rounded">
      <h1>Portal UKK 2026</h1>
      <p class="mb-0">Silakan masuk menggunakan akun Anda</p>
    </header>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <main class="card p-4 shadow-sm">
      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email / Username:</label>
          <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Kata Sandi:</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Masuk Dashboard</button>
      </form>

      <hr>

      <fieldset class="mt-2">
        <legend class="h6"><strong>Pelanggaran Siswa</strong></legend>
        <ul class="small mb-0">
          <li><strong>Guru:</strong> <code>guru@sekolah.sch.id</code> | Password: <code>guru123</code></li>
          <li><strong>User / Admin:</strong> <code>admin@sekolah.sch.id</code> | Password: <code>admin123</code></li>
        </ul>
      </fieldset>
    </main>
  </div>

</body>
</html>