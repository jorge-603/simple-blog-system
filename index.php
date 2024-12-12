<?php

include 'partials/header.php';
include 'partials/nav.php';
include 'lib/Parsedown.php';
include 'config/connection.php';

$posts = $conn->query("SELECT * FROM posts ORDER BY id_post DESC");

?>

<?php foreach ($posts as $post): ?>

    <div class="container">
        <div class="post">
            <h2><?= $post['title'] ?></h2>
            <?php if ($isAdmin) : ?>
                <a class="btn-adm" href="edit.php?id=<?= $post['id_post'] ?>">
                    Editar
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil">
                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                        <path d="m15 5 4 4" />
                    </svg>
                </a>
                <a class="btn-adm" href="delete.php?id=<?= $post['id_post'] ?>">
                    Eliminar
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                </a>
            <?php endif ?>
            <p class="date"><?= $post['post_date'] ?></p>
            <?php
            $contenido = $post['content'];
            $Parsedown = new Parsedown();
            echo $Parsedown->text($contenido);
            ?>
        </div>
    </div>

<?php endforeach ?>

<footer>
    <p>© 2024 Blog. Todos los derechos reservados.</p>
</footer>
</body>

</html>