<?php
require_once "koneksi.php";

// Query untuk card jadwal
$queryJadwalCard = mysqli_query($koneksi,"
SELECT reservasi_ruangan.*,
       ruangan.nama_ruangan
FROM reservasi_ruangan
JOIN ruangan
ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
ORDER BY tanggal_reservasi ASC, jam_mulai ASC
");

// Query untuk tabel jadwal
$queryJadwalTabel = mysqli_query($koneksi,"
SELECT reservasi_ruangan.*,
       ruangan.nama_ruangan
FROM reservasi_ruangan
JOIN ruangan
ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan
ORDER BY tanggal_reservasi ASC, jam_mulai ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pemakaian Ruangan</title>

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
            <li><a href="ruangan.php"><i class="bi bi-door-open"></i> Data Ruangan</a></li>
            <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Reservasi</a></li>
            <li><a href="jadwal.php"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
            <li><a href="pengguna.php"><i class="bi bi-people"></i> Pengguna</a></li>
            <li><a href="auth/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">

        <div class="topbar">
            <div class="circle circle1"></div>
<div class="circle circle2"></div>

    <div class="topbar-left">

        <div class="title-icon">
            <i class="bi bi-people-fill"></i>
        </div>

        <div class="page-title">

            <h2>Jadwal Pemakaian Ruangan</h2>

            <p>Lihat jadwal ruangan yang sudah dipesan dan disetujui</p>

            <div class="title-line"></div>

        </div>

    </div>

    <div class="profile-card">

        <div class="avatar">
            A
        </div>

        <div>

            <h5>Admin Kampus</h5>

            <small>Administrator</small>

        </div>

    </div>

</div>
        <div class="content-card">
            <h5 class="section-title">Filter Jadwal</h5>

            <form id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Cari Ruangan</label>
                       <input type="search"id="cariRuangan"class="form-control"placeholder="Nama ruangan atau kode ruangan">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date"id="filterTanggal"class="form-control">
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
                         <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-4 mb-4">

            <?php
            $tanggalSebelumnya = "";
            while($jadwal = mysqli_fetch_assoc($queryJadwalCard)){
                if($tanggalSebelumnya != $jadwal['tanggal_reservasi']){
                    if($tanggalSebelumnya != ""){
                        echo "</div></div>";
                    }

            ?>

            <div class="col-md-6 col-xl-4">
                <div class="schedule-box">
                    <div class="schedule-date">
                        <i class="bi bi-calendar-event text-primary me-1"></i>
                        <?= date("d F Y", strtotime($jadwal['tanggal_reservasi'])); ?>
                    </div>
                <?php
                        $tanggalSebelumnya = $jadwal['tanggal_reservasi'];
                    }

                ?>
                        <div class="schedule-item">
                            <div class="fw-bold">
                                <?= $jadwal['nama_ruangan']; ?>
                            </div>

                            <div class="text-muted small">
                                <?= substr($jadwal['jam_mulai'],0,5); ?>
                                -
                                <?= substr($jadwal['jam_selesai'],0,5); ?>
                            </div>

                            <div>
                                <?= $jadwal['keperluan']; ?>
                            </div>

                            <?php

                            $status = strtolower($jadwal['status_reservasi']);

                            if($status=="disetujui"){

                                echo '<span class="badge-status badge-disetujui mt-2 d-inline-block">Disetujui</span>';

                            }elseif($status=="menunggu"){

                                echo '<span class="badge-status badge-menunggu mt-2 d-inline-block">Menunggu</span>';

                            }elseif($status=="ditolak"){

                                echo '<span class="badge-status badge-ditolak mt-2 d-inline-block">Ditolak</span>';

                            }elseif($status=="selesai"){

                                echo '<span class="badge-status badge-selesai mt-2 d-inline-block">Selesai</span>';

                            }else{

                                echo '<span class="badge-status mt-2 d-inline-block">'.$jadwal['status_reservasi'].'</span>';

                            }

                            ?>

                        </div>

                <?php } ?>

                <?php
                if($tanggalSebelumnya != ""){
                    echo "</div></div>";
                }
                ?>
</div>

        <div class="content-card">
            <h5 class="section-title">Tabel Jadwal Pemakaian</h5>

            <div class="table-responsive">
                <table id="tabelJadwal" class="table table-hover">

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

                    <?php while($data = mysqli_fetch_assoc($queryJadwalTabel)){ ?>

                    <tr>

                        <td><?= date("Y-m-d", strtotime($data['tanggal_reservasi'])); ?></td>

                        <td>
                            <?= substr($data['jam_mulai'],0,5); ?>
                            -
                            <?= substr($data['jam_selesai'],0,5); ?>
                        </td>

                        <td><?= $data['nama_ruangan']; ?></td>

                        <td><?= $data['nama_pemesan']; ?></td>

                        <td><?= $data['keperluan']; ?></td>

                        <td>
                            <?php

                            $status = strtolower($data['status_reservasi']);

                            if($status == "disetujui"){
                                echo '<span class="badge bg-success">Disetujui</span>';
                            }elseif($status == "menunggu"){
                                echo '<span class="badge bg-warning text-dark">Menunggu</span>';
                            }elseif($status == "ditolak"){
                                echo '<span class="badge bg-danger">Ditolak</span>';
                            }elseif($status == "selesai"){
                                echo '<span class="badge bg-primary">Selesai</span>';
                            }else{
                                echo '<span class="badge bg-secondary">'.$data['status_reservasi'].'</span>';
                            }

                            ?>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>