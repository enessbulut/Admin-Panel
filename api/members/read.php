<?php
include "../db.php";

// Veritabanındaki 'uye' tablosundan veri çekiyoruz
$result = $conn->query("SELECT id, ad AS name, eposta AS email, 'user' AS role FROM uye");
$members = [];
while($row = $result->fetch_assoc()) {
    $members[] = $row;
}
echo json_encode($members);
?>
