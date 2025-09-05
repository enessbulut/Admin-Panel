<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['id'])) {
    $query = "DELETE FROM eser WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $data['id']);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Kitap silindi."]);
    } else {
        echo json_encode(["success" => false, "message" => "Kitap silinemedi: " . $stmt->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID gerekli."]);
}
?>
