<?php include 'header.php'; ?>

<div class="container-fluid">

    <!-- Page Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted mb-0" style="font-size:13.5px">Kelola data pelanggan Anda</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
            <i class="bi bi-plus-lg"></i> Tambah Pelanggan
        </button>
    </div>

    <input type="hidden" id="nama_user" value="<?= $user['nama'] ?>">
    <input type="hidden" id="id_user" value="<?= $user['id'] ?>">

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-people text-primary"></i>
                <span class="card-title">Daftar Pelanggan</span>
            </div>
        </div>
        <div class="card-body">

            <!-- Filter -->
            <div class="row mb-4 g-3 align-items-end">
                <div class="col-auto">
                    <label class="form-label">Tampilkan</label>
                    <select class="form-select" id="limit" onchange="getDataPelanggan()" style="width:90px">
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
                            placeholder="Cari nama / telepon..."
                            onkeyup="getDataPelanggan()"
                            style="border-left:none!important">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle table-custom" id="dataTable">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataUser">
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-hourglass-split me-2"></i>Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <span class="small text-muted">Total: </span>
                    <strong id="countPelanggan" class="small"></strong>
                    <span class="small text-muted"> pelanggan</span>
                </div>
                <ul class="pagination mb-0" id="pagination"></ul>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2 text-primary"></i>Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPelanggan" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Contoh: 08xxxxxxxxxx">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan Pelanggan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil me-2 text-primary"></i>Edit Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPelanggan" method="POST">
                    <input type="hidden" id="id_pelanggan" name="id_pelanggan">
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama_edit" name="nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin_edit" name="jenis_kelamin">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat_edit" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon_edit" name="telepon">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_edit" name="email">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
