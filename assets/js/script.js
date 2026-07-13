function lihatPassword() {

    const password = document.getElementById("password");
    const icon = document.getElementById("iconPassword");

    if (password.type === "password") {
        password.type = "text";
        icon.className = "bi bi-eye-slash";
    } else {
        password.type = "password";
        icon.className = "bi bi-eye";
    }
}


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

e.preventDefault();

const nama=document.getElementById("nama").value.trim();
const nim=document.getElementById("nim").value.trim();
const jenis=document.getElementById("jenis").value;
const fakultas=document.getElementById("fakultas").value.trim();
const prodi=document.getElementById("prodi").value.trim();
const email=document.getElementById("email").value.trim();
const hp=document.getElementById("hp").value.trim();
const alamat=document.getElementById("alamat").value.trim();

if(nama==""){
alert("Nama tidak boleh kosong");
return;
}

if(nim==""){
alert("NIM / NIP tidak boleh kosong");
return;
}

if(jenis==""){
alert("Pilih jenis pengguna");
return;
}

if(fakultas==""){
alert("Fakultas tidak boleh kosong");
return;
}

if(prodi==""){
alert("Prodi tidak boleh kosong");
return;
}

if(email==""){
alert("Email tidak boleh kosong");
return;
}

const emailRegex=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if(!emailRegex.test(email)){
alert("Format email salah");
return;
}

if(hp==""){
alert("Nomor HP tidak boleh kosong");
return;
}

if(!/^[0-9]+$/.test(hp)){
alert("Nomor HP hanya boleh angka");
return;
}

if(alamat==""){
alert("Alamat tidak boleh kosong");
return;
}

alert("Data berhasil divalidasi.");

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

            e.preventDefault();

            let nama = document.getElementById("nama").value.trim();
            let ruangan = document.getElementById("ruangan").value;
            let email = document.getElementById("email").value.trim();
            let hp = document.getElementById("hp").value.trim();
            let tanggal = document.getElementById("tanggal").value;
            let mulai = document.getElementById("jamMulai").value;
            let selesai = document.getElementById("jamSelesai").value;
            let peserta = document.getElementById("peserta").value;
            let keperluan = document.getElementById("keperluan").value.trim();

            if (nama == "" || ruangan == "" || email == "" || hp == "" ||
                tanggal == "" || mulai == "" || selesai == "" ||
                peserta == "" || keperluan == "") {

                alert("Semua data wajib diisi.");
                return;
            }

            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                alert("Format email salah.");
                return;
            }

            if (!/^[0-9]+$/.test(hp)) {
                alert("Nomor HP hanya boleh angka.");
                return;
            }

            if (mulai >= selesai) {
                alert("Jam mulai harus lebih kecil dari jam selesai.");
                return;
            }

            if (parseInt(peserta) < 1) {
                alert("Jumlah peserta minimal 1.");
                return;
            }

            alert("Reservasi berhasil divalidasi.");
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

        });

    }

    // ========================
    // FILTER
    // ========================

    const btnFilter = document.getElementById("btnFilter");

    if (btnFilter) {

        btnFilter.addEventListener("click", function () {

            let status = document.getElementById("filterStatus").value.toLowerCase();

            document.querySelectorAll("#tabelReservasi tbody tr").forEach(function (row) {

                if (status == "" || row.innerText.toLowerCase().includes(status)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }

            });

        });

    }

    // ========================
    // EDIT
    // ========================

    document.querySelectorAll(".btnEdit").forEach(function (btn) {

        btn.addEventListener("click", function () {

            let row = this.closest("tr");

            document.getElementById("kode").value = row.cells[0].innerText;
            document.getElementById("nama").value = row.cells[1].innerText;

            alert("Data berhasil dimuat ke form.");

            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });

        });

    });

    // ========================
    // HAPUS
    // ========================

    document.querySelectorAll(".btnHapus").forEach(function (btn) {

        btn.addEventListener("click", function () {

            if (confirm("Yakin ingin menghapus data?")) {

                this.closest("tr").remove();

            }

        });

    });

});

document.addEventListener("DOMContentLoaded", function () {

const form=document.getElementById("formRuangan");

if(form){

form.addEventListener("submit",function(e){

e.preventDefault();

let kode=document.getElementById("kode").value.trim();
let nama=document.getElementById("nama").value.trim();
let gedung=document.getElementById("gedung").value.trim();
let lantai=document.getElementById("lantai").value.trim();
let kapasitas=document.getElementById("kapasitas").value.trim();
let status=document.getElementById("status").value;
let fasilitas=document.getElementById("fasilitas").value.trim();

if(kode==""){
alert("Kode ruangan tidak boleh kosong");
return;
}

if(nama==""){
alert("Nama ruangan tidak boleh kosong");
return;
}

if(gedung==""){
alert("Gedung tidak boleh kosong");
return;
}

if(lantai==""){
alert("Lantai tidak boleh kosong");
return;
}

if(kapasitas==""){
alert("Kapasitas tidak boleh kosong");
return;
}

if(kapasitas<=0){
alert("Kapasitas harus lebih dari 0");
return;
}

if(status==""){
alert("Pilih status ruangan");
return;
}

if(fasilitas==""){
alert("Fasilitas tidak boleh kosong");
return;
}

alert("Data ruangan berhasil divalidasi.");

});

}

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

});