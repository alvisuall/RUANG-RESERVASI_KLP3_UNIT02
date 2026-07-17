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

<<<<<<< HEAD
document.addEventListener("DOMContentLoaded", function () {

console.log("Script berhasil dijalankan");


//==============================
// SEARCH TABLE
//==============================

const searchInput = document.getElementById("searchInput");

if(searchInput){

searchInput.addEventListener("keyup", function(){

let keyword = this.value.toLowerCase();

let rows = document.querySelectorAll("#tabelReservasi tbody tr");

rows.forEach(function(row){

let text = row.innerText.toLowerCase();

row.style.display = text.includes(keyword) ? "" : "none";

});

});

}

//==============================
// KONFIRMASI LOGOUT
//==============================

const logout = document.querySelector('a[href="auth/logout.php"]');

if(logout){

logout.addEventListener("click", function(e){

if(!confirm("Apakah Anda yakin ingin logout?")){

e.preventDefault();

}

});

}

//==============================
// KONFIRMASI TAMBAH RESERVASI
//==============================

const tambah = document.querySelector('a[href="reservasi.php"]');

if(tambah){

tambah.addEventListener("click", function(e){

if(!confirm("Masuk ke halaman Reservasi?")){

e.preventDefault();

}

});

}

//==============================
// EFEK HOVER CARD
//==============================

document.querySelectorAll(".stat-card").forEach(function(card){

card.addEventListener("mouseenter", function(){

card.style.transform="translateY(-8px)";
card.style.transition=".3s";

});

card.addEventListener("mouseleave", function(){

card.style.transform="translateY(0px)";

});

});

//==============================
// ANGKA BERJALAN
//==============================

document.querySelectorAll(".stat-card h3").forEach(function(number){

let target=parseInt(number.innerText);

let count=0;

let speed=Math.ceil(target/40);

let interval=setInterval(function(){

count+=speed;

if(count>=target){

count=target;
clearInterval(interval);

}

number.innerText=count;

},30);

});

//==============================
// WAKTU REALTIME
//==============================

const title=document.querySelector(".page-title p");

if(title){

setInterval(function(){

const now=new Date();

title.innerHTML="Kelola reservasi ruangan kampus | "+now.toLocaleTimeString('id-ID');

},1000);

}

//==============================
// HIGHLIGHT MENU
//==============================

const links=document.querySelectorAll(".sidebar-menu a");

links.forEach(function(link){

link.addEventListener("click",function(){

links.forEach(function(l){

l.classList.remove("active");

});

this.classList.add("active");

});

});

//==============================
// ANIMASI TABEL
//==============================

const rows=document.querySelectorAll("#tabelReservasi tbody tr");

rows.forEach(function(row,index){

row.style.opacity="0";

setTimeout(function(){

row.style.transition=".4s";

row.style.opacity="1";

},index*200);

});

});
const menuReservasi = document.getElementById("menuReservasi");

if (menuReservasi) {

    menuReservasi.addEventListener("click", function (e) {

        if (!confirm("Buka halaman Reservasi?")) {
            e.preventDefault();
        }

    });

}

document.addEventListener("DOMContentLoaded", function(){

const form=document.getElementById("filterForm");
const cari=document.getElementById("cariRuangan");
const tanggal=document.getElementById("filterTanggal");
const status=document.getElementById("filterStatus");
const tabel=document.getElementById("tabelJadwal");

if(form){

form.addEventListener("submit",function(e){

e.preventDefault();

const keyword=cari.value.toLowerCase();
const tgl=tanggal.value;
const sts=status.value.toLowerCase();

const rows=tabel.querySelectorAll("tbody tr");

rows.forEach(function(row){

const text=row.innerText.toLowerCase();

let tampil=true;

if(keyword!="" && !text.includes(keyword)){
tampil=false;
}

if(sts!="semua status" && sts!="" && !text.includes(sts)){
tampil=false;
}

if(tgl!=""){

const inputDate=new Date(tgl);

const bulan=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

const formatTanggal=inputDate.getDate()+" "+bulan[inputDate.getMonth()]+" "+inputDate.getFullYear();

if(!text.includes(formatTanggal.toLowerCase())){
tampil=false;
}

}

row.style.display=tampil?"":"none";

});

});

}

// Hover Card

document.querySelectorAll(".schedule-box").forEach(function(card){

card.addEventListener("mouseenter",function(){

card.style.transform="translateY(-5px)";
card.style.transition=".3s";

});

card.addEventListener("mouseleave",function(){

card.style.transform="translateY(0px)";

});

});

// Klik Jadwal

document.querySelectorAll(".schedule-item").forEach(function(item){

item.style.cursor="pointer";

item.addEventListener("click",function(){

alert("Jadwal dipilih :\n\n"+this.innerText);

});

});

// Highlight Baris

document.querySelectorAll("#tabelJadwal tbody tr").forEach(function(row){

row.addEventListener("click",function(){

document.querySelectorAll("#tabelJadwal tbody tr").forEach(function(r){

r.classList.remove("table-primary");

});

this.classList.add("table-primary");

});

});

// Validasi Tanggal

if(tanggal){

tanggal.min=new Date().toISOString().split("T")[0];

}

});

