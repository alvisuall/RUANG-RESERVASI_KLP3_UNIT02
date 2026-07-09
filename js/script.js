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
alert("JavaScript berhasil dijalankan!");
