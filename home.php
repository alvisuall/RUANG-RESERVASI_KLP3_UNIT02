<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

<<<<<<< HEAD
$role = $_SESSION['role'];
=======
$queryReservasiTerbaru = mysqli_query($koneksi, "
SELECT reservasi_ruangan.*,
       ruangan.nama_ruangan
FROM reservasi_ruangan
JOIN ruangan
ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
ORDER BY reservasi_ruangan.created_at DESC
LIMIT 5
");

$data = mysqli_query($koneksi, "SELECT * FROM pengguna");
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a

if ($role == 'pengguna') {
    $id_pengguna = getCurrentPenggunaId($koneksi);
    
    // Total Reservasi Saya
    $queryCount = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM reservasi_ruangan WHERE id_pengguna = $id_pengguna");
    $dataRuangan = mysqli_fetch_assoc($queryCount);
    
    // Reservasi Menunggu Saya
    $queryCount = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM reservasi_ruangan WHERE id_pengguna = $id_pengguna AND status_reservasi = 'menunggu'");
    $reservasiHariIni = mysqli_fetch_assoc($queryCount);
    
    // Reservasi Disetujui Saya
    $queryCount = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM reservasi_ruangan WHERE id_pengguna = $id_pengguna AND status_reservasi = 'disetujui'");
    $menunggu = mysqli_fetch_assoc($queryCount);
    
    // Reservasi Ditolak Saya
    $queryCount = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM reservasi_ruangan WHERE id_pengguna = $id_pengguna AND status_reservasi = 'ditolak'");
    $ditolak = mysqli_fetch_assoc($queryCount);

    // Query reservasi terbaru milik saya
    $queryReservasiTerbaru = mysqli_query($koneksi, "
        SELECT reservasi_ruangan.*, ruangan.nama_ruangan
        FROM reservasi_ruangan
        JOIN ruangan ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
        WHERE reservasi_ruangan.id_pengguna = $id_pengguna
        ORDER BY reservasi_ruangan.created_at DESC
        LIMIT 5
    ");
} else {
    // Admin / Petugas stats
    $queryRuangan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM ruangan");
    $dataRuangan = mysqli_fetch_assoc($queryRuangan);

    $query = mysqli_query($koneksi, "
        SELECT COUNT(*) AS total
        FROM reservasi_ruangan
        WHERE tanggal_reservasi = CURDATE()
    ");
    $reservasiHariIni = mysqli_fetch_assoc($query);

    $query = mysqli_query($koneksi, "
        SELECT COUNT(*) AS total
        FROM reservasi_ruangan
        WHERE status_reservasi = 'menunggu'
    ");
    $menunggu = mysqli_fetch_assoc($query);

    $query = mysqli_query($koneksi, "
        SELECT COUNT(*) AS total
        FROM reservasi_ruangan
        WHERE status_reservasi = 'ditolak'
    ");
    $ditolak = mysqli_fetch_assoc($query);

    $queryReservasiTerbaru = mysqli_query($koneksi, "
        SELECT reservasi_ruangan.*, ruangan.nama_ruangan
        FROM reservasi_ruangan
        JOIN ruangan ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
        ORDER BY reservasi_ruangan.created_at DESC
        LIMIT 5
    ");
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
    <title>Dashboard Reservasi Ruangan</title>
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
            <li><a href="home.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <?php if ($role == 'admin' || $role == 'petugas') : ?>
                <li><a href="ruangan.php"><i class="bi bi-door-open"></i> Data Ruangan</a></li>
                <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Kelola Reservasi</a></li>
                <li><a href="jadwal.php"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
                <li><a href="pengguna.php"><i class="bi bi-people"></i> Pengguna</a></li>
                <li><a href="laporan.php"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
            <?php else : ?>
                <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Buat Reservasi</a></li>
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
                    <i class="bi bi-speedometer"></i>
                </div>
                <div class="page-title">
                    <h2>Selamat Datang</h2>
                    <p>Kelola reservasi ruangan kampus dengan mudah dan cepat</p>
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

        <!-- Search Bar -->
        <div class="content-card mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-1">
                        <i class="bi bi-search"></i> Pencarian Reservasi
                    </h5>
                    <small class="text-muted">
                        Cari berdasarkan kode, nama pemesan, ruangan, tanggal, atau status.
                    </small>
                </div>
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute" style="left:15px; top:12px; color:#6c757d;"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Masukkan kata kunci..." style="padding-left:40px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Stat Card 1 -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1"><?= $role == 'pengguna' ? 'Reservasi Saya' : 'Total Ruangan'; ?></p>
                            <h3 class="fw-bold mb-0"><?php echo $dataRuangan['total']; ?></h3>
                        </div>
                        <div class="stat-icon bg-soft-primary">
                            <i class="bi <?= $role == 'pengguna' ? 'bi-calendar-check' : 'bi-door-open'; ?>"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1"><?= $role == 'pengguna' ? 'Menunggu' : 'Reservasi Hari Ini'; ?></p>
                            <h3 class="fw-bold mb-0"><?php echo $reservasiHariIni['total']; ?></h3>
                        </div>
                        <div class="stat-icon bg-soft-success">
                            <i class="bi <?= $role == 'pengguna' ? 'bi-hourglass-split' : 'bi-calendar-check'; ?>"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1"><?= $role == 'pengguna' ? 'Disetujui' : 'Menunggu'; ?></p>
                            <h3 class="fw-bold mb-0"><?php echo $menunggu['total']; ?></h3>
                        </div>
                        <div class="stat-icon bg-soft-warning">
                            <i class="bi <?= $role == 'pengguna' ? 'bi-patch-check' : 'bi-hourglass-split'; ?>"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Ditolak</p>
                            <h3 class="fw-bold mb-0"><?php echo $ditolak['total']; ?></h3>
                        </div>
                        <div class="stat-icon bg-soft-danger">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="section-title mb-0"><?= $role == 'pengguna' ? 'Reservasi Saya Terbaru' : 'Reservasi Terbaru'; ?></h5>
                <a href="reservasi.php" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Reservasi
                </a>
            </div>

            <div class="table-responsive">
<<<<<<< HEAD
                <table id="tabelReservasi" class="table table-bordered table-hover align-middle text-center shadow rounded overflow-hidden">
                    <thead class="table-primary">
                        <tr>
                            <th>Kode</th>
                            <th>Pemesan</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($queryReservasiTerbaru) > 0) {
                            while ($row = mysqli_fetch_assoc($queryReservasiTerbaru)) {
                                $badgeClass = '';
                                $rowClass = '';
                                $status = strtolower($row['status_reservasi']);
                                
                                if ($status == 'disetujui') {
                                    $badgeClass = 'bg-success';
                                    $rowClass = 'table-light';
                                } elseif ($status == 'menunggu') {
                                    $badgeClass = 'bg-warning text-dark';
                                    $rowClass = 'table-info';
                                } elseif ($status == 'ditolak') {
                                    $badgeClass = 'bg-danger';
                                    $rowClass = 'table-light';
                                } elseif ($status == 'selesai') {
                                    $badgeClass = 'bg-primary';
                                    $rowClass = 'table-light';
                                } else {
                                    $badgeClass = 'bg-secondary';
                                    $rowClass = 'table-light';
                                }
                        ?>
                        <tr class="<?= $rowClass; ?>">
                            <td><?= htmlspecialchars($row['kode_reservasi']); ?></td>
                            <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
                            <td><?= htmlspecialchars($row['nama_ruangan']); ?></td>
                            <td><?= formatTanggalIndo($row['tanggal_reservasi']); ?></td>
                            <td><?= date('H:i', strtotime($row['jam_mulai'])) . ' - ' . date('H:i', strtotime($row['jam_selesai'])); ?></td>
                            <td>
                                <span class="badge <?= $badgeClass; ?> rounded-pill">
                                    <?= ucfirst($row['status_reservasi']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-muted py-4">Belum ada data reservasi terbaru.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
=======
    <table id="tabelReservasi" class="table table-bordered table-hover align-middle text-center shadow rounded overflow-hidden">

        <thead class="table-primary">
            <tr>
                <th>Kode</th>
                <th>Pemesan</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            
            <?php while($data = mysqli_fetch_assoc($queryReservasiTerbaru)){ ?>

            <tr>

                <td><?= $data['kode_reservasi']; ?></td>

                <td><?= $data['nama_pemesan']; ?></td>

                <td><?= $data['nama_ruangan']; ?></td>

                <td><?= date("d F Y", strtotime($data['tanggal_reservasi'])); ?></td>

                <td><?= substr($data['jam_mulai'],0,5); ?> - <?= substr($data['jam_selesai'],0,5); ?></td>

                <td>

                    <?php

                        $status = strtolower(trim($data['status_reservasi']));

                        switch($status){

                            case "disetujui":
                                echo '<span class="badge bg-success rounded-pill">Disetujui</span>';
                                break;

                            case "menunggu":
                                echo '<span class="badge bg-warning text-dark rounded-pill">Menunggu</span>';
                                break;

                            case "ditolak":
                                echo '<span class="badge bg-danger rounded-pill">Ditolak</span>';
                                break;

                            case "selesai":
                                echo '<span class="badge bg-primary rounded-pill">Selesai</span>';
                                break;

                            case "dibatalkan":
                                echo '<span class="badge bg-secondary rounded-pill">Dibatalkan</span>';
                                break;

                            default:
                                echo '<span class="badge bg-dark rounded-pill">'.$data['status_reservasi'].'</span>';
                        }

                        ?>
                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>
</div>
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>