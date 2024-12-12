<?php

require "config/connection.php";

$error = null;

session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])){
        $error = "Por favor rellene todos los campos.";
    } else if (!str_contains($_POST['email'], '@')) {
        $error = "El formato de correo es inválido.";
    } else {
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindParam(":email", $_POST['email']);
        $statement->execute();

        if($statement->rowCount() > 0){
            $error = "Este correo ya ha sido registrado.";
        } else {
            
            # Comprobacion de usuario duplicado

            $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $statement->bindParam(":username", $_POST['username']);
            $statement->execute();

            if($statement->rowCount() > 0) {

                $error = "El nombre de usuario ya ha sido utilizado";

            } else {

                $conn->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)")
                ->execute([
                    ":username" => $_POST['username'],
                    ":email" => $_POST['email'],
                    ":password" => password_hash($_POST['password'], PASSWORD_BCRYPT),
                ]);

                $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
                $statement->bindParam(":email", $_POST['email']);
                $statement->execute();
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                session_start();
                $_SESION['user'] = $user;

                header("Location: index.php");

            }

        }

    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <div class="login-container">
        <h2>Registrarse</h2>
        <form action="register.php" method="POST">
            <input id="email" type="text" placeholder="Correo Electrónico" name="email" required>
            <input id="username" type="text" placeholder="Usuario" name="username" required>
            <input id="password" type="password" placeholder="Contraseña" name="password" required>
            <button type="submit">Registrarse</button>
            <?php if ($error) : ?>
            <p class="text-error">
                <?= $error ?>
            </p>
            <?php endif ?>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>
