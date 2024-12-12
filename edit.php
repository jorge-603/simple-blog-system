<?php

require "config/connection.php";

session_start();

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
        return;
    } else {

        $statement = $conn->prepare("SELECT * FROM posts WHERE id_post = :id_post");
        $statement->bindParam(":id_post", $_GET['id']);
        $statement->execute();
    
        $post = $statement->fetch(PDO::FETCH_ASSOC);

        $id_post = $_GET['id'];

        $error = null;


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['title']) || empty($_POST['content'])) {
                $error = "Por favor rellene todos los campos";
            } else {
                $title = $_POST['title'];
                $content = $_POST['content'];

                $statement = $conn->prepare("UPDATE posts SET title = :title, content = :content WHERE id_post = :id_post");
                $statement->bindParam(":id_post", $id_post);
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
    <link rel="stylesheet" href="assets/css/edit.css">
    <title>Añadir Post</title>
</head>

<body>
    <div class="post-container">
        <h2>Editar Post</h2>
        <form action="edit.php?id=<?= $id_post ?>" method="POST">
            <label for="title">Título del Post</label>
            <input value="<?= $post['title'] ?>" name="title" type="text" placeholder="Escribe el título aquí" id="title" required>

            <label for="content">Contenido</label>
            <textarea name="content" rows="6" placeholder="Escribe el contenido del post" id="content" required><?= $post['content'] ?></textarea>

            <button type="submit">Editar Post</button>
        </form>

        <div class="actions">
            <a href=".">Cancelar</a>
        </div>
    </div>
</body>

</html>