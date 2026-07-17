<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

$id_pengguna = getCurrentPenggunaId($koneksi);
$role = $_SESSION['role'];
$success_msg = '';
$error_msg = '';

// Ambil data detail profil dari pengguna
$stmt = mysqli_prepare($koneksi, "SELECT * FROM pengguna WHERE id_pengguna = ?");
mysqli_stmt_bind_param($stmt, "i", $id_pengguna);
mysqli_stmt_execute($stmt);
$data_pengguna = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (isset($_POST['update_profil'])) {
    $nama = trim($_POST['nama_lengkap']);
    $nim = trim($_POST['nim_nip']);
    $jenis = trim($_POST['jenis_pengguna']);
    $fakultas = trim($_POST['fakultas_unit']);
    $prodi = trim($_POST['prodi_bagian']);
    $hp = trim($_POST['no_hp']);
    $alamat = trim($_POST['alamat']);

    if (empty($nama) || empty($nim) || empty($jenis) || empty($fakultas) || empty($prodi) || empty($hp) || empty($alamat)) {
        $error_msg = "Semua field wajib diisi!";
    } else {
        // Update tabel pengguna
        $updateP = mysqli_prepare($koneksi, "
            UPDATE pengguna 
            SET nama_lengkap = ?, nim_nip = ?, jenis_pengguna = ?, fakultas_unit = ?, prodi_bagian = ?, no_hp = ?, alamat = ?
            WHERE id_pengguna = ?
        ");
        mysqli_stmt_bind_param($updateP, "sssssssi", $nama, $nim, $jenis, $fakultas, $prodi, $hp, $alamat, $id_pengguna);
        
        // Update tabel user_login
        $updateL = mysqli_prepare($koneksi, "
            UPDATE user_login
            SET nama_lengkap = ?
            WHERE email = ?
        ");
        mysqli_stmt_bind_param($updateL, "ss", $nama, $_SESSION['email']);

        if (mysqli_stmt_execute($updateP) && mysqli_stmt_execute($updateL)) {
            $_SESSION['nama'] = $nama; // Update session name
            $success_msg = "Profil Anda berhasil diperbarui!";
            
            // Reload data
            mysqli_stmt_execute($stmt);
            $data_pengguna = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        } else {
            $error_msg = "Gagal memperbarui profil. Mohon coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Reservasi Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
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
            <li><a href="home.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <?php if ($role == 'admin' || $role == 'petugas') : ?>
                <li><a href="ruangan.php"><i class="bi bi-door-open"></i> Data Ruangan</a></li>
                <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Kelola Reservasi</a></li>
                <li><a href="jadwal.php"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
                <li><a href="pengguna.php"><i class="bi bi-people"></i> Pengguna</a></li>
                <li><a href="laporan.php"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
            <?php else : ?>
                <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Buat Reservasi</a></li>
                <li><a href="riwayat.php"><i class="bi bi-clock-history"></i> Riwayat Reservasi</a></li>
                <li><a href="profil.php" class="active"><i class="bi bi-person-circle"></i> Profil Saya</a></li>
            <?php endif; ?>
            <li><a href="auth/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <div class="circle circle1"></div>
            <div class="circle circle2"></div>
            <div class="topbar-left">
                <div class="title-icon">
                    <i class="bi bi-person-bounding-box"></i>
                </div>
                <div class="page-title">
                    <h2>Profil Saya</h2>
                    <p>Kelola detail informasi profil personal Anda</p>
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

        <?php if (!empty($success_msg)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> <?= $success_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> <?= $error_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="content-card">
            <h5 class="section-title mb-4"><i class="bi bi-person-gear"></i> Pengaturan Informasi Profil</h5>
            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data_pengguna['nama_lengkap']); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIM / NIP</label>
                        <input type="text" name="nim_nip" class="form-control" value="<?= htmlspecialchars($data_pengguna['nim_nip']); ?>" placeholder="Masukkan NIM atau NIP" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Pengguna</label>
                        <select name="jenis_pengguna" class="form-select" required>
                            <option value="mahasiswa" <?= strtolower($data_pengguna['jenis_pengguna']) == 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                            <option value="dosen" <?= strtolower($data_pengguna['jenis_pengguna']) == 'dosen' ? 'selected' : ''; ?>>Dosen</option>
                            <option value="tendik" <?= strtolower($data_pengguna['jenis_pengguna']) == 'tendik' ? 'selected' : ''; ?>>Tendik</option>
                            <option value="organisasi" <?= strtolower($data_pengguna['jenis_pengguna']) == 'organisasi' ? 'selected' : ''; ?>>Organisasi</option>
                            <option value="umum" <?= strtolower($data_pengguna['jenis_pengguna']) == 'umum' ? 'selected' : ''; ?>>Umum</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fakultas / Unit Kerja</label>
                        <input type="text" name="fakultas_unit" class="form-control" value="<?= htmlspecialchars($data_pengguna['fakultas_unit']); ?>" placeholder="Contoh: Fakultas Tarbiyah dan Keguruan" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prodi / Bagian</label>
                        <input type="text" name="prodi_bagian" class="form-control" value="<?= htmlspecialchars($data_pengguna['prodi_bagian']); ?>" placeholder="Contoh: Pendidikan Teknologi Informasi" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email (Tidak dapat diubah)</label>
                        <input type="email" class="form-control text-muted" value="<?= htmlspecialchars($data_pengguna['email']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="tel" name="no_hp" class="form-control" value="<?= htmlspecialchars($data_pengguna['no_hp']); ?>" placeholder="Contoh: 08123456789" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat Tempat Tinggal</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap Anda" required><?= htmlspecialchars($data_pengguna['alamat']); ?></textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" name="update_profil" class="btn btn-primary">
                            <i class="bi bi-save2"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
