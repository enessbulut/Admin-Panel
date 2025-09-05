<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, PUT, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit; }

include "../db.php";

$input = json_decode(file_get_contents("php://input"), true);
$id = intval($input['id'] ?? 0);
$yazar_adi   = isset($input['yazar_adi'])   ? trim($input['yazar_adi'])   : null;
$yazar_resmi = isset($input['yazar_resmi']) ? trim($input['yazar_resmi']) : null;

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Geçerli id zorunludur."]);
    exit;
}

$fields = [];
$params = [];
$types  = "";

if ($yazar_adi !== null)   { $fields[] = "yazar_adi=?";   $params[] = $yazar_adi;   $types .= "s"; }
if ($yazar_resmi !== null) { $fields[] = "yazar_resmi=?"; $params[] = $yazar_resmi; $types .= "s"; }

if (empty($fields)) {
    echo json_encode(["success" => false, "message" => "Güncellenecek alan yok."]);
    exit;
}

$sql = "UPDATE yazar SET " . implode(", ", $fields) . " WHERE id=?";
$params[] = $id;
$types   .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Yazar güncellendi."]);
} else {
    echo json_encode(["success" => false, "message" => "Güncelleme hatası: " . $stmt->error]);
}

$stmt->close();
$conn->close();
