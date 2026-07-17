<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}
require_once "../koneksi.php";

if (!isset($_GET['halaman']) || !isset($_GET['id'])) {
    die("Parameter tidak lengkap.");
}

<<<<<<< HEAD
$role = $_SESSION['role'];
if ($role == 'pengguna') {
    header("Location: ../home.php");
    exit();
}
=======
    $halaman = $_GET['halaman'];
    $id = (int) $_GET['id'];
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a

$halaman = $_GET['halaman'];
$id = (int)$_GET['id'];

<<<<<<< HEAD
switch ($halaman) {

    /*
    ========================================
            HAPUS RUANGAN
    ========================================
    */
    case "ruangan":

        // Cek apakah ruangan masih dipakai reservasi
        $cek = mysqli_prepare(
            $koneksi,
            "SELECT COUNT(*) 
             FROM reservasi_ruangan
             WHERE id_ruangan=?"
        );

        mysqli_stmt_bind_param($cek, "i", $id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {

            echo "<script>
                alert('Ruangan masih digunakan pada data reservasi!');
                window.location='../ruangan.php';
            </script>";
            exit();
        }

        $hapus = mysqli_prepare(
            $koneksi,
            "DELETE FROM ruangan
             WHERE id_ruangan=?"
        );

        mysqli_stmt_bind_param($hapus, "i", $id);

        if (mysqli_stmt_execute($hapus)) {

            header("Location: ../ruangan.php?status=hapus");

        } else {

            echo "<script>
                alert('Gagal menghapus data!');
                window.location='../ruangan.php';
            </script>";

        }

    break;

    /*
    ========================================
            HAPUS PENGGUNA
    ========================================
    */

    case "pengguna":

        // Cek apakah pengguna masih punya reservasi
        $cek = mysqli_prepare(
            $koneksi,
            "SELECT COUNT(*)
             FROM reservasi_ruangan
             WHERE id_pengguna=?"
        );

        mysqli_stmt_bind_param($cek, "i", $id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {

            echo "<script>
                alert('Pengguna masih memiliki data reservasi!');
                window.location='../pengguna.php';
            </script>";
            exit();
        }

        $hapus = mysqli_prepare(
            $koneksi,
            "DELETE FROM pengguna
             WHERE id_pengguna=?"
        );

        mysqli_stmt_bind_param($hapus, "i", $id);

        if (mysqli_stmt_execute($hapus)) {

            header("Location: ../pengguna.php?status=hapus");

        } else {

            echo "<script>
                alert('Gagal menghapus data!');
                window.location='../pengguna.php';
            </script>";

        }

    break;

    /*
    ========================================
            HAPUS RESERVASI
    ========================================
    */

    case "reservasi":

        $hapus = mysqli_prepare(
            $koneksi,
            "DELETE FROM reservasi_ruangan
             WHERE id_reservasi=?"
        );

        mysqli_stmt_bind_param($hapus, "i", $id);

        if (mysqli_stmt_execute($hapus)) {

            header("Location: ../reservasi.php?status=hapus");

        } else {

            echo "<script>
                alert('Gagal menghapus data!');
                window.location='../reservasi.php';
            </script>";

        }

    break;

    default:

        die("Halaman tidak dikenali.");

=======
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

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
}
?>