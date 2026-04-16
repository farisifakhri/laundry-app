let currentPage = 1;
let limitPerPage = 10;
let totalPages = 0;
let totalData = 0;

$(document).ready(function () {
    $('#limit').val(limitPerPage);
    getDataJenisPelayanan();

    $('#formTambahJenisPelayanan').submit(function (e) {
        e.preventDefault();

        const nama = $('#nama').val();
        const harga = $('#harga').val();
        const status = $('#status').val();
        const created_by = $('#id_user').val();
        const created_by_name = $('#nama_user').val();

        if (nama && status) {
            const data = { action: 'add', nama, harga, status, created_by, created_by_name };

            submit(data)
                .then(res => {
                    if (res.success) { // ✅ sudah object, gak perlu JSON.parse
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data jenis pelayanan berhasil ditambahkan.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#formTambahJenisPelayanan')[0].reset();
                        getDataJenisPelayanan();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.error || 'Terjadi kesalahan saat menambahkan data jenis pelayanan.',
                        });
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menambahkan data jenis pelayanan.',
                    });
                })
                .finally(() => {
                    $('#modalTambahJenisPelayanan').modal('hide');
                })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Semua field harus diisi.',
            });
        };
    });
    $('#formEditJenisPelayanan').submit(function (e) {
        e.preventDefault();

        const id = $('#id_jenis_layanan').val();
        const nama = $('#nama_edit').val();
        const harga = $('#harga_edit').val();
        const status = $('#status_edit').val();
        const updated_by = $('#id_user').val();
        const updated_by_name = $('#nama_user').val();

        if (id && nama && status) {
            const data = { action: 'edit', id, nama, harga, status, updated_by, updated_by_name };

            submitEdit(data)
                .then(res => {
                    if (res.success) { // ✅ sudah object, gak perlu JSON.parse
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data jenis pelayanan berhasil diubah.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#formEditJenisPelayanan')[0].reset();
                        getDataJenisPelayanan();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.error || 'Terjadi kesalahan saat mengubah data jenis pelayanan.',
                        });
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengubah data jenis pelayanan.',
                    });
                })
                .finally(() => {
                    $('#modalEditJenisPelayanan').modal('hide');
                })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Semua field harus diisi.',
            });
        }
    })
});

function getDataJenisPelayanan() {
    $.ajax({
        url: "process/jenis_pelayanan/process.php",
        method: "GET",
        data: {
            action: 'get',
            limit: $('#limit').val(),
            search: $('#search').val(),
            page: currentPage
        },
        dataType: "json",
        success: function (data) {

            limit = parseInt($('#limit').val());

            // ✅ Panggil count dulu, lalu lanjutkan proses
            getDataCountJenisPelayanan(function(totalData){

                totalPages = Math.ceil(totalData / limit);
                // renderPagination(totalPages, currentPage);

                const tbody = $('#dataJenisPelayanan');
                tbody.empty();

                if (data.length > 0) {
                    data.forEach((item, i) => {
                        tbody.append(`
                            <tr>
                                <td>${(currentPage - 1) * limit + (i + 1)}</td>
                                <td>${item.nama}</td>
                                <td>${item.harga}</td>
                                <td>${item.status == '1' ? 'Aktif' : 'Tidak Aktif'}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick='modalEdit(${JSON.stringify(item)})'>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteJenisPelayanan(${item.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append('<tr><td colspan="7" class="text-center">Belum ada data.</td></tr>');
                }

            }); // <-- END Callback

        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
            $('#dataJenisPelayanan').html('<tr><td colspan="7" class="text-center">Gagal memuat data.</td></tr>');
        }
    });
}



function getDataCountJenisPelayanan(callback) {
    $.ajax({
        url: "process/jenis_pelayanan/process.php",
        method: "GET",
        data: { action: 'count' },
        dataType: "json",
        success: function (res) {
            let totalData = res.count;
            $('#countJenisPelayanan').text(totalData);

            if (callback) callback(totalData);
        },
        error: function () {
            if (callback) callback(0);
        }
    });
}


function renderPagination(total, current) {
    const pagination = $("#pagination");
    pagination.empty();

    // Tombol Previous
    const prevDisabled = current === 1 ? "disabled" : "";
    pagination.append(`
        <li class="page-item ${prevDisabled}">
            <a class="page-link" href="#" onclick="goToPage(${current - 1})">Previous</a>
        </li>
    `);

    // Tampilkan 5 halaman maksimal
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = Math.min(total, start + maxVisible - 1);
    if (end - start < maxVisible - 1) {
        start = Math.max(1, end - maxVisible + 1);
    }

    for (let i = start; i <= end; i++) {
        const active = i === current ? "active" : "";
        pagination.append(`
            <li class="page-item ${active}">
                <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
            </li>
        `);
    }

    // Tombol Next
    const nextDisabled = current === total ? "disabled" : "";
    pagination.append(`
        <li class="page-item ${nextDisabled}">
            <a class="page-link" href="#" onclick="goToPage(${current + 1})">Next</a>
        </li>
    `);
}

function goToPage(page) {
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderPagination(totalPages, currentPage);
    getDataJenisPelayanan();
}

function modalEdit(data) {
    $('#id_jenis_layanan').val(data.id);
    $('#nama_edit').val(data.nama);
    $('#harga_edit').val(data.harga);
    $('#status_edit').val(data.status);
    $('#modalEditJenisPelayanan').modal('show');
}

function submit(data){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "process/jenis_pelayanan/process.php",
            method: "POST",
            data: data,
            dataType: "json",
            success: resolve,
            error: reject
        });
    });
}

function submitEdit(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "process/jenis_pelayanan/process.php",
            method: "POST",
            data: data,
            dataType: "json",
            success: resolve,
            error: reject
        });
    });
}

function deleteJenisPelayanan(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data jenis pelayanan akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            const data = { action: 'delete', id };
            $.ajax({
                url: "process/jenis_pelayanan/process.php",
                method: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Terhapus!',
                            'Data jenis pelayanan berhasil dihapus.',
                            'success'
                        );
                        getDataJenisPelayanan();
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Data jenis pelayanan gagal dihapus.',
                            'error'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error AJAX:', error);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data jenis pelayanan.',
                        'error'
                    );
                }
            });
        }
    });
}