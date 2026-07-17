<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

$role = $_SESSION['role'];
if ($role == 'pengguna') {
    header("Location: home.php");
    exit();
}

$data = mysqli_query($koneksi, "SELECT * FROM pengguna");

$queryJadwal = mysqli_query($koneksi, "
SELECT
    reservasi_ruangan.*,
    ruangan.nama_ruangan
FROM reservasi_ruangan
JOIN ruangan
ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
WHERE reservasi_ruangan.status_reservasi = 'disetujui'
ORDER BY reservasi_ruangan.tanggal_reservasi ASC, reservasi_ruangan.jam_mulai ASC
");

$schedulesByDate = [];
$schedulesList = [];
while ($row = mysqli_fetch_assoc($queryJadwal)) {
    $schedulesByDate[$row['tanggal_reservasi']][] = $row;
    $schedulesList[] = $row;
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
    <title>Jadwal Pemakaian Ruangan - Reservasi</title>
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
            <li><a href="ruangan.php"><i class="bi bi-door-open"></i> Data Ruangan</a></li>
            <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Kelola Reservasi</a></li>
            <li><a href="jadwal.php" class="active"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
            <li><a href="pengguna.php"><i class="bi bi-people"></i> Pengguna</a></li>
            <li><a href="laporan.php"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
            <li><a href="auth/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <div class="circle circle1"></div>
            <div class="circle circle2"></div>
            <div class="topbar-left">
                <div class="title-icon">
                    <i class="bi bi-calendar-week-fill"></i>
                </div>
                <div class="page-title">
                    <h2>Jadwal Pemakaian Ruangan</h2>
                    <p>Lihat jadwal ruangan yang sudah dipesan dan disetujui</p>
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

        <div class="content-card" id="filterForm">
            <h5 class="section-title">Filter Jadwal</h5>
            <form id="filterFormSubmit" onsubmit="event.preventDefault();">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Cari Ruangan</label>
                        <input type="search" id="cariRuangan" class="form-control" placeholder="Nama ruangan atau kode ruangan">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" id="filterTanggal" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select id="filterStatus" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="btnFilter" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-4 mb-4">
            <?php
            if (empty($schedulesByDate)) {
                echo '<div class="col-12"><div class="alert alert-info">Belum ada jadwal pemakaian ruangan yang disetujui.</div></div>';
            } else {
                foreach ($schedulesByDate as $date => $items) {
            ?>
            <div class="col-md-6 col-xl-4">
                <div class="schedule-box">
                    <div class="schedule-date">
                        <i class="bi bi-calendar-event text-primary me-1"></i>
                        <?= formatTanggalIndo($date); ?>
                    </div>

                    <?php foreach ($items as $item) { 
                        $status = strtolower($item['status_reservasi']);
                        $badgeClass = 'badge-secondary';
                        if ($status == 'disetujui') {
                            $badgeClass = 'badge-disetujui';
                        } elseif ($status == 'menunggu') {
                            $badgeClass = 'badge-menunggu';
                        } elseif ($status == 'ditolak') {
                            $badgeClass = 'badge-ditolak';
                        }
                    ?>
                    <div class="schedule-item">
                        <div class="fw-bold"><?= htmlspecialchars($item['nama_ruangan']); ?></div>
                        <div class="text-muted small"><?= date('H:i', strtotime($item['jam_mulai'])) . ' - ' . date('H:i', strtotime($item['jam_selesai'])); ?></div>
                        <div><?= htmlspecialchars($item['keperluan']); ?></div>
                        <span class="badge-status <?= $badgeClass; ?> mt-2 d-inline-block"><?= ucfirst($item['status_reservasi']); ?></span>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>

        <div class="content-card">
            <h5 class="section-title">Tabel Jadwal Pemakaian</h5>
            <div class="table-responsive">
                <table id="tabelJadwal" class="table table-hover align-middle text-center">
                    <thead>
                         <tr>
                             <th>Tanggal</th>
                             <th>Jam</th>
                             <th>Ruangan</th>
                             <th>Pemesan</th>
                             <th>Keperluan</th>
                             <th>Status</th>
                         </tr>
                     </thead>
                    <tbody>
                        <?php
                        if (empty($schedulesList)) {
                            echo '<tr><td colspan="6" class="text-muted py-3">Tidak ada jadwal pemakaian ruangan.</td></tr>';
                        } else {
                            foreach ($schedulesList as $jadwal) {
                        ?>
                        <tr>
                            <td><?= formatTanggalIndo($jadwal['tanggal_reservasi']); ?></td>
                            <td><?= date('H:i', strtotime($jadwal['jam_mulai'])); ?> - <?= date('H:i', strtotime($jadwal['jam_selesai'])); ?></td>
                            <td><?= htmlspecialchars($jadwal['nama_ruangan']); ?></td>
                            <td><?= htmlspecialchars($jadwal['nama_pemesan']); ?></td>
                            <td><?= htmlspecialchars($jadwal['keperluan']); ?></td>
                            <td>
                                <?php
                                $status = strtolower($jadwal['status_reservasi']);
                                if ($status == 'disetujui') {
                                    echo '<span class="badge-status badge-disetujui">Disetujui</span>';
                                } elseif ($status == 'menunggu') {
                                    echo '<span class="badge-status badge-menunggu">Menunggu</span>';
                                } else {
                                    echo '<span class="badge-status">'.ucfirst($jadwal['status_reservasi']).'</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php 
                            }
                        }
                        ?>
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