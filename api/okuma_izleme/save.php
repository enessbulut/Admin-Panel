<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

$uye_id = intval($data['uye_id']);
$eser_id = intval($data['eser_id']);
$bitis_sayfasi = intval($data['bitis_sayfasi']);

// Önce kontrol et, varsa güncelle
$query_check = "SELECT id FROM okuma_izleme WHERE uye_id = $uye_id AND eser_id = $eser_id LIMIT 1";
$result = $conn->query($query_check);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $update = "UPDATE okuma_izleme SET bitis_sayfasi = $bitis_sayfasi WHERE id = $id";
    $conn->query($update);
} else {
    $insert = "INSERT INTO okuma_izleme (baslanilan_sayfa, bitis_sayfasi, eser_id, uye_id)
               VALUES (0, $bitis_sayfasi, $eser_id, $uye_id)";
    $conn->query($insert);
}

echo json_encode(["success" => true]);
?>
