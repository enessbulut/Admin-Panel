<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['baslik']) && !empty($data['yazar_id']) && !empty($data['yayinevi_id']) && !empty($data['pdf_link'])) {
    $query = "INSERT INTO eser (baslik, yazar_id, yayinevi_id, pdf_link, kapak_resmi, baski, tarih) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    $stmt->bind_param(
        "siissis",
        $data['baslik'],
        $data['yazar_id'],
        $data['yayinevi_id'],
        $data['pdf_link'],
        $data['kapak_resmi'],
        $data['baski'],
        $data['tarih']
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Kitap başarıyla eklendi."]);
    } else {
        echo json_encode(["success" => false, "message" => "Kitap eklenemedi: " . $stmt->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Eksik alanlar var."]);
}
?>
