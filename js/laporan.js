let data = [];

function getDataLaporan() {
    $.ajax({
        url: "process/laporan/process.php",
        method: "GET",
        data: {
            action: 'get',
            date_start: $('#date_start').val(),
            date_end: $('#date_end').val()  
        },
        dataType: "json",
        success: function (response) {
            data = response;
            console.log(data)
            const tbody = $('#dataLaporan');
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

                // gabungkan semua detail layanan
                let layananHTML = '';
                transaksi.detail_layanan.forEach((layanan) => {
                    const tanggalCuci = formatTanggal(layanan.tanggal_cuci);
                    const tanggalGosok = formatTanggal(layanan.tanggal_gosok);
                    const tanggalSelesai = formatTanggal(layanan.tanggal_selesai);
                    const tanggalAmbil = formatTanggal(layanan.tanggal_pengambilan);

                    let buttonHTML = '';

                    if (layanan.id_jenis_layanan == 3) {
                        if (!isValidDate(layanan.tanggal_cuci))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('cuci', ${layanan.id})"></button>`;
                        else if (!isValidDate(layanan.tanggal_selesai))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('selesai', ${layanan.id})"></button>`;
                        else if (!isValidDate(layanan.tanggal_pengambilan))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('ambil', ${layanan.id})"></button>`;
                    } else if (layanan.id_jenis_layanan == 4) {
                        if (!isValidDate(layanan.tanggal_gosok))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('gosok', ${layanan.id})"></button>`;
                        else if (!isValidDate(layanan.tanggal_selesai))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('selesai', ${layanan.id})"></button>`;
                        else if (!isValidDate(layanan.tanggal_pengambilan))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('ambil', ${layanan.id})"></button>`;
                    } else if (layanan.id_jenis_layanan == 2) {
                        if (!isValidDate(layanan.tanggal_cuci))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('cuci', ${layanan.id})"></button>`;
                        else if (!isValidDate(layanan.tanggal_gosok))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('gosok', ${layanan.id})"></button>`;
                        else if (!isValidDate(layanan.tanggal_selesai))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('selesai', ${layanan.id})"></button>`;
                        else if (!isValidDate(layanan.tanggal_pengambilan))
                            buttonHTML = `<button class="btn btn-sm btn-success" onclick="updateTanggal('ambil', ${layanan.id})"></button>`;
                    }

                    if (buttonHTML === '') buttonHTML = `<span class="badge bg-success"></span>`;

                    layananHTML += `
                        <div class="border rounded p-2 mb-2 bg-light">
                            <div><strong>${layanan.layanan}</strong> (${layanan.status_order})</div>
                            <div>Harga: Rp${layanan.harga.toLocaleString('id-ID')} | Qty: ${layanan.qty} | Total: Rp${layanan.subtotal.toLocaleString('id-ID')}</div>
                            <div class="small text-muted">
                                
                            </div>
                            <div class="small">
                                
                            </div>
                            
                        </div>`;
                });

                tbody.append(`
                    <tr>
                        <td>
                            <small>No. Pesanan: ${transaksi.id_transaksi}</small><br>
                            <strong>${transaksi.nama_pelanggan}</strong><br>
                            ${transaksi.alamat_pelanggan}<br>
                            <small>${transaksi.telp_pelanggan} | ${transaksi.email_pelanggan}</small>
                        </td>
                        <td>${transaksi.metode_pembayaran}</td>
                        <td>${tanggalOrder}</td>
                        <td>${layananHTML}</td>
                        <td>Rp${transaksi.total.toLocaleString('id-ID')}</td>
                    </tr>
                `);
            });
            
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', error);
        }
    });
}


