<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "eser_app";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
