let chartInstances = {};

// =======================
// HELPER FETCH (AJAX)
// =======================
async function fetchData(url, params = {}) {
    try {
        const res = await $.ajax({
            url: url,
            method: 'GET',
            data: params,
            dataType: 'json'
        });
        return res;
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
}

// =======================
// INIT
// =======================
async function initDashboard() {
    await Promise.all([
        getDataCountPelanggan(),
        getDataCountTransaksi()
    ]);

    // --- TAMBAHAN BARU: Setel bulan default ke bulan ini ---
    const now = new Date();
    // Format YYYY-MM (misal: 2026-04)
    const currentMonth = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0');

    $('#startDate').val(currentMonth);
    $('#endDate').val(currentMonth);
    
    // Tampilkan kolom "Sampai Bulan"
    $('#endDateWrapper').removeClass('d-none');
    
    // Langsung panggil grafik saat halaman pertama kali dibuka
    getDataGrafik();
}

// =======================
// DATE HANDLER
// =======================
function onStartDateChange() {
    const startDate = document.getElementById('startDate').value;
    const wrapper = document.getElementById('endDateWrapper');
    const endDate = document.getElementById('endDate');

    if (startDate) {
        wrapper.classList.remove('d-none');
        endDate.min = startDate;
        
        // --- TAMBAHAN BARU: Kalau endDate sudah ada isinya, langsung update grafik ---
        if (endDate.value) {
            getDataGrafik();
        }
    } else {
        wrapper.classList.add('d-none');
        endDate.value = '';
    }
}

// =======================
// COUNT PELANGGAN
// =======================
async function getDataCountPelanggan() {
    try {
        const data = await fetchData("process/pelanggan/process.php", {
            action: 'getcount'
        });

        const total = parseInt(data) || 0;
        $('#countPelanggan').text(total);

    } catch (error) {
        $('#countPelanggan').text('0');
    }
}

// =======================
// COUNT TRANSAKSI
// =======================
async function getDataCountTransaksi() {
    try {
        const data = await fetchData("process/pemesanan/process.php", {
            action: 'getcount'
        });

        const total = parseInt(data) || 0;
        $('#countPemesanan').text(total);

    } catch (error) {
        $('#countPemesanan').text('0');
    }
}

// =======================
// DATE HANDLER
// =======================
function onStartDateChange() {
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

// =======================
// GET DATA GRAFIK
// =======================
async function getDataGrafik() {
    const startDate = $('#startDate').val();
    const endDate   = $('#endDate').val();

    if (!startDate || !endDate) return;

    try {
        const [transaksi, pelanggan] = await Promise.all([
            fetchData('process/pemesanan/process.php', {
                action: 'getdetail',
                startDate,
                endDate
            }),
            fetchData('process/pemesanan/process.php', {
                action: 'getPelangganPerHari',
                startDate,
                endDate
            })
        ]);

        if (!transaksi.success || !pelanggan.success) {
            console.warn('Data tidak valid');
            return;
        }

        renderChart(transaksi.data, pelanggan.data);

    } catch (error) {
        console.error('Gagal ambil data grafik:', error);
    }
}

// =======================
// RENDER CHART
// =======================
function renderChart(dataTransaksi, dataPelanggan) {
    const labels = dataTransaksi.map(i => i.tanggal);

    const transaksiData = dataTransaksi.map(i => i.total);
    const pelangganData = dataPelanggan.map(i => i.total_pelanggan);

    renderLineChart('grafikTransaksi', 'Total Transaksi', labels, transaksiData);
    renderBarChart('grafikPelanggan', 'Total Pelanggan', labels, pelangganData);
}

// =======================
// LINE CHART
// =======================
function renderLineChart(id, label, labels, data) {
    const ctx = document.getElementById(id).getContext('2d');

    if (chartInstances[id]) {
        chartInstances[id].destroy();
    }

    chartInstances[id] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
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
}

// =======================
// BAR CHART
// =======================
function renderBarChart(id, label, labels, data) {
    const ctx = document.getElementById(id).getContext('2d');

    if (chartInstances[id]) {
        chartInstances[id].destroy();
    }

    chartInstances[id] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
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
}