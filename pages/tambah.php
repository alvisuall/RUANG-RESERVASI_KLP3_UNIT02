<?php
require_once "../koneksi.php";

if (!isset($_GET['halaman'])) {
    die("Halaman tidak ditemukan.");
}

$halaman = $_GET['halaman'];

switch ($halaman) {

    /*
    ==========================================
            TAMBAH DATA RUANGAN
    ==========================================
    */

    case "ruangan":

        if(isset($_POST['simpan'])){

            $kode       = trim($_POST['kode_ruangan']);
            $nama       = trim($_POST['nama_ruangan']);
            $gedung     = trim($_POST['gedung']);
            $lantai     = trim($_POST['lantai']);
            $kapasitas  = (int) $_POST['kapasitas'];
            $fasilitas  = trim($_POST['fasilitas']);
            $status     = trim($_POST['status_ruangan']);

            if(
                empty($kode) ||
                empty($nama) ||
                empty($gedung) ||
                empty($lantai) ||
                empty($kapasitas) ||
                empty($fasilitas) ||
                empty($status)
            ){
                echo "<script>
                alert('Semua data wajib diisi!');
                history.back();
                </script>";
                exit;
            }

            $cek = mysqli_prepare(
                $koneksi,
                "SELECT id_ruangan
                 FROM ruangan
                 WHERE kode_ruangan=?"
            );

            mysqli_stmt_bind_param(
                $cek,
                "s",
                $kode
            );

            mysqli_stmt_execute($cek);

            mysqli_stmt_store_result($cek);

            if(mysqli_stmt_num_rows($cek)>0){

                echo "<script>

                alert('Kode ruangan sudah digunakan!');

                history.back();

                </script>";

                exit;

            }

            $insert = mysqli_prepare(

                $koneksi,

                "INSERT INTO ruangan
                (
                    kode_ruangan,
                    nama_ruangan,
                    gedung,
                    lantai,
                    kapasitas,
                    fasilitas,
                    status_ruangan
                )

                VALUES

                (?,?,?,?,?,?,?)"

            );

            mysqli_stmt_bind_param(

                $insert,

                "ssssiss",

                $kode,
                $nama,
                $gedung,
                $lantai,
                $kapasitas,
                $fasilitas,
                $status

            );

            if(mysqli_stmt_execute($insert)){

                header("Location: ../ruangan.php?success=tambah");

                exit();

            }else{

                echo "<script>

                alert('Gagal menambah data ruangan.');

                history.back();

                </script>";

            }

        }

    break;

    /*
    ==========================================
            TAMBAH DATA PENGGUNA
    ==========================================
    */

    case "pengguna":

        if(isset($_POST['simpan'])){

            $nama       = trim($_POST['nama_lengkap']);
            $nim        = trim($_POST['nim_nip']);
            $jenis      = trim($_POST['jenis_pengguna']);
            $fakultas   = trim($_POST['fakultas_unit']);
            $prodi      = trim($_POST['prodi_bagian']);
            $email      = trim($_POST['email']);
            $hp         = trim($_POST['no_hp']);
            $alamat     = trim($_POST['alamat']);

            // ==========================
            // VALIDASI
            // ==========================

            if(
                empty($nama) ||
                empty($nim) ||
                empty($jenis) ||
                empty($fakultas) ||
                empty($prodi) ||
                empty($email) ||
                empty($hp) ||
                empty($alamat)
            ){

                echo "<script>
                alert('Semua data wajib diisi!');
                history.back();
                </script>";
                exit;

            }

            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

                echo "<script>
                alert('Format email tidak valid!');
                history.back();
                </script>";
                exit;

            }

            if(!is_numeric($nim)){

                echo "<script>
                alert('NIM / NIP harus berupa angka!');
                history.back();
                </script>";
                exit;

            }

            if(!is_numeric($hp)){

                echo "<script>
                alert('Nomor HP harus berupa angka!');
                history.back();
                </script>";
                exit;

            }

            // ==========================
            // CEK NIM
            // ==========================

            $cekNim = mysqli_prepare(

                $koneksi,

                "SELECT id_pengguna
                FROM pengguna
                WHERE nim_nip=?"

            );

            mysqli_stmt_bind_param(

                $cekNim,

                "s",

                $nim

            );

            mysqli_stmt_execute($cekNim);

            mysqli_stmt_store_result($cekNim);

            if(mysqli_stmt_num_rows($cekNim)>0){

                echo "<script>

                alert('NIM / NIP sudah terdaftar!');

                history.back();

                </script>";

                exit;

            }

            // ==========================
            // CEK EMAIL
            // ==========================

            $cekEmail=mysqli_prepare(

                $koneksi,

                "SELECT id_pengguna
                FROM pengguna
                WHERE email=?"

            );

            mysqli_stmt_bind_param(

                $cekEmail,

                "s",

                $email

            );

            mysqli_stmt_execute($cekEmail);

            mysqli_stmt_store_result($cekEmail);

            if(mysqli_stmt_num_rows($cekEmail)>0){

                echo "<script>

                alert('Email sudah digunakan!');

                history.back();

                </script>";

                exit;

            }

            // ==========================
            // INSERT
            // ==========================

            $insert=mysqli_prepare(

                $koneksi,

                "INSERT INTO pengguna
                (
                    nama_lengkap,
                    nim_nip,
                    jenis_pengguna,
                    fakultas_unit,
                    prodi_bagian,
                    email,
                    no_hp,
                    alamat
                )

                VALUES

                (?,?,?,?,?,?,?,?)"

            );

            mysqli_stmt_bind_param(

                $insert,

                "ssssssss",

                $nama,
                $nim,
                $jenis,
                $fakultas,
                $prodi,
                $email,
                $hp,
                $alamat

            );

            if(mysqli_stmt_execute($insert)){

                header("Location: ../pengguna.php?success=tambah");

                exit();

            }else{

                echo "<script>

                alert('Gagal menambahkan pengguna.');

                history.back();

                </script>";

            }

        }

    break;

    /*
    ==========================================
            TAMBAH DATA RESERVASI
    ==========================================
    */

    case "reservasi":

    if(isset($_POST['simpan'])){

        $kode           = trim($_POST['kode_reservasi']);
        $id_ruangan     = $_POST['id_ruangan'];
        $id_pengguna    = $_POST['id_pengguna'];
        $tanggal        = $_POST['tanggal_reservasi'];
        $jamMulai       = $_POST['jam_mulai'];
        $jamSelesai     = $_POST['jam_selesai'];
        $keperluan      = trim($_POST['keperluan']);
        $keterangan     = trim($_POST['keterangan']);
        $peserta        = (int)$_POST['jumlah_peserta'];
        $status         = $_POST['status_reservasi'];
        $catatan        = $_POST['catatan_admin'];

        // ==========================
        // VALIDASI
        // ==========================

        if(
            empty($kode) ||
            empty($id_ruangan) ||
            empty($id_pengguna) ||
            empty($tanggal) ||
            empty($jamMulai) ||
            empty($jamSelesai) ||
            empty($keperluan) ||
            empty($peserta)
        ){

            echo "<script>
            alert('Semua data wajib diisi!');
            history.back();
            </script>";
            exit;

        }

        if($jamMulai >= $jamSelesai){

            echo "<script>
            alert('Jam mulai harus lebih awal dari jam selesai!');
            history.back();
            </script>";
            exit;

        }

        if($peserta <= 0){

            echo "<script>
            alert('Jumlah peserta minimal 1 orang!');
            history.back();
            </script>";
            exit;

        }

        // ==========================
        // AMBIL DATA PENGGUNA
        // ==========================

        $pengguna=mysqli_prepare(

            $koneksi,

            "SELECT nama_lengkap,email,no_hp
            FROM pengguna
            WHERE id_pengguna=?"

        );

        mysqli_stmt_bind_param(
            $pengguna,
            "i",
            $id_pengguna
        );

        mysqli_stmt_execute($pengguna);

        $hasil=mysqli_stmt_get_result($pengguna);

        $data=mysqli_fetch_assoc($hasil);

        if(!$data){

            echo "<script>
            alert('Pengguna tidak ditemukan!');
            history.back();
            </script>";
            exit;

        }

        $namaPemesan=$data['nama_lengkap'];
        $emailPemesan=$data['email'];
        $hpPemesan=$data['no_hp'];

        // ==========================
        // CEK KAPASITAS
        // ==========================

        $ruangan=mysqli_prepare(

            $koneksi,

            "SELECT kapasitas
            FROM ruangan
            WHERE id_ruangan=?"

        );

        mysqli_stmt_bind_param(
            $ruangan,
            "i",
            $id_ruangan
        );

        mysqli_stmt_execute($ruangan);

        $hasilRuangan=mysqli_stmt_get_result($ruangan);

        $r=mysqli_fetch_assoc($hasilRuangan);

        if($peserta > $r['kapasitas']){

            echo "<script>

            alert('Jumlah peserta melebihi kapasitas ruangan!');

            history.back();

            </script>";

            exit;

        }

        // ==========================
        // CEK BENTROK JADWAL
        // ==========================

        $cek=mysqli_prepare(

            $koneksi,

            "SELECT id_reservasi
            FROM reservasi_ruangan

            WHERE

            id_ruangan=?

            AND tanggal_reservasi=?

            AND
            (
                jam_mulai < ?
                AND
                jam_selesai > ?
            )"

        );

        mysqli_stmt_bind_param(

            $cek,

            "isss",

            $id_ruangan,
            $tanggal,
            $jamSelesai,
            $jamMulai

        );

        mysqli_stmt_execute($cek);

        mysqli_stmt_store_result($cek);

        if(mysqli_stmt_num_rows($cek)>0){

            echo "<script>

            alert('Ruangan sudah dipakai pada jam tersebut!');

            history.back();

            </script>";

            exit;

        }

        // ==========================
        // INSERT
        // ==========================

        $insert=mysqli_prepare(

            $koneksi,

            "INSERT INTO reservasi_ruangan
            (

            kode_reservasi,
            id_ruangan,
            id_pengguna,
            nama_pemesan,
            email_pemesan,
            no_hp,
            tanggal_reservasi,
            jam_mulai,
            jam_selesai,
            keperluan,
            keterangan,
            jumlah_peserta,
            status_reservasi,
            catatan_admin

            )

            VALUES

            (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"

        );

        mysqli_stmt_bind_param(

            $insert,

            "siissssssssiss",

            $kode,
            $id_ruangan,
            $id_pengguna,
            $namaPemesan,
            $emailPemesan,
            $hpPemesan,
            $tanggal,
            $jamMulai,
            $jamSelesai,
            $keperluan,
            $keterangan,
            $peserta,
            $status,
            $catatan

        );

        if(mysqli_stmt_execute($insert)){

            header("Location: ../reservasi.php?success=tambah");

            exit();

        }else{

            echo "<script>

            alert('Reservasi gagal disimpan!');

            history.back();

            </script>";

        }

    }

    break;
}