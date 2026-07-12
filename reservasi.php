<?php
require_once "koneksi.php";

$queryReservasi = mysqli_query($koneksi,
    "SELECT reservasi_ruangan.*, ruangan.nama_ruangan
    FROM reservasi_ruangan
    JOIN ruangan
    ON reservasi_ruangan.id_ruangan = ruangan.id_ruangan");
$data = mysqli_query($koneksi, "SELECT * FROM pengguna");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Ruangan</title>

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

            <h2>Form Reservasi</h2>

            <p>Ajukan pemakaian ruangan kampus berdasarkan tanggal dan jam</p>

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
            <h5 class="section-title">Input Reservasi Ruangan</h5>

           <form id="formReservasi">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Reservasi</label>
                       <input type="text" id="kode" class="form-control"placeholder="RSV-2026-004">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Pilih Ruangan</label>
                        <select id="ruangan" class="form-select">
                            <option value="">Pilih ruangan</option>
                            <option value="1">Ruang Kuliah A101 - Kapasitas 40</option>
                            <option value="2">Laboratorium Komputer PTI - Kapasitas 35</option>
                            <option value="3">Aula Utama Kampus - Kapasitas 250</option>
                            <option value="4">Ruang Seminar B205 - Kapasitas 60</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Pemesan</label>
                        <input type="text" id="nama" class="form-control"placeholder="John Doe">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                       <input type="email" id="email" class="form-control"placeholder="johndoe@example.com">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="tel" id="hp" class="form-control"placeholder="081234567890">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Reservasi</label>
                       <input type="date" id="tanggal" class="form-control"placeholder="2023-10-10">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Mulai</label>
                        <input type="time" id="jamMulai" class="form-control"placeholder=" 09:00">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Selesai</label>
                        <input type="time" id="jamSelesai" class="form-control"placeholder="11:00">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Keperluan</label>
                       <input type="text" id="keperluan" class="form-control"placeholder="Pertemuan dengan dosen">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah Peserta</label>
                        <input type="number" id="peserta" class="form-control"placeholder=" 20">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Reservasi</label>
                        <select id="status" class="form-select">
                            <option value="menunggu">Menunggu</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Catatan Admin</label>
                       <input type="text" id="catatan" class="form-control"placeholder="Reservasi disetujui">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                        <textarea id="keterangan" class="form-control"placeholder="Keterangan tambahan"></textarea>
                    </div>

                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <strong>Validasi:</strong> tanggal wajib diisi, jam mulai dan jam selesai wajib diisi, jam mulai harus lebih awal dari jam selesai, dan jumlah peserta minimal 1 orang.
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Ajukan Reservasi
                        </button>
                        <button type="reset" class="btn btn-light border">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="content-card">
            <h5 class="section-title">Daftar Reservasi</h5>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                   <input type="search" id="searchInput" class="form-control">
                </div>
                <div class="col-md-3">
                    <select id="filterStatus" class="form-select">
                        <option>Semua Status</option>
                        <option>Menunggu</option>
                        <option>Disetujui</option>
                        <option>Ditolak</option>
                        <option>Selesai</option>
                        <option>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tabelReservasi" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pemesan</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Peserta</th>
                            <th>Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while($reservasi_ruangan = mysqli_fetch_assoc($queryReservasi)){ ?>

                        <tr>

                            <td><?= $reservasi_ruangan['kode_reservasi']; ?></td>
                            <td><?= $reservasi_ruangan['nama_pemesan']; ?></td>
                            <td><?= $reservasi_ruangan['nama_ruangan']; ?></td>
                            <td><?= $reservasi_ruangan['tanggal_reservasi']; ?></td>
                            <td><?= $reservasi_ruangan['jam_mulai']; ?></td>
                            <td><?= $reservasi_ruangan['jumlah_peserta']; ?></td>
                            

                            <td>
                                <?php
                                if($reservasi_ruangan['status_reservasi'] == "Disetujui"){
                                    echo '<span class="badge-status badge-disetujui">Disetujui</span>';
                                }elseif($reservasi_ruangan['status_reservasi'] == "Menunggu"){
                                    echo '<span class="badge-status badge-menunggu">Menunggu</span>';
                                }elseif($reservasi_ruangan['status_reservasi'] == "Ditolak"){
                                    echo '<span class="badge-status badge-ditolak">Ditolak</span>';
                                }else{
                                    echo '<span class="badge-status">'.$reservasi_ruangan['status_reservasi'].'</span>';
                                }
                                ?>
                            </td>

                            <td>
                                <a href="pages/edit.php?halaman=reservasi&id=<?= $reservasi_ruangan['id_reservasi']; ?>"
                                class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <a href="pages/hapus.php?halaman=reservasi&id=<?= $reservasi_ruangan['id_reservasi']; ?>"
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