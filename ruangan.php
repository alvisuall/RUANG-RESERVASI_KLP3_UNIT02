<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ruangan</title>

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

            <h2>Data Ruangan</h2>

            <p>Kelola data ruangan kampus yang dapat digunakan untuk reservasi</p>

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
            <h5 class="section-title">Form Tambah atau Edit Ruangan</h5>

            <form action="#" method="post">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Ruangan</label>
                        <input type="text" class="form-control" placeholder="Contoh: R-A101" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nama Ruangan</label>
                        <input type="text" class="form-control" placeholder="Contoh: Ruang Kuliah A101" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Gedung</label>
                        <input type="text" class="form-control" placeholder="Contoh: Gedung A" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Lantai</label>
                        <input type="text" class="form-control" placeholder="Contoh: 1">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kapasitas</label>
                        <input type="number" class="form-control" placeholder="Contoh: 40" min="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Ruangan</label>
                        <select class="form-select" required>
                            <option value="">Pilih status</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="perawatan">Perawatan</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fasilitas</label>
                        <input type="text" class="form-control" placeholder="AC, Projector, WiFi, Whiteboard">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Ruangan
                        </button>
                        <button type="reset" class="btn btn-light border">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="section-title mb-0">Daftar Ruangan</h5>

                <form action="#" method="get" class="d-flex gap-2">
                    <input type="search" class="form-control" placeholder="Cari nama atau kode ruangan">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6 col-xl-4">
                    <div class="room-card">
                        <div class="room-icon">
                            <i class="bi bi-door-open"></i>
                        </div>
                        <h5 class="fw-bold">Ruang Kuliah A101</h5>
                        <p class="text-muted mb-2">Kode: R-A101</p>
                        <p class="mb-1"><strong>Gedung:</strong> Gedung A, Lantai 1</p>
                        <p class="mb-1"><strong>Kapasitas:</strong> 40 orang</p>
                        <p class="mb-3"><strong>Fasilitas:</strong> AC, LCD Projector, Whiteboard, WiFi</p>
                        <span class="badge-status badge-disetujui">Tersedia</span>

                        <div class="mt-3 d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="room-card">
                        <div class="room-icon">
                            <i class="bi bi-pc-display"></i>
                        </div>
                        <h5 class="fw-bold">Laboratorium Komputer PTI</h5>
                        <p class="text-muted mb-2">Kode: LAB-PTI</p>
                        <p class="mb-1"><strong>Gedung:</strong> Gedung Laboratorium, Lantai 2</p>
                        <p class="mb-1"><strong>Kapasitas:</strong> 35 orang</p>
                        <p class="mb-3"><strong>Fasilitas:</strong> Komputer, AC, Projector, Internet</p>
                        <span class="badge-status badge-disetujui">Tersedia</span>

                        <div class="mt-3 d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="room-card">
                        <div class="room-icon">
                            <i class="bi bi-megaphone"></i>
                        </div>
                        <h5 class="fw-bold">Aula Utama Kampus</h5>
                        <p class="text-muted mb-2">Kode: AULA-01</p>
                        <p class="mb-1"><strong>Gedung:</strong> Gedung Rektorat, Lantai 1</p>
                        <p class="mb-1"><strong>Kapasitas:</strong> 250 orang</p>
                        <p class="mb-3"><strong>Fasilitas:</strong> Panggung, Sound System, Projector</p>
                        <span class="badge-status badge-disetujui">Tersedia</span>

                        <div class="mt-3 d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Ruangan</th>
                            <th>Gedung</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R-A101</td>
                            <td>Ruang Kuliah A101</td>
                            <td>Gedung A</td>
                            <td>40</td>
                            <td><span class="badge-status badge-disetujui">Tersedia</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td>LAB-PTI</td>
                            <td>Laboratorium Komputer PTI</td>
                            <td>Gedung Laboratorium</td>
                            <td>35</td>
                            <td><span class="badge-status badge-disetujui">Tersedia</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td>R-B205</td>
                            <td>Ruang Seminar B205</td>
                            <td>Gedung B</td>
                            <td>60</td>
                            <td><span class="badge-status badge-menunggu">Perawatan</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

</body>
</html>