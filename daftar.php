<?php
session_start();
require_once 'config/db.php';

// Logika untuk menentukan IPK berdasarkan semester
$semester = isset($_POST['semester']) ? (int)$_POST['semester'] : 1; // Default semester 1
$ipk = 3.0; // Default IPK jika tidak ada semester

if (isset($_POST['semester'])) {
    switch ($_POST['semester']) {
        case 1: $ipk = 2.5; break;
        case 2: $ipk = 2.7; break;
        case 3: $ipk = 2.9; break;
        case 4: $ipk = 3.0; break;
        case 5: $ipk = 3.2; break;
        case 6: $ipk = 3.4; break;
        case 7: $ipk = 3.5; break;
        case 8: $ipk = 3.8; break;
        default: $ipk = 3.0;
    }
}
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
        .btn-disabled {
            background-color: rgb(233, 236, 239) !important;
            color: #6c757d !important;
            pointer-events: none;
            border-color: rgb(233, 236, 239) !important;
        }
        .btn-primary,
        .btn-secondary {
            font-size: 1rem;
            border-radius: 50px;
            padding: 0.5rem 2rem;
        }
        .btn-primary {
            background-color: #4b5fa8;
            border-color: #4b5fa8;
            color: white;
        }
        .btn-primary:hover {
            background-color: #374a90;
            border-color: #374a90;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="Logo" style="height: 40px; width: auto;">
                <span style="font-size: 1.25rem; font-weight: bold; color: #4b5fa8;">BEASISWA</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="daftar.php">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link" href="hasil.php">Hasil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <!-- Pesan Error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="form-container">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Form Pendaftaran Beasiswa</h4>
                    
                    <form action="proses_daftar.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="hp" class="form-control" pattern="[0-9]+" title="Hanya angka yang diperbolehkan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-select" id="semester" required>
                                <option value="">Pilih Semester</option>
                                <?php for($i=1; $i<=8; $i++): ?>
                                    <option value="<?= $i ?>" <?= $semester == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">IPK</label>
                            <input type="text" id="ipk" value="<?= $ipk ?>" class="form-control" readonly>
                            <input type="hidden" name="ipk" value="<?= $ipk ?>">
                            <div id="ipk-warning" class="alert alert-danger mt-2" style="display: <?= $ipk < 3 ? 'block' : 'none'; ?>;">
                                Maaf, IPK Anda tidak memenuhi syarat minimum (3.0) untuk mendaftar beasiswa.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Beasiswa</label>
                            <select name="jenis_beasiswa" class="form-select" id="jenis_beasiswa" <?= $ipk < 3 ? 'disabled' : '' ?> required>
                                <option value="">Pilih Beasiswa</option>
                                <option value="Akademik">Beasiswa Akademik</option>
                                <option value="Non Akademik">Beasiswa Non-Akademik</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Berkas</label>
                            <input type="file" name="berkas" class="form-file" id="berkas" accept=".pdf" <?= $ipk < 3 ? 'disabled' : '' ?> required>
                        </div>

                        <!-- Tombol Daftar dan Batal -->
                        <div class="text-center">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" id="submit" class="btn btn-primary <?= $ipk < 3 ? 'btn-disabled' : '' ?>">
                                    Daftar
                                </button>
                                <a href="index.php" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hpInput = document.querySelector('input[name="hp"]');
            const semesterSelect = document.getElementById('semester');
            const ipkInput = document.getElementById('ipk');
            const jenisBeasiswa = document.getElementById('jenis_beasiswa');
            const berkasInput = document.getElementById('berkas');
            const submitButton = document.getElementById('submit');
            const ipkWarning = document.getElementById('ipk-warning');

            hpInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '');
            });

            semesterSelect.addEventListener('change', function () {
                const semester = parseInt(this.value);
                let ipk = 0;

                switch (semester) {
                    case 1: ipk = 2.5; break;
                    case 2: ipk = 2.7; break;
                    case 3: ipk = 2.9; break;
                    case 4: ipk = 3.0; break;
                    case 5: ipk = 3.2; break;
                    case 6: ipk = 3.4; break;
                    case 7: ipk = 3.5; break;
                    case 8: ipk = 3.8; break;
                    default: ipk = 3.0;
                }

                ipkInput.value = ipk.toFixed(2);
                document.querySelector('input[name="ipk"]').value = ipk.toFixed(2);

                const disable = ipk < 3;
                jenisBeasiswa.disabled = disable;
                berkasInput.disabled = disable;
                submitButton.classList.toggle('btn-disabled', disable);

                ipkWarning.style.display = disable ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>