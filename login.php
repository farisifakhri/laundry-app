<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="./assets/img/laundry_logo_no_bg.png">
    <title>Login – Nugraha Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="login-page-bg">
    <div class="login-card">

        <!-- Brand Panel -->
        <div class="login-brand-panel">
            <img src="./assets/img/laundry_logo_no_bg.png" alt="Nugraha Laundry Logo">
            <p class="login-brand-name">Nugraha Laundry</p>
            <p class="login-brand-tagline">Sistem Manajemen Laundry Terpadu</p>

            <div class="login-features">
                <div class="login-feature-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Kelola transaksi dengan mudah</span>
                </div>
                <div class="login-feature-item">
                    <i class="bi bi-people-fill"></i>
                    <span>Manajemen data pelanggan</span>
                </div>
                <div class="login-feature-item">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Laporan & analisis real-time</span>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="login-form-panel">
            <h2>Selamat Datang</h2>
            <p class="login-sub">Masuk ke akun Anda untuk melanjutkan</p>

            <form id="formLogin">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border:1.5px solid var(--border);border-right:none;border-radius:8px 0 0 8px;background:#fff">
                            <i class="bi bi-envelope" style="color:var(--text-muted)"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Masukkan email Anda" required
                            style="border-left:none!important;border-radius:0 8px 8px 0!important">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border:1.5px solid var(--border);border-right:none;border-radius:8px 0 0 8px;background:#fff">
                            <i class="bi bi-lock" style="color:var(--text-muted)"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan password" required
                            style="border-left:none!important;border-radius:0 8px 8px 0!important">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./js/login.js"></script>
</body>
</html>
