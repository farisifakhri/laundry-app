let currentPage = 1;
let limitPerPage = 10;
let totalPages = 0;
let totalData = 0;
let layanan = [];
let dataLayanan = [];

$(document).ready(function () {
    // Inisialisasi awal
    $('#limit').val(limitPerPage);
    getDataTransaksi();
    getPelanggan();
    getJenisPelayanan();

    // Listener pelanggan (bisa diisi logika tambahan)
    $('#id_pelanggan').on('change', function () {
        //menampilkan di depan
        console.log('Pelanggan dipilih:', this.value);
    });

    // ➕ Tambah baris layanan
    $('#btnTambahDetail').on('click', function () {
        const newRow = $('#detailBody tr:first').clone();
        newRow.find('input, select').val('');
        $('#detailBody').append(newRow);
        isiSemuaSelectLayanan();
    });

    // ❌ Hapus baris layanan
    $(document).on('click', '.btnHapus', function () {
        if ($('#detailBody tr').length > 1) {
            $(this).closest('tr').remove();
            hitungTotal();
        }
    });

    // 🔄 Saat jenis layanan berubah
    $(document).on('change', '.jenis_layanan', function () {
        const id_layanan = $(this).val();
        const row = $(this).closest('tr');
        const data = layanan.find(l => l.id == id_layanan);

        // Jika layanan ditemukan, isi harga otomatis
        if (data) {
            row.find('.harga').val(data.harga);
        } else {
            row.find('.harga').val(0);
        }

        hitungSubtotal(row);
    });

    // 🔢 Saat harga atau qty berubah
    $(document).on('input', '.harga, .qty', function () {
        const row = $(this).closest('tr');
        hitungSubtotal(row);
    });

    $('#formTambahPemesanan').submit(function (e) {
        e.preventDefault();
        
        const tanggal = new Date().toISOString().slice(0, 10);
        const id_pelanggan = $('#id_pelanggan').val();
        const id_transaksi = `${tanggal}-${id_pelanggan}-${Math.floor(Math.random() * 10000)}`;
        const metode_pembayaran = $('#metode_pembayaran').val();
        const note_pembayaran = $('#note_pembayaran').val();
        const total = $('#total').val();
        const created_by = $('#id_user').val();
        const created_by_name = $('#nama_user').val();
        const data = { action: 'add', id_transaksi, id_pelanggan, metode_pembayaran, note_pembayaran, total, created_by, created_by_name };

        const detail_layanan = [];
        $('#detailBody tr').each(function () {
            const jenis_layanan = $(this).find('.jenis_layanan').val();
            const harga = $(this).find('.harga').val();
            const qty = $(this).find('.qty').val();
            const subtotal = $(this).find('.subtotal').val();
            detail_layanan.push({ jenis_layanan, harga, qty, subtotal });
        });
        data.detail_layanan = detail_layanan;
        console.log(data);
        submit(data).then(() => {
            getDataTransaksi();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data pemesanan berhasil ditambahkan.',
                showConfirmButton: false,
                timer: 2000
            });
            $('#modalTambahPemesanan').modal('hide');
        })
    });
});

// Hitung subtotal dan total
function hitungSubtotal(row) {
    const harga = parseFloat(row.find('.harga').val()) || 0;
    const qty = parseFloat(row.find('.qty').val()) || 0;
    const subtotal = harga * qty;
    row.find('.subtotal').val(subtotal);
    hitungTotal();
}

// Hitung total keseluruhan
function hitungTotal() {
    let total = 0;
    $('.subtotal').each(function () {
        total += parseFloat($(this).val()) || 0;
    });
    $('#total').val(total);
}

