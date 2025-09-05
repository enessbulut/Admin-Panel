<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}

include __DIR__ . '/../common/db.php'; 

// Kitapları listeleme
$kitaplar = $conn->query("SELECT e.*, y.yazar_adi, p.yayinevi 
                          FROM eser e
                          LEFT JOIN yazar y ON e.yazar_id = y.id
                          LEFT JOIN yayinevi p ON e.yayinevi_id = p.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kitaplar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px; border-radius: 4px; margin-bottom: 5px; }
        .sidebar a:hover { background-color: #495057; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-3">
        <h3 class="text-center">Admin Panel</h3>
        <hr>
        <a href="../index.php">Anasayfa</a>
        <a href="read.php">Kitaplar</a>
        <a href="../members/read.php">Üyeler</a>
        <a href="../yazarlar.php">Yazarlar</a>
        <a href="../yayinevleri.php">Yayınevleri</a>
        <a href="../logout.php">Çıkış</a>
    </div>
    <div class="flex-grow-1 p-4">
        <h2>Kitaplar</h2>
        <a href="create.php" class="btn btn-primary mb-3">Yeni Kitap Ekle</a>

        <table class="table table-bordered">
            <tr>
                <th>Başlık</th>
                <th>Yazar</th>
                <th>Yayınevi</th>
                <th>PDF Link</th>
                <th>Kapak</th>
                <th>Baskı</th>
                <th>Tarih</th>
                <th>İşlemler</th>
            </tr>
            <?php while($b = $kitaplar->fetch_assoc()){ ?>
            <tr>
                <td><?= htmlspecialchars($b['baslik']) ?></td>
                <td><?= htmlspecialchars($b['yazar_adi']) ?></td>
                <td><?= htmlspecialchars($b['yayinevi']) ?></td>
                <td><?= htmlspecialchars($b['pdf_link']) ?></td>
                <td><?php if($b['kapak_resmi']){ ?><img src="<?= $b['kapak_resmi'] ?>" width="50"><?php } ?></td>
                <td><?= $b['baski'] ?></td>
                <td><?= $b['tarih'] ?></td>
                <td>
                    <a href="update.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                    <a href="delete.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-danger">Sil</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>
