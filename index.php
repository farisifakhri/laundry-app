<?php include 'header.php'; ?>

<div class="container-fluid">

    <!-- Judul -->
    <div class="mb-5">
        <h1 class="fw-bold">Dashboard</h1>
        <p class="text-muted fs-5">Selamat datang di sistem manajemen Laundry</p>
    </div>

    <!-- Info cards -->
    <div class="row g-4">

        <div class="col-md-6">
            <div class="card stat-card bg-primary text-white shadow-lg border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2">Total Pelanggan</h6>
                    <h1 class="fw-bold" id="countPelanggan"></h1>
                    <small>Pengguna terdaftar</small>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card stat-card bg-success text-white shadow-lg border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2">Total Pesanan</h6>
                    <h1 class="fw-bold" id="countPemesanan"></h1>
                    <small>Pesanan masuk</small>
                </div>
            </div>
        </div>

    </div>
  <!-- ================= FILTER LAPORAN ================= -->
    <div class="card mt-5 shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Filter Laporan</h5>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Dari Bulan</label>
                    <input
                        type="month"
                        class="form-control"
                        id="startDate"
                        onchange="onStartDateChange()"
                    >
                </div>

                <div class="col-md-4 d-none" id="endDateWrapper">
                    <label class="form-label">Sampai Bulan</label>
                    <input
                        type="month"
                        class="form-control"
                        id="endDate"
                        onchange="getDataGrafik()"
                    >
                </div>
            </div>


            <!--
            NOTE BACKEND:
            - User memilih rentang bulan (bulan A - bulan B)
            - Backend akan mengambil DATA PER TANGGAL
            - Contoh rentang: 2024-02 s/d 2024-03
            -->
        </div>
    </div>

    <!-- ================= GRAFIK TRANSAKSI PER TANGGAL ================= -->
    <div class="card mt-5 shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h5 class="fw-bold mb-4">Grafik Transaksi Harian</h5>
            <canvas id="grafikTransaksi" height="100"></canvas>

            <!--
            NOTE BACKEND:
            - Data grafik diambil dari variabel:
            $transaksi
            - Data sudah DIKELOMPOKKAN PER TANGGAL
            - Contoh format data:
            
            $transaksi = [
                ['tanggal' => '2024-02-01', 'total' => 5],
                ['tanggal' => '2024-02-02', 'total' => 8],
                ['tanggal' => '2024-02-03', 'total' => 6],
                ...
                ['tanggal' => '2024-03-31', 'total' => 10]
            ];
            -->
        </div>
    </div>

    <!-- ================= GRAFIK PELANGGAN PER TANGGAL ================= -->
    <div class="card mt-5 shadow-lg border-0 rounded-4 mb-5">
        <div class="card-body">
            <h5 class="fw-bold mb-4">Grafik Pelanggan Harian</h5>
            <canvas id="grafikPelanggan" height="100"></canvas>

            <!--
            NOTE BACKEND:
            - Data pelanggan juga ditampilkan PER TANGGAL
            - Bisa digabung atau dipisah dari variabel $transaksi
            - Contoh:
            
            $transaksi['pelanggan'] = [
                ['tanggal' => '2024-02-01', 'total' => 2],
                ['tanggal' => '2024-02-02', 'total' => 3],
                ...
            ];
            -->
        </div>
    </div>


    <!-- Highlight card -->
    <div class="card mt-5 spotlight-card border-0 shadow-lg rounded-4">
        <div class="card-body p-5 text-center">
            <h3 class="fw-bold mb-3">Sistem Laundry Aktif ✅</h3>
            <p class="fs-5 text-muted">
                Kelola pesanan, pelanggan, dan laporan dengan mudah dan cepat.
            </p>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
