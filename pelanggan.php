<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="fw-800 mb-1">Data Pelanggan</h1>
            <p class="text-muted mb-0">Kelola informasi database pelanggan setia Anda</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm py-2 px-4"
                data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
            <i class="bi bi-person-plus-fill fs-5"></i>
            <span>Tambah Pelanggan</span>
        </button>
    </div>

    <input type="hidden" id="nama_user" value="<?= htmlspecialchars($user['nama'] ?? '') ?>">
    <input type="hidden" id="id_user" value="<?= htmlspecialchars($user['id'] ?? '') ?>">

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="p-4 border-bottom bg-white rounded-top-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <select class="form-select border-0 bg-light fw-semibold" id="limit" onchange="getDataPelanggan()" style="width:110px;">
                            <option value="10">10 Baris</option>
                            <option value="25">25 Baris</option>
                            <option value="50">50 Baris</option>
                        </select>
                    </div>
                    <div class="col-md-4 ms-auto">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-0 ps-0" id="search" 
                                   placeholder="Cari nama, email, atau telepon..." onkeyup="getDataPelanggan()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="5%">No.</th>
                            <th>Profil Pelanggan</th>
                            <th>Kontak & WA</th>
                            <th>Gender</th>
                            <th>Alamat Lengkap</th>
                            <th class="pe-4 text-end" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataUser">
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                                <span class="text-muted">Memuat data...</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 border-top">
                <div class="text-muted small">
                    Total: <strong id="countPelanggan" class="text-primary">0</strong> pelanggan
                </div>
                <nav><ul class="pagination mb-0" id="pagination"></ul></nav>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formTambahPelanggan" class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pelanggan" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nomor WA</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="08xxxxxxxx" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email@gmail.com" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Rumah</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Alamat lengkap..."></textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Data Pelanggan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Data Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditPelanggan" class="row g-3">
                    <input type="hidden" id="id_pelanggan" name="id_pelanggan">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_edit" name="nama" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin_edit" name="jenis_kelamin" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nomor WA</label>
                        <input type="text" class="form-control" id="telepon_edit" name="telepon" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Email</label>
                        <input type="email" class="form-control" id="email_edit" name="email" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Rumah</label>
                        <textarea class="form-control" id="alamat_edit" name="alamat" rows="2"></textarea>
                    </div>
                    <div class="col-12 mt-4 text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>