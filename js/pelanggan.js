let currentPage = 1;
let limit = 10;
let totalPages = 0;

$(document).ready(function () {
    getDataPelanggan();

    $('#formTambahPelanggan, #formEditPelanggan').submit(function (e) {
        e.preventDefault();
        const isEdit = $(this).attr('id') === 'formEditPelanggan';
        const formData = $(this).serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;
        }, {});
        
        formData.action = isEdit ? 'edit' : 'add';
        if (isEdit) formData.id = $('#id_pelanggan').val();
        formData.created_by = $('#id_user').val();
        formData.created_by_name = $('#nama_user').val();

        $.ajax({
            url: "process/pelanggan/process.php",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(res) {
                if(res.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil!', timer: 1500, showConfirmButton: false });
                    $('.modal').modal('hide');
                    $(e.target)[0].reset();
                    getDataPelanggan();
                }
            }
        });
    });
});

function getDataPelanggan() {
    limit = parseInt($('#limit').val());
    $.getJSON("process/pelanggan/process.php", {
        action: 'get', limit, search: $('#search').val(), page: currentPage
    }, function (data) {
        const tbody = $('#dataUser');
        tbody.empty();
        
        if (!data.length) return tbody.append('<tr><td colspan="6" class="text-center">Kosong</td></tr>');

        data.forEach((user, i) => {
            const phoneWA = user.telepon.replace(/[^0-9]/g, '');
            tbody.append(`
                <tr>
                    <td class="ps-4 text-muted small">${(currentPage - 1) * limit + (i + 1)}</td>
                    <td>
                        <div class="fw-bold text-primary">${user.nama}</div>
                        <div class="small text-muted">${user.email}</div>
                    </td>
                    <td>
                        <a href="https://wa.me/${phoneWA}" target="_blank" class="badge bg-success-light text-success text-decoration-none">
                            <i class="bi bi-whatsapp"></i> ${user.telepon}
                        </a>
                    </td>
                    <td><span class="badge ${user.jenis_kelamin === 'L' ? 'bg-primary' : 'bg-danger'} rounded-pill">${user.jenis_kelamin === 'L' ? 'L' : 'P'}</span></td>
                    <td><div class="small text-truncate" style="max-width:200px">${user.alamat}</div></td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-light" onclick='modalEdit(${JSON.stringify(user)})'><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-light text-danger" onclick="deletePelanggan(${user.id})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `);
        });
        updatePagination();
    });
}

function updatePagination() {
    $.getJSON("process/pelanggan/process.php", { action: 'getcount' }, function(total) {
        $('#countPelanggan').text(total);
        totalPages = Math.ceil(total / limit);
        renderPagination(totalPages, currentPage);
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

function deletePelanggan(id) {
    Swal.fire({
        title: 'Hapus?', text: "Data tidak bisa kembali!", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Ya, Hapus'
    }).then((res) => {
        if (res.isConfirmed) {
            $.post("process/pelanggan/process.php", { action: 'delete', id }, () => getDataPelanggan());
        }
    });
}