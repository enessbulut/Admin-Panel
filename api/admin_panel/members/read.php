<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}
include __DIR__ . '/../common/db.php';

// Üyeleri ve okuma bilgilerini çek (cinsiyet eklendi)
$query = "
SELECT u.id AS uye_id, u.ad, u.eposta, u.yas, u.cinsiyet, e.baslik AS kitap_baslik, (o.bitis_sayfasi - o.baslanilan_sayfa) AS okunan_sayfa
FROM uye u
LEFT JOIN okuma_izleme o ON o.uye_id = u.id
LEFT JOIN eser e ON o.eser_id = e.id
ORDER BY u.ad, e.baslik
";

$result = $conn->query($query);

$members = [];
if($result){
    while($row = $result->fetch_assoc()){
        $uye_id = $row['uye_id'];
        if(!isset($members[$uye_id])){
            $members[$uye_id] = [
                'ad' => $row['ad'],
                'eposta' => $row['eposta'],
                'yas' => $row['yas'],
                'cinsiyet' => $row['cinsiyet'], // Yeni
                'okuma' => []
            ];
        }
        if($row['kitap_baslik']){
            $members[$uye_id]['okuma'][] = [
                'kitap' => $row['kitap_baslik'],
                'sayfa' => $row['okunan_sayfa']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Üyeler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px; border-radius: 4px; margin-bottom: 5px; }
        .sidebar a:hover { background-color: #495057; }
        .table th, .table td { vertical-align: middle; }
        .okuma-table th, .okuma-table td { font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-3">
        <h3 class="text-center">Admin Panel</h3>
        <hr>
        <a href="../index.php">Anasayfa</a>
        <a href="../books/read.php">Kitaplar</a>
        <a href="read.php">Üyeler</a>
        <a href="../yazarlar.php">Yazarlar</a>
        <a href="../yayinevleri.php">Yayınevleri</a>
        <a href="../logout.php">Çıkış</a>
    </div>

    <div class="flex-grow-1 p-4">
        <h2>Üyeler</h2>
        <table class="table table-bordered">
            <tr>
                <th>Ad</th>
                <th>Email</th>
                <th>Yaş</th>
                <th>Cinsiyet</th> <!-- Yeni sütun -->
                <th>Okunan Kitaplar</th>
                <th>İşlemler</th>
            </tr>
            <?php foreach($members as $uye_id => $uye): ?>
            <tr>
                <td><?= htmlspecialchars($uye['ad']) ?></td>
                <td><?= htmlspecialchars($uye['eposta']) ?></td>
                <td><?= $uye['yas'] ?></td>
                <td><?= htmlspecialchars($uye['cinsiyet'] ?? '-') ?></td> <!-- Yeni veri -->
                <td>
                    <?php if(count($uye['okuma']) > 0): ?>
                        <table class="table table-bordered okuma-table mb-0">
                            <tr>
                                <th>Kitap</th>
                                <th>Sayfa</th>
                            </tr>
                            <?php foreach($uye['okuma'] as $okuma): ?>
                            <tr>
                                <td><?= htmlspecialchars($okuma['kitap']) ?></td>
                                <td><?= $okuma['sayfa'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        Henüz okuma yok
                    <?php endif; ?>
                </td>
                <td>
                    <a href="update.php?id=<?= $uye_id ?>" class="btn btn-sm btn-warning">Düzenle</a>
                    <a href="delete.php?id=<?= $uye_id ?>" class="btn btn-sm btn-danger">Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>
