<header>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    var_dump($_SESSION);
    ?>

    <div>
        <h1>Salle Presencia</h1>
    </div>

    <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["rol"] === "admin"): ?>
        <ul>
            <li>Listado usuarios</li>
            <li>Listado fichadas</li>
        </ul>
    <?php elseif (isset($_SESSION["user"]) && $_SESSION["user"]["rol"] === "user"): ?>
        <ul>
            <li>Mis fichadas</li>
        </ul>
    <?php endif; ?>

    <?php if (isset($_SESSION["user"])): ?>
        Información usuario: info@test.com
        <a href="logout.php" class="btn btn-primary">
            Logout
        </a>
    <?php endif; ?>
</header>