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
}

$queryRuangan = mysqli_query($koneksi, "SELECT * FROM ruangan");
$rooms = [];
while ($r = mysqli_fetch_assoc($queryRuangan)) {
    $rooms[] = $r;
}
=======
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
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
$data = mysqli_query($koneksi, "SELECT * FROM pengguna");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ruangan - Reservasi</title>
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
            <li><a href="ruangan.php" class="active"><i class="bi bi-door-open"></i> Data Ruangan</a></li>
            <li><a href="reservasi.php"><i class="bi bi-calendar-plus"></i> Kelola Reservasi</a></li>
            <li><a href="jadwal.php"><i class="bi bi-calendar-week"></i> Jadwal Pemakaian</a></li>
            <li><a href="pengguna.php"><i class="bi bi-people"></i> Pengguna</a></li>
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
                    <i class="bi bi-door-open-fill"></i>
                </div>
                <div class="page-title">
                    <h2>Data Ruangan</h2>
                    <p>Kelola data ruangan kampus yang dapat digunakan untuk reservasi</p>
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
                <strong>Berhasil!</strong> Data ruangan berhasil <?= htmlspecialchars($_GET['success'] == 'edit' ? 'diubah' : 'ditambahkan'); ?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'hapus') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data ruangan berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data tidak berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

<<<<<<< HEAD
        <div class="content-card">
            <h5 class="section-title">Form Tambah Ruangan</h5>
            <form id="formRuangan" action="pages/tambah.php?halaman=ruangan" method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Ruangan</label>
                        <input type="text" id="kode" name="kode_ruangan" class="form-control" placeholder="R-A101" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nama Ruangan</label>
                        <input type="text" id="nama" name="nama_ruangan" class="form-control" placeholder="Ruang Kuliah A101" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Gedung</label>
                        <input type="text" id="gedung" name="gedung" class="form-control" placeholder="Gedung A" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Lantai</label>
                        <input type="text" id="lantai" name="lantai" class="form-control" placeholder="Lantai 1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kapasitas</label>
                        <input type="number" id="kapasitas" name="kapasitas" class="form-control" placeholder="Contoh: 50" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Ruangan</label>
                        <select id="status" name="status_ruangan" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Perawatan">Perawatan</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fasilitas</label>
                        <input type="text" id="fasilitas" name="fasilitas" class="form-control" placeholder="Contoh: AC, LCD Projector" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="simpan" class="btn btn-primary me-2">
                            <i class="bi bi-save"></i> Simpan Ruangan
                        </button>
                        <button type="reset" class="btn btn-light border">Reset</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-4 mb-4">
            <?php foreach ($rooms as $room) {
                $iconClass = 'bi-door-open';
                $namaLower = strtolower($room['nama_ruangan']);
                if (strpos($namaLower, 'lab') !== false || strpos($namaLower, 'komputer') !== false) {
                    $iconClass = 'bi-pc-display';
                } elseif (strpos($namaLower, 'aula') !== false) {
                    $iconClass = 'bi-megaphone';
                } elseif (strpos($namaLower, 'seminar') !== false) {
                    $iconClass = 'bi-chat-square-text';
                }
                
                $status = strtolower($room['status_ruangan']);
                $statusBadge = '<span class="badge-status badge-disetujui">Tersedia</span>';
                if ($status == 'perawatan') {
                    $statusBadge = '<span class="badge-status badge-menunggu">Perawatan</span>';
                } elseif ($status == 'tidak aktif' || $status == 'tidak_aktif') {
                    $statusBadge = '<span class="badge-status badge-ditolak">Tidak Aktif</span>';
                }
            ?>
            <div class="col-md-6 col-xl-4">
                <div class="room-card">
                    <div class="room-icon">
                        <i class="bi <?= $iconClass; ?>"></i>
                    </div>
                    <h5 class="fw-bold"><?= htmlspecialchars($room['nama_ruangan']); ?></h5>
                    <p class="text-muted mb-2">Kode: <?= htmlspecialchars($room['kode_ruangan']); ?></p>
                    <p class="mb-1"><strong>Gedung:</strong> <?= htmlspecialchars($room['gedung']); ?>, Lantai <?= htmlspecialchars($room['lantai']); ?></p>
                    <p class="mb-1"><strong>Kapasitas:</strong> <?= htmlspecialchars($room['kapasitas']); ?> orang</p>
                    <p class="mb-3"><strong>Fasilitas:</strong> <?= htmlspecialchars($room['fasilitas']); ?></p>
                    <?= $statusBadge; ?>

                    <div class="mt-3 d-flex gap-2">
                        <a href="pages/edit.php?halaman=ruangan&id=<?= $room['id_ruangan']; ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="pages/hapus.php?halaman=ruangan&id=<?= $room['id_ruangan']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="content-card">
            <h5 class="section-title mb-4"><i class="bi bi-table"></i> Daftar Ruangan</h5>
=======
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

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
            <div class="table-responsive">
               <table id="tabelRuangan" class="table table-hover align-middle text-center">
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
<<<<<<< HEAD
                        <?php foreach ($rooms as $data) { ?>
=======

                        <?php while($data = mysqli_fetch_assoc($queryRuanganTabel)) { ?>

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                        <tr>
                            <td class="fw-bold"><?= $data['kode_ruangan']; ?></td>
                            <td><?= htmlspecialchars($data['nama_ruangan']); ?></td>
                            <td><?= htmlspecialchars($data['gedung']); ?></td>
                            <td><?= htmlspecialchars($data['kapasitas']); ?> orang</td>
                            <td>
                                <?php
                                if(strtolower($data['status_ruangan']) == "tersedia"){
                                    echo '<span class="badge-status badge-disetujui">Tersedia</span>';
                                } else {
                                    echo '<span class="badge-status badge-menunggu">'.ucfirst($data['status_ruangan']).'</span>';
                                }
                                ?>
                            </td>
<<<<<<< HEAD
                            <td>
                                <a href="pages/edit.php?halaman=ruangan&id=<?= $data['id_ruangan']; ?>" class="btn btn-sm btn-outline-primary">
=======

                           <td>
                                <a href="ruangan.php?edit=<?= $data['id_ruangan']; ?>"
                                class="btn btn-sm btn-outline-primary">
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="pages/hapus.php?halaman=ruangan&id=<?= $data['id_ruangan']; ?>"
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