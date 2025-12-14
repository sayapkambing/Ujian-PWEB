<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Home - Monitoring Ruangan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="app">
        <h1 class="title">Smart Home — Monitoring Ruangan</h1>
        
        <div class="tabs">
            <button class="tab-btn" onclick="window.location.href='index.php'">Dashboard</button>
            <button class="tab-btn active">Monitoring Ruangan</button>
        </div>

        <div class="container-monitoring">
            <div class="form-section">
                <h2 class="section-title">Tambah / Edit Ruangan</h2>
                <form id="room-form" onsubmit="handleSubmit(event)">
                    <input type="hidden" id="edit_id" name="edit_id">
                    
                    <div class="input-row">
                        <input type="text" id="nama_ruangan" name="nama_ruangan" 
                               placeholder="Nama ruangan (mis. Dapur)" required>
                        <input type="number" id="suhu" name="suhu" 
                               placeholder="Suhu (°C)" step="0.01">
                        <input type="number" id="kelembaban" name="kelembaban" 
                               placeholder="Kelembaban (%)" step="0.01">
                        <input type="number" id="energi" name="energi" 
                               placeholder="Energi (kWh)" step="0.01">
                    </div>
                    
                    <div class="checkbox-row">
                        <label class="checkbox-label">
                            <input type="checkbox" id="lampu_status" name="lampu_status">
                            <span>Lampu</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="pintu_status" name="pintu_status">
                            <span>Pintu Terbuka</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-simpan" id="btn-submit">Simpan</button>
                </form>
            </div>

            <div class="list-section">
                <h2 class="section-title">Daftar Ruangan</h2>
                <div id="room-list">
                    <div class="loading">Memuat data...</div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>