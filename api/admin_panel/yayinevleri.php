<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}

include __DIR__ . '/common/db.php'; 

// Yayınevi ekleme
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['yayinevi'])){
    $yayinevi = trim($_POST['yayinevi']);
    if($yayinevi != ""){
        $stmt = $conn->prepare("INSERT INTO yayinevi (yayinevi) VALUES (?)");
        $stmt->bind_param("s", $yayinevi);
        if($stmt->execute()){
            $message = "Yayınevi eklendi.";
        } else {
            $message = "Hata: " . $stmt->error;
        }
    } else {
        $message = "Yayınevi adı boş olamaz.";
    }
}

// Yayınevi silme
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM yayinevi WHERE id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        $message = "Yayınevi silindi.";
    } else {
        $message = "Hata: " . $stmt->error;
    }
}

// Mevcut yayınevlerini listeleme
$yayinevleri = $conn->query("SELECT * FROM yayinevi ORDER BY yayinevi ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yayınevleri</title>
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
        <h2>Yayınevleri</h2>

        <?php if(isset($message)){ ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php } ?>

        <form method="POST" class="mb-4">
            <input type="text" name="yayinevi" placeholder="Yayınevi Adı" class="form-control mb-2" required>
            <button type="submit" class="btn btn-primary">Ekle</button>
        </form>

        <h4>Mevcut Yayınevleri</h4>
        <table class="table table-bordered mt-2">
            <tr><th>Yayınevi</th><th>İşlem</th></tr>
            <?php while($p = $yayinevleri->fetch_assoc()){ ?>
                <tr>
                    <td><?= htmlspecialchars($p['yayinevi']) ?></td>
                    <td>
                        <a href="yayinevleri.php?delete=<?= $p['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Bu yayınevini silmek istediğinize emin misiniz?')">
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
