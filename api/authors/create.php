<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

include "../db.php";

$input = json_decode(file_get_contents("php://input"), true);
$yazar_adi   = trim($input['yazar_adi'] ?? '');
$yazar_resmi = trim($input['yazar_resmi'] ?? '');

if ($yazar_adi === '') {
    echo json_encode(["success" => false, "message" => "yazar_adi zorunludur."]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO yazar (yazar_adi, yazar_resmi) VALUES (?, ?)");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Hazırlama hatası: " . $conn->error]);
    exit;
}

$stmt->bind_param("ss", $yazar_adi, $yazar_resmi);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Yazar eklendi.",
        "id" => $stmt->insert_id
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Ekleme hatası: " . $stmt->error]);
}

$stmt->close();
$conn->close();
