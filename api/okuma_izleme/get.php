<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';

$uye_id = intval($_GET['uye_id']);
$eser_id = intval($_GET['eser_id']);

$query = "SELECT bitis_sayfasi FROM okuma_izleme WHERE uye_id = $uye_id AND eser_id = $eser_id LIMIT 1";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode(["bitis_sayfasi" => intval($row['bitis_sayfasi'])]);
} else {
    echo json_encode(["bitis_sayfasi" => 0]);
}
?>
