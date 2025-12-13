php<?php
require_once 'config.php';

// Set header untuk AJAX
header('Content-Type: application/json');

$conn = getDBConnection();
$action = isset($_POST['action']) ? $_POST['action'] : '';

// GET ALL ROOMS
if ($action == 'get_all') {
    $sql = "SELECT * FROM rooms ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    $rooms = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rooms[] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'temperature' => (float)$row['temperature'],
                'humidity' => (float)$row['humidity'],
                'energy' => (float)$row['energy'],
                'lamp_on' => (bool)$row['lamp_on'],
                'door_locked' => (bool)$row['door_locked']
            ];
        }
    }
    
    jsonResponse(['success' => true, 'data' => $rooms]);
}

// ADD ROOM
elseif ($action == 'add') {
    $name = $conn->real_escape_string($_POST['name']);
    $temperature = (float)$_POST['temperature'];
    $lamp_on = isset($_POST['lamp_on']) ? 1 : 0;
    $door_locked = isset($_POST['door_locked']) ? 1 : 0;
    
    $sql = "INSERT INTO rooms (name, temperature, lamp_on, door_locked) 
            VALUES ('$name', $temperature, $lamp_on, $door_locked)";
    
    if ($conn->query($sql)) {
        jsonResponse([
            'success' => true, 
            'message' => 'Ruangan berhasil ditambahkan',
            'id' => $conn->insert_id
        ]);
    } else {
        jsonResponse(['success' => false, 'message' => 'Gagal menambahkan ruangan'], 500);
    }
}

// UPDATE ROOM
elseif ($action == 'update') {
    $id = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $temperature = (float)$_POST['temperature'];
    $lamp_on = isset($_POST['lamp_on']) ? 1 : 0;
    $door_locked = isset($_POST['door_locked']) ? 1 : 0;
    
    $sql = "UPDATE rooms SET 
            name = '$name',
            temperature = $temperature,
            lamp_on = $lamp_on,
            door_locked = $door_locked
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        jsonResponse(['success' => true, 'message' => 'Ruangan berhasil diupdate']);
    } else {
        jsonResponse(['success' => false, 'message' => 'Gagal mengupdate ruangan'], 500);
    }
}

// DELETE ROOM
elseif ($action == 'delete') {
    $id = (int)$_POST['id'];
    
    $sql = "DELETE FROM rooms WHERE id = $id";
    
    if ($conn->query($sql)) {
        jsonResponse(['success' => true, 'message' => 'Ruangan berhasil dihapus']);
    } else {
        jsonResponse(['success' => false, 'message' => 'Gagal menghapus ruangan'], 500);
    }
}

// GET DASHBOARD STATS
elseif ($action == 'get_stats') {
    $sql = "SELECT 
            ROUND(AVG(temperature), 0) as avg_temp,
            ROUND(AVG(humidity), 0) as avg_humidity,
            ROUND(SUM(energy), 2) as total_energy,
            COUNT(*) as total_rooms
            FROM rooms";
    
    $result = $conn->query($sql);
    $stats = $result->fetch_assoc();
    
    jsonResponse(['success' => true, 'data' => $stats]);
}

else {
    jsonResponse(['success' => false, 'message' => 'Action tidak valid'], 400);
}

$conn->close();
?>