async function printLaporan(tipe) {
    if (!data || data.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Belum ada data untuk dicetak!',
        });
        return;
    }

    const BRAND = "Pemesanan Laundry";
    const TAGLINE = "Cepat • Bersih • Terpercaya";
    const TANGGAL = new Date().toLocaleString("id-ID");

    // ====================== PDF ======================
    if (tipe === "pdf") {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: "p", unit: "pt", format: "a4" });

        const pageWidth = doc.internal.pageSize.getWidth();
        const marginX = 40;
        let y = 80;

        // ================= HEADER =================
        doc.setFont("helvetica", "bold");
        doc.setFontSize(14);
        doc.text("LAPORAN TRANSAKSI LAUNDRY", pageWidth / 2, 40, { align: "center" });

        doc.setFontSize(11);
        doc.text(BRAND, pageWidth / 2, 58, { align: "center" });

        doc.setFont("helvetica", "italic");
        doc.setFontSize(9);
        doc.text(TAGLINE, pageWidth / 2, 72, { align: "center" });

        doc.setFont("helvetica", "normal");
        doc.text(`Dicetak pada: ${TANGGAL}`, marginX, 72);

        // ================= IMPORT AUTOTABLE =================
        if (!doc.autoTable) {
            alert("Plugin jsPDF AutoTable belum dimuat!");
            return;
        }

        // ================= DATA TABEL =================
        const tableBody = [];
        let grandTotal = 0;
        let nomor = 1;

        data.forEach((t) => {
            tableBody.push([
                nomor++,
                t.id_transaksi,
                t.nama_pelanggan,
                t.metode_pembayaran,
                "",
                "",
                ""
            ]);

            t.detail_layanan.forEach((d) => {
                tableBody.push([
                    "",
                    "",
                    `   • ${d.layanan}`,
                    "",
                    d.qty.toString(),
                    `Rp${d.harga.toLocaleString("id-ID")}`,
                    `Rp${d.subtotal.toLocaleString("id-ID")}`
                ]);
            });

            tableBody.push(["", "", "", "", "", "Subtotal", `Rp${t.total.toLocaleString("id-ID")}`]);
            tableBody.push(["", "", "", "", "", "", ""]);
            grandTotal += t.total;
        });

        // ================= CETAK TABEL =================
        doc.autoTable({
            startY: y,

            head: [[
                "No",
                "ID",
                "Pelanggan / Layanan",
                "Metode",
                "Qty",
                "Harga",
                "Subtotal"
            ]],

            body: tableBody,
            theme: "grid",

            styles: {
                fontSize: 8,
                cellPadding: 2.5,
                valign: "middle",
                overflow: "linebreak"
            },

            headStyles: {
                fillColor: [41, 128, 185],
                textColor: 255,
                fontStyle: "bold",
                halign: "center",
                valign: "middle",
                minCellHeight: 14
            },

            columnStyles: {
                0: { cellWidth: 20, halign: "center" },   // No
                1: { cellWidth: 100, halign: "center" },   // ID
                2: { cellWidth: 200, halign: "left" },    // Pelanggan
                3: { cellWidth: 60, halign: "center" },   // Metode
                4: { cellWidth: 35, halign: "center" },   // Qty
                5: { cellWidth: 65, halign: "right" },    // Harga
                6: { cellWidth: 80, halign: "right" }     // Subtotal
            },

            margin: { left: 25, right: 25 },

            didParseCell: function (data) {
                // Baris detail (bullet)
                if (typeof data.cell.raw === "string" && data.cell.raw.includes("•")) {
                    data.cell.styles.fontStyle = "italic";
                    data.cell.styles.textColor = [70, 70, 70];
                }

                // Baris subtotal
                if (data.cell.raw === "Subtotal") {
                    data.cell.styles.fontStyle = "bold";
                    data.cell.styles.halign = "right";
                }
            }
        });



        // ================= TOTAL KESELURUHAN =================
        let finalY = doc.lastAutoTable.finalY + 15;
        doc.setFont("helvetica", "bold");
        doc.setFontSize(11);
        doc.text(`TOTAL KESELURUHAN :  Rp${grandTotal.toLocaleString("id-ID")}`, pageWidth - 260, finalY);

        // ================= FOOTER SETIAP HALAMAN =================
        const pageCount = doc.internal.getNumberOfPages();

        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);

            // Garis atas footer
            doc.setDrawColor(150);
            doc.line(40, 820, pageWidth - 40, 820);

            doc.setFontSize(9);
            doc.setFont("helvetica", "italic");

            doc.text(
                `${BRAND} • ${TAGLINE}`,
                pageWidth / 2,
                835,
                { align: "center" }
            );

            doc.text(
                `Halaman ${i} dari ${pageCount}`,
                pageWidth - 40,
                835,
                { align: "right" }
            );
        }

        doc.save("Laporan_Transaksi_Laundry.pdf");
    }

    // ====================== EXCEL ======================
    else if (tipe === "excel") {
        const wb = XLSX.utils.book_new();

        const ws_data = [
            ["LAPORAN TRANSAKSI LAUNDRY"],
            [BRAND],
            [`Dicetak pada : ${TANGGAL}`],
            [],
            ["No", "ID Transaksi", "Nama Pelanggan / Detail", "Metode", "Qty", "Harga", "Subtotal"]
        ];

        let totalAkhir = 0;
        let no = 1;

        data.forEach((t) => {
            ws_data.push([no++, t.id_transaksi, t.nama_pelanggan, t.metode_pembayaran, "", "", ""]);

            t.detail_layanan.forEach((d) => {
                ws_data.push(["", "", `   • ${d.layanan}`, "", d.qty, d.harga, d.subtotal]);
            });

            ws_data.push(["", "", "", "", "", "Subtotal", t.total]);
            ws_data.push([]);
            totalAkhir += t.total;
        });

        ws_data.push(["", "", "", "", "", "TOTAL", totalAkhir]);
        ws_data.push([]);
        ws_data.push([BRAND]);
        ws_data.push([TAGLINE]);
        ws_data.push([`Laporan digenerate otomatis oleh sistem`]);

        const ws = XLSX.utils.aoa_to_sheet(ws_data);

        // ================= MERGE =================
        ws["!merges"] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: 6 } },
            { s: { r: 1, c: 0 }, e: { r: 1, c: 6 } },
            { s: { r: 2, c: 0 }, e: { r: 2, c: 6 } }
        ];

        // ================= LEBAR KOLOM =================
        ws["!cols"] = [
            { wch: 5 },
            { wch: 20 },
            { wch: 35 },
            { wch: 15 },
            { wch: 8 },
            { wch: 12 },
            { wch: 15 }
        ];

        // ================= STYLE LOOP =================
        const range = XLSX.utils.decode_range(ws["!ref"]);

        for (let R = 0; R <= range.e.r; ++R) {
            for (let C = 0; C <= range.e.c; ++C) {
                const cell = XLSX.utils.encode_cell({ r: R, c: C });

                if (!ws[cell]) continue;

                ws[cell].s = {
                    border: {
                        top: { style: "thin", color: { rgb: "999999" } },
                        bottom: { style: "thin", color: { rgb: "999999" } },
                        left: { style: "thin", color: { rgb: "999999" } },
                        right: { style: "thin", color: { rgb: "999999" } },
                    },
                    font: { name: "Calibri", sz: 11 },
                    alignment: {
                        horizontal: C === 2 ? "left" : "center",
                        vertical: "center",
                        wrapText: true
                    }
                };
            }
        }

        // ============= STYLE JUDUL =============
        ws["A1"].s = {
            font: { bold: true, sz: 14, color: { rgb: "FFFFFF" } },
            fill: { patternType: "solid", fgColor: { rgb: "3498DB" } },
            alignment: { horizontal: "center", vertical: "center" }
        };

        ws["A2"].s = {
            font: { bold: true, sz: 12 },
            alignment: { horizontal: "center" }
        };

        ws["A3"].s = {
            font: { italic: true, sz: 10 },
            alignment: { horizontal: "center" }
        };

        XLSX.utils.book_append_sheet(wb, ws, "Laporan");
        XLSX.writeFile(wb, "Laporan_Transaksi_Laundry.xlsx");
    }
}

