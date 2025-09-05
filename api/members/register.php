<?php
// Hataları kapat ve JSON çıktısı ayarla
error_reporting(0);
ini_set('display_errors', 0);
header("Content-Type: application/json; charset=UTF-8");

// Veritabanı bağlantısı
include '../db.php';

// Flutter'dan gelen JSON verisini oku
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Alanları al
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$age = $data['age'] ?? null;            
$gender = $data['gender'] ?? '';        

// Basit doğrulama
if ($name == '' || $email == '' || $password == '' || $age === null || $gender == '') {
    echo json_encode(["success" => false, "message" => "Tüm alanları doldurun"]);
    exit;
}

// Cinsiyet kontrolü (sadece Erkek veya Kadın)
if(!in_array($gender, ['Erkek', 'Kadın'])){
    echo json_encode(["success" => false, "message" => "Cinsiyet geçersiz"]);
    exit;
}

// Şifreyi hashle
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Kayıt sorgusu
$sql = "INSERT INTO uye (ad, eposta, sifre, yas, cinsiyet) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssis", $name, $email, $hashed_password, $age, $gender);

// Sorguyu çalıştır ve JSON olarak yanıt dön
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Kayıt başarılı"]);
} else {
    echo json_encode(["success" => false, "message" => "Kayıt yapılamadı: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
