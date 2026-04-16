<?php
include './auth_check.php';
$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? '';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="./assets/img/laundry_logo_no_bg.png">
    <title>Nugraha Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo-icon">
                <i class="bi bi-water"></i>
            </div>
            <div>
                <p class="sidebar-title">Nugraha</p>
                <p class="sidebar-subtitle">Laundry System</p>
            </div>
        </div>

        <div class="sidebar-body">
            <p class="sidebar-section-label">Menu Utama</p>
            <ul class="sidebar-menu nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>" href="index.php">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>

                <?php if ($role == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'pelanggan' ? 'active' : '' ?>" href="pelanggan.php">
                        <i class="bi bi-people-fill"></i> Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'jenis_pelayanan' ? 'active' : '' ?>" href="jenis_pelayanan.php">
                        <i class="bi bi-tags-fill"></i> Jenis Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'pemesanan' ? 'active' : '' ?>" href="pemesanan.php">
                        <i class="bi bi-bag-check-fill"></i> Transaksi
                    </a>
                </li>
                <?php endif; ?>
            </ul>

            <p class="sidebar-section-label">Laporan & Pengaturan</p>
            <ul class="sidebar-menu nav flex-column">
                <?php if ($role == 'admin' || $role == 'owner') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'laporan' ? 'active' : '' ?>" href="laporan.php">
                        <i class="bi bi-bar-chart-line-fill"></i> Laporan Laba
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($role == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'user' ? 'active' : '' ?>" href="user.php">
                        <i class="bi bi-person-badge-fill"></i> Manajemen User
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </aside>

    <nav class="navbar navbar-expand">
        <div class="container-fluid">
            <button class="btn border-0 d-md-none me-2 px-1" id="btnToggleSidebar">
                <i class="bi bi-list fs-4"></i>
            </button>

            <h5 class="navbar-page-title mb-0">
                <?php
                $titles = [
                    'index'           => 'Overview Dashboard',
                    'pelanggan'       => 'Manajemen Pelanggan',
                    'jenis_pelayanan' => 'Konfigurasi Layanan',
                    'pemesanan'       => 'Riwayat Transaksi',
                    'laporan'         => 'Analisis Laporan',
                    'user'            => 'Manajemen Pengguna',
                    'struk'           => 'Cetak Struk',
                ];
                echo $titles[$currentPage] ?? 'Nugraha Laundry';
                ?>
            </h5>

            <div class="dropdown ms-auto">
                <div class="d-flex align-items-center gap-3" data-bs-toggle="dropdown" style="cursor:pointer">
                    <div class="text-end d-none d-md-block">
                        <p class="mb-0 fw-bold" style="font-size:13px; color:var(--text-primary)"><?= htmlspecialchars($user['nama'] ?? 'Admin') ?></p>
                        <p class="mb-0 text-muted" style="font-size:11px; text-transform:capitalize;"><?= htmlspecialchars($role) ?></p>
                    </div>
                    <div class="avatar-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2" style="border-radius:12px">
                    <li class="px-3 py-2 border-bottom mb-1">
                        <div class="fw-bold" style="font-size:13px"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 text-danger" href="logout.php">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="app">