document.addEventListener("DOMContentLoaded", function(){

//===========================
// VALIDASI FORM
//===========================

const form=document.getElementById("formPengguna");

if(form){

form.addEventListener("submit",function(e){

const nama=document.getElementById("nama").value.trim();
const nim=document.getElementById("nim").value.trim();
const jenis=document.getElementById("jenis").value;
const fakultas=document.getElementById("fakultas").value.trim();
const prodi=document.getElementById("prodi").value.trim();
const email=document.getElementById("email").value.trim();
const hp=document.getElementById("hp").value.trim();
const alamat=document.getElementById("alamat").value.trim();

if(nama==""){
e.preventDefault();
alert("Nama tidak boleh kosong");
return;
}

if(nim==""){
e.preventDefault();
alert("NIM / NIP tidak boleh kosong");
return;
}

if(jenis==""){
e.preventDefault();
alert("Pilih jenis pengguna");
return;
}

if(fakultas==""){
e.preventDefault();
alert("Fakultas tidak boleh kosong");
return;
}

if(prodi==""){
e.preventDefault();
alert("Prodi tidak boleh kosong");
return;
}

if(email==""){
e.preventDefault();
alert("Email tidak boleh kosong");
return;
}

const emailRegex=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if(!emailRegex.test(email)){
e.preventDefault();
alert("Format email salah");
return;
}

if(hp==""){
e.preventDefault();
alert("Nomor HP tidak boleh kosong");
return;
}

if(!/^[0-9]+$/.test(hp)){
e.preventDefault();
alert("Nomor HP hanya boleh angka");
return;
}

if(alamat==""){
e.preventDefault();
alert("Alamat tidak boleh kosong");
return;
}

});

}

//===========================
// SEARCH
//===========================

const search=document.getElementById("searchInput");

if(search){

search.addEventListener("keyup",function(){

const keyword=this.value.toLowerCase();

document.querySelectorAll("#tabelPengguna tbody tr").forEach(function(row){

row.style.display=row.innerText.toLowerCase().includes(keyword)?"":"none";

});

});

}

//===========================
// EDIT
//===========================

document.querySelectorAll(".btnEdit").forEach(function(btn){

btn.addEventListener("click",function(){

let row=this.closest("tr");

document.getElementById("nama").value=row.cells[0].innerText;
document.getElementById("nim").value=row.cells[1].innerText;
document.getElementById("jenis").value=row.cells[2].innerText.toLowerCase();
document.getElementById("fakultas").value=row.cells[3].innerText;
document.getElementById("email").value=row.cells[4].innerText;
document.getElementById("hp").value=row.cells[5].innerText;

window.scrollTo({
top:0,
behavior:"smooth"
});

});

});

//===========================
// HAPUS
//===========================

document.querySelectorAll(".btnHapus").forEach(function(btn){

btn.addEventListener("click",function(){

if(confirm("Yakin ingin menghapus data ini?")){

this.closest("tr").remove();

alert("Data berhasil dihapus.");

}

});

});

});
document.addEventListener("DOMContentLoaded", function () {

    // ========================
    // VALIDASI FORM
    // ========================

    const form = document.getElementById("formReservasi");

    if (form) {

        form.addEventListener("submit", function (e) {

            let kode = document.getElementById("kode_reservasi").value.trim();
            let pengguna = document.getElementById("id_pengguna").value;
            let ruangan = document.getElementById("id_ruangan").value;
            let tanggal = document.getElementById("tanggal_reservasi").value;
            let mulai = document.getElementById("jam_mulai").value;
            let selesai = document.getElementById("jam_selesai").value;
            let peserta = document.getElementById("jumlah_peserta").value;
            let keperluan = document.getElementById("keperluan").value.trim();

            if (kode == "" || pengguna == "" || ruangan == "" ||
                tanggal == "" || mulai == "" || selesai == "" ||
                peserta == "" || keperluan == "") {

                e.preventDefault();
                alert("Semua data wajib diisi.");
                return;
            }

            if (mulai >= selesai) {
                e.preventDefault();
                alert("Jam mulai harus lebih kecil dari jam selesai.");
                return;
            }

            if (parseInt(peserta) < 1) {
                e.preventDefault();
                alert("Jumlah peserta minimal 1.");
                return;
            }
        });

    }

    // ========================
    // PENCARIAN
    // ========================

    const search = document.getElementById("searchInput");

    if (search) {

        search.addEventListener("keyup", function () {

            let keyword = this.value.toLowerCase();

            document.querySelectorAll("#tabelReservasi tbody tr").forEach(function (row) {

                row.style.display =
                    row.innerText.toLowerCase().includes(keyword) ? "" : "none";

            });

=======
            if (password.type === "password") {
                password.type = "text";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
            } else {
                password.type = "password";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
            }

>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a
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

<<<<<<< HEAD
            const form = document.getElementById("formRuangan");

            if (form) {

                form.addEventListener("submit", function (e) {

                    let kode = document.getElementById("kode").value.trim();
                    let nama = document.getElementById("nama").value.trim();
                    let gedung = document.getElementById("gedung").value.trim();
                    let lantai = document.getElementById("lantai").value.trim();
                    let kapasitas = document.getElementById("kapasitas").value.trim();
                    let status = document.getElementById("status").value;
                    let fasilitas = document.getElementById("fasilitas").value.trim();

                    if (kode == "") {
                        e.preventDefault();
                        alert("Kode ruangan tidak boleh kosong");
                        return;
                    }

                    if (nama == "") {
                        e.preventDefault();
                        alert("Nama ruangan tidak boleh kosong");
                        return;
                    }

                    if (gedung == "") {
                        e.preventDefault();
                        alert("Gedung tidak boleh kosong");
                        return;
                    }

                    if (lantai == "") {
                        e.preventDefault();
                        alert("Lantai tidak boleh kosong");
                        return;
                    }

                    if (kapasitas == "") {
                        e.preventDefault();
                        alert("Kapasitas tidak boleh kosong");
                        return;
                    }

                    if (kapasitas <= 0) {
                        e.preventDefault();
                        alert("Kapasitas harus lebih dari 0");
                        return;
                    }

                    if (status == "") {
                        e.preventDefault();
                        alert("Pilih status ruangan");
                        return;
                    }

                    if (fasilitas == "") {
                        e.preventDefault();
                        alert("Fasilitas tidak boleh kosong");
                        return;
                    }

                    // Kalau semua valid, biarkan form terkirim ke PHP
                });

            }

        });

//================ SEARCH ===================

const search=document.getElementById("searchInput");

if(search){

search.addEventListener("keyup",function(){

let keyword=this.value.toLowerCase();

document.querySelectorAll("#tabelRuangan tbody tr").forEach(function(row){

row.style.display=row.innerText.toLowerCase().includes(keyword)?"":"none";

});

});

}

//================ EDIT ===================

document.querySelectorAll(".btnEdit").forEach(function(btn){

btn.addEventListener("click",function(){

let row=this.closest("tr");

document.getElementById("kode").value=row.cells[0].innerText;
document.getElementById("nama").value=row.cells[1].innerText;
document.getElementById("gedung").value=row.cells[2].innerText;
document.getElementById("kapasitas").value=row.cells[3].innerText;

window.scrollTo({
top:0,
behavior:"smooth"
});

alert("Data berhasil dimuat ke form.");

});

});

//================ HAPUS ===================

document.querySelectorAll(".btnHapus").forEach(function(btn){

btn.addEventListener("click",function(){

if(confirm("Yakin ingin menghapus data ini?")){

this.closest("tr").remove();

alert("Data berhasil dihapus.");

}

});

});

//================ RESET ===================

const reset=document.getElementById("btnReset");

if(reset){

reset.addEventListener("click",function(){

if(confirm("Reset semua data?")){

form.reset();

}

});

}
=======
    if (tanggal) {

        const hariIni = new Date().toISOString().split("T")[0];

        tanggal.min = hariIni;

    }
>>>>>>> 71f784bdf2045fdd685b663878ac4a9ecf8a488a

//==============================
// DARK MODE
//==============================
(function() {
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
        if (toggleSwitch) {
            if (currentTheme === 'dark') {
                toggleSwitch.checked = true;
            }
            toggleSwitch.addEventListener('change', function(e) {
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
document.addEventListener("DOMContentLoaded", function() {
    const btnFilter = document.getElementById("btnFilter");
    const searchInput = document.getElementById("searchInput");
    const filterStatus = document.getElementById("filterStatus");
    const filterTanggal = document.getElementById("filterTanggal");
    
    if (btnFilter || searchInput || filterStatus || filterTanggal) {
        const performFilter = function() {
            const keyword = searchInput ? searchInput.value.toLowerCase() : "";
            const status = filterStatus ? filterStatus.value.toLowerCase() : "";
            const tanggal = filterTanggal ? filterTanggal.value : "";
            
            const rows = document.querySelectorAll("#tabelReservasi tbody tr, #tabelJadwal tbody tr");
            rows.forEach(function(row) {
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
                    const months = ["januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember"];
                    const indDate = String(dateObj.getDate()).padStart(2, '0') + " " + months[dateObj.getMonth()] + " " + dateObj.getFullYear();
                    
                    if (!text.includes(indDate) && !text.includes(tanggal)) {
                        show = false;
                    }
                }
                
                row.style.display = show ? "" : "none";
            });
        };
        
        if (btnFilter) {
            btnFilter.addEventListener("click", function(e) {
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
        
        modal.querySelector(".btn-modal-ok").addEventListener("click", function() {
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
    
    newBtnConfirm.addEventListener("click", function() {
        modal.classList.remove("active");
        if (onConfirm) onConfirm();
    });
    
    newBtnCancel.addEventListener("click", function() {
        modal.classList.remove("active");
    });
    
    setTimeout(() => {
        modal.classList.add("active");
    }, 50);
}

// Override native alert dialog
window.alert = function(message) {
    showCustomAlert("Pemberitahuan", message);
};

// Global confirm click interceptor
document.addEventListener("click", function(e) {
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
        
        showCustomConfirm("Konfirmasi Aksi", message, function() {
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

