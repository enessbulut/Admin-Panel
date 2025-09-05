<?php
include 'common/db.php'; // db.php yolunu doğru yaz

$result = $conn->query("SELECT * FROM uye");

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "ID: ".$row['id']." - Ad: ".$row['ad']." - Email: ".$row['eposta']."<br>";
    }
} else {
    echo "Hiç üye yok veya sorgu hatalı!";
}
?>
