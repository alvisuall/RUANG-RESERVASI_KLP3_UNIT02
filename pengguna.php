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

            <form action="#" method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIM atau NIP</label>
                        <input type="text" class="form-control" placeholder="NIM atau NIP">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Pengguna</label>
                        <select class="form-select" required>
                            <option value="">Pilih jenis</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="tendik">Tendik</option>
                            <option value="organisasi">Organisasi</option>
                            <option value="umum">Umum</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fakultas atau Unit</label>
                        <input type="text" class="form-control" placeholder="Contoh: Fakultas Tarbiyah dan Keguruan">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prodi atau Bagian</label>
                        <input type="text" class="form-control" placeholder="Contoh: Pendidikan Teknologi Informasi">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" placeholder="nama@email.com">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="tel" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan alamat pengguna"></textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Pengguna
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
                        <tr>
                            <td>Ridwan Maulana</td>
                            <td>20260001</td>
                            <td>Mahasiswa</td>
                            <td>Fakultas Tarbiyah dan Keguruan</td>
                            <td>ridwan@student.ac.id</td>
                            <td>081234567890</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Dr. Ahmad Zaini</td>
                            <td>198701012020121001</td>
                            <td>Dosen</td>
                            <td>Fakultas Sains dan Teknologi</td>
                            <td>ahmad@kampus.ac.id</td>
                            <td>082233445566</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td>HMPS PTI</td>
                            <td>ORG001</td>
                            <td>Organisasi</td>
                            <td>Fakultas Tarbiyah dan Keguruan</td>
                            <td>hmpspti@kampus.ac.id</td>
                            <td>085277889900</td>
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