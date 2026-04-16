<?php
require_once '../config.php';
header('Content-Type: application/json');

function getDataPelanggan($conn, $params) {
    $limit = isset($params['limit']) ? (int)$params['limit'] : 10;
    $page = isset($params['page']) ? (int)$params['page'] : 1;
    $search = isset($params['search']) ? trim($params['search']) : '';

    // Hitung offset
    $offset = ($page - 1) * $limit;

    // Query dasar
    $sql = "SELECT * FROM pelanggan";
    
    // Kalau ada pencarian
    if (!empty($search)) {
        $sql .= " WHERE nama LIKE ? OR email LIKE ? OR telepon LIKE ? OR alamat LIKE ?";
    }

    // Tambahkan LIMIT dan OFFSET
    $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);

    // Binding parameter
    if (!empty($search)) {
        $like = "%{$search}%";
        $stmt->bind_param("ssssii", $like, $like, $like, $like, $limit, $offset);
    } else {
        $stmt->bind_param("ii", $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

function getDataCountPelanggan($conn) {
    $sql = "SELECT COUNT(*) AS count FROM pelanggan";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}
// hapus data
function deletePelanggan($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM pelanggan WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}


function addPelanggan($conn, $data) {
    $nama  = $data['nama'] ?? '';
    $email = $data['email'] ?? '';
    $telepon = $data['telepon'] ?? '';
    $alamat = $data['alamat'] ?? '';
    $jenis_kelamin = $data['jenis_kelamin'] ?? '';
    $created_by = $data['created_by'] ?? 0;
    $created_by_name = $data['created_by_name'] ?? '';
    $created_at = date('Y-m-d H:i:s');

    // Jumlah kolom = 8 → jumlah ? juga harus 8
    $stmt = $conn->prepare("INSERT INTO pelanggan 
        (nama, email, telepon, alamat, jenis_kelamin, created_by, created_by_name, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // 'sssssiss' → string, string, string, string, string, int, string, string
    $stmt->bind_param("sssssiss", $nama, $email, $telepon, $alamat, $jenis_kelamin, $created_by, $created_by_name, $created_at);
    return $stmt->execute();
}

function editPelanggan($conn, $data) {
    $id = $data['id'] ?? 0;
    $nama  = $data['nama'] ?? '';
    $email = $data['email'] ?? '';
    $telepon = $data['telepon'] ?? '';
    $alamat = $data['alamat'] ?? '';
    $jenis_kelamin = $data['jenis_kelamin'] ?? '';
    $updated_by = $data['updated_by'] ?? 0;
    $updated_by_name = $data['updated_by_name'] ?? '';
    $updated_at = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE pelanggan 
        SET nama = ?, email = ?, telepon = ?, alamat = ?, jenis_kelamin = ?, updated_by = ?, updated_by_name = ?, updated_at = ?
        WHERE id = ?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // 9 parameter total → 9 tipe data
    $stmt->bind_param("sssssissi", $nama, $email, $telepon, $alamat, $jenis_kelamin, $updated_by, $updated_by_name, $updated_at, $id);
    return $stmt->execute();
}


// --- ROUTER AREA ---

$action = $_REQUEST['action'] ?? 'get';

switch ($action) {
    case 'add':
        $data = $_POST ?? [];
        if (isset($data)) {
            $ok = addPelanggan($conn, $data);
            echo json_encode(['success' => $ok]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Data tidak lengkap']);
        }
        break;

    case 'delete':
        $data = $_POST ?? [];
        $ok = deletePelanggan($conn, $data['id']);
        echo json_encode(['success' => $ok]);
        break;

    case 'edit':
        $data = $_POST ?? [];
        $ok = editPelanggan($conn, $data);
        echo json_encode(['success' => $ok]);
        break;
    
    case 'getcount':
        echo json_encode(getDataCountPelanggan($conn));
        break;

    default: // get data pelanggan per halaman
        echo json_encode(getDataPelanggan($conn, [
            'limit' => $_REQUEST['limit'] ?? 10,
            'search' => $_REQUEST['search'] ?? '',
            'page'   => $_REQUEST['page'] ?? 1
        ]));
        break;
}
?>
