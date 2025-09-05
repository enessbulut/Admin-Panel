<?php
header("Content-Type: application/json; charset=UTF-8");
include_once "../db.php";

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $query = "DELETE FROM yayinevi WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Yayınevi başarıyla silindi."]);
    } else {
        echo json_encode(["success" => false, "message" => "Yayınevi silinemedi."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Yayınevi ID gerekli."]);
}
?>
