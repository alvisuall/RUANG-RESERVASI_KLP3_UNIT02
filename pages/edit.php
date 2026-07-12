<?php
require_once "../koneksi.php";

if (!isset($_GET['halaman']) || !isset($_GET['id'])) {
    die("Parameter tidak lengkap.");
}

$halaman = $_GET['halaman'];
$id = $_GET['id'];

switch ($halaman) {

    case "ruangan":

        // Ambil data berdasarkan ID
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM ruangan WHERE id_ruangan = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        // Jika tombol Simpan ditekan
        if (isset($_POST['simpan'])) {

            $kode = $_POST['kode_ruangan'];
            $nama = $_POST['nama_ruangan'];
            $gedung = $_POST['gedung'];
            $lantai = $_POST['lantai'];
            $kapasitas = $_POST['kapasitas'];
            $fasilitas = $_POST['fasilitas'];
            $status = $_POST['status_ruangan'];

            $update = mysqli_prepare($koneksi,
            "UPDATE ruangan
            SET kode_ruangan=?,
                nama_ruangan=?,
                gedung=?,
                lantai=?,
                kapasitas=?,
                fasilitas=?,
                status_ruangan=?
            WHERE id_ruangan=?");

            mysqli_stmt_bind_param(
                $update,
                "ssssissi",
                $kode,
                $nama,
                $gedung,
                $lantai,
                $kapasitas,
                $fasilitas,
                $status,
                $id
            );

            if(mysqli_stmt_execute($update)){
                header("Location: ../ruangan.php");
                exit();
            }else{
                echo "Gagal mengubah data.";
            }
        }

        break;

    default:
        die("Halaman tidak dikenali.");
}
?>