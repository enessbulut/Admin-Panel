<?php
session_start();
include 'common/db.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Örnek admin kontrolü (dilersen tabloya bağlayabilirsin)
    if($username == "admin" && $password == "123456"){
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Kullanıcı adı veya parola yanlış!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card p-4 shadow">
                <h3 class="text-center mb-3">Admin Giriş</h3>
                <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="POST">
                    <input type="text" name="username" class="form-control mb-3" placeholder="Kullanıcı Adı" required>
                    <input type="password" name="password" class="form-control mb-3" placeholder="Parola" required>
                    <button type="submit" name="login" class="btn btn-primary w-100">Giriş Yap</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
