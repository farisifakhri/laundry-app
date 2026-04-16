let currentPage = 1;
let limitPerPage = 10;
let totalPages = 0;
let totalData = 0;

$(document).ready(function () {
    $('#limit').val(limitPerPage);
    getDataPelanggan();

    $('#formTambahPelanggan').submit(function (e) {
        e.preventDefault();

        const nama = $('#nama').val();
        const jenis_kelamin = $('#jenis_kelamin').val();
        const alamat = $('#alamat').val();
        const telepon = $('#telepon').val();
        const email = $('#email').val();
        const created_by = $('#id_user').val();
        const created_by_name = $('#nama_user').val();

        if (nama && jenis_kelamin && alamat && telepon && email) {
            const data = { action: 'add', nama, jenis_kelamin, alamat, telepon, email, created_by, created_by_name };

            submit(data)
                .then(res => {
                    if (res.success) { // ✅ sudah object, gak perlu JSON.parse
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data pelanggan berhasil ditambahkan.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#formTambahPelanggan')[0].reset();
                        getDataPelanggan();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.error || 'Terjadi kesalahan saat menambahkan data pelanggan.',
                        });
                    }
                })
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Kolom kosong!',
                text: 'Mohon isi semua kolom sebelum menyimpan.',
            });
        }
    });

    $('#formEditPelanggan').submit(function (e) {
        e.preventDefault();

        const id = $('#id_pelanggan').val();
        const nama = $('#nama_edit').val();
        const jenis_kelamin = $('#jenis_kelamin_edit').val();
        const alamat = $('#alamat_edit').val();
        const telepon = $('#telepon_edit').val();
        const email = $('#email_edit').val();
        const updated_by = $('#id_user').val();
        const updated_by_name = $('#nama_user').val();

        if (id && nama && jenis_kelamin && alamat && telepon && email) {
            const data = { action: 'edit', id, nama, jenis_kelamin, alamat, telepon, email, updated_by, updated_by_name };

            sumbitEdit(data)
                .then(res => {
                    if (res.success) { // ✅ sudah object, gak perlu JSON.parse
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data pelanggan berhasil diubah.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#formEditPelanggan')[0].reset();
                        getDataPelanggan();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.error || 'Terjadi kesalahan saat mengubah data pelanggan.',
                        });
                    }
                })
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Kolom kosong!',
                text: 'Mohon isi semua kolom sebelum menyimpan.',
            });
        }
    });
});

function submit(data){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "process/pelanggan/process.php",
            method: "POST",
            data: data,
            dataType: "json", // ✅ tambahkan ini
            success: resolve,
            error: reject
        });
    });
}

// 🔹 Ambil data pelanggan per halaman
async function getDataPelanggan() {
    $.ajax({
        url: "process/pelanggan/process.php",
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
            dataTotal = getDataCountPelanggan();
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
                        <td>${user.id} - ${user.nama}</td>
                        <td>${user.telepon}</td>
                        <td>${user.email}</td>
                        <td>${user.jenis_kelamin}</td>
                        <td>${user.alamat}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick='modalEdit(${JSON.stringify(user)})'><i class="bi bi-pencil-square"></i></button>
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

// 🔹 Ambil total data pelanggan & hitung total halaman
function getDataCountPelanggan() {
    $.ajax({
        url: "process/pelanggan/process.php",
        method: "GET",
        data: { action: 'getcount' },
        dataType: "json",
        success: function (data) {
            totalData = parseInt(data) || 0;
            console.log(totalData)
            limit = parseInt($('#limit').val()) || limitPerPage;
            $('#countPelanggan').text(totalData);
            totalPages = Math.ceil(totalData / limit);
            console.log(totalPages, totalData, limit)
            renderPagination(totalPages, currentPage);
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
            $('#countPelanggan').text('0');
        }
    });
}

function modalEdit(data) {
    $('#id_pelanggan').val(data.id);
    $('#nama_edit').val(data.nama);
    $('#jenis_kelamin_edit').val(data.jenis_kelamin);
    $('#alamat_edit').val(data.alamat);
    $('#telepon_edit').val(data.telepon);
    $('#email_edit').val(data.email);
    $('#modalEditPelanggan').modal('show');
}

// 🔹 Render pagination dinamis
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

// 🔹 Fungsi pindah halaman
function goToPage(page) {
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderPagination(totalPages, currentPage);
    getDataPelanggan();
}

function sumbitEdit(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "process/pelanggan/process.php",
            method: "POST",
            data: data,
            dataType: "json", // ✅ tambahkan ini
            success: resolve,
            error: reject
        });
    })
}

function deletePelanggan(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data pelanggan akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            const data = { action: 'delete', id };
            $.ajax({
                url: "process/pelanggan/process.php",
                method: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Terhapus!',
                            'Data pelanggan berhasil dihapus.',
                            'success'
                        );
                        getDataPelanggan();
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Data pelanggan gagal dihapus.',
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