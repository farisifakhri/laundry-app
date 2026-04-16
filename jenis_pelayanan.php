<?php
include 'header.php';


$user = $_SESSION['user'] ?? null;
?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Halaman Jenis Layanan</h5>
    </div>

    <div class="col-md-3">
        <button type="button" 
            class="btn btn-primary btn-sm d-flex align-items-center gap-1"
            data-bs-toggle="modal" 
            data-bs-target="#modalTambahJenisPelayanan">
        <i class="bi bi-plus"></i> Tambah Layanan
    </button>
    </div>

    <input type="hidden" id="nama_user" value="<?= $user['nama'] ?>">
    <input type="hidden" id="id_user" value="<?= $user['id'] ?>">

    <div class="card-body">

        <!-- FILTER -->
        <div class="row mb-3 g-2 align-items-end">
            <div class="col-md-2">
                <label for="limit" class="form-label">Limit</label>
                <select class="form-select" id="limit" onchange="getDataJenisPelayanan()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-md-4 ms-auto">
                <label for="search" class="form-label">Cari Layanan</label>
                <input type="text" 
                       class="form-control" 
                       id="search"
                       placeholder="Cari nama layanan..." 
                       onkeyup="getDataJenisPelayanan()">
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered table-custom" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No.</th>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody id="dataJenisPelayanan">
                    <tr>
                        <td colspan="5" class="text-center py-4">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOT -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <span class="small text-muted">Total Data: </span>
                <strong id="countJenisPelayanan"></strong>
            </div>

            <ul class="pagination mb-0" id="pagination"></ul>
        </div>

    </div>
</div>

<!-- Modal tambah data layanan -->
<div class="modal fade" id="modalTambahJenisPelayanan" tabindex="-1" aria-labelledby="modalTambahPelayananLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahJenisPelayananLabel">Tambah Data Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahJenisPelayanan" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option selected>Pilih Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit data layanan -->
<div class="modal fade" id="modalEditJenisPelayanan" tabindex="-1" aria-labelledby="modalEditPelayananLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLayananLabel">Edit Data Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditJenisPelayanan" method="POST">
                    <input type="hidden" id="id_jenis_layanan" name="id_layanan">
                    <div class="mb-3">
                        <label for="nama_edit" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama_edit" name="nama_edit">
                    </div>
                    <div class="mb-3">
                        <label for="harga_edit" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga_edit" name="harga">
                    </div>
                    <div class="mb-3">
                        <label for="status_edit" class="form-label">Status</label>
                        <select class="form-select" id="status_edit" name="status">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>