<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}
include '../common/db.php';

$id = $_GET['id'] ?? null;
if($id){
    // Önce okuma_izleme tablosundaki ilişkili kayıtların eser_id'sini NULL yap
    $stmt1 = $conn->prepare("UPDATE okuma_izleme SET eser_id = NULL WHERE eser_id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->close();

    // Ardından kitabı sil
    $stmt2 = $conn->prepare("DELETE FROM eser WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();
}

header("Location: read.php");
exit;
?>
