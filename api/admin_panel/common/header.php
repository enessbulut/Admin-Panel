<?php
// Admin paneli sayfa başlığı ve navbar
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../admin_panel/books/read.php">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../admin_panel/books/read.php">Kitaplar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin_panel/members/read.php">Üyeler</a>
                </li>
            </ul>
            <span class="navbar-text">
                <a href="../admin_panel/logout.php" class="text-decoration-none text-light">Çıkış Yap</a>
            </span>
        </div>
    </div>
</nav>
<div class="container mt-4">
