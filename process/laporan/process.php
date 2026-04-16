<?php
require_once '../config.php';
header('Content-Type: application/json');

function getDataLaporan($conn, $date_start, $date_end) {
    $sql = "
        SELECT 
            t.id_transaksi AS id_transaksi,
            t.id_pelanggan,
            CONCAT(t.id_pelanggan, ' - ', p.nama) AS nama_pelanggan,
            p.telepon AS telp_pelanggan,
            p.email AS email_pelanggan,
            p.alamat AS alamat_pelanggan,
            t.metode_pembayaran,
            t.catatan_tambahan,
            t.total,
            t.created_at,
            CONCAT('[', 
                GROUP_CONCAT(
                    CONCAT(
                        '{',
                        '\"id\":', IFNULL(dt.id, 0), ',',
                        '\"id_transaksi\":\"', IFNULL(dt.id_transaksi, ''), '\",',
                        '\"id_jenis_layanan\":', IFNULL(dt.id_jenis_layanan, 0), ',',
                        '\"layanan\":\"', IFNULL(jl.nama, ''), '\",',
                        '\"harga\":', IFNULL(jl.harga, 0), ',',
                        '\"qty\":', IFNULL(dt.qty, 0), ',',
                        '\"subtotal\":', IFNULL(dt.subtotal, 0), ',',
                        '\"status_order\":\"', IFNULL(dt.status_order, ''), '\",',
                        '\"tanggal_cuci\":\"', IFNULL(DATE_FORMAT(dt.tanggal_cuci, '%Y-%m-%d %H:%i:%s'), ''), '\",',
                        '\"tanggal_gosok\":\"', IFNULL(DATE_FORMAT(dt.tanggal_gosok, '%Y-%m-%d %H:%i:%s'), ''), '\",',
                        '\"tanggal_selesai\":\"', IFNULL(DATE_FORMAT(dt.tanggal_selesai, '%Y-%m-%d %H:%i:%s'), ''), '\",',
                        '\"tanggal_pengambilan\":\"', IFNULL(DATE_FORMAT(dt.tanggal_pengambilan, '%Y-%m-%d %H:%i:%s'), ''), '\",',
                        '\"updated_by_cuci\":', IFNULL(dt.updated_by_cuci, 0), ',',
                        '\"updated_by_name_cuci\":\"', IFNULL(dt.updated_by_name_cuci, ''), '\",',
                        '\"updated_by_gosok\":', IFNULL(dt.updated_by_gosok, 0), ',',
                        '\"updated_by_name_gosok\":\"', IFNULL(dt.updated_by_name_gosok, ''), '\",',
                        '\"updated_by_selesai\":', IFNULL(dt.updated_by_selesai, 0), ',',
                        '\"updated_by_name_selesai\":\"', IFNULL(dt.updated_by_name_selesai, ''), '\",',
                        '\"updated_by_pengembalian\":', IFNULL(dt.updated_by_pengembalian, 0), ',',
                        '\"updated_by_name_pengembalian\":\"', IFNULL(dt.updated_by_name_pengembalian, ''), '\"',
                        '}'
                    ) SEPARATOR ','
                ), 
            ']') AS detail_layanan
        FROM transaksi t
        JOIN pelanggan p ON t.id_pelanggan = p.id
        LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
        LEFT JOIN jenis_layanan jl ON dt.id_jenis_layanan = jl.id
        WHERE t.created_at BETWEEN ? AND ?
        GROUP BY t.id_transaksi
        ORDER BY t.id_transaksi DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $date_start, $date_end);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // 🟩 Tambahkan perbaikan di sini
    foreach ($result as &$row) {
        $row['detail_layanan'] = json_decode($row['detail_layanan'], true) ?? [];
    }

    return $result;
}


$action = $_REQUEST['action'] ?? 'get';

switch ($action) {
    case 'get':
        $date_start = ($_REQUEST['date_start'] ?? date('Y-m-d')) . ' 00:00:00';
        $date_end   = ($_REQUEST['date_end'] ?? date('Y-m-d')) . ' 23:59:59';
        echo json_encode(getDataLaporan($conn, $date_start, $date_end));
        break;
}
