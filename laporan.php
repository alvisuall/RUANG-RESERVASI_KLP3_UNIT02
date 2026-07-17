<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
if ($role == 'pengguna') {
    header("Location: home.php");
    exit();
}

require_once "koneksi.php";

$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-01');
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : date('Y-m-t');
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Query untuk laporan
$sql = "SELECT reservasi_ruangan.*, ruangan.nama_ruangan, ruangan.kode_ruangan, pengguna.nim_nip
        FROM reservasi_ruangan
        JOIN ruangan ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
        LEFT JOIN pengguna ON reservasi_ruangan.id_pengguna = pengguna.id_pengguna
        WHERE reservasi_ruangan.tanggal_reservasi BETWEEN ? AND ?";

if (!empty($status)) {
    $sql .= " AND reservasi_ruangan.status_reservasi = ?";
}
$sql .= " ORDER BY reservasi_ruangan.tanggal_reservasi ASC, reservasi_ruangan.jam_mulai ASC";

$stmt = mysqli_prepare($koneksi, $sql);
if (!empty($status)) {
    mysqli_stmt_bind_param($stmt, "sss", $tgl_mulai, $tgl_selesai, $status);
} else {
    mysqli_stmt_bind_param($stmt, "ss", $tgl_mulai, $tgl_selesai);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Array penampung data untuk loop & export
$laporan_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $laporan_data[] = $row;
}

// Fitur Ekspor CSV
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Laporan_Reservasi_' . $tgl_mulai . '_sd_' . $tgl_selesai . '.csv');
    $output = fopen('php://output', 'w');
    
    // Header CSV
    fputcsv($output, ['Kode Reservasi', 'NIM/NIP', 'Nama Pemesan', 'Email', 'No HP', 'Kode Ruangan', 'Nama Ruangan', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Keperluan', 'Jumlah Peserta', 'Status', 'Catatan Admin']);
    
    foreach ($laporan_data as $row) {
        fputcsv($output, [
            $row['kode_reservasi'],
            $row['nim_nip'],
            $row['nama_pemesan'],
            $row['email_pemesan'],
            $row['no_hp'],
            $row['kode_ruangan'],
            $row['nama_ruangan'],
            $row['tanggal_reservasi'],
            $row['jam_mulai'],
            $row['jam_selesai'],
            $row['keperluan'],
            $row['jumlah_peserta'],
            $row['status_reservasi'],
            $row['catatan_admin']
        ]);
    }
    fclose($output);
    exit();
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
    <title>Laporan Reservasi Ruangan Kampus</title>
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
                <li><a href="laporan.php" class="active"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
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
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>
                <div class="page-title">
                    <h2>Laporan Reservasi</h2>
                    <p>Rekapitulasi pengajuan pemakaian ruangan kampus per periode</p>
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

        <div class="content-card mb-4" id="filterForm">
            <h5 class="section-title"><i class="bi bi-funnel"></i> Parameter Periode</h5>
            <form method="GET" action="">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?= htmlspecialchars($tgl_mulai); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?= htmlspecialchars($tgl_selesai); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status Reservasi</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="menunggu" <?= $status == 'menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                            <option value="disetujui" <?= $status == 'disetujui' ? 'selected' : ''; ?>>Disetujui</option>
                            <option value="ditolak" <?= $status == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                            <option value="selesai" <?= $status == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="dibatalkan" <?= $status == 'dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                        <a href="?tgl_mulai=<?= $tgl_mulai; ?>&tgl_selesai=<?= $tgl_selesai; ?>&status=<?= $status; ?>&export=csv" class="btn btn-outline-success">
                            <i class="bi bi-file-earmark-spreadsheet"></i> CSV
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <h5 class="section-title mb-0"><i class="bi bi-table"></i> Data Rekap Reservasi</h5>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="bi bi-printer"></i> Cetak Laporan / PDF
                </button>
            </div>
            
            <!-- Header khusus Cetak -->
            <div class="d-none d-print-block text-center mb-4">
                <h3>REKAPITULASI RESERVASI RUANGAN KAMPUS</h3>
                <h5>Universitas UIN Ar-Raniry</h5>
                <p class="text-muted small">Periode: <?= formatTanggalIndo($tgl_mulai); ?> s/d <?= formatTanggalIndo($tgl_selesai); ?> <?= !empty($status) ? '(Status: ' . ucfirst($status) . ')' : ''; ?></p>
                <hr style="border: 2px solid black;">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Pemesan / NIM</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Jumlah Peserta</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($laporan_data) > 0) : ?>
                            <?php $no = 1; foreach ($laporan_data as $row) : 
                                $status_res = strtolower($row['status_reservasi']);
                                $badgeClass = 'badge-secondary';
                                if ($status_res == 'disetujui') {
                                    $badgeClass = 'badge-disetujui';
                                } elseif ($status_res == 'menunggu') {
                                    $badgeClass = 'badge-menunggu';
                                } elseif ($status_res == 'ditolak') {
                                    $badgeClass = 'badge-ditolak';
                                } elseif ($status_res == 'selesai') {
                                    $badgeClass = 'badge-selesai';
                                } elseif ($status_res == 'dibatalkan') {
                                    $badgeClass = 'badge-dibatalkan';
                                }
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['kode_reservasi']); ?></td>
                                <td><?= htmlspecialchars($row['nama_pemesan']); ?> <br> <small class="text-muted"><?= htmlspecialchars($row['nim_nip']); ?></small></td>
                                <td><?= htmlspecialchars($row['nama_ruangan']); ?></td>
                                <td><?= formatTanggalIndo($row['tanggal_reservasi']); ?></td>
                                <td><?= date('H:i', strtotime($row['jam_mulai'])) . ' - ' . date('H:i', strtotime($row['jam_selesai'])); ?></td>
                                <td><?= htmlspecialchars($row['jumlah_peserta']); ?> orang</td>
                                <td><?= htmlspecialchars($row['keperluan']); ?></td>
                                <td>
                                    <span class="badge-status <?= $badgeClass; ?>">
                                        <?= ucfirst($row['status_reservasi']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-muted py-4">Tidak ada data reservasi pada periode ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Tanda Tangan Cetak -->
            <div class="d-none d-print-block mt-5 pt-3">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <div class="text-center" style="width: 250px;">
                        <p>Banda Aceh, <?= formatTanggalIndo(date('Y-m-d')); ?></p>
                        <p class="mb-5 pb-3">Administrator Kampus</p>
                        <hr style="border-top: 1px solid black; margin-top: 50px;">
                        <p class="fw-bold">NIP. ..................................</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
