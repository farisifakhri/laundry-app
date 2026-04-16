<?php
require_once '../config.php';
header('Content-Type: application/json');

function getDataJenisPelayanan($conn, $params) {
    $limit = isset($params['limit']) ? (int)$params['limit'] : 10;
    $page = isset($params['page']) ? (int)$params['page'] : 1;
    $search = isset($params['search']) ? trim($params['search']) : '';

    // Hitung offset
    $offset = ($page - 1) * $limit;

    // Query dasar
    $sql = "SELECT * FROM jenis_layanan";

    // Kalau ada pencarian
    if (!empty($search)) {
        $sql .= " WHERE nama LIKE ? OR harga LIKE ?";
    }

    // Tambahkan LIMIT dan OFFSET
    $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);

    // Binding parameter
    if (!empty($search)) {
        $like = "%{$search}%";
        $stmt->bind_param("ssii", $like, $like, $limit, $offset);
    } else {
        $stmt->bind_param("ii", $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

function getDataCountJenisPelayanan($conn) {
    $sql = "SELECT COUNT(*) AS count FROM jenis_layanan";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function addJenisPelayanan($conn, $data) {
    $nama = $data['nama'] ?? '';
    $harga = (int)($data['harga'] ?? 0);
    $status = (int)($data['status'] ?? 1);
    $created_by = (int)($data['created_by'] ?? 0);
    $created_by_name = $data['created_by_name'] ?? '';
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO jenis_layanan 
            (nama, harga, status, created_by, created_by_name, created_at) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->error); // DEBUG, boleh hapus nanti
    }

    $stmt->bind_param(
        "siisss",
        $nama,
        $harga,
        $status,
        $created_by,
        $created_by_name,
        $created_at
    );

    return $stmt->execute();
}


function editJenisPelayanan($conn, $data) {
    $id = $data['id'] ?? 0;
    $nama = $data['nama'] ?? '';
    $harga = $data['harga'] ?? '';
    $status = $data['status'] ?? 1;
    $updated_by = $data['updated_by'] ?? 0;
    $updated_by_name = $data['updated_by_name'] ?? '';
    $updated_at = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE jenis_layanan SET nama = ?, harga = ?, status = ?, updated_by = ?, updated_by_name = ?, updated_at = ? WHERE id = ?");
    $stmt->bind_param("sssissi", $nama, $harga, $status, $updated_by, $updated_by_name, $updated_at, $id);
    return $stmt->execute();
}

function deleteJenisPelayanan($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM jenis_layanan WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}


$action = $_REQUEST['action'] ?? 'get';

switch ($action) {
    case 'add':
        $data = $_POST ?? [];
        if (isset($data)) {
            $ok = addJenisPelayanan($conn, $data);
            echo json_encode(['success' => $ok]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Data tidak lengkap']);
        }
        break;

    case 'delete':
        $data = $_POST ?? [];
        $ok = deleteJenisPelayanan($conn, $data['id']);
        echo json_encode(['success' => $ok]);
        break;

    case 'edit':
        $data = $_POST ?? [];
        $ok = editJenisPelayanan($conn, $data);
        echo json_encode(['success' => $ok]);
        break;

    case 'count':
        echo json_encode(getDataCountJenisPelayanan($conn));
        break;

    default:
        $params = $_REQUEST ?? [];
        echo json_encode(getDataJenisPelayanan($conn, $params));
        break;
}
?>