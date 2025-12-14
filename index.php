<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Home Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="app">
        <h1 class="title">Smart Home Dashboard</h1>
        
        <div class="container-dashboard">
            <div class="dashboard-cards" id="dashboard-cards">
                <div class="loading">Memuat data...</div>
            </div>
            
            <button class="btn-monitoring" onclick="window.location.href='monitoring.php'">
                Lihat Monitoring Ruangan
            </button>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>