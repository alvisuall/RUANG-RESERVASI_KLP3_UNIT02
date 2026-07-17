<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

<<<<<<< HEAD
$role = $_SESSION['role'];
if ($role == 'pengguna') {
    header("Location: home.php");
    exit();
=======
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

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
}

$queryPengguna = mysqli_query($koneksi, "SELECT * FROM pengguna");
$data = mysqli_query($koneksi, "SELECT * FROM pengguna");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Reservasi</title>
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
            <li><a href="ruangan.php"><i class="bi bi-door-open"></i> Data Ruangan</a></li>
            <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Kelola Reservasi</a></li>
            <li><a href="jadwal.php"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
            <li><a href="pengguna.php" class="active"><i class="bi bi-people"></i> Pengguna</a></li>
            <li><a href="laporan.php"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
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

        <?php if (isset($_GET['success'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data pengguna berhasil <?= htmlspecialchars($_GET['success'] == 'edit' ? 'diubah' : 'ditambahkan'); ?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'hapus') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data pengguna berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="content-card">
<<<<<<< HEAD
            <h5 class="section-title">Form Data Pengguna</h5>
            <form id="formPengguna" action="pages/tambah.php?halaman=pengguna" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama_lengkap" class="form-control" placeholder="John Doe" required>
=======
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
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIM atau NIP</label>
<<<<<<< HEAD
                        <input type="text" id="nim" name="nim_nip" class="form-control" placeholder="250212896" required>
=======
                        <input type="text"id="nim_nip"name="nim_nip"class="form-control"placeholder="250212896" value="<?= ($mode=="edit") ? $dataEdit['nim_nip'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Pengguna</label>
<<<<<<< HEAD
                        <select id="jenis" name="jenis_pengguna" class="form-select" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Tendik">Tendik</option>
                            <option value="Organisasi">Organisasi</option>
                            <option value="Umum">Umum</option>
=======
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

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fakultas atau Unit</label>
<<<<<<< HEAD
                        <input type="text" id="fakultas" name="fakultas_unit" class="form-control" placeholder="FTK / 02" required>
=======
                        <input type="text"id="fakultas"name="fakultas_unit"class="form-control"placeholder="FTK / 02" value="<?= ($mode=="edit") ? $dataEdit['fakultas_unit'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prodi atau Bagian</label>
<<<<<<< HEAD
                        <input type="text" id="prodi" name="prodi_bagian" class="form-control" placeholder="PTI, PAI, dll" required>
=======
                        <input type="text"id="prodi"name="prodi_bagian"class="form-control"placeholder="PTI, PAI, dll.." value="<?= ($mode=="edit") ? $dataEdit['prodi_bagian'] : ''; ?>">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
<<<<<<< HEAD
                        <input type="email" id="email" name="email" class="form-control" placeholder="johndoe@example.com" required>
=======
                        <input type="email"id="email"name="email"class="form-control"placeholder="johndoe@example.com" value="<?= ($mode=="edit") ? $dataEdit['email'] : ''; ?>">
                        <small id="infoEmail" class="text-muted"></small>
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. HP</label>
<<<<<<< HEAD
                        <input type="tel" id="hp" name="no_hp" class="form-control" placeholder="081234567890" required>
=======
                       <input type="tel"id="hp"name="no_hp"class="form-control"placeholder="081234567890" value="<?= ($mode=="edit") ? $dataEdit['no_hp'] : ''; ?>">
                        <small id="infoHP" class="text-muted"></small>
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
<<<<<<< HEAD
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Jln. Syech Abdurrauf, Darussalam" required></textarea>
=======
                        <textarea id="alamat"name="alamat"class="form-control"placeholder="Jln. Syech Abdurrauf, KOPELMA Darussalam, Kec. Syiah Kuala, Kota Banda Aceh"rows="3"><?= ($mode=="edit") ? $dataEdit['alamat'] : ''; ?></textarea>
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                    <div class="col-12">
<<<<<<< HEAD
                        <button type="submit" name="simpan" class="btn btn-primary me-2">
                            <i class="bi bi-save"></i> Simpan Pengguna
                        </button>
                        <button type="reset" class="btn btn-light border">Reset</button>
=======
                        <button type="submit" class="btn btn-primary">
                            <i class="bi <?= ($mode=="edit") ? "bi-pencil-square" : "bi-save"; ?>"></i>
                            <?= ($mode=="edit") ? "Update Pengguna" : "Simpan Pengguna"; ?>
                        </button>

                        <button type="reset" class="btn btn-light border">
                            Reset
                        </button>
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </div>
                </div>
            </form>
        </div>

        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="section-title mb-0">Daftar Pengguna</h5>
<<<<<<< HEAD
                <div class="d-flex gap-2">
                    <input type="search" id="searchInput" class="form-control" placeholder="Cari nama, NIM, atau NIP...">
                </div>
            </div>

            <div class="table-responsive">
                <table id="tabelPengguna" class="table table-hover align-middle text-center">
=======

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
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
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
<<<<<<< HEAD
                        <?php while($pengguna = mysqli_fetch_assoc($queryPengguna)){ ?>
                        <tr>
                            <td><?= htmlspecialchars($pengguna['nama_lengkap']); ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($pengguna['nim_nip']); ?></td>
                            <td><?= htmlspecialchars($pengguna['jenis_pengguna']); ?></td>
                            <td><?= htmlspecialchars($pengguna['fakultas_unit']); ?></td>
                            <td><?= htmlspecialchars($pengguna['email']); ?></td>
                            <td><?= htmlspecialchars($pengguna['no_hp']); ?></td>
                            <td>
                                <a href="pages/edit.php?halaman=pengguna&id=<?= $pengguna['id_pengguna']; ?>" class="btn btn-sm btn-outline-primary">
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
=======

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

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<script>
setTimeout(function(){
    let alert=document.querySelector(".alert");
    if(alert){
        alert.classList.remove("show");
        setTimeout(function(){
            alert.remove();
        },300);
    }
},3000);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>