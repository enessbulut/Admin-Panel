<?php
header("Content-Type: application/json; charset=UTF-8");
include_once "../db.php";

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name)) {
    $query = "INSERT INTO yayinevi (yayinevi) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $data->name);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Yayınevi başarıyla eklendi."]);
    } else {
        echo json_encode(["success" => false, "message" => "Yayınevi eklenemedi."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Yayınevi adı boş olamaz."]);
}
?>
