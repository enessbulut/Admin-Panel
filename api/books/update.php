<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $query = "UPDATE eser SET 
                baslik = ?,
                yazar_id = ?,
                yayinevi_id = ?,
                pdf_link = ?,
                kapak_resmi = ?,
                tarih = ?
              WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "siisssi",
        $data->title,
        $data->author_id,
        $data->publisher_id,
        $data->pdf_url,
        $data->cover_url,
        $data->year,
        $data->id
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Kitap güncellendi."]);
    } else {
        echo json_encode(["success" => false, "message" => "Kitap güncellenemedi."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID gerekli."]);
}
?>
