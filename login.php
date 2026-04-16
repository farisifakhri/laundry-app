<?php
session_start();

// Jika sudah login, redirect ke index.php
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
    <title>ASET MANAJEMEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="card-login">
        <div class="card-body">
            <div class="row align-items-center">

                <!-- Bagian kanan: Gambar -->
                <div class="col-md-6 text-center">
                    <img src="./assets/img/laundry_logo_no_bg.png" 
                        class="img-fluid" 
                        alt="Logo Bulet"
                        style="max-height: auto;">
                </div>

                <!-- Bagian kiri: Form Login -->
                <div class="col-md-6 d-flex align-items-center">
                    <div class="login-form card shadow-lg border-0 w-100 p-4 rounded-4">

                        <h2 class="fw-bold text-center mb-1">Login User</h2>
                        <p class="text-muted text-center mb-4">Silahkan masuk dengan akun Anda</p>

                        <div class="card-body p-0">
                            <form id="formLogin">

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input 
                                        type="email" 
                                        class="form-control form-control-lg" 
                                        id="email" 
                                        name="email" 
                                        placeholder="Masukkan email Anda"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <input 
                                        type="password" 
                                        class="form-control form-control-lg" 
                                        id="password" 
                                        name="password"
                                        placeholder="Masukkan password"
                                        required
                                    >
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/login.js"></script>
</body>
</html>