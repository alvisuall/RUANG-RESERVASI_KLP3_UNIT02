<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}
require_once "../koneksi.php";

$role = $_SESSION['role'];
if ($role == 'pengguna') {
    header("Location: ../home.php");
    exit();
}

if (!isset($_GET['halaman']) || !isset($_GET['id'])) {
    die("Parameter tidak lengkap.");
}

$halaman = $_GET['halaman'];
$id = (int)$_GET['id'];
$error_msg = '';

switch ($halaman) {

    case "ruangan":
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM ruangan WHERE id_ruangan = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        if (!$data) {
            die("Data ruangan tidak ditemukan.");
        }

        if (isset($_POST['simpan'])) {
            $kode = trim($_POST['kode_ruangan']);
            $nama = trim($_POST['nama_ruangan']);
            $gedung = trim($_POST['gedung']);
            $lantai = trim($_POST['lantai']);
            $kapasitas = (int)$_POST['kapasitas'];
            $fasilitas = trim($_POST['fasilitas']);
            $status = trim($_POST['status_ruangan']);

            if (empty($kode) || empty($nama) || empty($gedung) || empty($lantai) || empty($kapasitas) || empty($fasilitas) || empty($status)) {
                $error_msg = "Semua data wajib diisi!";
            } else {
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

                mysqli_stmt_bind_param($update, "ssssissi", $kode, $nama, $gedung, $lantai, $kapasitas, $fasilitas, $status, $id);

                if(mysqli_stmt_execute($update)){
                    header("Location: ../ruangan.php?success=edit");
                    exit();
                }else{
                    $error_msg = "Gagal mengubah data ruangan.";
                }
            }
        }
        break;

    case "pengguna":
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM pengguna WHERE id_pengguna = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        if (!$data) {
            die("Data pengguna tidak ditemukan.");
        }

        if (isset($_POST['simpan'])) {
            $nama = trim($_POST['nama_lengkap']);
            $nim = trim($_POST['nim_nip']);
            $jenis = trim($_POST['jenis_pengguna']);
            $fakultas = trim($_POST['fakultas_unit']);
            $prodi = trim($_POST['prodi_bagian']);
            $email = trim($_POST['email']);
            $hp = trim($_POST['no_hp']);
            $alamat = trim($_POST['alamat']);

            if (empty($nama) || empty($nim) || empty($jenis) || empty($fakultas) || empty($prodi) || empty($email) || empty($hp) || empty($alamat)) {
                $error_msg = "Semua data wajib diisi!";
            } else {
                $update = mysqli_prepare($koneksi,
                "UPDATE pengguna
                SET nama_lengkap=?,
                    nim_nip=?,
                    jenis_pengguna=?,
                    fakultas_unit=?,
                    prodi_bagian=?,
                    email=?,
                    no_hp=?,
                    alamat=?
                WHERE id_pengguna=?");

                mysqli_stmt_bind_param($update, "ssssssssi", $nama, $nim, $jenis, $fakultas, $prodi, $email, $hp, $alamat, $id);

                if(mysqli_stmt_execute($update)){
                    header("Location: ../pengguna.php?success=edit");
                    exit();
                }else{
                    $error_msg = "Gagal mengubah data pengguna.";
                }
            }
        }
        break;

    case "reservasi":
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM reservasi_ruangan WHERE id_reservasi = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        if (!$data) {
            die("Data reservasi tidak ditemukan.");
        }

        if (isset($_POST['simpan'])) {
            $kode = trim($_POST['kode_reservasi']);
            $id_pengguna_input = (int)$_POST['id_pengguna'];
            $id_ruangan = (int)$_POST['id_ruangan'];
            $tanggal = $_POST['tanggal_reservasi'];
            $jamMulai = $_POST['jam_mulai'];
            $jamSelesai = $_POST['jam_selesai'];
            $keperluan = trim($_POST['keperluan']);
            $peserta = (int)$_POST['jumlah_peserta'];
            $keterangan = trim($_POST['keterangan']);
            $status = $_POST['status_reservasi'];
            $catatan = trim($_POST['catatan_admin']);

            if (empty($kode) || empty($id_pengguna_input) || empty($id_ruangan) || empty($tanggal) || empty($jamMulai) || empty($jamSelesai) || empty($keperluan) || empty($peserta) || empty($status)) {
                $error_msg = "Semua data wajib diisi!";
            } elseif ($jamMulai >= $jamSelesai) {
                $error_msg = "Jam mulai harus lebih awal dari jam selesai!";
            } else {
                // Cek kapasitas ruangan
                $ruangan = mysqli_prepare($koneksi, "SELECT kapasitas FROM ruangan WHERE id_ruangan=?");
                mysqli_stmt_bind_param($ruangan, "i", $id_ruangan);
                mysqli_stmt_execute($ruangan);
                $hasilRuangan = mysqli_stmt_get_result($ruangan);
                $r = mysqli_fetch_assoc($hasilRuangan);
                
                if ($peserta > $r['kapasitas']) {
                    $error_msg = "Jumlah peserta melebihi kapasitas ruangan (" . $r['kapasitas'] . " orang)!";
                } else {
                    // Cek bentrok jadwal (abaikan reservasi ini sendiri)
                    $cek = mysqli_prepare($koneksi, "
                        SELECT id_reservasi
                        FROM reservasi_ruangan
                        WHERE id_ruangan=?
                          AND tanggal_reservasi=?
                          AND id_reservasi != ?
                          AND (jam_mulai < ? AND jam_selesai > ?)
                    ");
                    mysqli_stmt_bind_param($cek, "isiss", $id_ruangan, $tanggal, $id, $jamSelesai, $jamMulai);
                    mysqli_stmt_execute($cek);
                    mysqli_stmt_store_result($cek);
                    
                    if (mysqli_stmt_num_rows($cek) > 0) {
                        $error_msg = "Ruangan sudah dipakai pada jam tersebut!";
                    } else {
                        // Ambil data detail pengguna
                        $stmtUser = mysqli_prepare($koneksi, "SELECT nama_lengkap, email, no_hp FROM pengguna WHERE id_pengguna = ?");
                        mysqli_stmt_bind_param($stmtUser, "i", $id_pengguna_input);
                        mysqli_stmt_execute($stmtUser);
                        $resUser = mysqli_stmt_get_result($stmtUser);
                        $user = mysqli_fetch_assoc($resUser);

                        if (!$user) {
                            $error_msg = "Pengguna tidak ditemukan.";
                        } else {
                            $namaPemesan = $user['nama_lengkap'];
                            $emailPemesan = $user['email'];
                            $hpPemesan = $user['no_hp'];

                            $update = mysqli_prepare($koneksi,
                            "UPDATE reservasi_ruangan
                            SET kode_reservasi=?,
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
                            WHERE id_reservasi=?");

                            mysqli_stmt_bind_param($update, "siissssssssissi",
                                $kode, $id_ruangan, $id_pengguna_input, $namaPemesan, $emailPemesan, $hpPemesan,
                                $tanggal, $jamMulai, $jamSelesai, $keperluan, $keterangan, $peserta, $status, $catatan, $id
                            );

                            if(mysqli_stmt_execute($update)){
                                header("Location: ../reservasi.php?success=edit");
                                exit();
                            }else{
                                $error_msg = "Gagal mengubah data reservasi.";
                            }
                        }
                    }
                }
            }
        }
        break;

    default:
        die("Halaman tidak dikenali.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data <?= ucfirst($halaman); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="app-wrapper">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-building-check"></i>
            </div>
            <div>
                <h5>Reservasi</h5>
                <small>Ruangan Kampus</small>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../home.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <?php if ($role == 'admin' || $role == 'petugas') : ?>
                <li><a href="../ruangan.php" class="<?= $halaman == 'ruangan' ? 'active' : ''; ?>"><i class="bi bi-door-open"></i> Data Ruangan</a></li>
                <li><a href="../reservasi.php" class="<?= $halaman == 'reservasi' ? 'active' : ''; ?>"><i class="bi bi-calendar-plus"></i> Kelola Reservasi</a></li>
                <li><a href="../jadwal.php"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
                <li><a href="../pengguna.php" class="<?= $halaman == 'pengguna' ? 'active' : ''; ?>"><i class="bi bi-people"></i> Pengguna</a></li>
                <li><a href="../laporan.php"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
            <?php else : ?>
                <li><a href="../reservasi.php"><i class="bi bi-calendar-plus"></i> Buat Reservasi</a></li>
                <li><a href="../riwayat.php"><i class="bi bi-clock-history"></i> Riwayat Reservasi</a></li>
                <li><a href="../profil.php"><i class="bi bi-person-circle"></i> Profil Saya</a></li>
            <?php endif; ?>
            <li><a href="../auth/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <div class="circle circle1"></div>
            <div class="circle circle2"></div>
            <div class="topbar-left">
                <div class="title-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="page-title">
                    <h2>Edit Data <?= ucfirst($halaman); ?></h2>
                    <p>Ubah detail informasi <?= $halaman; ?> yang tersimpan di sistem.</p>
                    <div class="title-line"></div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="theme-switch-wrapper">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" id="checkbox" />
                        <div class="slider round">
                            <i class="bi bi-sun-fill"></i>
                            <i class="bi bi-moon-stars-fill"></i>
                        </div>
                    </label>
                </div>
                <div class="profile-card">
                    <div class="avatar">
                        <?= strtoupper(substr($_SESSION['nama'], 0, 1)); ?>
                    </div>
                    <div>
                        <h5><?= htmlspecialchars($_SESSION['nama']); ?></h5>
                        <small><?= ucfirst($role); ?></small>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($error_msg)) : ?>
            <div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert" style="max-width: 1000px;">
                <strong>Gagal!</strong> <?= $error_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="content-card mx-auto" style="max-width: 1000px;">
            <h5 class="section-title mb-4">Form Edit <?= ucfirst($halaman); ?></h5>

            <?php if ($halaman == 'ruangan') : ?>
                <!-- Form Ruangan -->
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kode Ruangan</label>
                            <input type="text" name="kode_ruangan" class="form-control" value="<?= htmlspecialchars($data['kode_ruangan']); ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Ruangan</label>
                            <input type="text" name="nama_ruangan" class="form-control" value="<?= htmlspecialchars($data['nama_ruangan']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Gedung</label>
                            <input type="text" name="gedung" class="form-control" value="<?= htmlspecialchars($data['gedung']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Lantai</label>
                            <input type="text" name="lantai" class="form-control" value="<?= htmlspecialchars($data['lantai']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kapasitas</label>
                            <input type="number" name="kapasitas" class="form-control" value="<?= htmlspecialchars($data['kapasitas']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Ruangan</label>
                            <select name="status_ruangan" class="form-select" required>
                                <option value="tersedia" <?= strtolower($data['status_ruangan']) == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                                <option value="perawatan" <?= strtolower($data['status_ruangan']) == 'perawatan' ? 'selected' : ''; ?>>Perawatan</option>
                                <option value="tidak_aktif" <?= strtolower($data['status_ruangan']) == 'tidak_aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fasilitas</label>
                            <input type="text" name="fasilitas" class="form-control" value="<?= htmlspecialchars($data['fasilitas']); ?>" required>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" name="simpan" class="btn btn-primary me-2">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <a href="../ruangan.php" class="btn btn-light border">Batal</a>
                        </div>
                    </div>
                </form>

            <?php elseif ($halaman == 'pengguna') : ?>
                <!-- Form Pengguna -->
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">NIM atau NIP</label>
                            <input type="text" name="nim_nip" class="form-control" value="<?= htmlspecialchars($data['nim_nip']); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Jenis Pengguna</label>
                            <select name="jenis_pengguna" class="form-select" required>
                                <option value="mahasiswa" <?= strtolower($data['jenis_pengguna']) == 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                                <option value="dosen" <?= strtolower($data['jenis_pengguna']) == 'dosen' ? 'selected' : ''; ?>>Dosen</option>
                                <option value="tendik" <?= strtolower($data['jenis_pengguna']) == 'tendik' ? 'selected' : ''; ?>>Tendik</option>
                                <option value="organisasi" <?= strtolower($data['jenis_pengguna']) == 'organisasi' ? 'selected' : ''; ?>>Organisasi</option>
                                <option value="umum" <?= strtolower($data['jenis_pengguna']) == 'umum' ? 'selected' : ''; ?>>Umum</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fakultas atau Unit</label>
                            <input type="text" name="fakultas_unit" class="form-control" value="<?= htmlspecialchars($data['fakultas_unit']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Prodi atau Bagian</label>
                            <input type="text" name="prodi_bagian" class="form-control" value="<?= htmlspecialchars($data['prodi_bagian']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="tel" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp']); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($data['alamat']); ?></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" name="simpan" class="btn btn-primary me-2">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <a href="../pengguna.php" class="btn btn-light border">Batal</a>
                        </div>
                    </div>
                </form>

            <?php elseif ($halaman == 'reservasi') : ?>
                <!-- Form Reservasi -->
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kode Reservasi</label>
                            <input type="text" name="kode_reservasi" class="form-control" value="<?= htmlspecialchars($data['kode_reservasi']); ?>" required readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Pilih Pengguna</label>
                            <select name="id_pengguna" class="form-select" required>
                                <?php
                                $penggunaQuery = mysqli_query($koneksi, "SELECT * FROM pengguna ORDER BY nama_lengkap ASC");
                                while ($p = mysqli_fetch_assoc($penggunaQuery)) {
                                    $selected = ($p['id_pengguna'] == $data['id_pengguna']) ? 'selected' : '';
                                    echo "<option value='{$p['id_pengguna']}' {$selected}>{$p['nama_lengkap']} ({$p['nim_nip']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Pilih Ruangan</label>
                            <select name="id_ruangan" class="form-select" required>
                                <?php
                                $ruanganQuery = mysqli_query($koneksi, "SELECT * FROM ruangan ORDER BY nama_ruangan ASC");
                                while ($r = mysqli_fetch_assoc($ruanganQuery)) {
                                    $selected = ($r['id_ruangan'] == $data['id_ruangan']) ? 'selected' : '';
                                    echo "<option value='{$r['id_ruangan']}' {$selected}>{$r['nama_ruangan']} (Gedung {$r['gedung']}, Kapasitas {$r['kapasitas']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tanggal Reservasi</label>
                            <input type="date" name="tanggal_reservasi" class="form-control" value="<?= htmlspecialchars($data['tanggal_reservasi']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" value="<?= htmlspecialchars($data['jam_mulai']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" value="<?= htmlspecialchars($data['jam_selesai']); ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Keperluan</label>
                            <input type="text" name="keperluan" class="form-control" value="<?= htmlspecialchars($data['keperluan']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" class="form-control" value="<?= htmlspecialchars($data['jumlah_peserta']); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="2"><?= htmlspecialchars($data['keterangan']); ?></textarea>
                        </div>

                        <!-- Khusus Admin/Petugas bisa ubah status & catatan -->
                        <div class="col-md-6 border-top pt-3 mt-3">
                            <label class="form-label fw-semibold text-primary">Status Reservasi</label>
                            <select name="status_reservasi" class="form-select border-primary" required>
                                <option value="menunggu" <?= strtolower($data['status_reservasi']) == 'menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                <option value="disetujui" <?= strtolower($data['status_reservasi']) == 'disetujui' ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="ditolak" <?= strtolower($data['status_reservasi']) == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                <option value="selesai" <?= strtolower($data['status_reservasi']) == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                <option value="dibatalkan" <?= strtolower($data['status_reservasi']) == 'dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-6 border-top pt-3 mt-3">
                            <label class="form-label fw-semibold text-primary">Catatan Admin</label>
                            <textarea name="catatan_admin" class="form-control border-primary" rows="2"><?= htmlspecialchars($data['catatan_admin']); ?></textarea>
                        </div>

                        <div class="col-12 mt-4 border-top pt-3">
                            <button type="submit" name="simpan" class="btn btn-primary me-2">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <a href="../reservasi.php" class="btn btn-light border">Batal</a>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>