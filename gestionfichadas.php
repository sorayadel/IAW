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
        try {
          $listado_fichadas = $listado_fichadas->cargar();
        } catch (Exception $e) {
          $_SESSION['error'] = $e->getMessage();
          header("Location: gestionfichadas.php");
          exit;
        }
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
          <tbody>
            <?php foreach ($listado_fichadas as $fichada): ?>
              <tr>
                <td>#</td>
                <td><?php echo $fichada["codigo"] ?></td>
                <td><?php echo $fichada["nombre"] ?></td>
                <td><?php echo $fichada["fecha"] ?></td>
                <td>
                  <?php if (isset($fichada["fichada_inicio_1"])): ?>
                    <?php echo $fichada["fichada_inicio_1"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (isset($fichada["fichada_fin_1"])): ?>
                    <?php echo $fichada["fichada_fin_1"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (isset($fichada["fichada_inicio_2"])): ?>
                    <?php echo $fichada["fichada_inicio_2"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (isset($fichada["fichada_fin_2"])): ?>
                    <?php echo $fichada["fichada_fin_2"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (isset($fichada["fichada_inicio_3"])): ?>
                    <?php echo $fichada["fichada_inicio_3"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (isset($fichada["fichada_fin_3"])): ?>
                    <?php echo $fichada["fichada_fin_3"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (isset($fichada["fichada_inicio_4"])): ?>
                    <?php echo $fichada["fichada_inicio_4"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (isset($fichada["fichada_fin_4"])): ?>
                    <?php echo $fichada["fichada_fin_4"]; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <a
                    href="gestionfichadas.php"
                    class="btn btn-warning btn-sm">
                    Editar</a>
                  <a
                    href="gestionfichadas.php"
                    class="btn btn-danger btn-sm">
                    Borrar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>