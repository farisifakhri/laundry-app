<?php
include './auth_check.php';
$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="./assets/img/laundry_logo_no_bg.png">
    <title>Laundry App</title>
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
    <div>
        <div class="sidebar">
            <div class="sidebar-header">
                <h5 class="fw-bold text-primary mb-0">
                    <i class="bi bi-box-seam me-2"></i> Laundry App
                </h5>
            </div>


            <ul class="nav flex-column sidebar-menu">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        <i class="bi bi-house-door me-2"></i> Home
                    </a>
                </li>

                <?php if ($role == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link" href="pelanggan.php">
                        <i class="bi bi-people me-2"></i> Pelanggan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="jenis_pelayanan.php">
                        <i class="bi bi-tags me-2"></i> Jenis Layanan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pemesanan.php">
                        <i class="bi bi-basket me-2"></i> Transaksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="laporan.php">
                        <i class="bi bi-file-earmark-text me-2"></i> Laporan
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($role == 'owner') : ?>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="user.php">
                        <i class="bi bi-people-fill me-2"></i> User
                    </a>
                </li> -->

                <li class="nav-item">
                    <a class="nav-link" href="laporan.php">
                        <i class="bi bi-file-earmark-text me-2"></i> Laporan
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </div>
        <div>
            <nav class="navbar navbar-expand bg-white shadow-sm px-3 py-2">
                <div class="container-fluid">

                    <h5 class="mb-0 fw-bold text-primary">
                        Transaksi Laundry
                    </h5>

                    <div class="dropdown ms-auto">
                        <button class="btn d-flex align-items-center gap-2 border-0"
                            type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-3 text-primary"></i>
                            <span class="fw-semibold d-none d-md-inline">
                                <?= $user['nama']; ?>
                            </span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow rounded-3">
                            <li>
                                <a class="dropdown-item text-danger" href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>

        </div>
    </div>
    <div class="app">