<?php
require_once "koneksi.php";

$queryPengguna = mysqli_query($koneksi, "SELECT * FROM pengguna");
$data = mysqli_query($koneksi, "SELECT * FROM pengguna");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>

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

            <h2>Data Pengguna</h2>

            <p>Kelola data pemesan ruangan kampus</p>

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
            <h5 class="section-title">Form Data Pengguna</h5>

            <form id="formPengguna"
                action="pages/tambah.php?halaman=pengguna"
                method="POST">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama_lengkap"
                            class="form-control"
                            placeholder="John Doe"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIM atau NIP</label>
                        <input
                            type="text"
                            id="nim"
                            name="nim_nip"
                            class="form-control"
                            placeholder="250212896"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Pengguna</label>
                        <select
                            id="jenis"
                            name="jenis_pengguna"
                            class="form-select"
                            required>

                            <option value="">Pilih Jenis</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Tendik">Tendik</option>
                            <option value="Organisasi">Organisasi</option>
                            <option value="Umum">Umum</option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fakultas atau Unit</label>
                        <input
                            type="text"
                            id="fakultas"
                            name="fakultas_unit"
                            class="form-control"
                            placeholder="FTK / 02"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prodi atau Bagian</label>
                        <input
                            type="text"
                            id="prodi"
                            name="prodi_bagian"
                            class="form-control"
                            placeholder="PTI, PAI, dll"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="johndoe@example.com"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input
                            type="tel"
                            id="hp"
                            name="no_hp"
                            class="form-control"
                            placeholder="081234567890"
                            required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            class="form-control"
                            rows="3"
                            placeholder="Jln. Syech Abdurrauf, Darussalam"
                            required></textarea>
                    </div>

                    <div class="col-12">

                        <button
                            type="submit"
                            name="simpan"
                            class="btn btn-primary">

                            <i class="bi bi-save"></i>
                            Simpan Pengguna

                        </button>

                        <button
                            type="reset"
                            class="btn btn-light border">

                            Reset

                        </button>

                    </div>

                </div>

            </form>
        </div>

        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="section-title mb-0">Daftar Pengguna</h5>

                <form action="#" method="get" class="d-flex gap-2">
                    <input type="search" class="form-control" placeholder="Cari nama, NIM, atau NIP">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIM atau NIP</th>
                            <th>Jenis</th>
                            <th>Fakultas atau Unit</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                            <?php while($pengguna = mysqli_fetch_assoc($queryPengguna)){ ?>

                            <tr>

                                <td><?= $pengguna['nama_lengkap']; ?></td>
                                <td><?= $pengguna['nim_nip']; ?></td>
                                <td><?= $pengguna['jenis_pengguna']; ?></td>
                                <td><?= $pengguna['fakultas_unit']; ?></td>
                                <td><?= $pengguna['email']; ?></td>
                                <td><?= $pengguna['no_hp']; ?></td>

                                <td>

                                    <a href="pages/edit.php?halaman=pengguna&id=<?= $pengguna['id_pengguna']; ?>"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <a href="pages/hapus.php?halaman=pengguna&id=<?= $pengguna['id_pengguna']; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Yakin ingin menghapus data ini?');">
                                            <i class="bi bi-trash"></i> Hapus
                                    </a>
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