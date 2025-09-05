<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

include "../db.php";

// Sorgu ve hata kontrolü ekleyelim
$sql = "SELECT id, yazar_adi, yazar_resmi FROM yazar ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["success" => false, "message" => "Sorgu hatası: " . $conn->error]);
    exit;
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode(["success" => true, "data" => $rows]);
$conn->close();
