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
    // EFEK HOVER CARD
    //==================================================
    document.querySelectorAll(".stat-card").forEach(function (card) {
        card.addEventListener("mouseenter", function () {
            card.style.transform = "translateY(-8px)";
            card.style.transition = ".3s";
        });
        card.addEventListener("mouseleave", function () {
            card.style.transform = "translateY(0px)";
        });
    });

    //==================================================
    // WAKTU REALTIME
    //==================================================
    const title = document.querySelector(".page-title p");
    if (title) {
        setInterval(function () {
            const now = new Date();
            title.innerHTML = "Kelola reservasi ruangan kampus | " + now.toLocaleTimeString('id-ID');
        }, 1000);
    }

    //==================================================
    // HIGHLIGHT MENU
    //==================================================
    const links = document.querySelectorAll(".sidebar-menu a");
    links.forEach(function (link) {
        link.addEventListener("click", function () {
            links.forEach(function (l) {
                l.classList.remove("active");
            });
            this.classList.add("active");
        });
    });

    //==================================================
    // ANIMASI TABEL
    //==================================================
    const tableRows = document.querySelectorAll("#tabelReservasi tbody tr, #tabelRuangan tbody tr, #tabelPengguna tbody tr");
    tableRows.forEach(function (row, index) {
        row.style.opacity = "0";
        setTimeout(function () {
            row.style.transition = ".4s";
            row.style.opacity = "1";
        }, index * 100);
    });

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
                infoEmail.className = "text-success small d-block mt-1";
            } else {
                infoEmail.textContent = "Format email tidak valid";
                infoEmail.className = "text-danger small d-block mt-1";
            }
        });
    }

    //==================================================
    // VALIDASI FORM RUANGAN
    //==================================================
    const formRuangan = document.getElementById("formRuangan");
    if (formRuangan) {
        formRuangan.addEventListener("submit", function (e) {
            let kode = document.getElementById("kode").value.trim();
            let nama = document.getElementById("nama").value.trim();
            let gedung = document.getElementById("gedung").value.trim();
            let lantai = document.getElementById("lantai").value.trim();
            let kapasitas = document.getElementById("kapasitas").value.trim();
            let status = document.getElementById("status").value;
            let fasilitas = document.getElementById("fasilitas").value.trim();

            if (kode === "" || nama === "" || gedung === "" || lantai === "" || kapasitas === "" || status === "" || fasilitas === "") {
                e.preventDefault();
                alert("Semua field wajib diisi!");
                return;
            }

            if (isNaN(kapasitas) || parseInt(kapasitas) <= 0) {
                e.preventDefault();
                alert("Kapasitas harus berupa angka lebih dari 0!");
                return;
            }
        });
    }

    //==================================================
    // VALIDASI FORM PENGGUNA
    //==================================================
    const formPengguna = document.getElementById("formPengguna");
    if (formPengguna) {
        formPengguna.addEventListener("submit", function (e) {
            let nama = document.getElementById("nama").value.trim();
            let nim = document.getElementById("nim").value.trim();
            let jenis = document.getElementById("jenis").value;
            let fakultas = document.getElementById("fakultas").value.trim();
            let prodi = document.getElementById("prodi").value.trim();
            let emailVal = document.getElementById("email").value.trim();
            let hpVal = document.getElementById("hp").value.trim();
            let alamat = document.getElementById("alamat").value.trim();

            if (nama === "" || nim === "" || jenis === "" || fakultas === "" || prodi === "" || emailVal === "" || hpVal === "" || alamat === "") {
                e.preventDefault();
                alert("Semua field wajib diisi!");
                return;
            }

            if (isNaN(nim)) {
                e.preventDefault();
                alert("NIM / NIP harus berupa angka!");
                return;
            }

            if (isNaN(hpVal)) {
                e.preventDefault();
                alert("Nomor HP harus berupa angka!");
                return;
            }

            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(emailVal)) {
                e.preventDefault();
                alert("Format email tidak valid!");
                return;
            }
        });
    }

    //==================================================
    // VALIDASI FORM RESERVASI
    //==================================================
    const formReservasi = document.getElementById("formReservasi");
    if (formReservasi) {
        formReservasi.addEventListener("submit", function (e) {
            let idRuangan = document.getElementById("id_ruangan").value;
            let idPengguna = document.getElementById("id_pengguna").value;
            let tanggalVal = document.getElementById("tanggal_reservasi").value;
            let jamMulai = document.getElementById("jam_mulai").value;
            let jamSelesai = document.getElementById("jam_selesai").value;
            let keperluan = document.getElementById("keperluan").value.trim();
            let peserta = document.getElementById("jumlah_peserta").value;

            if (idRuangan === "" || idPengguna === "" || tanggalVal === "" || jamMulai === "" || jamSelesai === "" || keperluan === "" || peserta === "") {
                e.preventDefault();
                alert("Semua field wajib diisi!");
                return;
            }

            if (jamMulai >= jamSelesai) {
                e.preventDefault();
                alert("Jam mulai harus lebih awal dari jam selesai!");
                return;
            }

            if (isNaN(peserta) || parseInt(peserta) <= 0) {
                e.preventDefault();
                alert("Jumlah peserta minimal 1 orang!");
                return;
            }
        });
    }

});

//==============================
// DARK MODE
//==============================
(function () {
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    document.addEventListener("DOMContentLoaded", function () {
        const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
        if (toggleSwitch) {
            if (currentTheme === 'dark') {
                toggleSwitch.checked = true;
            }
            toggleSwitch.addEventListener('change', function (e) {
                if (e.target.checked) {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('theme', 'light');
                }
            });
        }
    });
})();

