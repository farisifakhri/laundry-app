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
    <div class="card mb-4 border-0" style="box-shadow: 0 4px 20px rgba(0,0,0,0.05); border-radius: 16px;">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-icon" style="background: var(--primary-light); color: var(--primary); width: 42px; height: 42px; font-size: 18px; border-radius: 12px;">
                        <i class="bi bi-calendar2-range-fill"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 15px;">Filter Periode Grafik</h6>
                        <small style="color: var(--text-muted); font-size: 12px;">Tentukan rentang bulan untuk melihat analisis transaksi</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="input-group shadow-sm" style="width: auto; border-radius: 10px; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 text-muted px-3">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                        <input type="month" class="form-control border-start-0 fw-semibold" id="startDate" onchange="onStartDateChange()" style="cursor: pointer;">
                    </div>
                    
                    <i class="bi bi-arrow-right-short text-muted fs-4 d-none d-md-block" id="endDateArrow"></i>
                    
                    <div class="input-group shadow-sm" id="endDateWrapper" style="width: auto; border-radius: 10px; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 text-muted px-3">
                            <i class="bi bi-calendar-check"></i>
                        </span>
                        <input type="month" class="form-control border-start-0 fw-semibold" id="endDate" onchange="getDataGrafik()" style="cursor: pointer;">
                    </div>
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
