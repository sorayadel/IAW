<header class="mb-3 bg-light p-3">
  <?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  ?>

  <div>
    <h1>Salle Presencia</h1>
  </div>

  <div class="row">
    <div class="col-6">
      <?php if (!isset($_SESSION["usuario"])): ?>
        <nav class="nav">
          <a class="nav-link" href="index.php">Login</a>
        </nav>
      <?php endif; ?>
      <?php if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"] === "admin"): ?>
        <nav class="nav">
          <a class="nav-link" href="gestionusuarios.php">Listado usuarios</a>
          <a class="nav-link" href="gestionfichadas.php">Gestion fichadas</a>
        </nav>
      <?php elseif (isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"] === "user"): ?>
        <nav class="nav">
          <a class="nav-link" href="fichar.php">Mis fichadas</a>
        </nav>
      <?php endif; ?>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-center">
      <?php if (isset($_SESSION["usuario"])): ?>
        <a href="perfil.php" class="btn btn-outline-success me-2">
          Información usuario: <?php echo $_SESSION["usuario"]["email"] ?>
        </a>
        <a href="logout.php" class="btn btn-outline-danger">
          Logout
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>