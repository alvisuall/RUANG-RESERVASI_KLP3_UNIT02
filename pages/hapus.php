<?php
require_once "../koneksi.php";

if (isset($_GET['halaman']) && isset($_GET['id'])) {

    $halaman = $_GET['halaman'];
    $id = (int) $_GET['id'];

    switch ($halaman) {

        case "ruangan":

                // Cek apakah ruangan masih digunakan di reservasi
                $cek = mysqli_query($koneksi, "SELECT * FROM reservasi_ruangan WHERE id_ruangan = $id");

                if(mysqli_num_rows($cek) > 0){

                    echo "<script>
                            alert('Ruangan tidak dapat dihapus karena masih digunakan pada data reservasi!');
                            window.location='../ruangan.php';
                        </script>";
                    exit();

                }

                $sql = "DELETE FROM ruangan WHERE id_ruangan = ?";
                $redirect = "../ruangan.php";

        break;

        case "reservasi":

            $sql = "DELETE FROM reservasi_ruangan WHERE id_reservasi = ?";
            $redirect = "../reservasi.php";

            break;

        case "pengguna":

            $sql = "DELETE FROM pengguna WHERE id_pengguna = ?";
            $redirect = "../pengguna.php";

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

        echo "<script>
                alert('Data gagal dihapus!');
                window.history.back();
              </script>";

    }

} else {

    echo "Parameter tidak lengkap.";

}
?>