
<?php
// Veritabanı bağlantısı (mysqli)
$host = "localhost"; // MySQL sunucu
$user = "root";      // Kullanıcı adı
$pass = "";          // Şifre
$db   = "eser_app";  // Veritabanı adı

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Veritabanına bağlanılamadı: " . $conn->connect_error]));
}

// Karakter seti UTF-8
$conn->set_charset("utf8");
?>
