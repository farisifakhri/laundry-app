<?php
session_start();

if (!isset($_SESSION['user'])) {
    // ✅ kalau belum login, redirect ke login.php
    header('Location: login.php');
    exit();
}

