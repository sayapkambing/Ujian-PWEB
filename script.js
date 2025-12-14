// Load saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('dashboard-cards')) {
        loadDashboard();
    }
    if (document.getElementById('room-list')) {
        loadRoomList();
    }
});

// ===== DASHBOARD FUNCTIONS =====
async function loadDashboard() {
    try {
        const response = await fetch('api.php?action=get_rooms');
        const result = await response.json();
        
        const container = document.getElementById('dashboard-cards');
        container.innerHTML = '';
        
        if (!result.success || result.data.length === 0) {
            container.innerHTML = `
                <div class="dashboard-card">
                    <div class="message-info">
                        Belum ada data ruangan. Silakan tambahkan di halaman Monitoring.
                    </div>
                </div>
            `;
            return;
        }
        
        // Tampilkan setiap ruangan
        result.data.forEach(room => {
            // Card Suhu
            container.innerHTML += `
                <div class="dashboard-card">
                    <div class="card-header-dash">
                        <h3 class="card-title-dash">Suhu</h3>
                    </div>
                    <p class="card-subtitle">${room.nama_ruangan}</p>
                    <div class="card-value">${room.suhu}°C</div>
                </div>
            `;
            
            // Card Kelembaban
            container.innerHTML += `
                <div class="dashboard-card">
                    <div class="card-header-dash">
                        <h3 class="card-title-dash">Kelembaban</h3>
                    </div>
                    <p class="card-subtitle">${room.nama_ruangan}</p>
                    <div class="card-value">${room.kelembaban}%</div>
                </div>
            `;
            
            // Card Energi
            container.innerHTML += `
                <div class="dashboard-card">
                    <div class="card-header-dash">
                        <h3 class="card-title-dash">Energi</h3>
                    </div>
                    <p class="card-subtitle">${room.nama_ruangan}</p>
                    <div class="card-value">${room.energi} kWh</div>
                </div>
            `;
            
            // Card Keamanan
            container.innerHTML += `
                <div class="dashboard-card">
                    <div class="card-header-dash">
                        <h3 class="card-title-dash">Keamanan</h3>
                    </div>
                    <p class="card-subtitle">${room.nama_ruangan}</p>
                    <div class="card-value">${room.pintu_status == 1 ? 'Terbuka' : 'Terkunci'}</div>
                </div>
            `;
        });
        
    } catch (error) {
        console.error('Error loading dashboard:', error);
        document.getElementById('dashboard-cards').innerHTML = `
            <div class="dashboard-card">
                <div class="message-info">Error memuat data. Pastikan server berjalan.</div>
            </div>
        `;
    }
}

// ===== MONITORING FUNCTIONS =====
async function loadRoomList() {
    try {
        const response = await fetch('api.php?action=get_rooms');
        const result = await response.json();
        
        const container = document.getElementById('room-list');
        container.innerHTML = '';
        
        if (!result.success || result.data.length === 0) {
            container.innerHTML = '<div class="no-data">Belum ada ruangan. Silakan tambahkan ruangan baru.</div>';
            return;
        }
        
        result.data.forEach(room => {
            const lampuText = room.lampu_status == 1 ? 'Nyala' : 'Mati';
            const pintuText = room.pintu_status == 1 ? 'Terbuka' : 'Terkunci';
            
            container.innerHTML += `
                <div class="room-list-item">
                    <div class="room-list-info">
                        <h3 class="room-list-name">${room.nama_ruangan}</h3>
                        <div class="room-list-details">
                            Suhu: ${room.suhu}°C | Kelembaban: ${room.kelembaban}% | Energi: ${room.energi} kWh | Lampu ${lampuText} | Pintu ${pintuText}
                        </div>
                    </div>
                    <div class="room-list-actions">
                        <button class="btn-edit" onclick="editRoom(${room.id})">
                            ✏️ Edit
                        </button>
                        <button class="btn-hapus" onclick="deleteRoom(${room.id})">
                            🗑️ Hapus
                        </button>
                    </div>
                </div>
            `;
        });
        
    } catch (error) {
        console.error('Error loading room list:', error);
        document.getElementById('room-list').innerHTML = '<div class="no-data">Error memuat data</div>';
    }
}

// Handle form submit (Tambah atau Update)
async function handleSubmit(event) {
    event.preventDefault();
    
    const editId = document.getElementById('edit_id').value;
    const formData = new FormData(event.target);
    
    const data = {
        id: editId || null,
        nama_ruangan: formData.get('nama_ruangan'),
        suhu: formData.get('suhu') || 0,
        kelembaban: formData.get('kelembaban') || 0,
        energi: formData.get('energi') || 0,
        lampu_status: document.getElementById('lampu_status').checked,
        pintu_status: document.getElementById('pintu_status').checked
    };
    
    const action = editId ? 'update_room' : 'add_room';
    
    try {
        const response = await fetch(`api.php?action=${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(editId ? '✅ Ruangan berhasil diupdate!' : '✅ Ruangan berhasil ditambahkan!');
            resetForm();
            loadRoomList();
        } else {
            alert('❌ Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat menyimpan data');
    }
}

// Edit room - mengisi form dengan data
async function editRoom(id) {
    try {
        const response = await fetch('api.php?action=get_rooms');
        const result = await response.json();
        
        if (result.success) {
            const room = result.data.find(r => r.id == id);
            if (room) {
                document.getElementById('edit_id').value = room.id;
                document.getElementById('nama_ruangan').value = room.nama_ruangan;
                document.getElementById('suhu').value = room.suhu;
                document.getElementById('kelembaban').value = room.kelembaban;
                document.getElementById('energi').value = room.energi;
                document.getElementById('lampu_status').checked = room.lampu_status == 1;
                document.getElementById('pintu_status').checked = room.pintu_status == 1;
                
                document.getElementById('btn-submit').textContent = 'Update';
                
                // Scroll ke form
                document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth' });
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat mengambil data');
    }
}

// Reset form
function resetForm() {
    document.getElementById('room-form').reset();
    document.getElementById('edit_id').value = '';
    document.getElementById('btn-submit').textContent = 'Simpan';
}

// Delete room
async function deleteRoom(id) {
    if (!confirm('❓ Apakah Anda yakin ingin menghapus ruangan ini?')) {
        return;
    }
    
    try {
        const response = await fetch('api.php?action=delete_room', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ Ruangan berhasil dihapus!');
            loadRoomList();
        } else {
            alert('❌ Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat menghapus data');
    }
}
