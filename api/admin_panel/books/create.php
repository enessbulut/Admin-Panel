<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}

include __DIR__ . '/../common/db.php'; 

// Yazar ve yayınevlerini çek
$yazarlar = $conn->query("SELECT id, yazar_adi FROM yazar ORDER BY yazar_adi ASC");
$yayinevleri = $conn->query("SELECT id, yayinevi FROM yayinevi ORDER BY yayinevi ASC");

// Kitap ekleme
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $baslik = trim($_POST['baslik']);
    $yazar_id = $_POST['yazar_id'];
    $yayinevi_id = $_POST['yayinevi_id'];
    $pdf_link = trim($_POST['pdf_link']);
    $baski = trim($_POST['baski']);
    $tarih = trim($_POST['tarih']);

    if($baslik != "" && $yazar_id && $yayinevi_id){
        $stmt = $conn->prepare("INSERT INTO eser (baslik, yazar_id, yayinevi_id, pdf_link, baski, tarih) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("siisss", $baslik, $yazar_id, $yayinevi_id, $pdf_link, $baski, $tarih);
        if($stmt->execute()){
            $message = "Kitap eklendi.";
        } else {
            $message = "Hata: " . $stmt->error;
        }
    } else {
        $message = "Başlık, Yazar ve Yayınevi alanları zorunludur.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yeni Kitap Ekle</title>
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
        <a href="../index.php">Dashboard</a>
        <a href="read.php">Kitaplar</a>
        <a href="../members/read.php">Üyeler</a>
        <a href="../yazarlar.php">Yazarlar</a>
        <a href="../yayinevleri.php">Yayınevleri</a>
        <a href="../logout.php">Çıkış</a>
    </div>

    <div class="flex-grow-1 p-4">
        <h2>Yeni Kitap Ekle</h2>

        <?php if(isset($message)){ ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label>Başlık</label>
                <input type="text" name="baslik" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Yazar</label>
                <select name="yazar_id" class="form-select" required>
                    <option value="">-- Yazar Seçin --</option>
                    <?php while($y = $yazarlar->fetch_assoc()){ ?>
                        <option value="<?= $y['id'] ?>"><?= htmlspecialchars($y['yazar_adi']) ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Yayınevi</label>
                <select name="yayinevi_id" class="form-select" required>
                    <option value="">-- Yayınevi Seçin --</option>
                    <?php while($p = $yayinevleri->fetch_assoc()){ ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['yayinevi']) ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label>PDF Link</label>
                <input type="text" name="pdf_link" class="form-control">
            </div>

            <div class="mb-3">
                <label>Baskı</label>
                <input type="text" name="baski" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tarih</label>
                <input type="date" name="tarih" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Ekle</button>
        </form>
    </div>
</div>
</body>
</html>
