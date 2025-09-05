<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

include "../db.php";

$input = json_decode(file_get_contents("php://input"), true);
$id = isset($input['id']) ? intval($input['id']) : 0;

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Geçerli id zorunludur."]);
    exit;
}

// Prepare kontrolü ekleyelim
$stmt = $conn->prepare("DELETE FROM yazar WHERE id=?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Hazırlama hatası: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Yazar silindi."]);
    } else {
        echo json_encode(["success" => false, "message" => "Silinecek yazar bulunamadı."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Silme hatası: " . $stmt->error]);
}

$stmt->close();
$conn->close();
