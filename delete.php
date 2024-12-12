<?php 
    require "config/connection.php";

    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    } else {
        $id_user = $_SESSION['user']['id_user'];

        $statement = $conn->prepare("SELECT * FROM admins WHERE id_user = :id_user");
        $statement->bindParam(":id_user", $id_user);
        $statement->execute();

        if($statement->rowCount() == 0) {
            http_response_code(403);
            header("Location: login.php");
            return;
        } else {

            $id = $_GET['id'];

            $statement = $conn->prepare("DELETE FROM posts WHERE id_post = :id");
            $statement->bindParam(":id", $id);
            $statement->execute();

            header("Location: index.php");
        }
    }
?>