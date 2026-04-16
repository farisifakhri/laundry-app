<?php include 'header.php'; ?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Selamat datang kembali, <strong><?= htmlspecialchars($user['nama'] ?? '') ?></strong> 👋</p>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card stat-card stat-card-primary">
                <div class="card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-label">Total Pelanggan</div>
                    <div class="stat-value" id="countPelanggan">—</div>
                    <div class="stat-sub">Pengguna terdaftar</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card stat-card-success">
                <div class="card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value" id="countPemesanan">—</div>
                    <div class="stat-sub">Pesanan masuk</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Laporan -->
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-funnel text-primary"></i>
            <span class="card-title">Filter Laporan</span>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Dari Bulan</label>
                    <input type="month" class="form-control" id="startDate" onchange="onStartDateChange()">
                </div>
                <div class="col-md-4 d-none" id="endDateWrapper">
                    <label class="form-label">Sampai Bulan</label>
                    <input type="month" class="form-control" id="endDate" onchange="getDataGrafik()">
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Transaksi -->
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-bar-chart-line text-primary"></i>
            <span class="card-title">Grafik Transaksi Harian</span>
        </div>
        <div class="card-body">
            <canvas id="grafikTransaksi" height="100"></canvas>
        </div>
    </div>

    <!-- Grafik Pelanggan -->
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-person-lines-fill text-primary"></i>
            <span class="card-title">Grafik Pelanggan Harian</span>
        </div>
        <div class="card-body">
            <canvas id="grafikPelanggan" height="100"></canvas>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="card spotlight-card mb-4">
        <div class="card-body p-5 text-center">
            <div style="font-size:40px;margin-bottom:12px">✅</div>
            <h3 class="fw-bold mb-3">Sistem Laundry Aktif</h3>
            <p class="fs-6 text-muted mb-0">
                Kelola pesanan, pelanggan, dan laporan dengan mudah dan efisien.
            </p>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
