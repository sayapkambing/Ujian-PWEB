php<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');           
define('DB_PASS', '');               
define('DB_NAME', 'smart_home');

// Koneksi ke database
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }
    
    // Set charset UTF-8
    $conn->set_charset("utf8");
    
    return $conn;
}

// Fungsi untuk response JSON
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>
