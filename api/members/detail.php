<?php
header("Content-Type: application/json; charset=UTF-8");
include __DIR__ . '/../common/db.php';  // <-- senin db bağlantı dosyan

// Kullanıcı ID parametresi
if (!isset($_GET['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Kullanıcı ID belirtilmedi"
    ]);
    exit;
}

$userId = intval($_GET['id']);

// Veritabanından kullanıcı bilgilerini çek
$stmt = $conn->prepare("SELECT id, ad, eposta, kullanici_adi, yas FROM uye WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "data" => $row
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Kullanıcı bulunamadı"
    ]);
}

$stmt->close();
$conn->close();
?>
