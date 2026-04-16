<?php
require_once '../config.php';
header('Content-Type: application/json');

function getDataTransaksi($conn, $params) {
    $limit = isset($params['limit']) ? (int)$params['limit'] : 10;
    $page = isset($params['page']) ? (int)$params['page'] : 1;
    $search = isset($params['search']) ? trim($params['search']) : '';
    $offset = ($page - 1) * $limit;

    $sql = "
        SELECT 
            t.id_transaksi AS id_transaksi,
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
        WHERE (p.nama LIKE ? OR p.email LIKE ? OR ? = '')
        GROUP BY t.id_transaksi
        ORDER BY t.id_transaksi DESC
        LIMIT ? OFFSET ?;
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $like = "%{$search}%";
    $stmt->bind_param("sssii", $like, $like, $search, $limit, $offset);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        // ubah string JSON jadi array PHP
        $row['detail_layanan'] = json_decode($row['detail_layanan'], true);
        $data[] = $row;
    }

    return $data;
}
function getDataCountTransaksi($conn) {
    $sql = "SELECT COUNT(*) AS count FROM transaksi";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function deleteTransaksi($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM transaksi WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function addTransaksi($conn, $data) {
    $id_transaksi = $data['id_transaksi'] ?? '';
    $id_pelanggan = intval($data['id_pelanggan'] ?? 0);
    $metode_pembayaran = $data['metode_pembayaran'] ?? '';
    $note_pembayaran = $data['note_pembayaran'] ?? '';
    $total = floatval($data['total'] ?? 0);
    $detail_layanan = $data['detail_layanan'] ?? [];
    $created_by = intval($data['created_by'] ?? 0);
    $created_by_name = $data['created_by_name'] ?? '';
    $created_at = date('Y-m-d H:i:s');
    

    try {
        $conn->begin_transaction();

        // --- insert ke tabel transaksi ---
        $stmt = $conn->prepare("
            INSERT INTO transaksi (id_transaksi, id_pelanggan, metode_pembayaran, catatan_tambahan, total, created_by, created_by_name, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        if (!$stmt) {
            throw new Exception("Prepare gagal (transaksi): " . $conn->error);
        }

        $stmt->bind_param("sissdiss", $id_transaksi, $id_pelanggan, $metode_pembayaran, $note_pembayaran, $total, $created_by, $created_by_name, $created_at);

        if (!$stmt->execute()) {
            throw new Exception("Gagal insert transaksi: " . $stmt->error);
        }

        // --- insert ke tabel detail_transaksi ---
        $stmt2 = $conn->prepare("
            INSERT INTO detail_transaksi (id_transaksi, id_jenis_layanan, qty, subtotal, status_order)
            VALUES (?, ?, ?, ?, ?)
        ");
        if (!$stmt2) {
            throw new Exception("Prepare gagal (detail_transaksi): " . $conn->error);
        }

        foreach ($detail_layanan as $layanan) {
            $id_jenis_layanan = intval($layanan['jenis_layanan'] ?? 0);
            $qty = intval($layanan['qty'] ?? 0);
            $subtotal = floatval($layanan['subtotal'] ?? 0);
            $status_order = 'proses';

            $stmt2->bind_param(
                "siids",
                $id_transaksi,
                $id_jenis_layanan,
                $qty,
                $subtotal,
                $status_order
            );

            if (!$stmt2->execute()) {
                throw new Exception("Gagal insert detail_transaksi: " . $stmt2->error);
            }
        }


        $conn->commit();
        return true;

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Transaksi gagal: " . $e->getMessage());
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
        return false;
    }
}

function updateStatus($conn, $data) {
    $id = intval($data['id'] ?? 0);
    $status = $data['status'] ?? '';
    $updated_by = intval($data['updated_by'] ?? 0);
    $updated_by_name = $data['updated_by_name'] ?? '';
    $tanggal = date('Y-m-d H:i:s');

    if ($status !== 'selesai') {
        throw new Exception("Status tidak valid");
    }

    $stmt = $conn->prepare("
        UPDATE detail_transaksi 
        SET 
            status_order = ?,
            tanggal_selesai = ?,
            updated_by_selesai = ?,
            updated_by_name_selesai = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssisi",
        $status,
        $tanggal,
        $updated_by,
        $updated_by_name,
        $id
    );

    return $stmt->execute();
}

function updateTanggal($conn, $data) {
    $id = $data['id'] ?? 0;
    $status = $data['status'] ?? '';
    $tanggal = date('Y-m-d H:i:s');
    $updated_by = $data['updated_by'] ?? 0;
    $updated_by_name = $data['updated_by_name'] ?? '';
    $field = match ($status) {
        'cuci' => ['tanggal_cuci', 'updated_by_cuci', 'updated_by_name_cuci'],
        'gosok' => ['tanggal_gosok', 'updated_by_gosok', 'updated_by_name_gosok'],
        'selesai' => ['tanggal_selesai', 'updated_by_selesai', 'updated_by_name_selesai'],
        'ambil' => ['tanggal_pengambilan', 'updated_by_pengembalian', 'updated_by_name_pengembalian'],
        default => throw new Exception("Status tidak valid"),
    };
    $stmt = $conn->prepare("UPDATE detail_transaksi SET $field[0] = ?, $field[1] = ?, $field[2] = ?, status_order = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $tanggal, $updated_by, $updated_by_name, $status, $id);
    return $stmt->execute();
}

function getDetailTransaksi($conn, $startMonth, $endMonth)
{
    if (!$startMonth || !$endMonth) {
        return [
            'success' => false,
            'message' => 'Start dan End bulan wajib diisi'
        ];
    }

    $startDate = date('Y-m-01', strtotime($startMonth . '-01')) . ' 00:00:00';
    $endDate   = date('Y-m-t', strtotime($endMonth . '-01')) . ' 23:59:59';

    $sql = "
        SELECT 
            DATE(t.created_at) AS tanggal,
            COUNT(DISTINCT t.id_transaksi) AS total
        FROM transaksi t
        JOIN detail_transaksi dt 
            ON dt.id_transaksi = t.id_transaksi
        WHERE t.created_at BETWEEN ? AND ?
        GROUP BY DATE(t.created_at)
        ORDER BY tanggal ASC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [
            'success' => false,
            'message' => 'SQL Error: ' . $conn->error
        ];
    }

    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();

    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return [
        'success' => true,
        'data' => $data
    ];
}


function getPelangganPerHari($conn, $startMonth, $endMonth)
{
    if (!$startMonth || !$endMonth) {
        return [
            'success' => false,
            'message' => 'Start dan End bulan wajib diisi'
        ];
    }

    $startDate = date('Y-m-01', strtotime($startMonth . '-01'));
    $endDate   = date('Y-m-t', strtotime($endMonth . '-01')) . ' 23:59:59';

    $sql = "
        SELECT 
            DATE(created_at) AS tanggal,
            COUNT(DISTINCT id_pelanggan) AS total_pelanggan
        FROM transaksi
        WHERE created_at BETWEEN ? AND ?
        GROUP BY DATE(created_at)
        ORDER BY tanggal ASC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [
            'success' => false,
            'message' => 'SQL Error: ' . $conn->error
        ];
    }

    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();

    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return [
        'success' => true,
        'data'    => $data
    ];
}



$action = $_REQUEST['action'] ?? 'get';

switch ($action) {
    case 'add':
        $data = $_POST ?? [];
        if (isset($data)) {
            $ok = addTransaksi($conn, $data);
            echo json_encode(['success' => $ok]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Data tidak lengkap']);
        }
        break;

    case 'delete':
        $data = $_POST ?? [];
        $ok = deleteTransaksi($conn, $data['id']);
        echo json_encode(['success' => $ok]);
        break;

    case 'getcount':
        echo json_encode(getDataCountTransaksi($conn));
        break;

    case 'updateTanggal':
        $data = $_POST ?? [];
        $ok = updateTanggal($conn, $data);
        echo json_encode(['success' => $ok]);
        break;

    case 'getdetail':
        $startDate = $_GET['startDate'] ?? '';
        $endDate   = $_GET['endDate'] ?? '';

        echo json_encode(
            getDetailTransaksi($conn, $startDate, $endDate)
        );
        break;

    case 'getPelangganPerHari':
        $startDate = $_GET['startDate'] ?? '';
        $endDate   = $_GET['endDate'] ?? '';

        echo json_encode(
            getPelangganPerHari($conn, $startDate, $endDate)
        );
        break;
        
    case 'updateStatus':
        $data = $_POST ?? [];
        try {
            $ok = updateStatus($conn, $data);
            echo json_encode(['success' => $ok]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        break;

    default:
        echo json_encode(getDataTransaksi($conn,[
            'limit' => $_REQUEST['limit'] ?? 10,
            'search' => $_REQUEST['search'] ?? '',
            'page' => $_REQUEST['page'] ?? 1
        ]));
        break;
}
?>