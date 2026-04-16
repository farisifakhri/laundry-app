<?php
include 'header.php';
?>
<div class="card shadow-sm border-0 rounded-4">

    <!-- HEADER -->
    <div class="card-header bg-white border-0">
        <h5 class="mb-0 fw-semibold">Halaman Laporan</h5>
    </div>

    <div class="card-body">

        <!-- FILTER -->
        <div class="row g-3 align-items-end mb-4">

            <div class="col-md-3">
                <label for="date_start" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="date_start">
            </div>

            <div class="col-md-3">
                <label for="date_end" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="date_end">
            </div>

            <div class="col-md-6 d-flex flex-wrap gap-2 justify-content-md-end">
                <button type="button" 
                        class="btn btn-primary d-flex align-items-center gap-1"
                        onclick="getDataLaporan()">
                    <i class="bi bi-search"></i> Tampilkan
                </button>

                <button type="button" 
                        class="btn btn-outline-danger d-flex align-items-center gap-1"
                        onclick="printLaporan('pdf')">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </button>

                <button type="button" 
                        class="btn btn-outline-success d-flex align-items-center gap-1"
                        onclick="printLaporan('excel')">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </button>
            </div>

        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="30%">Pelanggan</th>
                        <th width="15%">Metode Pembayaran</th>
                        <th width="15%">Tanggal Order</th>
                        <th>Detail Layanan</th>
                        <th width="15%">Total</th>
                    </tr>
                </thead>

                <tbody id="dataLaporan">
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php
include 'footer.php';
?>
