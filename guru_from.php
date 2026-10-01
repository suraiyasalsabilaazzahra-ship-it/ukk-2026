<?php
// Hubungkan ke database
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Guru</title>
</head>
<body>

    <div>
        <h2>Form Input Data Guru</h2>
        
        <form action="proses_guru.php" method="POST">
            <!-- ID (Hidden) -> Auto Increment di database -->
            <input type="hidden" name="id" id="id">

            <!-- NIP -->
            <div>
                <label for="nip">NIP</label><br>
                <input type="text" name="nip" id="nip" maxlength="30" placeholder="Masukkan NIP" required>
            </div>
            <br>

            <!-- Nama Guru -->
            <div>
                <label for="nama">Nama Lengkap</label><br>
                <input type="text" name="nama" id="nama" maxlength="150" placeholder="Masukkan nama guru" required>
            </div>
            <br>

            <!-- Email -->
            <div>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" maxlength="150" placeholder="contoh@school.sch.id" required>
            </div>
            <br>

            <!-- Status Aktif -->
            <div>
                <label for="status_aktif">Status Aktif</label><br>
                <select name="status_aktif" id="status_aktif" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <br>

            <!-- User ID (Mengambil otomatis dari tabel t_users) -->
            <div>
                <label for="user_id">Akun User (User ID)</label><br>
                <select name="user_id" id="user_id" required>
                    <option value="">-- Pilih Akun User --</option>
                    <?php
                    // Mengambil seluruh data user dari database
                    $query_user = mysqli_query($koneksi, "SELECT id, username, email FROM t_users");
                    
                    // Looping data user ke dalam dropdown
                    while ($user = mysqli_fetch_assoc($query_user)) {
                        echo '<option value="' . $user['id'] . '">' . $user['id'] . ' - ' . $user['username'] . ' (' . $user['email'] . ')</option>';
                    }
                    ?>
                </select>
            </div>
            <br>

            <!-- Tombol Aksi -->
            <div>
                <button type="submit" name="simpan">Simpan Data</button>
                <button type="reset">Batal / Reset</button>
            </div>
        </form>
    </div>

</body>
</html>