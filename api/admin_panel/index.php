<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}

include __DIR__ . '/common/db.php'; 

// Toplam üye sayısı
$result = $conn->query("SELECT COUNT(*) as total FROM uye");
$totalMembers =  mysqli_fetch_array($result)['total'] ;

// Toplam kitap sayısı
$result = $conn->query("SELECT COUNT(*) as total FROM eser");
$totalBooks = $result ? $result->fetch_assoc()['total'] : 0;

// Toplam okunan sayfa
$result = $conn->query("SELECT SUM(bitis_sayfasi - baslanilan_sayfa) as total FROM okuma_izleme");
$totalReadPages = $result ? $result->fetch_assoc()['total'] : 0;

// Son eklenen 5 kitap
$recentBooks = $conn->query("SELECT e.baslik, y.yazar_adi 
                             FROM eser e 
                             LEFT JOIN yazar y ON e.yazar_id = y.id
                             ORDER BY e.id DESC 
                             LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px; border-radius: 4px; margin-bottom: 5px; }
        .sidebar a:hover { background-color: #495057; }
        .card-title { font-size: 1.1rem; font-weight: bold; }
        .card-number { font-size: 2rem; font-weight: bold; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-3">
        <h3 class="text-center">Admin Panel</h3>
        <hr>
        <a href="index.php">Anasayfa</a>
        <a href="books/read.php">Kitaplar</a>
        <a href="members/read.php">Üyeler</a>
        <a href="yazarlar.php">Yazarlar</a>
        <a href="yayinevleri.php">Yayınevleri</a>
        <a href="logout.php">Çıkış</a>
    </div>
    <div class="flex-grow-1 p-4">
        <h2>Dashboard</h2>
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <div class="card-title">Toplam Üye</div>
                        <div class="card-number"><?= $totalMembers ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-bg-success">
                    <div class="card-body">
                        <div class="card-title">Toplam Kitap</div>
                        <div class="card-number"><?= $totalBooks ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-bg-warning">
                    <div class="card-body">
                        <div class="card-title">Toplam Okunan Sayfa</div>
                        <div class="card-number"><?= $totalReadPages ?></div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-5">Son Eklenen Kitaplar</h4>
        <table class="table table-bordered table-striped mt-2">
            <thead class="table-dark">
                <tr>
                    <th>Başlık</th>
                    <th>Yazar</th>
                </tr>
            </thead>
            <tbody>
                <?php if($recentBooks && $recentBooks->num_rows > 0): ?>
                    <?php while($book = $recentBooks->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['baslik']) ?></td>
                            <td><?= htmlspecialchars($book['yazar_adi']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center">Henüz kitap eklenmedi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
