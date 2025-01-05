<?php
session_start();
require_once 'config/db.php';

// Konfigurasi Pagination
$limit = 10 ; // Data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Query dengan pagination
$sql = "SELECT * FROM pendaftaran ORDER BY created_at ASC LIMIT $start, $limit";
$stmt = $pdo->query($sql);
$pendaftaran = $stmt->fetchAll();

// Hitung total data untuk pagination
$total_sql = "SELECT COUNT(*) FROM pendaftaran";
$total_data = $pdo->query($total_sql)->fetchColumn();
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pendaftaran Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link active" href="hasil.php">Hasil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Hasil Pendaftaran Beasiswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th class="text-center">Semester</th>
                                        <th class="text-center">IPK</th>
                                        <th>Jenis Beasiswa</th>
                                        <th class="text-center">Berkas</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($pendaftaran) > 0): ?>
                                        <?php 
                                        $no = $start + 1;
                                        foreach ($pendaftaran as $p): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($p['nama']) ?></td>
                                            <td><?= htmlspecialchars($p['email']) ?></td>
                                            <td><?= htmlspecialchars($p['no_hp']) ?></td>
                                            <td class="text-center"><?= $p['semester'] ?></td>
                                            <td class="text-center"><?= number_format($p['ipk'], 2) ?></td>
                                            <td><?= htmlspecialchars($p['jenis_beasiswa']) ?></td>
                                            <td class="text-center">
                                                <a href="uploads/<?= htmlspecialchars($p['berkas']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   target="_blank">
                                                    <i class="fas fa-file-alt me-1"></i> Lihat
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                    $status_class = '';
                                                    if ($p['status_ajuan'] === 'Disetujui') {
                                                        $status_class = 'bg-success text-white';
                                                    } elseif ($p['status_ajuan'] === 'Ditolak') {
                                                        $status_class = 'bg-danger text-white';
                                                    } elseif ($p['status_ajuan'] === 'Pending') {
                                                        $status_class = 'bg-warning text-dark';
                                                    } else {
                                                        $status_class = 'bg-secondary text-white';
                                                    }
                                                ?>
                                                <span class="badge <?= $status_class ?>">
                                                    <?= htmlspecialchars($p['status_ajuan']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Belum ada data pendaftaran
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
