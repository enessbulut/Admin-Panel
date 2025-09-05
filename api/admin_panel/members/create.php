<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}
include '../common/db.php';

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ad = $_POST['ad'];
    $eposta = $_POST['eposta'];
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);
    $yas = $_POST['yas'];

    $stmt = $conn->prepare("INSERT INTO uye (ad, eposta, kullanici_adi, sifre, yas) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $ad, $eposta, $kullanici_adi, $sifre, $yas);

    if($stmt->execute()){
        $message = "Üye başarıyla eklendi!";
    } else {
        $message = "Üye eklenemedi!";
    }
}
?>
<?php include '../common/header.php'; ?>
<h3>Yeni Üye Ekle</h3>
<?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>
<form method="POST">
    <input type="text" name="ad" class="form-control mb-2" placeholder="Ad" required>
    <input type="email" name="eposta" class="form-control mb-2" placeholder="Email" required>
    <input type="text" name="kullanici_adi" class="form-control mb-2" placeholder="Kullanıcı Adı" required>
    <input type="password" name="sifre" class="form-control mb-2" placeholder="Şifre" required>
    <input type="number" name="yas" class="form-control mb-2" placeholder="Yaş" required>
    <button type="submit" class="btn btn-success">Ekle</button>
</form>
<?php include '../common/footer.php'; ?>
