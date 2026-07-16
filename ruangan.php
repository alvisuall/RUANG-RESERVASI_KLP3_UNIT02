<?php
require_once "koneksi.php";

$mode = "tambah";
$dataEdit = [];

if (isset($_GET['edit'])) {

    $mode = "edit";
    $id = (int) $_GET['edit'];

    $queryEdit = mysqli_query($koneksi, "SELECT * FROM ruangan WHERE id_ruangan = $id");

    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

$queryRuanganCard = mysqli_query($koneksi, "SELECT * FROM ruangan");
$queryRuanganTabel = mysqli_query($koneksi, "SELECT * FROM ruangan");
$data = mysqli_query($koneksi, "SELECT * FROM pengguna");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ruangan</title>

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
    <h5 class="section-title">
        <?= ($mode == "edit") ? "Form Edit Ruangan" : "Form Tambah Ruangan"; ?>
    </h5>

    <form id="formRuangan"
          action="<?= ($mode == "edit") ? "pages/edit.php" : "pages/tambah.php"; ?>"
          method="POST">

        <?php if($mode == "edit"){ ?>
            <input type="hidden" name="halaman" value="ruangan">
            <input type="hidden" name="id_ruangan" value="<?= $dataEdit['id_ruangan']; ?>">
        <?php } ?>

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Ruangan</label>
                <input
                    type="text"
                    id="kode"
                    name="kode_ruangan"
                    class="form-control"
                    placeholder="R-A101"
                    value="<?= ($mode=="edit") ? $dataEdit['kode_ruangan'] : ''; ?>">
            </div>

            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Ruangan</label>
                <input
                    type="text"
                    id="nama"
                    name="nama_ruangan"
                    class="form-control"
                    placeholder="Ruang Kuliah A101"
                    value="<?= ($mode=="edit") ? $dataEdit['nama_ruangan'] : ''; ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Gedung</label>
                <input
                    type="text"
                    id="gedung"
                    name="gedung"
                    class="form-control"
                    placeholder="Gedung A"
                    value="<?= ($mode=="edit") ? $dataEdit['gedung'] : ''; ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Lantai</label>
                <input
                    type="text"
                    id="lantai"
                    name="lantai"
                    class="form-control"
                    placeholder="Lantai 1"
                    value="<?= ($mode=="edit") ? $dataEdit['lantai'] : ''; ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Kapasitas</label>
                <input
                    type="number"
                    id="kapasitas"
                    name="kapasitas"
                    class="form-control"
                    placeholder="Contoh: 50"
                    value="<?= ($mode=="edit") ? $dataEdit['kapasitas'] : ''; ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Status Ruangan</label>

                <select id="status" name="status_ruangan" class="form-select">

                    <option value="">Pilih Status</option>

                    <option value="Tersedia"
                    <?= ($mode=="edit" && $dataEdit['status_ruangan']=="Tersedia") ? "selected" : ""; ?>>
                        Tersedia
                    </option>

                    <option value="Perawatan"
                    <?= ($mode=="edit" && $dataEdit['status_ruangan']=="Perawatan") ? "selected" : ""; ?>>
                        Perawatan
                    </option>

                    <option value="Tidak Aktif"
                    <?= ($mode=="edit" && $dataEdit['status_ruangan']=="Tidak Aktif") ? "selected" : ""; ?>>
                        Tidak Aktif
                    </option>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Fasilitas</label>
                <input
                    type="text"
                    id="fasilitas"
                    name="fasilitas"
                    class="form-control"
                    placeholder="Contoh: AC, LCD Projector"
                    value="<?= ($mode=="edit") ? $dataEdit['fasilitas'] : ''; ?>">
            </div>

            <div class="col-12">

                <button type="submit" class="btn btn-primary">
                    <i class="bi <?= ($mode=="edit") ? "bi-pencil-square" : "bi-save"; ?>"></i>

                    <?= ($mode=="edit") ? "Update Ruangan" : "Simpan Ruangan"; ?>
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
                    <input type="search"
                            id="searchRuangan"
                            class="form-control"
                            placeholder="Cari nama atau kode ruangan">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

           <div class="row g-4">

                <?php while($data = mysqli_fetch_assoc($queryRuanganCard)){ ?>

                <div class="col-md-6 col-xl-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <h5 class="fw-bold">
                                <?= $data['nama_ruangan']; ?>
                            </h5>

                            <p><strong>Kode:</strong> <?= $data['kode_ruangan']; ?></p>

                            <p><strong>Gedung:</strong> <?= $data['gedung']; ?></p>

                            <p><strong>Lantai:</strong> <?= $data['lantai']; ?></p>

                            <p><strong>Kapasitas:</strong> <?= $data['kapasitas']; ?> Orang</p>

                            <p><strong>Fasilitas:</strong> <?= $data['fasilitas']; ?></p>

                            <span class="badge bg-success">
                                <?= $data['status_ruangan']; ?>
                            </span>

                        </div>

                        <div class="card-footer">

                            <a href="ruangan.php?edit=<?= $data['id_ruangan']; ?>"
                            class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>

                            <a href="pages/hapus.php?halaman=ruangan&id=<?= $data['id_ruangan']; ?>"
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Yakin ingin menghapus data ini?');">
                                    <i class="bi bi-trash"></i> Hapus
                            </a>

                        </div>

                    </div>

                </div>

                <?php } ?>

            </div>

            <div class="table-responsive">
               <table id="tabelRuangan" class="table table-hover">
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

                        <?php while($data = mysqli_fetch_assoc($queryRuanganTabel)) { ?>

                        <tr>
                            <td><?= $data['kode_ruangan']; ?></td>
                            <td><?= $data['nama_ruangan']; ?></td>
                            <td><?= $data['gedung']; ?></td>
                            <td><?= $data['kapasitas']; ?></td>

                            <td>
                                <?php
                                if($data['status_ruangan'] == "Tersedia"){
                                    echo '<span class="badge-status badge-disetujui">Tersedia</span>';
                                }else{
                                    echo '<span class="badge-status badge-menunggu">'.$data['status_ruangan'].'</span>';
                                }
                                ?>
                            </td>

                           <td>
                                <a href="ruangan.php?edit=<?= $data['id_ruangan']; ?>"
                                class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <a href="pages/hapus.php?halaman=ruangan&id=<?= $data['id_ruangan']; ?>"
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