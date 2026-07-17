<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_reservasi_ruangan_kampus";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function getCurrentPenggunaId($koneksi) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['id_user'])) return null;
    
    // Get email from session, fallback to DB if empty
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    if (empty($email)) {
        $id_user = $_SESSION['id_user'];
        $q = mysqli_query($koneksi, "SELECT email FROM user_login WHERE id_user = $id_user");
        if ($row = mysqli_fetch_assoc($q)) {
            $email = $row['email'];
            $_SESSION['email'] = $email;
        }
    }
    
    $stmt = mysqli_prepare($koneksi, "SELECT id_pengguna FROM pengguna WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['id_pengguna'];
    } else {
        // Create new record in pengguna with NULL for nim_nip to avoid unique duplicate constraint errors
        $nama = $_SESSION['nama'];
        $stmtInsert = mysqli_prepare($koneksi, "INSERT INTO pengguna (nama_lengkap, email, nim_nip, jenis_pengguna, fakultas_unit, prodi_bagian, no_hp, alamat) VALUES (?, ?, NULL, 'mahasiswa', NULL, NULL, NULL, NULL)");
        mysqli_stmt_bind_param($stmtInsert, "ss", $nama, $email);
        mysqli_stmt_execute($stmtInsert);
        return mysqli_insert_id($koneksi);
    }
}