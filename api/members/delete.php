<?php
include "../db.php";
$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];
$sql = "DELETE FROM uye WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Üye silindi"]);
} else {
    echo json_encode(["success" => false, "message" => "Silme başarısız"]);
}
?>
