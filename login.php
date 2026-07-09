<?php

// Memulai session agar data login bisa disimpan
session_start();

// Menghubungkan file ini dengan koneksi database
include "koneksi.php";

// Mengambil data username dan password dari form login
// trim() digunakan untuk menghapus spasi di awal dan akhir username
$username = trim($_POST['username']);
$password = $_POST['password'];

// Query untuk mencari username yang dimasukkan pengguna
// Sekaligus memastikan akun masih aktif
$sql = "SELECT * FROM user_login
        WHERE username = ?
        AND status_akun = 'aktif'";

// Membuat prepared statement
// Cara ini lebih aman karena mencegah SQL Injection
$stmt = mysqli_prepare($conn, $sql);

// Mengisi tanda tanya (?) pada query dengan nilai username
// "s" berarti tipe datanya String
mysqli_stmt_bind_param($stmt, "s", $username);

// Menjalankan query
mysqli_stmt_execute($stmt);

// Mengambil hasil query
$result = mysqli_stmt_get_result($stmt);

// Mengecek apakah username ditemukan
if(mysqli_num_rows($result) == 1){

    // Mengambil data user menjadi array
    $data = mysqli_fetch_assoc($result);

    // Mengecek apakah password yang dimasukkan sesuai
    // dengan password hash yang ada di database
    if(password_verify($password, $data['password_hash'])){

        // Menyimpan data user ke dalam session
        // Session digunakan agar user tetap dianggap login
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // Mengarahkan user ke dashboard sesuai role
        if($data['role']=="admin"){

            header("Location: home.php");

        }

        elseif($data['role']=="petugas"){

            header("Location: home.php");

        }

        else{

            // Role pengguna (mahasiswa/user)
            header("Location: home.php");

        }

        // Menghentikan proses setelah redirect
        exit();

    }else{

        // Password tidak cocok
        echo "Password salah.";

    }

}else{

    // Username tidak ditemukan
    // atau akun tidak aktif
    echo "Username tidak ditemukan atau akun tidak aktif.";

}

?>