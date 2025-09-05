<?php
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);
$eposta = $data["eposta"] ?? '';
$sifre = $data["sifre"] ?? '';

$sql = "SELECT * FROM uye WHERE eposta=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $eposta);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($sifre, $user["sifre"])) {
        echo json_encode([
            "success" => true,
            "user" => [
                "id" => $user["id"],
                "ad" => $user["ad"],
                "eposta" => $user["eposta"],
                "kullanici_adi" => $user["kullanici_adi"]
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Hatalı şifre"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Kullanıcı bulunamadı"]);
}
?>
