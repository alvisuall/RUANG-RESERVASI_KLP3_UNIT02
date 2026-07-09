<?php
include 'koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM pengguna");
?>
<!DOCTYPE php>
<php lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pemakaian Ruangan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
            <li><a href="#"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
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

            <form action="#" method="get">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Cari Ruangan</label>
                        <input type="search" class="form-control" placeholder="Nama ruangan atau kode ruangan">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select">
                            <option>Semua Status</option>
                            <option>Disetujui</option>
                            <option>Menunggu</option>
                            <option>Selesai</option>
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
            <div class="col-md-6 col-xl-4">
                <div class="schedule-box">
                    <div class="schedule-date">
                        <i class="bi bi-calendar-event text-primary me-1"></i>
                        05 Juli 2026
                    </div>

                    <div class="schedule-item">
                        <div class="fw-bold">Ruang Kuliah A101</div>
                        <div class="text-muted small">08:00 - 10:00</div>
                        <div>Diskusi Kelompok Mata Kuliah</div>
                        <span class="badge-status badge-disetujui mt-2 d-inline-block">Disetujui</span>
                    </div>

                    <div class="schedule-item">
                        <div class="fw-bold">Ruang Seminar B205</div>
                        <div class="text-muted small">13:00 - 15:00</div>
                        <div>Rapat Koordinasi Dosen</div>
                        <span class="badge-status badge-menunggu mt-2 d-inline-block">Menunggu</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="schedule-box">
                    <div class="schedule-date">
                        <i class="bi bi-calendar-event text-primary me-1"></i>
                        06 Juli 2026
                    </div>

                    <div class="schedule-item">
                        <div class="fw-bold">Laboratorium Komputer PTI</div>
                        <div class="text-muted small">09:00 - 12:00</div>
                        <div>Praktikum Pemrograman Web</div>
                        <span class="badge-status badge-menunggu mt-2 d-inline-block">Menunggu</span>
                    </div>

                    <div class="schedule-item">
                        <div class="fw-bold">Ruang Kuliah A101</div>
                        <div class="text-muted small">14:00 - 16:00</div>
                        <div>Kuliah Tamu Teknologi Pendidikan</div>
                        <span class="badge-status badge-disetujui mt-2 d-inline-block">Disetujui</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="schedule-box">
                    <div class="schedule-date">
                        <i class="bi bi-calendar-event text-primary me-1"></i>
                        10 Juli 2026
                    </div>

                    <div class="schedule-item">
                        <div class="fw-bold">Aula Utama Kampus</div>
                        <div class="text-muted small">13:00 - 16:00</div>
                        <div>Seminar Teknologi Pendidikan</div>
                        <span class="badge-status badge-disetujui mt-2 d-inline-block">Disetujui</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <h5 class="section-title">Tabel Jadwal Pemakaian</h5>

            <div class="table-responsive">
                <table class="table table-hover">
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
                        <tr>
                            <td>05 Juli 2026</td>
                            <td>08:00 - 10:00</td>
                            <td>Ruang Kuliah A101</td>
                            <td>Ridwan Maulana</td>
                            <td>Diskusi Kelompok Mata Kuliah</td>
                            <td><span class="badge-status badge-disetujui">Disetujui</span></td>
                        </tr>
                        <tr>
                            <td>06 Juli 2026</td>
                            <td>09:00 - 12:00</td>
                            <td>Laboratorium Komputer PTI</td>
                            <td>Dr. Ahmad Zaini</td>
                            <td>Praktikum Pemrograman Web</td>
                            <td><span class="badge-status badge-menunggu">Menunggu</span></td>
                        </tr>
                        <tr>
                            <td>10 Juli 2026</td>
                            <td>13:00 - 16:00</td>
                            <td>Aula Utama Kampus</td>
                            <td>HMPS PTI</td>
                            <td>Seminar Teknologi Pendidikan</td>
                            <td><span class="badge-status badge-disetujui">Disetujui</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

</body>
</php>