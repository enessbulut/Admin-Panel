<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}

include __DIR__ . '/common/db.php'; 

// Yazar ekleme
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['yazar_adi'])){
    $yazar = trim($_POST['yazar_adi']);
    if($yazar != ""){
        $stmt = $conn->prepare("INSERT INTO yazar (yazar_adi) VALUES (?)");
        $stmt->bind_param("s", $yazar);
        if($stmt->execute()){
            $message = "Yazar eklendi.";
        } else {
            $message = "Hata: " . $stmt->error;
        }
    } else {
        $message = "Yazar adı boş olamaz.";
    }
}

// Yazar silme
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM yazar WHERE id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        $message = "Yazar silindi.";
    } else {
        $message = "Hata: " . $stmt->error;
    }
}

// Mevcut yazarları listeleme
$yazarlar = $conn->query("SELECT * FROM yazar ORDER BY yazar_adi ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yazarlar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 12px; border-radius: 4px; margin-bottom: 5px; }
        .sidebar a:hover { background-color: #495057; }
        .alert { margin-top: 15px; }
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
        <h2>Yazarlar</h2>

        <?php if(isset($message)){ ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php } ?>

        <form method="POST" class="mb-4">
            <input type="text" name="yazar_adi" placeholder="Yazar Adı" class="form-control mb-2" required>
            <button type="submit" class="btn btn-primary">Ekle</button>
        </form>

        <h4>Mevcut Yazarlar</h4>
        <table class="table table-bordered mt-2">
            <tr><th>Yazar Adı</th><th>İşlem</th></tr>
            <?php while($y = $yazarlar->fetch_assoc()){ ?>
                <tr>
                    <td><?= htmlspecialchars($y['yazar_adi']) ?></td>
                    <td>
                        <a href="yazarlar.php?delete=<?= $y['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Bu yazarı silmek istediğinize emin misiniz?')">
                           Sil
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>
