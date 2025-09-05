<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}
include '../common/db.php';

$id = $_GET['id'] ?? null;
if(!$id) header("Location: read.php");

$stmt = $conn->prepare("SELECT * FROM uye WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$member = $result->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ad = $_POST['ad'];
    $eposta = $_POST['eposta'];
    $kullanici_adi = $_POST['kullanici_adi'];
    $yas = $_POST['yas'];

    $stmt = $conn->prepare("UPDATE uye SET ad=?, eposta=?, kullanici_adi=?, yas=? WHERE id=?");
    $stmt->bind_param("sssii", $ad, $eposta, $kullanici_adi, $yas, $id);
    $stmt->execute();

    header("Location: read.php");
    exit;
}
?>
<?php include '../common/header.php'; ?>
<h3>Üye Güncelle</h3>
<form method="POST">
    <input type="text" name="ad" class="form-control mb-2" value="<?= htmlspecialchars($member['ad']) ?>" required>
    <input type="email" name="eposta" class="form-control mb-2" value="<?= htmlspecialchars($member['eposta']) ?>" required>
    <input type="text" name="kullanici_adi" class="form-control mb-2" value="<?= htmlspecialchars($member['kullanici_adi']) ?>" required>
    <input type="number" name="yas" class="form-control mb-2" value="<?= $member['yas'] ?>" required>
    <button type="submit" class="btn btn-warning">Güncelle</button>
    <a href="read.php" class="btn btn-secondary">Geri</a>
</form>
<?php include '../common/footer.php'; ?>
