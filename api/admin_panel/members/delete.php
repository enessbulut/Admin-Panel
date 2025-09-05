<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}
include '../common/db.php';

$id = $_GET['id'] ?? null;
if($id){
    $stmt = $conn->prepare("DELETE FROM uye WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: read.php");
exit;
