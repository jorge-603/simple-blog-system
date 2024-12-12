<header>

    <?php
    session_start();
    include "config/connection.php";
    $isAdmin = false;
    ?>

    <div class="left">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-newspaper">
            <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" />
            <path d="M18 14h-8" />
            <path d="M15 18h-5" />
            <path d="M10 6h8v4h-8V6Z" />
        </svg>
        <h1>Blog</h1>
    </div>

    <div class="right">

        <?php if (!isset($_SESSION['user'])): ?>

            <a href="login.php">
                Iniciar sesion
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </a>

        <?php endif ?>

        <?php if (isset($_SESSION['user'])): ?>

            <?php
            $statement = $conn->prepare("SELECT * FROM admins WHERE id_user = :id_user");
            $statement->bindParam(":id_user", $_SESSION['user']['id_user']);
            $statement->execute();
            ?>

            <?php if ($statement->rowCount() > 0) : ?>
            <?php $isAdmin = true; ?>

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-cog">
                    <path d="M2 21a8 8 0 0 1 10.434-7.62" />
                    <circle cx="10" cy="8" r="5" />
                    <circle cx="18" cy="18" r="3" />
                    <path d="m19.5 14.3-.4.9" />
                    <path d="m16.9 20.8-.4.9" />
                    <path d="m21.7 19.5-.9-.4" />
                    <path d="m15.2 16.9-.9-.4" />
                    <path d="m21.7 16.5-.9.4" />
                    <path d="m15.2 19.1-.9.4" />
                    <path d="m19.5 21.7-.4-.9" />
                    <path d="m16.9 15.2-.4-.9" />
                </svg>
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round">
                    <circle cx="12" cy="8" r="5" />
                    <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
            <?php endif ?>
            <p><?php echo " " . $_SESSION['user']['username']?></p>

            <?php if($isAdmin): ?>
                <a href="post.php">
                    Subir post
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-plus">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8 12h8" />
                        <path d="M12 8v8" />
                    </svg>
                </a>
            <?php endif ?>

            <a href="logout.php">
                Cerrar sesion
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
            </a>

        <?php endif ?>
    </div>

</header>