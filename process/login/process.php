<?php
require_once '../config.php';
session_start(); // ✅ tambahkan ini di atas

header('Content-Type: application/json');

function loginUser($conn, $email, $password) {
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // ✅ Simpan data login ke session
            $_SESSION['user'] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'role' => $row['role']
            ];

            return [
                'success' => true,
                'user' => $_SESSION['user']
            ];
        } else {
            return ['success' => false, 'error' => 'Password salah.'];
        }
    } else {
        return ['success' => false, 'error' => 'Email tidak ditemukan.'];
    }
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'login':
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Email dan password wajib diisi.']);
            exit;
        }

        $result = loginUser($conn, $email, $password);
        echo json_encode($result);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Aksi tidak valid.']);
        break;
}
