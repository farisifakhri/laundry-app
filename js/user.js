let currentPage = 1;
let limitPerPage = 10;
let totalPages = 0;
let totalData = 0;

$(document).ready(function () {
    $('#limit').val(limitPerPage);
    getDataUser();

    $('#formTambahUser').submit(function (e) {
        e.preventDefault();

        const nama = $('#nama').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const status = $('#status').val();
        const role = $('#role').val();
        const created_by = $('#id_user').val();
        const created_by_name = $('#nama_user').val();

        if (nama && email && password && status) {
            const data = { action: 'add', nama, email, password, role, status, created_by, created_by_name };

            submit(data)
                .then(res => {
                    if (res.success) { // ✅ sudah object, gak perlu JSON.parse
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data user berhasil ditambahkan.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#formTambahUser')[0].reset();
                        getDataUser();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.error || 'Terjadi kesalahan saat menambahkan data user.',
                        });
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menambahkan data user.',
                    });
                })
                .finally(() => {
                    $('#modalTambahUser').modal('hide');
                });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Semua field harus diisi.',
            });
        }
    });

    $('#formEditUser').submit(function (e) {
        e.preventDefault();

        const id = $('#id_user').val();
        const nama = $('#nama_edit').val();
        const email = $('#email_edit').val();
        const status = $('#status_edit').val();
        const role = $('#role_edit').val();
        const updated_by = $('#id_user').val();
        const updated_by_name = $('#nama_user').val();

        if (id && nama && email && password && status) {
            const data = { action: 'edit', id, nama, email, role, status, updated_by, updated_by_name };
            sumbitEdit(data)
                .then(res => {
                    if (res.success) { // ✅ sudah object, gak perlu JSON.parse
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data user berhasil diubah.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#formEditUser')[0].reset();
                        getDataUser();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.error || 'Terjadi kesalahan saat mengubah data user.',
                        });
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengubah data user.',
                    });
                })
                .finally(() => {
                    $('#modalEditUser').modal('hide');
                });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Semua field harus diisi.',
            });
        }
    });
})

async function getDataUser() {
    $.ajax({
        url: "process/user/process.php",
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
            dataTotal = getDataCountUser();
            totalPages = Math.ceil(dataTotal / limit);
            // renderPagination(totalPages, currentPage);
            const tbody = $('#dataUser');
            tbody.empty();

            if (!data || data.length === 0) {
                tbody.append('<tr><td colspan="7" class="text-center">Belum ada data.</td></tr>');
                return;
            }

            data.forEach((user, i) => {
                tbody.append(`
                    <tr>
                        <td>${(currentPage - 1) * limit + (i + 1)}</td>
                        <td>${user.nama}</td>
                        <td>${user.email}</td>
                        <td>${user.status == '1' ? 'Aktif' : 'Tidak Aktif'}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick='modalEdit(${JSON.stringify(user)})'><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
            $('#dataUser').html('<tr><td colspan="7" class="text-center">Gagal memuat data.</td></tr>');
        }
    });
}

function getDataCountUser() {
    $.ajax({
        url: "process/user/process.php",
        method: "GET",
        data: { action: 'getcount' },
        dataType: "json",
        success: function (data) {
            totalData = parseInt(data) || 0;
            limit = parseInt($('#limit').val()) || limitPerPage;
            $('#countUser').text(totalData);
            totalPages = Math.ceil(totalData / limit);
            renderPagination(totalPages, currentPage);
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
            $('#countUser').text('0');
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
    getDataUser();
}

function modalEdit(data) {
    $('#id_user').val(data.id);
    $('#nama_edit').val(data.nama);
    $('#email_edit').val(data.email);
    $('#status_edit').val(data.status);
    $('#role_edit').val(data.role);
    $('#modalEditUser').modal('show');
}   

function submit(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "process/user/process.php",
            method: "POST",
            data: data,
            dataType: "json",
            success: resolve,
            error: reject
        });
    })
}

function sumbitEdit(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "process/user/process.php",
            method: "POST",
            data: data,
            dataType: "json",
            success: resolve,
            error: reject
        });
    })
}

function deleteUser(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data user akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            const data = { action: 'delete', id };
            $.ajax({
                url: "process/user/process.php",
                method: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Terhapus!',
                            'Data user berhasil dihapus.',
                            'success'
                        );
                        getDataUser();
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Data user gagal dihapus.',
                            'error'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error AJAX:', error);
                }
            });
        }
    });
}