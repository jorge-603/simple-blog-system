<?php

require "config/connection.php";

$error = null;

session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username'] || $_POST['password'])) {
        $error = "Por favor rellene todos los campos";
    } else {
        $statement = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $statement->bindParam(":username", $_POST['username']);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $error = "Credenciales incorrectas.";
        } else {
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($_POST['password'], $user['password'])) {
                $error = "Credenciales incorrectas";
            } else {
                session_start();
                unset($user['password']);
                $_SESSION['user'] = $user;
                header("Location: index.php");
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es_MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <input name="username" type="text" placeholder="Usuario" id="username" required>
            <input name="password" type="password" placeholder="Contraseña" id="password" required>
            <button type="submit">Acceder</button>
        </form>
        <? if ($error): ?>
            <p class="text-error">
                <?= $error ?>
            </p>
        <? endif ?>
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
    </div>
</body>

</html>