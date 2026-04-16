<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="fw-800 mb-1">Jenis Layanan</h1>
            <p class="text-muted mb-0">Kelola katalog jasa dan tarif <strong>Nugraha Laundry</strong></p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm py-2 px-4"
                data-bs-toggle="modal" data-bs-target="#modalTambahJenisPelayanan">
            <i class="bi bi-plus-circle-fill fs-5"></i>
            <span>Tambah Layanan Baru</span>
        </button>
    </div>

    <input type="hidden" id="nama_user" value="<?= htmlspecialchars($user['nama'] ?? '') ?>">
    <input type="hidden" id="id_user" value="<?= htmlspecialchars($user['id'] ?? '') ?>">

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="p-4 border-bottom bg-white rounded-top-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <select class="form-select border-0 bg-light fw-semibold" id="limit" onchange="getDataJenisPelayanan()" style="width:110px;">
                            <option value="10">10 Baris</option>
                            <option value="25">25 Baris</option>
                            <option value="50">50 Baris</option>
                        </select>
                    </div>
                    <div class="col-md-4 ms-auto">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-0 ps-0" id="search" 
                                   placeholder="Cari nama layanan atau harga..." onkeyup="getDataJenisPelayanan()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="5%">No.</th>
                            <th>Nama Layanan</th>
                            <th>Harga per Satuan</th>
                            <th>Status Operasional</th>
                            <th class="pe-4 text-end" width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataJenisPelayanan">
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                                <span class="text-muted">Sinkronisasi data layanan...</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 border-top">
                <div class="text-muted small">
                    Menampilkan <strong id="countJenisPelayanan" class="text-primary">0</strong> jenis jasa aktif
                </div>
                <nav><ul class="pagination mb-0" id="pagination"></ul></nav>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahJenisPelayanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-tag-fill text-primary me-2"></i>Konfigurasi Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formTambahJenisPelayanan" class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Jasa / Layanan</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Cuci Kering Setrika" required>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label small fw-bold text-muted text-uppercase">Harga (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control" id="harga" name="harga" placeholder="0" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditJenisPelayanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditJenisPelayanan" class="row g-3">
                    <input type="hidden" id="id_jenis_layanan" name="id_layanan">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Jasa / Layanan</label>
                        <input type="text" class="form-control" id="nama_edit" name="nama_edit" required>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label small fw-bold text-muted text-uppercase">Harga (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control" id="harga_edit" name="harga_edit" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                        <select class="form-select" id="status_edit" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4 text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Update Layanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>