<?php
require_once "../koneksi.php";

if (isset($_GET['halaman']) && isset($_GET['id'])) {

    $halaman = $_GET['halaman'];
    $id = $_GET['id'];

    switch ($halaman) {

        case "ruangan":
            $sql = "DELETE FROM ruangan WHERE id_ruangan = ?";
            $redirect = "../ruangan.php";
            break;

        case "pengguna":
            $sql = "DELETE FROM pengguna WHERE id_pengguna = ?";
            $redirect = "../pengguna.php";
            break;

        case "reservasi":
            $sql = "DELETE FROM reservasi_ruangan WHERE id_reservasi = ?";
            $redirect = "../reservasi.php";
            break;

        default:
            die("Halaman tidak dikenali.");
    }

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: $redirect");
        exit();
    } else {
        echo "Gagal menghapus data.";
    }

} else {
    echo "Parameter tidak lengkap.";
}
?>