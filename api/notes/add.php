<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

$uye_id = intval($data['uye_id']);
$eser_id = intval($data['eser_id']);
$sayfa = intval($data['sayfa']);
$icerik = $conn->real_escape_string($data['icerik']);

$insert = "INSERT INTO notes (uye_id, eser_id, sayfa, icerik) VALUES ($uye_id, $eser_id, $sayfa, '$icerik')";
if ($conn->query($insert)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}
?>
