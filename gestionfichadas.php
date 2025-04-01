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

        if($_SESSION["usuario"]["rol"] !== "admin") {
          header("Location: fichar.php");
          die;
        }

        require_once "clsUsuario.php";
        ?>

        Hola administrador
      </div>
    </div>
  </div>
</body>

</html>