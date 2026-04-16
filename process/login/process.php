<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

// ❗ Matikan output error ke browser
ini_set('display_errors', 0);
error_reporting(E_ALL);

function loginUser($conn, $email, $password) {
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    
    if (!$stmt) {
        return ['success' => false, 'error' => 'Query error: ' . $conn->error];
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'role' => $row['role']
            ];

            return ['success' => true, 'user' => $_SESSION['user']];
        } else {
            return ['success' => false, 'error' => 'Password salah.'];
        }
    } else {
        return ['success' => false, 'error' => 'Email tidak ditemukan.'];
    }
}

try {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Email dan password wajib diisi.']);
            exit;
        }

        $result = loginUser($conn, $email, $password);
        echo json_encode($result);
    } else {
        echo json_encode(['success' => false, 'error' => 'Aksi tidak valid.']);
    }

} catch (Throwable $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Server error',
        'debug' => $e->getMessage()
    ]);
}