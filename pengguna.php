<?php
require_once "koneksi.php";

$mode = "tambah";
$dataEdit = [];

if(isset($_GET['edit'])){

    $mode = "edit";

    $id = (int)$_GET['edit'];

    $queryEdit = mysqli_query(
        $koneksi,
        "SELECT * FROM pengguna WHERE id_pengguna = $id"
    );

    $dataEdit = mysqli_fetch_assoc($queryEdit);

}

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
            <h5 class="section-title"><?= ($mode=="edit") ? "Form Edit Pengguna" : "Form Tambah Pengguna"; ?></h5>

            <form id="formPengguna"
                action="<?= ($mode=="edit") ? "pages/edit.php" : "pages/tambah.php"; ?>"
                method="POST">
                <input type="hidden" name="halaman" value="pengguna">
                    <?php if($mode=="edit"){ ?>
                    <input
                    type="hidden"
                    name="id_pengguna"
                    value="<?= $dataEdit['id_pengguna']; ?>">
                    <?php } ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                       <input type="text"id="nama_lengkap"name="nama_lengkap"class="form-control"placeholder="john doe" value="<?= ($mode=="edit") ? $dataEdit['nama_lengkap'] : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIM atau NIP</label>
                        <input type="text"id="nim_nip"name="nim_nip"class="form-control"placeholder="250212896" value="<?= ($mode=="edit") ? $dataEdit['nim_nip'] : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Pengguna</label>
                       <select name="jenis_pengguna" class="form-select">

                            <option value="Mahasiswa"
                            <?= ($mode=="edit" && $dataEdit['jenis_pengguna']=="Mahasiswa") ? "selected" : ""; ?>>
                            Mahasiswa
                            </option>

                            <option value="Dosen"
                            <?= ($mode=="edit" && $dataEdit['jenis_pengguna']=="Dosen") ? "selected" : ""; ?>>
                            Dosen
                            </option>

                            <option value="Tendik"
                            <?= ($mode=="edit" && $dataEdit['jenis_pengguna']=="Tendik") ? "selected" : ""; ?>>
                            Tendik
                            </option>
                            
                            <option value="Organisasi"
                            <?= ($mode=="edit" && $dataEdit['jenis_pengguna']=="Organisasi") ? "selected" : ""; ?>>
                            Organisasi
                            </option>

                            <option value="Umum"
                            <?= ($mode=="edit" && $dataEdit['jenis_pengguna']=="Umum") ? "selected" : ""; ?>>
                            Umum
                            </option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fakultas atau Unit</label>
                        <input type="text"id="fakultas"name="fakultas_unit"class="form-control"placeholder="FTK / 02" value="<?= ($mode=="edit") ? $dataEdit['fakultas_unit'] : ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prodi atau Bagian</label>
                        <input type="text"id="prodi"name="prodi_bagian"class="form-control"placeholder="PTI, PAI, dll.." value="<?= ($mode=="edit") ? $dataEdit['prodi_bagian'] : ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email"id="email"name="email"class="form-control"placeholder="johndoe@example.com" value="<?= ($mode=="edit") ? $dataEdit['email'] : ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. HP</label>
                       <input type="tel"id="hp"name="no_hp"class="form-control"placeholder="081234567890" value="<?= ($mode=="edit") ? $dataEdit['no_hp'] : ''; ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea id="alamat"name="alamat"class="form-control"placeholder="Jln. Syech Abdurrauf, KOPELMA Darussalam, Kec. Syiah Kuala, Kota Banda Aceh"rows="3"><?= ($mode=="edit") ? $dataEdit['alamat'] : ''; ?></textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi <?= ($mode=="edit") ? "bi-pencil-square" : "bi-save"; ?>"></i>
                            <?= ($mode=="edit") ? "Update Pengguna" : "Simpan Pengguna"; ?>
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
                    <input type="search"
                            id="searchPengguna"
                            class="form-control"
                            placeholder="Cari nama, NIM, atau NIP">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div class="table-responsive">
                <table id="tabelPengguna" class="table table-hover">
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

                                    <a
                                        href="pengguna.php?edit=<?= $pengguna['id_pengguna']; ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                        Edit
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