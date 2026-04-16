<?php
include 'header.php';
?>
<div class="    card shadow-sm border-0 rounded-4">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Halaman Pelanggan</h5>
    </div>    

    <div class="col-md-3">
        <button type="button" 
                class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                data-bs-toggle="modal" 
                data-bs-target="#modalTambahPelanggan">
            <i class="bi bi-plus"></i> Tambah Pelanggan
        </button>
    </div>

    <input type="hidden" id="nama_user" value="<?= $user['nama'] ?>">
    <input type="hidden" id="id_user" value="<?= $user['id'] ?>">

    <div class="card-body">

        <!-- FILTER -->
        <div class="row mb-3 g-2 align-items-end">
            <div class="col-md-2">
                <label for="limit" class="form-label">Limit</label>
                <select class="form-select" id="limit" onchange="getDataPelanggan()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-md-4 ms-auto">
                <label for="search" class="form-label">Cari Pelanggan</label>
                <input type="text" 
                       class="form-control" 
                       id="search"
                       placeholder="Cari nama / telepon..." 
                       onkeyup="getDataPelanggan()">
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered table-custom" id="dataTable">
                <thead class="table-light">
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
                        <td colspan="6" class="text-center py-4">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOT -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <span class="small text-muted">Total Data: </span>
                <strong id="countPelanggan"></strong>
            </div>

            <ul class="pagination mb-0" id="pagination"></ul>
        </div>

    </div>
</div>

<!-- Modal tambah data pelanggan -->
<div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-labelledby="modalTambahPelangganLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPelangganLabel">Tambah data Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPelanggan" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                            <option selected>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit data pelanggan -->
<div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPelangganLabel">Edit Data Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPelanggan" method="POST">
                    <input type="hidden" id="id_pelanggan" name="id_pelanggan">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama_edit" name="nama">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin_edit" name="jenis_kelamin">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat_edit" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon_edit" name="telepon">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_edit" name="email">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
