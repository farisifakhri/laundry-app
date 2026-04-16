<?php
require_once '../config.php';
header('Content-Type: application/json');

function getDataUser($conn, $params) {
    $limit = isset($params['limit']) ? (int)$params['limit'] : 10;
    $page = isset($params['page']) ? (int)$params['page'] : 1;
    $search = isset($params['search']) ? trim($params['search']) : '';

    // Hitung offset
    $offset = ($page - 1) * $limit;

    // Query dasar
    $sql = "SELECT * FROM user";

    // Kalau ada pencarian
    if (!empty($search)) {
        $sql .= " WHERE nama LIKE ? OR email LIKE ?";
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
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}

function getDataCountUser($conn) {
    $sql = "SELECT COUNT(*) AS count FROM user";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function addUser($conn, $data) {
    $nama  = $data['nama'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $status = $data['status'] ?? 1;
    $role = $data['role'] ?? '';
    $created_by = $data['created_by'] ?? 0;
    $created_by_name = $data['created_by_name'] ?? '';
    $created_at = date('Y-m-d H:i:s');

    // 🔒 Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (nama, email, password, role, status, created_by, created_by_name, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssisss", $nama, $email, $hashedPassword, $role, $status, $created_by, $created_by_name, $created_at);
    return $stmt->execute();
}

function editUser($conn, $data) {
    $id = $data['id'] ?? 0;
    $nama  = $data['nama'] ?? '';
    $email = $data['email'] ?? '';
    $status = $data['status'] ?? 1;
    $role = $data['role'] ?? '';
    $updated_by = $data['updated_by'] ?? 0;
    $updated_by_name = $data['updated_by_name'] ?? '';
    $updated_at = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE user 
                            SET nama = ?, email = ?, status = ?, role = ?, updated_by = ?, updated_by_name = ?, updated_at = ?
                            WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssisissi", $nama, $email, $status, $role, $updated_by, $updated_by_name, $updated_at, $id);
    return $stmt->execute();
}


function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}


$action = $_REQUEST['action'] ?? 'get';

switch ($action) {
    case 'add':
        $data = $_POST ?? [];
        if (isset($data)) {
            $ok = addUser($conn, $data);
            echo json_encode(['success' => $ok]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Data tidak lengkap']);
        }
        break;

    case 'delete':
        $data = $_POST ?? [];
        $ok = deleteUser($conn, $data['id']);
        echo json_encode(['success' => $ok]);
        break;

    case 'edit':
        $data = $_POST ?? [];
        $ok = editUser($conn, $data);
        echo json_encode(['success' => $ok]);
        break;
    
    case 'getcount':
        echo json_encode(getDataCountUser($conn));
        break;

    default:
        echo json_encode(getDataUser($conn, [
            'limit' => $_REQUEST['limit'] ?? 10,
            'search' => $_REQUEST['search'] ?? '',
            'page'   => $_REQUEST['page'] ?? 1
        ]));
        break;
}
?>