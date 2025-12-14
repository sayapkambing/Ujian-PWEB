<?php
header('Content-Type: application/json');
require_once 'config.php';

$conn = getConnection();
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// GET - Ambil semua ruangan
if ($method === 'GET' && $action === 'get_rooms') {
    $sql = "SELECT * FROM ruangan ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    
    sendResponse(true, 'Data berhasil diambil', $rooms);
}

// POST - Tambah ruangan baru
if ($method === 'POST' && $action === 'add_room') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $nama = $conn->real_escape_string($data['nama_ruangan'] ?? '');
    $suhu = floatval($data['suhu'] ?? 0);
    $kelembaban = floatval($data['kelembaban'] ?? 0);
    $energi = floatval($data['energi'] ?? 0);
    $lampu = isset($data['lampu_status']) && $data['lampu_status'] ? 1 : 0;
    $pintu = isset($data['pintu_status']) && $data['pintu_status'] ? 1 : 0;
    
    if (empty($nama)) {
        sendResponse(false, 'Nama ruangan harus diisi');
    }
    
    $sql = "INSERT INTO ruangan (nama_ruangan, suhu, kelembaban, energi, lampu_status, pintu_status) 
            VALUES ('$nama', $suhu, $kelembaban, $energi, $lampu, $pintu)";
    
    if ($conn->query($sql)) {
        sendResponse(true, 'Ruangan berhasil ditambahkan', ['id' => $conn->insert_id]);
    } else {
        sendResponse(false, 'Gagal menambahkan ruangan: ' . $conn->error);
    }
}

// POST - Update ruangan
if ($method === 'POST' && $action === 'update_room') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = intval($data['id'] ?? 0);
    $nama = $conn->real_escape_string($data['nama_ruangan'] ?? '');
    $suhu = floatval($data['suhu'] ?? 0);
    $kelembaban = floatval($data['kelembaban'] ?? 0);
    $energi = floatval($data['energi'] ?? 0);
    $lampu = isset($data['lampu_status']) && $data['lampu_status'] ? 1 : 0;
    $pintu = isset($data['pintu_status']) && $data['pintu_status'] ? 1 : 0;
    
    if ($id === 0) {
        sendResponse(false, 'ID ruangan tidak valid');
    }
    
    if (empty($nama)) {
        sendResponse(false, 'Nama ruangan harus diisi');
    }
    
    $sql = "UPDATE ruangan SET 
            nama_ruangan = '$nama',
            suhu = $suhu,
            kelembaban = $kelembaban,
            energi = $energi,
            lampu_status = $lampu,
            pintu_status = $pintu
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        sendResponse(true, 'Ruangan berhasil diupdate');
    } else {
        sendResponse(false, 'Gagal mengupdate ruangan: ' . $conn->error);
    }
}

// DELETE - Hapus ruangan
if ($method === 'POST' && $action === 'delete_room') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = intval($data['id'] ?? 0);
    
    if ($id === 0) {
        sendResponse(false, 'ID ruangan tidak valid');
    }
    
    $sql = "DELETE FROM ruangan WHERE id = $id";
    
    if ($conn->query($sql)) {
        sendResponse(true, 'Ruangan berhasil dihapus');
    } else {
        sendResponse(false, 'Gagal menghapus ruangan: ' . $conn->error);
    }
}

$conn->close();
sendResponse(false, 'Action tidak valid');
?>