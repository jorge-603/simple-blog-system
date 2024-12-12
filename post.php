<?php
    require "config/connection.php";

    session_start();

    $error = null;

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        return;

    } else {
        $statement = $conn->prepare("SELECT * FROM admins WHERE id_user = :id_user");
        $statement->bindParam(":id_user", $_SESSION['user']['id_user']);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            http_response_code(403);
            header("Location: login.php");
        } else {
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (empty($_POST['title']) || empty($_POST['content'])) {
                    $error = "Por favor rellene todos los campos";
                } else {
                    $statement = $conn->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
                    $statement->bindParam(":title", $_POST['title']);
                    $statement->bindParam(":content", $_POST['content']);
                    $statement->execute();

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
    <title>Añadir Post</title>
    <link rel="stylesheet" href="assets/css/post.css">
</head>
<body>
    <div class="post-container">
        <h2>Añadir Post</h2>
        <form action="post.php" method="POST">
            <label for="title">Título del Post</label>
            <input name="title" type="text" placeholder="Escribe el título aquí" id="title" required>

            <label for="content">Contenido</label>
            <textarea name="content" rows="6" placeholder="Escribe el contenido del post" id="content" required></textarea>
            
            <button type="submit">Subir Post</button>
        </form>

        <div class="actions">
            <a href=".">Cancelar</a>
        </div>
    </div>
</body>
</html>
