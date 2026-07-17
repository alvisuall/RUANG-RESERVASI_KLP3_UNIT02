<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}
require_once "koneksi.php";

$role = $_SESSION['role'];
if ($role == 'pengguna') {
    header("Location: home.php");
    exit();
}

$mode = "tambah";
$dataEdit = [];

if (isset($_GET['edit'])) {
    $mode = "edit";
    $id = (int)$_GET['edit'];
    $queryEdit = mysqli_query(
        $koneksi,
        "SELECT * FROM pengguna WHERE id_pengguna = $id"
    );
    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

$queryPengguna = mysqli_query($koneksi, "SELECT * FROM pengguna ORDER BY nama_lengkap ASC");
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
            <h5 class="section-title"><?= ($mode == "edit") ? "Form Edit Pengguna" : "Form Data Pengguna"; ?></h5>
            <form id="formPengguna" action="<?= ($mode == "edit") ? "pages/edit.php" : "pages/tambah.php"; ?>" method="POST">
                <input type="hidden" name="halaman" value="pengguna">
                <?php if ($mode == "edit") : ?>
                    <input type="hidden" name="id_pengguna" value="<?= $dataEdit['id_pengguna']; ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama_lengkap" class="form-control" placeholder="John Doe" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['nama_lengkap']) : ''; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIM atau NIP</label>
                        <input type="text" id="nim" name="nim_nip" class="form-control" placeholder="250212896" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['nim_nip']) : ''; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Pengguna</label>
                        <select id="jenis" name="jenis_pengguna" class="form-select" required>
                            <option value="">Pilih Jenis</option>
                            <option value="mahasiswa" <?= ($mode == "edit" && strtolower($dataEdit['jenis_pengguna']) == "mahasiswa") ? "selected" : ""; ?>>Mahasiswa</option>
                            <option value="dosen" <?= ($mode == "edit" && strtolower($dataEdit['jenis_pengguna']) == "dosen") ? "selected" : ""; ?>>Dosen</option>
                            <option value="tendik" <?= ($mode == "edit" && strtolower($dataEdit['jenis_pengguna']) == "tendik") ? "selected" : ""; ?>>Tendik</option>
                            <option value="organisasi" <?= ($mode == "edit" && strtolower($dataEdit['jenis_pengguna']) == "organisasi") ? "selected" : ""; ?>>Organisasi</option>
                            <option value="umum" <?= ($mode == "edit" && strtolower($dataEdit['jenis_pengguna']) == "umum") ? "selected" : ""; ?>>Umum</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fakultas atau Unit</label>
                        <input type="text" id="fakultas" name="fakultas_unit" class="form-control" placeholder="FTK / 02" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['fakultas_unit']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prodi atau Bagian</label>
                        <input type="text" id="prodi" name="prodi_bagian" class="form-control" placeholder="PTI, PAI, dll" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['prodi_bagian']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="johndoe@example.com" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['email']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="tel" id="hp" name="no_hp" class="form-control" placeholder="081234567890" value="<?= ($mode == "edit") ? htmlspecialchars($dataEdit['no_hp']) : ''; ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Jln. Syech Abdurrauf, Darussalam" required><?= ($mode == "edit") ? htmlspecialchars($dataEdit['alamat']) : ''; ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="simpan" class="btn btn-primary me-2">
                            <i class="bi <?= ($mode == "edit") ? "bi-pencil-square" : "bi-save"; ?>"></i>
                            <?= ($mode == "edit") ? "Update Pengguna" : "Simpan Pengguna"; ?>
                        </button>
                        <?php if ($mode == "edit") : ?>
                            <a href="pengguna.php" class="btn btn-light border">Batal</a>
                        <?php else : ?>
                            <button type="reset" class="btn btn-light border">Reset</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="section-title mb-0">Daftar Pengguna</h5>
                <div class="d-flex gap-2">
                    <input type="search" id="searchInput" class="form-control" placeholder="Cari nama, NIM, atau NIP...">
                </div>
            </div>

            <div class="table-responsive">
                <table id="tabelPengguna" class="table table-hover align-middle text-center">
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
                        <?php while ($pengguna = mysqli_fetch_assoc($queryPengguna)) { ?>
                            <tr>
                                <td><?= htmlspecialchars($pengguna['nama_lengkap']); ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($pengguna['nim_nip']); ?></td>
                                <td><?= htmlspecialchars(ucfirst($pengguna['jenis_pengguna'])); ?></td>
                                <td><?= htmlspecialchars($pengguna['fakultas_unit']); ?></td>
                                <td><?= htmlspecialchars($pengguna['email']); ?></td>
                                <td><?= htmlspecialchars($pengguna['no_hp']); ?></td>
                                <td>
                                    <a href="pengguna.php?edit=<?= $pengguna['id_pengguna']; ?>" class="btn btn-sm btn-outline-primary me-1">
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