<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

$role = $_SESSION['role'];
$id_pengguna = null;
if ($role == 'pengguna') {
    $id_pengguna = getCurrentPenggunaId($koneksi);
}

$mode = "tambah";
$dataEdit = [];

if (isset($_GET['edit'])) {
    $mode = "edit";
    $id = (int)$_GET['edit'];
    $queryEdit = mysqli_query($koneksi,
        "SELECT * FROM reservasi_ruangan WHERE id_reservasi = $id");
    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

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

        <div class="content-card">
            <h5 class="section-title"><?= ($mode == "edit") ? "Form Edit Reservasi" : "Input Reservasi Ruangan"; ?></h5>
            <form id="formReservasi" action="<?= ($mode == "edit") ? "pages/edit.php" : "pages/tambah.php?halaman=reservasi"; ?>" method="POST">
                <input type="hidden" name="halaman" value="reservasi">
                <?php if ($mode == "edit") : ?>
                    <input type="hidden" name="id_reservasi" value="<?= $dataEdit['id_reservasi']; ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <!-- Kode Reservasi -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Reservasi</label>
                        <input type="text" id="kode_reservasi" name="kode_reservasi" class="form-control" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['kode_reservasi']) : 'RSV-' . date('Ymd') . '-' . rand(100, 999); ?>" readonly required>
                    </div>

                    <?php if ($role == 'pengguna') : ?>
                        <!-- User login info (mahasiswa) -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Pemesan</label>
                            <input type="text" class="form-control text-muted" value="<?= htmlspecialchars($_SESSION['nama']); ?> (<?= htmlspecialchars($_SESSION['email']); ?>)" readonly>
                            <input type="hidden" id="id_pengguna" name="id_pengguna" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['id_pengguna']) : $id_pengguna; ?>">
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
                                <option value="<?= $p['id_pengguna']; ?>" <?= ($mode == "edit" && $p['id_pengguna'] == $dataEdit['id_pengguna']) ? "selected" : ""; ?>>
                                    <?= htmlspecialchars($p['nama_lengkap']); ?> (<?= htmlspecialchars($p['nim_nip']); ?>)
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <!-- Pilih Ruangan -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Pilih Ruangan</label>
                        <select id="id_ruangan" name="id_ruangan" class="form-select" required>
                            <option value="">Pilih Ruangan</option>
                            <?php
                            $ruangan = mysqli_query($koneksi, "SELECT * FROM ruangan WHERE status_ruangan='tersedia' ORDER BY nama_ruangan");
                            while($r=mysqli_fetch_assoc($ruangan)){
                            ?>
                            <option value="<?= $r['id_ruangan']; ?>" <?= ($mode == "edit" && $r['id_ruangan'] == $dataEdit['id_ruangan']) ? "selected" : ""; ?>>
                                <?= htmlspecialchars($r['nama_ruangan']); ?> | <?= htmlspecialchars($r['gedung']); ?> | Kapasitas <?= $r['kapasitas']; ?> orang
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Reservasi</label>
                        <input type="date" id="tanggal_reservasi" name="tanggal_reservasi" class="form-control" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['tanggal_reservasi']) : ''; ?>" required>
                    </div>

                    <!-- Jam Mulai -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['jam_mulai']) : ''; ?>" required>
                    </div>

                    <!-- Jam Selesai -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['jam_selesai']) : ''; ?>" required>
                    </div>

                    <!-- Keperluan -->
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Keperluan</label>
                        <input type="text" id="keperluan" name="keperluan" class="form-control" placeholder="Contoh : Seminar, Rapat, Kuliah Umum" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['keperluan']) : ''; ?>" required>
                    </div>

                    <!-- Jumlah Peserta -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah Peserta</label>
                        <input type="number" id="jumlah_peserta" name="jumlah_peserta" class="form-control" min="1" placeholder="20" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['jumlah_peserta']) : ''; ?>" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan (opsional)"><?= ($mode == "edit") ? htmlspecialchars($dataEdit['keterangan']) : ''; ?></textarea>
                    </div>

                    <!-- Hidden fields for status & admin notes -->
                    <input type="hidden" name="status_reservasi" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['status_reservasi']) : 'menunggu'; ?>">
                    <input type="hidden" name="catatan_admin" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['catatan_admin']) : '-'; ?>">

                    <!-- Informasi -->
                    <div class="col-12">
                        <div class="alert alert-info">
                            <strong>Informasi :</strong> Setelah reservasi dikirim, status akan menjadi <strong>Menunggu</strong> dan akan diverifikasi oleh Administrator.
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="col-12">
                        <button type="submit" name="simpan" class="btn btn-primary me-2">
                            <i class="bi <?= ($mode == "edit") ? "bi-pencil-square" : "bi-send"; ?>"></i> 
                            <?= ($mode == "edit") ? "Update Reservasi" : "Ajukan Reservasi"; ?>
                        </button>
                        <?php if ($mode == "edit") : ?>
                            <a href="reservasi.php" class="btn btn-light border">Batal</a>
                        <?php else : ?>
                            <button type="reset" class="btn btn-light border">Reset</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <div class="content-card">
            <h5 class="section-title"><?= $role == 'pengguna' ? 'Daftar Reservasi Saya' : 'Daftar Semua Reservasi'; ?></h5>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                   <input type="search" id="searchInput" class="form-control" placeholder="Cari nama, kode, atau status...">
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
                            ?>
                            <tr class="<?= 'table-' . ($status == 'disetujui' ? 'success' : ($status == 'menunggu' ? 'info' : ($status == 'ditolak' ? 'danger' : ($status == 'selesai' ? 'light' : 'warning')))); ?>">
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