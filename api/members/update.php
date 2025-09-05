<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];
$name = $data["name"];
$email = $data["email"];

$sql = "UPDATE uye SET ad=?, eposta=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $email, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Üye güncellendi"]);
} else {
    echo json_encode(["success" => false, "message" => "Hata oluştu: " . $stmt->error]);
}
?>
