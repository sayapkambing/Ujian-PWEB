javascript// Base URL for API
const API_URL = 'api.php';

// Load Dashboard Statistics
function loadDashboardStats() {
    fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=get_stats'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('avg-temp').textContent = data.data.avg_temp + '°C';
            document.getElementById('avg-humidity').textContent = data.data.avg_humidity + '%';
            document.getElementById('total-energy').textContent = data.data.total_energy + ' kW';
        }
    })
    .catch(error => console.error('Error:', error));
}

// Load All Rooms
function loadRooms() {
    fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=get_all'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayRooms(data.data);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Display Rooms
function displayRooms(rooms) {
    const roomList = document.getElementById('room-list');
    
    if (rooms.length === 0) {
        roomList.innerHTML = '<p class="no-data">Belum ada ruangan. Silakan tambahkan ruangan baru.</p>';
        return;
    }
    
    roomList.innerHTML = rooms.map(room => `
        <div class="room-item">
            <h3 class="room-name">${room.name}</h3>
            <div class="room-details">
                <p class="room-detail"><strong>Lampu:</strong> ${room.lamp_on ? 'ON' : 'OFF'}</p>
                <p class="room-detail"><strong>Pintu:</strong> ${room.door_locked ? 'Terkunci' : 'Terbuka'}</p>
                <p class="room-detail"><strong>Suhu:</strong> ${room.temperature} °C</p>
            </div>
            <div class="room-actions">
                <button onclick="editRoom(${room.id}, '${room.name}', ${room.temperature}, ${room.lamp_on}, ${room.door_locked})" class="btn-edit">
                    ✏ Edit
                </button>
                <button onclick="deleteRoom(${room.id})" class="btn-delete">
                    🗑 Hapus
                </button>
            </div>
        </div>
    `).join('');
}

// Form Submit Handler
document.getElementById('room-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const roomId = document.getElementById('room-id').value;
    
    // Set action
    formData.append('action', roomId ? 'update' : 'add');
    
    // Handle checkboxes
    if (!formData.has('lamp_on')) {
        formData.delete('lamp_on');
    }
    if (!formData.has('door_locked')) {
        formData.delete('door_locked');
    }
    
    fetch(API_URL, {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            resetForm();
            loadRooms();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

// Edit Room
function editRoom(id, name, temperature, lampOn, doorLocked) {
    document.getElementById('room-id').value = id;
    document.getElementById('room-name').value = name;
    document.getElementById('room-temp').value = temperature;
    document.getElementById('lamp-on').checked = lampOn;
    document.getElementById('door-locked').checked = doorLocked;
    document.getElementById('btn-submit').textContent = 'Update';
    document.getElementById('btn-cancel').style.display = 'inline-block';
    
    // Scroll to form
    document.getElementById('room-form').scrollIntoView({ behavior: 'smooth' });
}

// Delete Room
function deleteRoom(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus ruangan ini?')) {
        return;
    }
    
    fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: action=delete&id=${id}
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadRooms();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Reset Form
function resetForm() {
    document.getElementById('room-form').reset();
    document.getElementById('room-id').value = '';
    document.getElementById('btn-submit').textContent = 'Simpan';
    document.getElementById('btn-cancel').style.display = 'none';
}

// Cancel Button Handler
document.getElementById('btn-cancel')?.addEventListener('click', resetForm);