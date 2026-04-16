$(document).ready(function () {
    getDataCountPelanggan();
    getDataCountTransaksi();
})

function getDataCountPelanggan() {
    $.ajax({
        url: "process/pelanggan/process.php",
        method: "GET",
        data: { action: 'getcount' },
        dataType: "json",
        success: function (data) {
            totalPelanggan = parseInt(data) || 0;
            $('#countPelanggan').text(totalPelanggan);
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
            $('#countPelanggan').text('0');
        }
    });
}

function onStartDateChange() {
    console.log('Start date changed');
    const startDate = document.getElementById('startDate').value;
    const wrapper = document.getElementById('endDateWrapper');
    const endDate = document.getElementById('endDate');

    if (startDate) {
        wrapper.classList.remove('d-none');
        endDate.min = startDate;
    } else {
        wrapper.classList.add('d-none');
        endDate.value = '';
    }
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
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
        }
    })
    return totalData;
}

let chartTransaksi = null;
let chartPelanggan = null;

async function getDataGrafik() {
    const startDate = $('#startDate').val();
    const endDate   = $('#endDate').val();

    if (!startDate || !endDate) return;

    try {
        const result = await getDetailTransaksi(startDate, endDate);
        const result2 = await getPelangganPerHari(startDate, endDate);

        if (!result.success || !result2.success) return;

        // ================= PREPARE DATA =================
        const labels = result.data.map(item => item.tanggal);

        const dataTransaksi = result.data.map(item => item.total);
        const dataPelanggan = result2.data.map(item => item.total_pelanggan);

        // ================= GRAFIK TRANSAKSI =================
        const ctxTransaksi = document.getElementById('grafikTransaksi').getContext('2d');

        if (chartTransaksi) chartTransaksi.destroy();

        chartTransaksi = new Chart(ctxTransaksi, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Transaksi',
                    data: dataTransaksi,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        // ================= GRAFIK PELANGGAN =================
        const ctxPelanggan = document.getElementById('grafikPelanggan').getContext('2d');

        if (chartPelanggan) chartPelanggan.destroy();

        chartPelanggan = new Chart(ctxPelanggan, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Pelanggan',
                    data: dataPelanggan,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

    } catch (error) {
        console.error('Gagal ambil data grafik:', error);
    }
}

function getDetailTransaksi(startDate, endDate) {
    return $.ajax({
        url: 'process/pemesanan/process.php',
        method: 'GET',
        dataType: 'json',
        data: {
            action: 'getdetail',
            startDate,
            endDate
        }
    });
}

function getPelangganPerHari(startDate, endDate) {
    return $.ajax({
        url: 'process/pemesanan/process.php',
        method: 'GET',
        dataType: 'json',
        data: {
            action: 'getPelangganPerHari',
            startDate,
            endDate
        }
    });
    
}