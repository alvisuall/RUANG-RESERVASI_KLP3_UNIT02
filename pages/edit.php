<?php
require_once "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $halaman = $_POST['halaman'];

    switch ($halaman) {

        // ==========================
        // EDIT RUANGAN
        // ==========================

        case "ruangan":

            $sql = "UPDATE ruangan SET
                        kode_ruangan=?,
                        nama_ruangan=?,
                        gedung=?,
                        lantai=?,
                        kapasitas=?,
                        status_ruangan=?,
                        fasilitas=?
                    WHERE id_ruangan=?";

            $stmt = mysqli_prepare($koneksi, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssissi",
                $_POST['kode_ruangan'],
                $_POST['nama_ruangan'],
                $_POST['gedung'],
                $_POST['lantai'],
                $_POST['kapasitas'],
                $_POST['status_ruangan'],
                $_POST['fasilitas'],
                $_POST['id_ruangan']
            );

            $redirect = "../ruangan.php";

        break;

        // ==========================
        // EDIT RESERVASI
        // ==========================

        case "reservasi":

            $sql = "UPDATE reservasi_ruangan SET

                        kode_reservasi=?,
                        id_ruangan=?,
                        id_pengguna=?,
                        nama_pemesan=?,
                        email_pemesan=?,
                        no_hp=?,
                        tanggal_reservasi=?,
                        jam_mulai=?,
                        jam_selesai=?,
                        keperluan=?,
                        keterangan=?,
                        jumlah_peserta=?,
                        status_reservasi=?,
                        catatan_admin=?

                    WHERE id_reservasi=?";

            $stmt = mysqli_prepare($koneksi,$sql);

            mysqli_stmt_bind_param(

                $stmt,

                "siissssssssissi",

                $_POST['kode_reservasi'],
                $_POST['id_ruangan'],
                $_POST['id_pengguna'],
                $_POST['nama_pemesan'],
                $_POST['email_pemesan'],
                $_POST['no_hp'],
                $_POST['tanggal_reservasi'],
                $_POST['jam_mulai'],
                $_POST['jam_selesai'],
                $_POST['keperluan'],
                $_POST['keterangan'],
                $_POST['jumlah_peserta'],
                $_POST['status_reservasi'],
                $_POST['catatan_admin'],
                $_POST['id_reservasi']

            );

            $redirect="../reservasi.php";

        break;

         // ==========================
        // EDIT PENGGUNA
        // ==========================

        case "pengguna":

            $sql = "UPDATE pengguna SET

                        nama_lengkap=?,
                        nim_nip=?,
                        jenis_pengguna=?,
                        fakultas_unit=?,
                        prodi_bagian=?,
                        email=?,
                        no_hp=?,
                        alamat=?

                    WHERE id_pengguna=?";

            $stmt = mysqli_prepare($koneksi,$sql);

          mysqli_stmt_bind_param(

            $stmt,

            "ssssssssi",

            $_POST['nama_lengkap'],
            $_POST['nim_nip'],
            $_POST['jenis_pengguna'],
            $_POST['fakultas_unit'],
            $_POST['prodi_bagian'],
            $_POST['email'],
            $_POST['no_hp'],
            $_POST['alamat'],
            $_POST['id_pengguna']

         );

            $redirect="../pengguna.php";

        break;

        default:

            die("Halaman tidak dikenali.");

    }

    if(mysqli_stmt_execute($stmt)){

        header("Location: $redirect");
        exit();

    }else{

        echo mysqli_error($koneksi);

    }

}
?>