async function getDataTransaksi() {
    $.ajax({
        url: "process/pemesanan/process.php",
        method: "GET",
        data: {
            action: 'get',
            limit: $('#limit').val() || limitPerPage,
            search: $('#search').val() || '',
            page: currentPage
        },
        dataType: "json",
        success: async function (data) {
            console.log(data);
            limit = parseInt($('#limit').val());
            dataTotal = await getDataCountTransaksi();
            totalPages = Math.ceil(dataTotal / limit);

            const tbody = $('#dataPemesanan');
            tbody.empty();

            if (!data || data.length === 0) {
                tbody.append('<tr><td colspan="11" class="text-center">Belum ada data.</td></tr>');
                return;
            }

            // Helper untuk cek tanggal valid
            const isValidDate = (dateStr) => {
                return dateStr && dateStr !== '0000-00-00 00:00:00' && dateStr !== '0000-00-00';
            };

            const formatTanggal = (tanggal) =>
                isValidDate(tanggal)
                    ? new Date(tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })
                    : '-';

            data.forEach((transaksi, i) => {
                const tanggalOrder = formatTanggal(transaksi.created_at);

                let layananHTML = '';

                transaksi.detail_layanan.forEach((layanan) => {

                    let statusBadge = '';
                    let actionButton = '';

                    if (layanan.status_order === 'proses') {
                        statusBadge = `<span class="badge bg-warning text-dark">Proses</span>`;
                        actionButton = `
                            <button class="btn btn-sm btn-success mt-2"
                                    onclick="updateStatus('selesai', ${layanan.id})">
                                Tandai Selesai
                            </button>`;
                    } else {
                        statusBadge = `<span class="badge bg-success">Selesai</span>`;
                    }

                    layananHTML += `
                        <div class="border rounded p-2 mb-2 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>${layanan.layanan}</strong>
                                ${statusBadge}
                            </div>

                            <div class="small mt-1">
                                Harga: Rp${layanan.harga.toLocaleString('id-ID')} |
                                Qty: ${layanan.qty} |
                                Total: Rp${layanan.subtotal.toLocaleString('id-ID')}
                            </div>

                            <div class="small text-muted">
                                Order: ${new Date(layanan.created_at).toLocaleDateString('id-ID')}
                            </div>

                            ${actionButton}
                        </div>
                    `;
                });


                tbody.append(`
                    <tr>
                        <td>${(currentPage - 1) * limit + (i + 1)}</td>
                        <td>
                            <small>No. Pesanan: ${transaksi.id_transaksi}</small><br>
                            <strong>
                            ${transaksi.nama_pelanggan}</strong><br>
                            ${transaksi.alamat_pelanggan}<br>
                            <small>${transaksi.telp_pelanggan} | ${transaksi.email_pelanggan}</small>
                        </td>
                        <td>${transaksi.metode_pembayaran}</td>
                        <td>${tanggalOrder}</td>
                        <td>${layananHTML}</td>
                        <td>Rp${transaksi.total.toLocaleString('id-ID')}</td>
                        <td>
                            <button class="btn btn-info btn-sm" 
                                    onclick='cetakStruk(${JSON.stringify(transaksi)})'>
                                <i class="bi bi-printer"></i> Cetak Struk
                            </button>
                        </td>
                    </tr>
                `);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
            $('#dataPemesanan').html('<tr><td colspan="11" class="text-center">Gagal memuat data.</td></tr>');
        }
    });
}

function updateStatus(status, id) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Yakin ingin menyelesaikan layanan ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Selesaikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "process/pemesanan/process.php",
                method: "POST",
                data: {
                    action: 'updateStatus',
                    status: status,
                    id: id,
                    updated_by: $('#id_user').val(),
                    updated_by_name: $('#nama_user').val()
                },
                dataType: "json",
                success: function () {
                    getDataTransaksi();
                    Swal.fire('Berhasil!', 'Status berhasil diperbarui.', 'success');
                }
            });
        }
    });
}


async function getDataCountTransaksi() {
    $.ajax({
        url: "process/pemesanan/process.php",
        method: "GET",
        data: {
            action: 'getcount'
        },
        dataType: "json",
        success: function (data) {
            totalData = parseInt(data) || 0;
            $('#countPemesanan').text(totalData);
            limit = parseInt($('#limit').val()) || limitPerPage;
            totalPages = Math.ceil(totalData / limit);
            renderPagination(totalPages, currentPage);
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
        }
    })
    return totalData;
}

async function getPelanggan(){
    $.ajax({
        url: "process/pelanggan/process.php",
        method: "GET",
        data: {
            action: 'get',
            limit: 100000,
            search: '',
            page: 1
        },
        dataType: "json",
        success: function (data) {
            const selectPelanggan = $('#id_pelanggan');
            selectPelanggan.empty();
            selectPelanggan.append('<option selected>Pilih Pelanggan</option>');
            data.forEach(pelanggan => {
                selectPelanggan.append(`<option value="${pelanggan.id}">${pelanggan.id} - ${pelanggan.nama}</option>`);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
        }
    })
}

// 🔹 Ambil data layanan dari server (sekali saja)
async function getJenisPelayanan() {
    $.ajax({
        url: "process/jenis_pelayanan/process.php",
        method: "GET",
        data: {
            action: 'get',
            limit: 100000,
            search: '',
            page: 1
        },
        dataType: "json",
        success: function (data) {
            layanan = data;
            isiSemuaSelectLayanan(); // panggil fungsi untuk isi dropdown
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
        }
    });
}

// 🔹 Isi semua <select class="jenis_layanan"> di tabel
function isiSemuaSelectLayanan() {
    $('.jenis_layanan').each(function () {
        const select = $(this);
        const selected = select.val(); // simpan pilihan sebelumnya (kalau ada)
        select.empty().append('<option value="">Pilih Layanan</option>');
        layanan.forEach(jenisLayanan => {
            select.append(`<option value="${jenisLayanan.id}">${jenisLayanan.nama}</option>`);
        });
        if (selected) select.val(selected); // restore pilihan lama
    });
}

function updateTanggal(status, id) {
    console.log(status, id)
    Swal.fire({
        title: 'Konfirmasi',
        text: `Apakah Anda yakin ingin mengubah status pemesanan dengan ID ${id} menjadi ${status}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, ubah status'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "process/pemesanan/process.php",
                method: "POST",
                data: {
                    action: 'updateTanggal',
                    status: status,
                    updated_by: 1,
                    updated_by_name: 'Admin',
                    id: id
                },
                dataType: "json",
                success: function (data) {
                    getDataTransaksi();
                },
                error: function (xhr, status, error) {
                    console.error('Error AJAX:', error);
                }
            });
        }
    });
}

function submit(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "process/pemesanan/process.php",
            method: "POST",
            data: data,
            dataType: "json",
            success: resolve,
            error: reject
        });
    })
}

function cetakStruk(data) {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "struk.php";

  for (const key in data) {
    if (data.hasOwnProperty(key)) {
      const input = document.createElement("input");
      input.type = "hidden";
      input.name = key;
      input.value = typeof data[key] === "object" ? JSON.stringify(data[key]) : data[key];
      form.appendChild(input);
    }
  }

  document.body.appendChild(form);
  form.submit();
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
    getDataTransaksi();
}