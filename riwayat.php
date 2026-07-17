<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

$id_pengguna = getCurrentPenggunaId($koneksi);
$role = $_SESSION['role'];

// Query riwayat reservasi personal
$queryRiwayat = mysqli_prepare($koneksi, "
    SELECT reservasi_ruangan.*, ruangan.nama_ruangan, ruangan.gedung
    FROM reservasi_ruangan
    JOIN ruangan ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
    WHERE reservasi_ruangan.id_pengguna = ?
    ORDER BY reservasi_ruangan.tanggal_reservasi DESC, reservasi_ruangan.jam_mulai DESC
");
mysqli_stmt_bind_param($queryRiwayat, "i", $id_pengguna);
mysqli_stmt_execute($queryRiwayat);
$result = mysqli_stmt_get_result($queryRiwayat);

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
    <title>Riwayat Reservasi Saya</title>
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
                <li><a href="riwayat.php" class="active"><i class="bi bi-clock-history"></i> Riwayat Reservasi</a></li>
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
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="page-title">
                    <h2>Riwayat Reservasi Saya</h2>
                    <p>Pantau status pengajuan reservasi ruangan Anda</p>
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

        <div class="content-card">
            <h5 class="section-title"><i class="bi bi-funnel"></i> Pencarian & Filter</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                   <input type="search" id="searchInput" class="form-control" placeholder="Cari kode, ruangan, keperluan...">
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
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="content-card">
            <h5 class="section-title mb-4"><i class="bi bi-list-stars"></i> Daftar Pengajuan Reservasi</h5>
            <div class="table-responsive">
                <table id="tabelReservasi" class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Peserta</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Catatan Admin / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0) : ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) : 
                                $status = strtolower($row['status_reservasi']);
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
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($row['kode_reservasi']); ?></td>
                                <td><?= htmlspecialchars($row['nama_ruangan']); ?> <br> <small class="text-muted"><?= htmlspecialchars($row['gedung']); ?></small></td>
                                <td><?= formatTanggalIndo($row['tanggal_reservasi']); ?></td>
                                <td><?= date('H:i', strtotime($row['jam_mulai'])) . ' - ' . date('H:i', strtotime($row['jam_selesai'])); ?></td>
                                <td><?= htmlspecialchars($row['jumlah_peserta']); ?> orang</td>
                                <td><?= htmlspecialchars($row['keperluan']); ?></td>
                                <td>
                                    <span class="badge-status <?= $badgeClass; ?> d-inline-block">
                                        <?= ucfirst($row['status_reservasi']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($row['catatan_admin'])) : ?>
                                        <small class="text-info d-block fw-semibold">Catatan Admin:</small>
                                        <small><?= htmlspecialchars($row['catatan_admin']); ?></small>
                                    <?php else : ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-muted py-4">Anda belum pernah mengajukan reservasi ruangan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
