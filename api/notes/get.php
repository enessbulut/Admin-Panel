<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$uye_id = intval($_GET['uye_id']);
$eser_id = intval($_GET['eser_id']);
$sayfa = intval($_GET['sayfa']);

$query = "SELECT id, icerik, olusturma_tarihi FROM notes 
          WHERE uye_id = $uye_id AND eser_id = $eser_id AND sayfa = $sayfa
          ORDER BY olusturma_tarihi DESC";

$result = $conn->query($query);

$notes = [];
while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
}

echo json_encode(["success" => true, "data" => $notes]);
?>
