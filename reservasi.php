<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

<<<<<<< HEAD
$role = $_SESSION['role'];
$id_pengguna = getCurrentPenggunaId($koneksi);

if ($role == 'pengguna') {
    // Pengguna biasa hanya melihat data miliknya sendiri
    $queryReservasi = mysqli_prepare($koneksi,
        "SELECT reservasi_ruangan.*, ruangan.nama_ruangan
        FROM reservasi_ruangan
        JOIN ruangan ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
        WHERE reservasi_ruangan.id_pengguna = ?
        ORDER BY reservasi_ruangan.created_at DESC");
    mysqli_stmt_bind_param($queryReservasi, "i", $id_pengguna);
    mysqli_stmt_execute($queryReservasi);
    $resultReservasi = mysqli_stmt_get_result($queryReservasi);
} else {
    // Admin dan Petugas melihat semua data
    $resultReservasi = mysqli_query($koneksi,
        "SELECT reservasi_ruangan.*, ruangan.nama_ruangan
        FROM reservasi_ruangan
        JOIN ruangan ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
        ORDER BY reservasi_ruangan.created_at DESC");
}

function formatTanggalIndo($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $split = explode('-', $tanggal);
    if(count($split) !== 3) return $tanggal;
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
=======
$mode = "tambah";
$dataEdit = [];

if (isset($_GET['edit'])) {

    $mode = "edit";
    $id = (int)$_GET['edit'];

    $queryEdit = mysqli_query($koneksi,
        "SELECT * FROM reservasi_ruangan WHERE id_reservasi = $id");

    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

$queryReservasi = mysqli_query($koneksi,
    "SELECT reservasi_ruangan.*, ruangan.nama_ruangan
    FROM reservasi_ruangan
    JOIN ruangan
    ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan");
$data = mysqli_query($koneksi, "SELECT * FROM pengguna");
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Ruangan Kampus</title>
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
                <li><a href="reservasi.php" class="active"><i class="bi bi-calendar-plus"></i> Kelola Reservasi</a></li>
                <li><a href="jadwal.php"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
                <li><a href="pengguna.php"><i class="bi bi-people"></i> Pengguna</a></li>
                <li><a href="laporan.php"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
            <?php else : ?>
                <li><a href="reservasi.php" class="active"><i class="bi bi-calendar-plus"></i> Buat Reservasi</a></li>
                <li><a href="riwayat.php"><i class="bi bi-clock-history"></i> Riwayat Reservasi</a></li>
                <li><a href="profil.php"><i class="bi bi-person-circle"></i> Profil Saya</a></li>
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
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div class="page-title">
                    <h2><?= $role == 'pengguna' ? 'Form Reservasi' : 'Kelola Reservasi'; ?></h2>
                    <p>Ajukan pemakaian ruangan kampus berdasarkan tanggal dan jam</p>
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

        <?php if (isset($_GET['success'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Reservasi ruangan berhasil <?= htmlspecialchars($_GET['success'] == 'edit' ? 'diperbarui' : 'diajukan'); ?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'hapus') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data reservasi berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

<<<<<<< HEAD
        <div class="content-card">
            <h5 class="section-title">Input Reservasi Ruangan</h5>
            <form id="formReservasi" action="pages/tambah.php?halaman=reservasi" method="POST">
=======
    <div class="content-card">
        <h5 class="section-title">
            <?= ($mode=="edit") ? "Form Edit Reservasi" : "Input Reservasi Ruangan"; ?>
        </h5>

           <form id="formReservasi"
                action="<?= ($mode=="edit") ? "pages/edit.php" : "pages/tambah.php"; ?>"
                method="POST">

                <input type="hidden" name="halaman" value="reservasi">
                    <?php if($mode=="edit"){ ?>
                    <input type="hidden" name="id_reservasi" value="<?= $dataEdit['id_reservasi']; ?>">
                    <?php } ?>

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                <div class="row g-3">
                    <!-- Kode Reservasi -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Reservasi</label>
<<<<<<< HEAD
                        <input type="text" id="kode_reservasi" name="kode_reservasi" class="form-control" value="RSV-<?= date('Ymd') ?>-<?= rand(100, 999) ?>" readonly required>
=======
                       <input
                        type="text"
                        id="kode"
                        name="kode_reservasi"
                        class="form-control"
                        placeholder="RSV-2026-004"
                        value="<?= ($mode=="edit") ? $dataEdit['kode_reservasi'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>

                    <?php if ($role == 'pengguna') : ?>
                        <!-- User login info (mahasiswa) -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Pemesan</label>
                            <input type="text" class="form-control text-muted" value="<?= htmlspecialchars($_SESSION['nama']); ?> (<?= htmlspecialchars($_SESSION['email']); ?>)" readonly>
                            <input type="hidden" id="id_pengguna" name="id_pengguna" value="<?= $id_pengguna; ?>">
                        </div>
                    <?php else : ?>
                        <!-- Pilih Pengguna (Admin/Petugas) -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Pilih Pengguna</label>
                            <select id="id_pengguna" name="id_pengguna" class="form-select" required>
                                <option value="">Pilih Pengguna</option>
                                <?php
                                $pengguna = mysqli_query($koneksi, "SELECT * FROM pengguna ORDER BY nama_lengkap ASC");
                                while($p=mysqli_fetch_assoc($pengguna)){
                                ?>
                                <option value="<?= $p['id_pengguna']; ?>">
                                    <?= htmlspecialchars($p['nama_lengkap']); ?> (<?= htmlspecialchars($p['nim_nip']); ?>)
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <!-- Pilih Ruangan -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Pilih Ruangan</label>
<<<<<<< HEAD
                        <select id="id_ruangan" name="id_ruangan" class="form-select" required>
                            <option value="">Pilih Ruangan</option>
                            <?php
                            $ruangan = mysqli_query($koneksi, "SELECT * FROM ruangan WHERE status_ruangan='tersedia' ORDER BY nama_ruangan");
                            while($r=mysqli_fetch_assoc($ruangan)){
                            ?>
                            <option value="<?= $r['id_ruangan']; ?>">
                                <?= htmlspecialchars($r['nama_ruangan']); ?> | <?= htmlspecialchars($r['gedung']); ?> | Kapasitas <?= $r['kapasitas']; ?> orang
                            </option>
=======
                        <select name="id_ruangan" id="ruangan" class="form-select">

                            <option value="">Pilih ruangan</option>
                            <?php
                            $queryRuangan=mysqli_query($koneksi,"SELECT * FROM ruangan");
                            while($ruangan=mysqli_fetch_assoc($queryRuangan)){
                            ?>

                            <option
                            value="<?= $ruangan['id_ruangan']; ?>"
                            <?= ($mode=="edit" && $ruangan['id_ruangan']==$dataEdit['id_ruangan']) ? "selected" : ""; ?>>
                            <?= $ruangan['nama_ruangan']; ?> - Kapasitas <?= $ruangan['kapasitas']; ?>
                            </option>

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                            <?php } ?>
                        </select>
                    </div>

<<<<<<< HEAD
                    <!-- Tanggal -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Reservasi</label>
                        <input type="date" id="tanggal_reservasi" name="tanggal_reservasi" class="form-control" required>
=======
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Pemesan</label>
                        <input
                        type="text"
                        id="nama"
                        name="nama_pemesan"
                        class="form-control"
                        placeholder="John Doe"
                        value="<?= ($mode=="edit") ? $dataEdit['nama_pemesan'] : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                       <input type="email" id="email" name="email_pemesan" class="form-control" placeholder="johndoe@example.com" value="<?= ($mode=="edit") ? $dataEdit['email_pemesan'] : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="tel" id="hp" name="no_hp" class="form-control" placeholder="081234567890" value="<?= ($mode=="edit") ? $dataEdit['no_hp'] : ''; ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Reservasi</label>
                       <input type="date" id="tanggal" name="tanggal_reservasi" class="form-control" placeholder="2023-10-10" value="<?= ($mode=="edit") ? $dataEdit['tanggal_reservasi'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>

                    <!-- Jam Mulai -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Mulai</label>
<<<<<<< HEAD
                        <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" required>
=======
                        <input type="time" id="jamMulai" name="jam_mulai" class="form-control"placeholder=" 09:00" value="<?= ($mode=="edit") ? $dataEdit['jam_mulai'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>

                    <!-- Jam Selesai -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Selesai</label>
<<<<<<< HEAD
                        <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" required>
=======
                        <input type="time" id="jamSelesai" name="jam_selesai" class="form-control"placeholder="11:00" value="<?= ($mode=="edit") ? $dataEdit['jam_selesai'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>

                    <!-- Keperluan -->
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Keperluan</label>
<<<<<<< HEAD
                        <input type="text" id="keperluan" name="keperluan" class="form-control" placeholder="Contoh : Seminar, Rapat, Kuliah Umum" required>
=======
                       <input type="text" id="keperluan" name="keperluan" class="form-control"placeholder="Pertemuan dengan dosen" value="<?= ($mode=="edit") ? $dataEdit['keperluan'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>

                    <!-- Jumlah Peserta -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah Peserta</label>
<<<<<<< HEAD
                        <input type="number" id="jumlah_peserta" name="jumlah_peserta" class="form-control" min="1" placeholder="20" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan (opsional)"></textarea>
                    </div>

                    <!-- Hidden -->
                    <input type="hidden" name="status_reservasi" value="menunggu">
                    <input type="hidden" name="catatan_admin" value="-">

                    <!-- Informasi -->
=======
                        <input type="number" id="peserta" name="jumlah_peserta" class="form-control"placeholder=" 20" value="<?= ($mode=="edit") ? $dataEdit['jumlah_peserta'] : ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Reservasi</label>
                        <select id="status" name="status_reservasi" class="form-select">
                            <option value="menunggu" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                            <option value="disetujui" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                            <option value="ditolak" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                            <option value="selesai" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                            <option value="dibatalkan" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Catatan Admin</label>
                       <input type="text" id="catatan" name="catatan_admin" class="form-control"placeholder="Reservasi disetujui" value="<?= ($mode=="edit") ? $dataEdit['catatan_admin'] : ''; ?>">
                    </div>
                    
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    <div class="col-12">
                        <div class="alert alert-info">
                            <strong>Informasi :</strong> Setelah reservasi dikirim, status akan menjadi <strong>Menunggu</strong> dan akan diverifikasi oleh Administrator.
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="col-12">
<<<<<<< HEAD
                        <button type="submit" name="simpan" class="btn btn-primary me-2">
                            <i class="bi bi-send"></i> Ajukan Reservasi
                        </button>
                        <button type="reset" class="btn btn-light border">Reset</button>
=======
                       <button type="submit" class="btn btn-primary">
                            <i class="bi <?= ($mode=="edit") ? "bi-pencil-square" : "bi-send"; ?>"></i>
                            <?= ($mode=="edit") ? "Update Reservasi" : "Ajukan Reservasi"; ?>
                        </button>
                        
                        <button type="reset" class="btn btn-light border">
                            Reset
                        </button>
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                </div>
            </form>
        </div>

        <div class="content-card">
            <h5 class="section-title"><?= $role == 'pengguna' ? 'Daftar Reservasi Saya' : 'Daftar Semua Reservasi'; ?></h5>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
<<<<<<< HEAD
                   <input type="search" id="searchInput" class="form-control" placeholder="Cari nama, kode, atau status...">
=======
                   <input type="search"
                            id="searchReservasi"
                            class="form-control"
                            placeholder="Nama peserta, kode reservasi, atau ruangan">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                </div>
                <div class="col-md-3">
                    <select id="filterStatus" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" id="filterTanggal" class="form-control">
                </div>
                <div class="col-md-2">
                    <button id="btnFilter" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tabelReservasi" class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pemesan</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Peserta</th>
                            <th>Status</th>
                            <?php if ($role == 'admin' || $role == 'petugas') : ?>
                                <th width="160">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultReservasi) > 0) : ?>
                            <?php while($reservasi_ruangan = mysqli_fetch_assoc($resultReservasi)){ 
                                $status = strtolower($reservasi_ruangan['status_reservasi']);
                                $badgeClass = 'badge-secondary';
                                if ($status == 'disetujui') {
                                    $badgeClass = 'badge-disetujui';
                                } elseif ($status == 'menunggu') {
                                    $badgeClass = 'badge-menunggu';
                                } elseif ($status == 'ditolak') {
                                    $badgeClass = 'badge-ditolak';
                                } elseif ($status == 'selesai') {
                                    $badgeClass = 'badge-selesai';
                                } elseif ($status == 'dibatalkan') {
                                    $badgeClass = 'badge-dibatalkan';
                                }
<<<<<<< HEAD
                            ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($reservasi_ruangan['kode_reservasi']); ?></td>
                                <td><?= htmlspecialchars($reservasi_ruangan['nama_pemesan']); ?></td>
                                <td><?= htmlspecialchars($reservasi_ruangan['nama_ruangan']); ?></td>
                                <td><?= formatTanggalIndo($reservasi_ruangan['tanggal_reservasi']); ?></td>
                                <td><?= date('H:i', strtotime($reservasi_ruangan['jam_mulai'])) . ' - ' . date('H:i', strtotime($reservasi_ruangan['jam_selesai'])); ?></td>
                                <td><?= htmlspecialchars($reservasi_ruangan['jumlah_peserta']); ?> orang</td>
                                <td>
                                    <span class="badge-status <?= $badgeClass; ?> d-inline-block">
                                        <?= ucfirst($reservasi_ruangan['status_reservasi']); ?>
                                    </span>
                                </td>
                                <?php if ($role == 'admin' || $role == 'petugas') : ?>
                                    <td>
                                        <a href="pages/edit.php?halaman=reservasi&id=<?= $reservasi_ruangan['id_reservasi']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="pages/hapus.php?halaman=reservasi&id=<?= $reservasi_ruangan['id_reservasi']; ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Yakin ingin menghapus data ini?');">
                                                <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php } ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="<?= ($role == 'admin' || $role == 'petugas') ? 8 : 7; ?>" class="text-muted py-4">Belum ada pengajuan reservasi.</td>
                            </tr>
                        <?php endif; ?>
=======
                                ?>
                            </td>

                            <td>
                                <a href="reservasi.php?edit=<?= $reservasi_ruangan['id_reservasi']; ?>"
                                class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <a href="pages/hapus.php?halaman=reservasi&id=<?= $reservasi_ruangan['id_reservasi']; ?>"
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Yakin ingin menghapus data ini?');">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>

                        </tr>

                        <?php } 
                        ?>

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<script>
setTimeout(function(){
    let alert=document.querySelector(".alert");
    if(alert){
        alert.classList.remove("show");
        setTimeout(function(){
            alert.remove();
        },300);
    }
},3000);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>