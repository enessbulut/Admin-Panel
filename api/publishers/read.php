<?php
header("Content-Type: application/json; charset=UTF-8");
include_once "../db.php";

// Yayinevi tablosunu çekiyoruz
$query = "SELECT * FROM yayinevi";
$result = $conn->query($query);

$publishers = [];

while ($row = $result->fetch_assoc()) {
    $publishers[] = $row;
}

echo json_encode($publishers);
?>
