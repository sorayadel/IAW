<!DOCTYPE html>
<html lang="es">

<head>
  <?php require_once "headContenido.php"; ?>
</head>

<body>
  <?php require_once "cabecera.php"; ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }

        if (!isset($_SESSION["usuario"])) {
          header("Location: index.php");
          die;
        }

        if ($_SESSION["usuario"]["rol"] !== "admin") {
          header("Location: fichar.php");
          die;
        }

        require_once "clsUsuario.php";
        require_once "clsFichadas.php";
        ?>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
          </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensaje'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['mensaje']; ?>
            <?php unset($_SESSION['mensaje']); ?>
          </div>
        <?php endif; ?>
        
        <?php
        $usuario = new Usuario();
        $usuario->cargar($_SESSION["usuario"]["id"]);

        $listado_fichadas = new Fichadas();
        ?>

        <h1>Listado fichadas</h1>
        <table class="table table-striped mt-3">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Fecha</th>
              <th>Inicio 1</th>
              <th>Fin 1</th>
              <th>Inicio 2</th>
              <th>Fin 2</th>
              <th>Inicio 3</th>
              <th>Fin 3</th>
              <th>Inicio 4</th>
              <th>Fin 4</th>
              <th>Tiempo</th>
            </tr>
          </thead>
      </div>
    </div>
  </div>
</body>

</html>