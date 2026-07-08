<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_reservasi_ruangan_kampus.sql";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal!");
}
?>