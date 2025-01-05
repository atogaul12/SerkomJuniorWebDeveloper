<?php
session_start();
require_once 'config/db.php';

// Fetch data jumlah pendaftar
$sql_akademik = "SELECT COUNT(*) as total FROM pendaftaran WHERE jenis_beasiswa = 'Akademik'";
$sql_non_akademik = "SELECT COUNT(*) as total FROM pendaftaran WHERE jenis_beasiswa = 'Non Akademik'";
$akademik = $pdo->query($sql_akademik)->fetch()['total'];
$non_akademik = $pdo->query($sql_non_akademik)->fetch()['total'];
$total_pendaftar = $akademik + $non_akademik;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Navbar Styling */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
        }
        .navbar-brand span {
            font-size: 1.25rem;
            font-weight: bold;
            color: #4b5fa8;
        }
        .navbar-nav .nav-link {
            color: #4b5fa8 !important;
            font-weight: normal;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link.active {
            font-weight: bold;
            text-decoration: underline;
            color: #4b5fa8;
        }
        .navbar-nav .nav-link:hover {
            color: #374a90;
        }
        /* Additional Hero and Content Styling */
        .hero {
            background: linear-gradient(to right, #4b5fa8, #374a90);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .cta-button a {
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 30px;
            background-color: white;
            color: #4b5fa8;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }
        .cta-button a:hover {
            background-color: #374a90;
            color: white;
        }
        .features {
            padding: 40px 0;
        }
        .features h2 {
            margin-bottom: 30px;
            color: #4b5fa8;
            text-align: center;
        }
        .feature-item {
            text-align: center;
        }
        .chart-container {
            margin: 40px auto;
            max-width: 800px;
            text-align: center;
        }
        .footer {
            padding: 20px;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="Logo">
                <span>BEASISWA</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link" href="hasil.php">Hasil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Pendaftaran Beasiswa Terbaik</h1>
            <p>Bergabunglah dengan ribuan mahasiswa berprestasi dan raih cita-cita bersama kami.</p>
            <div class="cta-button">
                <a href="daftar.php" class="btn btn-primary btn-lg rounded-pill mt-3">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features py-5">
        <div class="container">
            <h2 class="text-center mb-4">Jenis Beasiswa</h2>
            <div class="row justify-content-center">
                <div class="col-md-5 text-center">
                    <i class="fas fa-medal fa-3x text-primary mb-3"></i>
                    <h5>Beasiswa Akademik</h5>
                    <p>Untuk mahasiswa berprestasi akademik dengan IPK minimal 3.0.</p>
                </div>
                <div class="col-md-5 text-center">
                    <i class="fas fa-trophy fa-3x text-success mb-3"></i>
                    <h5>Beasiswa Non-Akademik</h5>
                    <p>Untuk mahasiswa dengan prestasi non-akademik di bidang olahraga, seni, dan lainnya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Chart Section -->
    <section class="chart-container">
        <div class="container text-center">
            <h2>Statistik Pendaftaran Beasiswa</h2>
            <canvas id="beasiswaChart"></canvas>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Pendaftaran Beasiswa. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('beasiswaChart').getContext('2d');
        const beasiswaChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Beasiswa Akademik', 'Beasiswa Non-Akademik'],
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: [<?= $akademik ?>, <?= $non_akademik ?>],
                    backgroundColor: ['#007bff', '#28a745'],
                    borderColor: ['#007bff', '#28a745'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
