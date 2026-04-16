<?php include 'header.php'; ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0" style="font-size:13.5px">Kelola data transaksi laundry</p>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#modalTambahPemesanan">
            <i class="bi bi-plus-lg"></i> Tambah Transaksi
        </button>
    </div>

    <input type="hidden" id="nama_user" value="<?= $user['nama'] ?>">
    <input type="hidden" id="id_user" value="<?= $user['id'] ?>">

    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-bag-check text-primary"></i>
            <span class="card-title">Daftar Transaksi</span>
        </div>
        <div class="card-body">

            <div class="row mb-4 g-3 align-items-end">
                <div class="col-auto">
                    <label class="form-label">Tampilkan</label>
                    <select class="form-select" id="limit" onchange="getDataTransaksi()" style="width:90px">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-4 ms-auto">
                    <label class="form-label">Pencarian</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border:1.5px solid var(--border);background:#fff;border-right:none">
                            <i class="bi bi-search" style="color:var(--text-muted);font-size:13px"></i>
                        </span>
                        <input type="text" class="form-control" id="search"
                            placeholder="Nama pelanggan / tanggal..."
                            onkeyup="getDataTransaksi()"
                            style="border-left:none!important">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-custom" id="dataTable">
                    <thead>
                        <tr>
                            <th width="4%">No</th>
                            <th width="22%">Pelanggan</th>
                            <th width="15%">Metode Bayar</th>
                            <th width="15%">Tanggal Order</th>
                            <th>Detail Layanan</th>
                            <th width="12%">Total</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataPemesanan">
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-hourglass-split me-2"></i>Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Total: <strong id="countPemesanan"></strong> transaksi
                </div>
                <ul class="pagination mb-0" id="pagination"></ul>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="modalTambahPemesanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-bag-plus me-2 text-primary"></i>Tambah Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPemesanan" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pelanggan</label>
                            <select class="form-select" id="id_pelanggan" name="id_pelanggan" required>
                                <option value="">Pilih Pelanggan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">Pilih Metode</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="E-Wallet">E-Wallet</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <input type="text" class="form-control" id="note_pembayaran" name="note_pembayaran" placeholder="Opsional">
                    </div>

                    <hr class="my-3">

                    <h6 class="fw-700 mb-3" style="font-weight:700">Detail Layanan</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="tableDetail">
                            <thead>
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
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control harga" name="harga[]" required></td>
                                    <td><input type="number" class="form-control qty" name="qty[]" required></td>
                                    <td><input type="number" class="form-control subtotal" name="subtotal[]" readonly></td>
                                    <td><button type="button" class="btn btn-danger btn-sm btnHapus"><i class="bi bi-trash"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-1" id="btnTambahDetail">
                            <i class="bi bi-plus-lg"></i> Tambah Layanan
                        </button>
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0 fw-bold">Total (Rp):</label>
                            <input type="number" class="form-control" id="total" name="total" readonly style="width:160px">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
