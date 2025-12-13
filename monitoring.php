<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏡 Smart Home — Monitoring Ruangan Imut</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="cute-bg">

    <div class="container-wide cute-container">

        <!-- Header -->
        <div class="header-center cute-header">
            <h1 class="title-large cute-title">✨ Smart Home — Monitoring Ruangan ✨</h1>
            <div class="nav-buttons">
                <a href="index.php" class="nav-btn cute-btn">🏠 Dashboard</a>
                <a href="monitoring.php" class="nav-btn cute-btn active">🌈 Monitoring</a>
            </div>
        </div>

        <!-- Add/Edit Form -->
        <div class="form-card cute-card">
            <h2 class="form-title cute-subtitle">💖 Tambah / Edit Ruangan 💖</h2>

            <form id="room-form" class="room-form">
                <input type="hidden" id="room-id" name="id">

                <input 
                    type="text" 
                    id="room-name" 
                    name="name" 
                    placeholder="🌸 Nama ruangan (mis. Dapur Imut)" 
                    required
                    class="form-input cute-input"
                >

                <label class="checkbox-label cute-checkbox">
                    <input type="checkbox" id="lamp-on" name="lamp_on">
                    <span>💡 Lampu Menyala</span>
                </label>

                <label class="checkbox-label cute-checkbox">
                    <input type="checkbox" id="door-locked" name="door_locked">
                    <span>🚪 Pintu Terbuka</span>
                </label>

                <input 
                    type="number" 
                    id="room-temp" 
                    name="temperature" 
                    placeholder="🌡️ Suhu (°C)" 
                    step="0.1"
                    required
                    class="form-input-small cute-input"
                >

                <button type="submit" class="btn-save cute-save-btn" id="btn-submit">💾 Simpan</button>
                <button type="button" class="btn-cancel cute-cancel-btn" id="btn-cancel" style="display:none;">❌ Batal</button>
            </form>
        </div>

        <!-- Room List -->
        <div class="form-card cute-card">
            <h2 class="form-title cute-subtitle">📋 Daftar Ruangan</h2>

            <div id="room-list" class="room-list cute-list">
                <p class="loading cute-loading">⏳ Memuat data ruangan lucu...</p>
            </div>
        </div>

    </div>

    <script src="js/script.js"></script>
    <script>
        loadRooms();
    </script>

</body>
</html>
