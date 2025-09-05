<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$query = "SELECT e.id, e.baslik, e.tarih, e.pdf_link, e.kapak_resmi,
                 y.yazar_adi AS author, p.yayinevi AS publisher
          FROM eser e
          LEFT JOIN yazar y ON e.yazar_id = y.id
          LEFT JOIN yayinevi p ON e.yayinevi_id = p.id
          ORDER BY e.id DESC";

$result = $conn->query($query);

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => "Sorgu hatası: " . $conn->error
    ]);
    exit;
}

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

if (count($books) > 0) {
    echo json_encode([
        "success" => true,
        "data" => $books
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Kayıt bulunamadı"
    ]);
}
?>
