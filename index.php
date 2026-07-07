<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Reservasi Ruangan Kampus</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="login-page">

    <div class="login-card">

        <!-- Logo -->
        <div class="login-logo">
            <i class="bi bi-building-check"></i>
        </div>

        <!-- Judul -->
        <div class="text-center mb-4">

            <h2 class="fw-bold text-primary">
                Reservasi Ruangan Kampus
            </h2>

            <p class="text-muted">
                Selamat Datang 👋
                <br>
                Silakan login untuk mengakses sistem reservasi ruangan kampus.
            </p>

        </div>

        

        <!-- Form Login -->

        <form action="home.html">

            <!-- Username -->

            <div class="mb-3">

                <label class="form-label fw-semibold">

                    Username / Email

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-person-fill"></i>

                    </span>

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Masukkan Username atau Email"
                        required>

                </div>

            </div>

            <!-- Password -->

            <div class="mb-3">

                <label class="form-label fw-semibold">

                    Password

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-lock-fill"></i>

                    </span>

                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        placeholder="Masukkan Password"
                        required>

                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        onclick="lihatPassword()">

                         <i class="bi bi-eye" id="iconPassword"></i>

                    </button>

                </div>

            </div>

            <!-- Remember -->

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="ingatSaya">

                    <label
                        class="form-check-label"
                        for="ingatSaya">

                        Ingat Saya

                    </label>

                </div>

                <a href="#" class="text-decoration-none">

                    Lupa Password?

                </a>

            </div>

            <!-- Tombol Login -->

            <button
                class="btn btn-primary w-100 py-2">

                <i class="bi bi-box-arrow-in-right me-2"></i>

                Login

            </button>

        </form>

        <!-- Garis -->

        <div class="text-center my-4">

            <hr>

            <span class="text-muted">

                atau login menggunakan

            </span>

        </div>

        <!-- Login Sosial -->

        <div class="d-grid gap-2">

            <button class="btn btn-outline-danger">

                <i class="bi bi-google me-2"></i>

                Login dengan Google

            </button>

            <button class="btn btn-outline-primary">

                <i class="bi bi-microsoft me-2"></i>

                Login dengan Microsoft

            </button>

        </div>

        <!-- Footer -->

        <div class="text-center mt-4">

            <small class="text-muted">

                © 2026 Sistem Reservasi Ruangan Kampus

            </small>

            <br>

            <small class="text-secondary">

                Universitas UIN Ar-Raniry

            </small>

        </div>

    </div>

</div>

<script>

function lihatPassword(){

    const password=document.getElementById("password");

    const icon=document.getElementById("iconPassword");

    if(password.type==="password"){

        password.type="text";

        icon.className="bi bi-eye-slash";

    }else{

        password.type="password";

        icon.className="bi bi-eye";

    }

}

</script>

        
</body>
</html>




