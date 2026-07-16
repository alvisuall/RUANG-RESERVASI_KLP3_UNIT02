//==================================================
// RESERVASI RUANGAN KAMPUS
// Script JavaScript
//==================================================

document.addEventListener("DOMContentLoaded", function () {

    //==================================================
    // LOGIN - SHOW / HIDE PASSWORD
    //==================================================

    const password = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    if (password && togglePassword) {

        togglePassword.addEventListener("click", function () {

            if (password.type === "password") {
                password.type = "text";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
            } else {
                password.type = "password";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
            }

        });

    }


    //==================================================
    // LOGOUT
    //==================================================

    const logout = document.querySelector('a[href="auth/logout.php"]');

    if (logout) {

        logout.addEventListener("click", function (e) {

            if (!confirm("Yakin ingin logout?")) {
                e.preventDefault();
            }

        });

    }


    //==================================================
    // VALIDASI FORM RUANGAN
    //==================================================

    const formRuangan = document.getElementById("formRuangan");

    if (formRuangan) {

        formRuangan.addEventListener("submit", function (e) {

            const kode = document.getElementById("kode").value.trim();
            const nama = document.getElementById("nama").value.trim();
            const gedung = document.getElementById("gedung").value.trim();
            const lantai = document.getElementById("lantai").value.trim();
            const kapasitas = document.getElementById("kapasitas").value.trim();
            const status = document.getElementById("status").value;

            if (
                kode === "" ||
                nama === "" ||
                gedung === "" ||
                lantai === "" ||
                kapasitas === "" ||
                status === ""
            ) {

                e.preventDefault();
                alert("Semua data ruangan wajib diisi.");

            }

        });

    }
        //==================================================
    // VALIDASI FORM PENGGUNA
    //==================================================

    const formPengguna = document.getElementById("formPengguna");

    if (formPengguna) {

        formPengguna.addEventListener("submit", function (e) {

            const nama = document.getElementById("nama_lengkap").value.trim();
            const nim = document.getElementById("nim_nip").value.trim();
            const fakultas = document.getElementById("fakultas").value.trim();
            const prodi = document.getElementById("prodi").value.trim();
            const email = document.getElementById("email").value.trim();
            const hp = document.getElementById("hp").value.trim();
            const alamat = document.getElementById("alamat").value.trim();

            if (
                nama === "" ||
                nim === "" ||
                fakultas === "" ||
                prodi === "" ||
                email === "" ||
                hp === "" ||
                alamat === ""
            ) {

                e.preventDefault();
                alert("Semua data pengguna wajib diisi.");

            }

        });

    }


    //==================================================
    // VALIDASI FORM RESERVASI
    //==================================================

    const formReservasi = document.getElementById("formReservasi");

    if (formReservasi) {

        formReservasi.addEventListener("submit", function (e) {

            const kode = document.getElementById("kode").value.trim();
            const ruangan = document.getElementById("ruangan").value;
            const nama = document.getElementById("nama").value.trim();
            const email = document.getElementById("email").value.trim();
            const hp = document.getElementById("hp").value.trim();
            const tanggal = document.getElementById("tanggal").value;
            const jamMulai = document.getElementById("jamMulai").value;
            const jamSelesai = document.getElementById("jamSelesai").value;
            const keperluan = document.getElementById("keperluan").value.trim();
            const peserta = document.getElementById("peserta").value;

            if (
                kode === "" ||
                ruangan === "" ||
                nama === "" ||
                email === "" ||
                hp === "" ||
                tanggal === "" ||
                jamMulai === "" ||
                jamSelesai === "" ||
                keperluan === "" ||
                peserta === ""
            ) {

                e.preventDefault();
                alert("Semua data reservasi wajib diisi.");
                return;

            }

            if (jamMulai >= jamSelesai) {

                e.preventDefault();
                alert("Jam mulai harus lebih awal dari jam selesai.");
                return;

            }

            if (peserta < 1) {

                e.preventDefault();
                alert("Jumlah peserta minimal 1 orang.");

            }

        });

    }
        //==================================================
    // FUNGSI SEARCH TABEL
    //==================================================

    function cariData(inputId, tabelId) {

        const input = document.getElementById(inputId);
        const tabel = document.getElementById(tabelId);

        if (!input || !tabel) return;

        input.addEventListener("keyup", function () {

            const keyword = this.value.toLowerCase();
            const baris = tabel.querySelectorAll("tbody tr");

            baris.forEach(function (row) {

                const text = row.innerText.toLowerCase();

                if (text.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }

            });

        });

    }


    //==================================================
    // SEARCH
    //==================================================

    cariData("searchRuangan", "tabelRuangan");
    cariData("searchPengguna", "tabelPengguna");
    cariData("searchReservasi", "tabelReservasi");

        //==================================================
    // FILTER STATUS RESERVASI
    //==================================================

    const filterStatus = document.getElementById("filterStatus");
    const tabelReservasi = document.getElementById("tabelReservasi");

    if (filterStatus && tabelReservasi) {

        filterStatus.addEventListener("change", function () {

            const status = this.value.toLowerCase();
            const baris = tabelReservasi.querySelectorAll("tbody tr");

            baris.forEach(function (row) {

                const isiStatus = row.cells[6].innerText.toLowerCase();

                if (
                    status === "" ||
                    status === "semua status" ||
                    isiStatus.includes(status)
                ) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }

            });

        });

    }


    //==================================================
    // FILTER JADWAL
    //==================================================

    const cariRuangan = document.getElementById("cariRuangan");
    const tabelJadwal = document.getElementById("tabelJadwal");

    if (cariRuangan && tabelJadwal) {

        cariRuangan.addEventListener("keyup", function () {

            const keyword = this.value.toLowerCase();
            const baris = tabelJadwal.querySelectorAll("tbody tr");

            baris.forEach(function (row) {

                const text = row.innerText.toLowerCase();

                if (text.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }

            });

        });

    }


    //==================================================
    // VALIDASI FILTER TANGGAL JADWAL
    //==================================================

    const filterTanggal = document.getElementById("filterTanggal");

    if (filterTanggal) {

        filterTanggal.max = "2099-12-31";

    }

        //==================================================
    // NOMOR HP HANYA BOLEH ANGKA
    //==================================================

    const hp = document.getElementById("hp");

    if (hp) {

        hp.addEventListener("input", function () {

            this.value = this.value.replace(/[^0-9]/g, "");

        });

    }

        //==================================================
    // VALIDASI EMAIL
    //==================================================

    const email = document.getElementById("email");
    const infoEmail = document.getElementById("infoEmail");

    if (email && infoEmail) {

        email.addEventListener("input", function () {

            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (this.value === "") {

                infoEmail.textContent = "";
                infoEmail.className = "";

            } else if (regex.test(this.value)) {

                infoEmail.textContent = "✓ Email valid";
                infoEmail.className = "text-success";

            } else {

                infoEmail.textContent = "Format email tidak valid";
                infoEmail.className = "text-danger";

            }

        });

    }

        //==================================================
    // VALIDASI TANGGAL
    //==================================================

    const tanggal = document.getElementById("tanggal");

    if (tanggal) {

        const hariIni = new Date().toISOString().split("T")[0];

        tanggal.min = hariIni;

    }

});