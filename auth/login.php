<?php

// Memulai session
// Session digunakan untuk menyimpan data pengguna setelah berhasil login
session_start();

// Menghubungkan ke database
require_once "../koneksi.php";

// Memastikan file hanya bisa diakses melalui tombol Login (POST)
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../index.php");
    exit();
}

// Mengambil data dari form login
$username = trim($_POST['username']);
$password = $_POST['password'];

// Mencari user berdasarkan username yang aktif
$sql = "SELECT * FROM user_login
        WHERE username = ?
        AND status_akun = 'aktif'";

// Membuat prepared statement agar aman dari SQL Injection
$stmt = mysqli_prepare($koneksi, $sql);

// Memasukkan username ke query
mysqli_stmt_bind_param($stmt, "s", $username);

// Menjalankan query
mysqli_stmt_execute($stmt);

// Mengambil hasil query
$result = mysqli_stmt_get_result($stmt);

// Mengecek apakah username ditemukan
if (mysqli_num_rows($result) == 1) {

    // Mengambil data user
    $data = mysqli_fetch_assoc($result);

    // Mengecek password
    if (password_verify($password, $data['password_hash'])) {

        // Menyimpan data user ke session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['email'] = $data['email'];

        // Mengarahkan user sesuai role
        if ($data['role'] == "admin") {

            header("Location: ../home.php");

        } elseif ($data['role'] == "petugas") {

            header("Location: ../home.php");

        } else {

            // Role pengguna (mahasiswa/user)
            header("Location: ../home.php");

        }

        exit();

    } else {

        // Password salah
        echo "Password salah.";

    }

} else {

    // Username tidak ditemukan atau akun tidak aktif
    echo "Username tidak ditemukan atau akun tidak aktif.";

}

// Menutup statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($koneksi);

?>