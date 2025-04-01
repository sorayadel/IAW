<!DOCTYPE html>
<html lang="es">

<head>
  <?php require_once "headContenido.php"; ?>
</head>

<body>
  <?php require_once "cabecera.php"; ?>

  <?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  require_once "clsUsuario.php";
  require_once "clsHistoricoFichadas.php";

  if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    die;
  }

  $usuario = new Usuario();
  $usuario->cargar($_SESSION["usuario"]["id"]);
  ?>

  <div class="container">
    <div class="row">
      <div class="col-12">
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

        <?php if (isset($_GET["accion"]) && $_GET["accion"] === "fichar"): ?>
          <?php
          // $fichada = new HistoricoFichadas();

          // try {
          //   $respuestaFichar = $fichada->crear($usuario->getId());
          // } catch (Exception $e) {
          //   $_SESSION["error"] = $e->getMessage();
          //   header("Location: fichar.php");
          //   die;
          // }

          // if ($respuestaFichar) {
          //   $_SESSION["mensaje"] = "Fichada registrada correctamente.";
          // }

          header("Location: fichar.php");
          die;
          ?>
        <?php endif; ?>
        <h1>Mis fichadas</h1>
        <div class="bievenida">
          ¡Hola, <strong><?php echo $usuario->getNombre() ?></strong>!
        </div>
        <div class="mt-3">
          <form
            method="POST"
            action="fichar.php?accion=fichar">
            <button
              class="btn btn-lg btn-primary"
              type="submit">
              Fichar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>