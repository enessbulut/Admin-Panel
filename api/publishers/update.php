<?php
header("Content-Type: application/json; charset=UTF-8");
include_once "../db.php";

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->yayinevi)) {
    $query = "UPDATE yayinevi SET yayinevi=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $data->yayinevi, $data->id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Yayınevi başarıyla güncellendi."]);
    } else {
        echo json_encode(["success" => false, "message" => "Yayınevi güncellenemedi."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID ve yeni isim gerekli."]);
}
?>