//==============================
// COMBINED FILTER FOR TABLES
//==============================
document.addEventListener("DOMContentLoaded", function () {
    const btnFilter = document.getElementById("btnFilter");
    const searchInput = document.getElementById("searchInput");
    const filterStatus = document.getElementById("filterStatus");
    const filterTanggal = document.getElementById("filterTanggal");

    if (btnFilter || searchInput || filterStatus || filterTanggal) {
        const performFilter = function () {
            const keyword = searchInput ? searchInput.value.toLowerCase() : "";
            const status = filterStatus ? filterStatus.value.toLowerCase() : "";
            const tanggal = filterTanggal ? filterTanggal.value : "";

            const rows = document.querySelectorAll("#tabelReservasi tbody tr, #tabelJadwal tbody tr, #tabelRuangan tbody tr, #tabelPengguna tbody tr");
            rows.forEach(function (row) {
                const text = row.innerText.toLowerCase();
                let show = true;

                if (keyword !== "" && !text.includes(keyword)) {
                    show = false;
                }

                if (status !== "" && status !== "semua status" && !text.includes(status)) {
                    show = false;
                }

                if (tanggal !== "") {
                    const dateObj = new Date(tanggal);
                    const months = ["januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember"];
                    const indDate = String(dateObj.getDate()).padStart(2, '0') + " " + months[dateObj.getMonth()] + " " + dateObj.getFullYear();

                    if (!text.includes(indDate) && !text.includes(tanggal)) {
                        show = false;
                    }
                }

                row.style.display = show ? "" : "none";
            });
        };

        if (btnFilter) {
            btnFilter.addEventListener("click", function (e) {
                e.preventDefault();
                performFilter();
            });
        }

        if (searchInput) {
            searchInput.addEventListener("keyup", performFilter);
        }

        if (filterStatus) {
            filterStatus.addEventListener("change", performFilter);
        }

        if (filterTanggal) {
            filterTanggal.addEventListener("change", performFilter);
        }
    }
});

//=======================================
// CUSTOM POPUP MODAL (ALERT & CONFIRM)
//=======================================
function showCustomAlert(title, message) {
    let modal = document.getElementById("custom-alert-modal");
    if (!modal) {
        modal = document.createElement("div");
        modal.id = "custom-alert-modal";
        modal.className = "custom-modal-overlay";
        modal.innerHTML = `
            <div class="custom-modal-box">
                <div class="custom-modal-icon">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <h4 class="custom-modal-title"></h4>
                <p class="custom-modal-text"></p>
                <div class="custom-modal-actions">
                    <button class="btn btn-primary w-100 btn-modal-ok">OK</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);

        modal.querySelector(".btn-modal-ok").addEventListener("click", function () {
            modal.classList.remove("active");
        });
    }

    modal.querySelector(".custom-modal-title").innerText = title;
    modal.querySelector(".custom-modal-text").innerText = message;

    setTimeout(() => {
        modal.classList.add("active");
    }, 50);
}

function showCustomConfirm(title, message, onConfirm) {
    let modal = document.getElementById("custom-confirm-modal");
    if (!modal) {
        modal = document.createElement("div");
        modal.id = "custom-confirm-modal";
        modal.className = "custom-modal-overlay";
        modal.innerHTML = `
            <div class="custom-modal-box">
                <div class="custom-modal-icon text-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h4 class="custom-modal-title"></h4>
                <p class="custom-modal-text"></p>
                <div class="custom-modal-actions d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1 btn-modal-confirm">Ya, Lanjutkan</button>
                    <button class="btn btn-light border flex-grow-1 btn-modal-cancel">Batal</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    modal.querySelector(".custom-modal-title").innerText = title;
    modal.querySelector(".custom-modal-text").innerText = message;

    const btnConfirm = modal.querySelector(".btn-modal-confirm");
    const btnCancel = modal.querySelector(".btn-modal-cancel");

    const newBtnConfirm = btnConfirm.cloneNode(true);
    const newBtnCancel = btnCancel.cloneNode(true);

    btnConfirm.parentNode.replaceChild(newBtnConfirm, btnConfirm);
    btnCancel.parentNode.replaceChild(newBtnCancel, btnCancel);

    newBtnConfirm.addEventListener("click", function () {
        modal.classList.remove("active");
        if (onConfirm) onConfirm();
    });

    newBtnCancel.addEventListener("click", function () {
        modal.classList.remove("active");
    });

    setTimeout(() => {
        modal.classList.add("active");
    }, 50);
}

// Override native alert dialog
window.alert = function (message) {
    showCustomAlert("Pemberitahuan", message);
};

// Global confirm click interceptor
document.addEventListener("click", function (e) {
    const target = e.target.closest("[onclick], a, button");
    if (!target) return;

    const onClickAttr = target.getAttribute("onclick");
    const isConfirm = onClickAttr && onClickAttr.includes("confirm(");
    const isLogout = target.getAttribute("href") && target.getAttribute("href").includes("logout.php");

    if (isConfirm || isLogout) {
        e.preventDefault();
        e.stopPropagation();

        let message = "Apakah Anda yakin ingin melanjutkan?";
        if (isConfirm) {
            const match = onClickAttr.match(/confirm\(['"](.*?)['"]\)/);
            if (match && match[1]) {
                message = match[1];
            }
        } else if (isLogout) {
            message = "Apakah Anda yakin ingin logout dari sistem?";
        }

        showCustomConfirm("Konfirmasi Aksi", message, function () {
            if (target.getAttribute("href")) {
                window.location.href = target.getAttribute("href");
            } else {
                const form = target.closest("form");
                if (form) {
                    form.submit();
                } else if (onClickAttr) {
                    const cleanJs = onClickAttr.replace(/return\s+confirm\(.*?\);?/, "");
                    if (cleanJs.trim()) {
                        eval(cleanJs);
                    }
                }
            }
        });
    }
}, true);
