<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Home - Dashboard</title>
    <link rel="stylesheet" href="style.css">



    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1 class="title">🌸 Smart Home Dashboard 🌸</h1>
        
        <div class="dashboard-grid">

            <!-- Temperature Card -->
            <div class="card">
                <div class="card-header">
                    <div class="icon-circle pink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"/>
                        </svg>
                    </div>
                    <h2>Suhu</h2>
                </div>
                <p class="card-value" id="avg-temp">--°C</p>
            </div>

            <!-- Humidity Card -->
            <div class="card">
                <div class="card-header">
                    <div class="icon-circle pink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                        </svg>
                    </div>
                    <h2>Kelembaban</h2>
                </div>
                <p class="card-value" id="avg-humidity">--%</p>
            </div>

            <!-- Energy Card -->
            <div class="card">
                <div class="card-header">
                    <div class="icon-circle yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                        </svg>
                    </div>
                    <h2>Energi</h2>
                </div>
                <p class="card-value" id="total-energy">-- kW</p>
            </div>

            <!-- Security Card -->
            <div class="card">
                <div class="card-header">
                    <div class="icon-circle pink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <h2>Keamanan</h2>
                </div>
                <p class="card-value-small">Terkunci 🔒</p>
            </div>

        </div>

        <a href="monitoring.php" class="btn-primary">Lihat Monitoring Ruangan 💗</a>
    </div>

    <script src="js/script.js"></script>
    <script>
        loadDashboardStats();
    </script>

</body>
</html>
