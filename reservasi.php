<?php
require_once "koneksi.php";

$mode = "tambah";
$dataEdit = [];

if (isset($_GET['edit'])) {

    $mode = "edit";
    $id = (int)$_GET['edit'];

    $queryEdit = mysqli_query($koneksi,
        "SELECT * FROM reservasi_ruangan WHERE id_reservasi = $id");

    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

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
        <h5 class="section-title">
            <?= ($mode=="edit") ? "Form Edit Reservasi" : "Input Reservasi Ruangan"; ?>
        </h5>

           <form id="formReservasi"
                action="<?= ($mode=="edit") ? "pages/edit.php" : "pages/tambah.php"; ?>"
                method="POST">

                <input type="hidden" name="halaman" value="reservasi">
                    <?php if($mode=="edit"){ ?>
                    <input type="hidden" name="id_reservasi" value="<?= $dataEdit['id_reservasi']; ?>">
                    <?php } ?>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Reservasi</label>
                       <input
                        type="text"
                        id="kode"
                        name="kode_reservasi"
                        class="form-control"
                        placeholder="RSV-2026-004"
                        value="<?= ($mode=="edit") ? $dataEdit['kode_reservasi'] : ''; ?>">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Pilih Ruangan</label>
                        <select name="id_ruangan" id="ruangan" class="form-select">

                            <option value="">Pilih ruangan</option>
                            <?php
                            $queryRuangan=mysqli_query($koneksi,"SELECT * FROM ruangan");
                            while($ruangan=mysqli_fetch_assoc($queryRuangan)){
                            ?>

                            <option
                            value="<?= $ruangan['id_ruangan']; ?>"
                            <?= ($mode=="edit" && $ruangan['id_ruangan']==$dataEdit['id_ruangan']) ? "selected" : ""; ?>>
                            <?= $ruangan['nama_ruangan']; ?> - Kapasitas <?= $ruangan['kapasitas']; ?>
                            </option>

                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Pemesan</label>
                        <input
                        type="text"
                        id="nama"
                        name="nama_pemesan"
                        class="form-control"
                        placeholder="John Doe"
                        value="<?= ($mode=="edit") ? $dataEdit['nama_pemesan'] : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                       <input type="email" id="email" name="email_pemesan" class="form-control" placeholder="johndoe@example.com" value="<?= ($mode=="edit") ? $dataEdit['email_pemesan'] : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="tel" id="hp" name="no_hp" class="form-control" placeholder="081234567890" value="<?= ($mode=="edit") ? $dataEdit['no_hp'] : ''; ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Reservasi</label>
                       <input type="date" id="tanggal" name="tanggal_reservasi" class="form-control" placeholder="2023-10-10" value="<?= ($mode=="edit") ? $dataEdit['tanggal_reservasi'] : ''; ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Mulai</label>
                        <input type="time" id="jamMulai" name="jam_mulai" class="form-control"placeholder=" 09:00" value="<?= ($mode=="edit") ? $dataEdit['jam_mulai'] : ''; ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Selesai</label>
                        <input type="time" id="jamSelesai" name="jam_selesai" class="form-control"placeholder="11:00" value="<?= ($mode=="edit") ? $dataEdit['jam_selesai'] : ''; ?>">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Keperluan</label>
                       <input type="text" id="keperluan" name="keperluan" class="form-control"placeholder="Pertemuan dengan dosen" value="<?= ($mode=="edit") ? $dataEdit['keperluan'] : ''; ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah Peserta</label>
                        <input type="number" id="peserta" name="jumlah_peserta" class="form-control"placeholder=" 20" value="<?= ($mode=="edit") ? $dataEdit['jumlah_peserta'] : ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Reservasi</label>
                        <select id="status" name="status_reservasi" class="form-select">
                            <option value="menunggu" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                            <option value="disetujui" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                            <option value="ditolak" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                            <option value="selesai" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                            <option value="dibatalkan" <?= ($mode=="edit" && $dataEdit['status_reservasi'] == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Catatan Admin</label>
                       <input type="text" id="catatan" name="catatan_admin" class="form-control"placeholder="Reservasi disetujui" value="<?= ($mode=="edit") ? $dataEdit['catatan_admin'] : ''; ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control"placeholder="Keterangan tambahan"><?= ($mode=="edit") ? $dataEdit['keterangan'] : ''; ?></textarea>
                    </div>

                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <strong>Validasi:</strong> tanggal wajib diisi, jam mulai dan jam selesai wajib diisi, jam mulai harus lebih awal dari jam selesai, dan jumlah peserta minimal 1 orang.
                        </div>
                    </div>

                    <div class="col-12">
                       <button type="submit" class="btn btn-primary">
                            <i class="bi <?= ($mode=="edit") ? "bi-pencil-square" : "bi-send"; ?>"></i>
                            <?= ($mode=="edit") ? "Update Reservasi" : "Ajukan Reservasi"; ?>
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
                   <input type="search" id="searchInput" class="form-control" placeholder="nama peserta, kode reservasi/ruangan">
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
                                <a href="reservasi.php?edit=<?= $reservasi_ruangan['id_reservasi']; ?>"
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

                        <?php } 
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>