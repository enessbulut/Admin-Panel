<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "ID eksik"]);
    exit;
}

$bookId = intval($_GET['id']);

$query = "SELECT e.id, e.baslik, e.sayfa_sayisi, e.baski, e.tarih, e.kapak_resmi, e.pdf_link,
                 y.yazar_adi AS author, p.yayinevi AS publisher
          FROM eser e
          LEFT JOIN yazar y ON e.yazar_id = y.id
          LEFT JOIN yayinevi p ON e.yayinevi_id = p.id
          WHERE e.id = $bookId
          LIMIT 1";

$result = $conn->query($query);

if (!$result) {
    echo json_encode(["success" => false, "message" => "Sorgu hatası: " . $conn->error]);
    exit;
}

$book = $result->fetch_assoc();

if ($book) {
    // PDF linkini Windows yolu yerine URL yapıyoruz 
    if (!empty($book['pdf_link'])) {
        $book['pdf_link'] = "http://10.0.2.2/api/books/pdf/" . basename($book['pdf_link']);
    }

    echo json_encode(["success" => true, "data" => $book]);
} else {
    echo json_encode(["success" => false, "message" => "Kitap bulunamadı"]);
}
?>
