let chartTransaksi = null;
let chartPelanggan = null;

$(document).ready(function () {
    initDashboard();
});

async function initDashboard() {
    // Ambil angka counter secara paralel
    Promise.all([
        $.get("process/pelanggan/process.php?action=getcount"),
        $.get("process/pemesanan/process.php?action=getcount")
    ]).then(([countP, countT]) => {
        $('#countPelanggan').text(parseInt(countP) || 0);
        $('#countPemesanan').text(parseInt(countT) || 0);
    });

    // Set default ke bulan berjalan
    const now = new Date();
    const currentMonth = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0');
    $('#startDate').val(currentMonth);
    $('#endDate').val(currentMonth);
    $('#endDateWrapper').removeClass('d-none');
    
    getDataGrafik(); // Langsung muat grafik
}

function onStartDateChange() {
    const startDate = $('#startDate').val();
    if (startDate) {
        $('#endDateWrapper').removeClass('d-none');
        $('#endDate').attr('min', startDate);
        if ($('#endDate').val()) getDataGrafik();
    }
}

async function getDataGrafik() {
    const startDate = $('#startDate').val();
    const endDate   = $('#endDate').val();
    if (!startDate || !endDate) return;

    try {
        const [resT, resP] = await Promise.all([
            $.getJSON('process/pemesanan/process.php', { action: 'getdetail', startDate, endDate }),
            $.getJSON('process/pemesanan/process.php', { action: 'getPelangganPerHari', startDate, endDate })
        ]);

        if (resT.success && resP.success) renderCharts(resT.data, resP.data);
    } catch (err) { console.error('Gagal muat grafik:', err); }
}

function renderCharts(dataT, dataP) {
    const labels = dataT.map(i => i.tanggal);
    const ctxT = document.getElementById('grafikTransaksi').getContext('2d');
    if (chartTransaksi) chartTransaksi.destroy();
    chartTransaksi = new Chart(ctxT, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Transaksi',
                data: dataT.map(i => i.total),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true, tension: 0.4
            }]
        }
    });

    const ctxP = document.getElementById('grafikPelanggan').getContext('2d');
    if (chartPelanggan) chartPelanggan.destroy();
    chartPelanggan = new Chart(ctxP, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pelanggan',
                data: dataP.map(i => i.total_pelanggan),
                backgroundColor: '#10b981', borderRadius: 6
            }]
        }
    });
}