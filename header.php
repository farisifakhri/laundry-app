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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="./assets/img/laundry_logo_no_bg.png">
    <title>Nugraha Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo-icon">
                <i class="bi bi-water"></i>
            </div>
            <div>
                <p class="sidebar-title">Nugraha</p>
                <p class="sidebar-subtitle">Laundry Management</p>
            </div>
        </div>

        <div class="sidebar-body">
            <p class="sidebar-section-label">Menu Utama</p>
            <ul class="sidebar-menu nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>" href="index.php">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>

                <?php if ($role == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'pelanggan' ? 'active' : '' ?>" href="pelanggan.php">
                        <i class="bi bi-people"></i> Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'jenis_pelayanan' ? 'active' : '' ?>" href="jenis_pelayanan.php">
                        <i class="bi bi-tags"></i> Jenis Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'pemesanan' ? 'active' : '' ?>" href="pemesanan.php">
                        <i class="bi bi-bag-check"></i> Transaksi
                    </a>
                </li>
                <?php endif; ?>
            </ul>

            <p class="sidebar-section-label" style="margin-top:16px">Laporan</p>
            <ul class="sidebar-menu nav flex-column">
                <?php if ($role == 'admin' || $role == 'owner') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'laporan' ? 'active' : '' ?>" href="laporan.php">
                        <i class="bi bi-file-earmark-bar-graph"></i> Laporan
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </aside>

    <nav class="navbar navbar-expand bg-white px-3 py-2">
        <div class="container-fluid">
            <h5 class="navbar-page-title mb-0">
                <?php
                $titles = [
                    'index'           => 'Dashboard',
                    'pelanggan'       => 'Data Pelanggan',
                    'jenis_pelayanan' => 'Jenis Layanan',
                    'pemesanan'       => 'Transaksi',
                    'laporan'         => 'Laporan',
                    'user'            => 'Manajemen User',
                    'struk'           => 'Struk Pembayaran',
                ];
                echo $titles[$currentPage] ?? 'Nugraha Laundry';
                ?>
            </h5>

            <div class="dropdown ms-auto">
                <button class="btn d-flex align-items-center gap-2 border-0 p-1" type="button" data-bs-toggle="dropdown">
                    <span class="avatar-icon">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <div class="text-start d-none d-md-block">
                        <div style="font-size:13px;font-weight:700;color:var(--text-primary);line-height:1.2">
                            <?= htmlspecialchars($user['nama'] ?? 'User') ?>
                        </div>
                        <div style="font-size:11px;color:var(--text-muted);text-transform:capitalize">
                            <?= htmlspecialchars($role) ?>
                        </div>
                    </div>
                    <i class="bi bi-chevron-down ms-1" style="font-size:11px;color:var(--text-muted)"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow rounded-3" style="min-width:180px">
                    <li>
                        <div class="px-3 py-2 border-bottom mb-1">
                            <div style="font-size:13px;font-weight:700"><?= htmlspecialchars($user['nama'] ?? '') ?></div>
                            <div style="font-size:11.5px;color:var(--text-muted)"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="logout.php">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="app">
