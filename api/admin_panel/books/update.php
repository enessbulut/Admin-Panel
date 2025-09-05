<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}
include '../common/db.php';

$id = $_GET['id'] ?? null;
if(!$id) header("Location: read.php");

$stmt = $conn->prepare("SELECT * FROM eser WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $baslik = $_POST['baslik'];
    $yazar_id = $_POST['yazar_id'];
    $yayinevi_id = $_POST['yayinevi_id'];
    $pdf_link = $_POST['pdf_link'];
    $kapak_resmi = $_POST['kapak_resmi'];
    $baski = $_POST['baski'];
    $tarih = $_POST['tarih'];

    $stmt = $conn->prepare("UPDATE eser SET baslik=?, yazar_id=?, yayinevi_id=?, pdf_link=?, kapak_resmi=?, baski=?, tarih=? WHERE id=?");
    $stmt->bind_param("siisssii", $baslik, $yazar_id, $yayinevi_id, $pdf_link, $kapak_resmi, $baski, $tarih, $id);
    $stmt->execute();

    header("Location: read.php");
    exit;
}
?>
<?php include '../common/header.php'; ?>
<h3>Kitap Güncelle</h3>
<form method="POST">
    <input type="text" name="baslik" class="form-control mb-2" value="<?= htmlspecialchars($book['baslik']) ?>" required>
    <input type="number" name="yazar_id" class="form-control mb-2" value="<?= $book['yazar_id'] ?>" required>
    <input type="number" name="yayinevi_id" class="form-control mb-2" value="<?= $book['yayinevi_id'] ?>" required>
    <input type="text" name="pdf_link" class="form-control mb-2" value="<?= $book['pdf_link'] ?>" required>
    <input type="text" name="kapak_resmi" class="form-control mb-2" value="<?= $book['kapak_resmi'] ?>">
    <input type="number" name="baski" class="form-control mb-2" value="<?= $book['baski'] ?>" required>
    <input type="date" name="tarih" class="form-control mb-2" value="<?= $book['tarih'] ?>" required>
    <button type="submit" class="btn btn-warning">Güncelle</button>
    <a href="read.php" class="btn btn-secondary">Geri</a>
</form>
<?php include '../common/footer.php'; ?>
