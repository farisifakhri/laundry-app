<?php
include 'header.php';
?>
<div class="card shadow-sm border-0 rounded-4">

    <!-- HEADER -->
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Halaman Transaksi</h5>
    </div>

    <div class="col-md-3">
        <button type="button"
                class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahPemesanan">
            <i class="bi bi-plus"></i> Tambah Transaksi
        </button>
    </div>

    <input type="hidden" id="nama_user" value="<?= $user['nama'] ?>">
    <input type="hidden" id="id_user" value="<?= $user['id'] ?>">

    <div class="card-body">

        <!-- FILTER -->
        <div class="row mb-3 align-items-end g-2">
            <div class="col-md-2">
                <label for="limit" class="form-label">Limit</label>
                <select class="form-select" id="limit" onchange="getDataTransaksi()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-md-4 ms-auto">
                <label for="search" class="form-label">Cari Transaksi</label>
                <input type="text"
                       class="form-control"
                       id="search"
                       placeholder="Nama pelanggan / tanggal..."
                       onkeyup="getDataTransaksi()">
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="4%">No</th>
                        <th width="22%">Pelanggan</th>
                        <th width="15%">Metode Pembayaran</th>
                        <th width="15%">Tanggal Order</th>
                        <th>Detail Layanan</th>
                        <th width="12%">Total</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>

                <tbody id="dataPemesanan">
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOTER TABLE -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted">
                Total Data: <strong id="countPemesanan"></strong>
            </div>

            <ul class="pagination mb-0" id="pagination"></ul>
        </div>

    </div>
</div>

<!-- Modal tambah pemesanan -->
<div class="modal fade" id="modalTambahPemesanan" tabindex="-1" aria-labelledby="modalTambahPemesananLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPemesananLabel">Tambah Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="formTambahPemesanan" method="POST">
                    <!-- Bagian Transaksi Utama -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_pelanggan" class="form-label">Pelanggan</label>
                            <select class="form-select" id="id_pelanggan" name="id_pelanggan" required>
                                <option value="">Pilih Pelanggan</option>
                                <!-- Option pelanggan -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="E-Wallet">E-wallet</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="note_pembayaran" class="form-label">Catatan Tambahan</label>
                        <input type="text" class="form-control" id="note_pembayaran" name="note_pembayaran">
                    </div>

                    <hr>

                    <!-- Bagian Detail Transaksi -->
                    <h6>Detail Layanan</h6>
                    <table class="table table-bordered align-middle" id="tableDetail">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Layanan</th>
                                <th>Harga/Kg (Rp)</th>
                                <th>Qty (Kg)</th>
                                <th>Subtotal (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detailBody">
                            <tr>
                                <td>
                                    <select class="form-select jenis_layanan" name="jenis_layanan[]" required>
                                        <option value="">Pilih Layanan</option>
                                        <!-- Tambahkan jenis layanan di sini -->
                                    </select>
                                </td>
                                <td><input type="number" class="form-control harga" name="harga[]" required></td>
                                <td><input type="number" class="form-control qty" name="qty[]" required></td>
                                <td><input type="number" class="form-control subtotal" name="subtotal[]" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm btnHapus">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mb-3">
                        <button type="button" class="btn btn-success btn-sm" id="btnTambahDetail">
                            + Tambah Layanan
                        </button>
                    </div>

                    <div class="mb-3 text-end">
                        <label for="total" class="form-label fw-bold">Total (Rp):</label>
                        <input type="number" class="form-control d-inline-block w-auto" id="total" name="total" readonly>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include 'footer.php';
?>