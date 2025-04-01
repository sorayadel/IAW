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
        require_once "clsHistoricoFichadas.php";
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

        $historico_fichadas = new HistoricoFichadas();

        try {
          $fichadas_usuario = $historico_fichadas->cargar($usuario->getId());
        } catch (Exception $e) {
          $_SESSION['error'] = $e->getMessage();
          header("Location: gestionhistoricofichadas.php");
          die;
        }
        ?>

        <div class="row">
          <div class="col-12">
            <div class="card mt-3">
              <div class="card-body">
                <h5>Historico fichadas</h5>
                <table class="table table-striped mt-3">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Procesada</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php foreach ($fichadas_usuario as $fichada): ?>
                      <tr>
                        <td><?php echo $fichada["fecha"]  ?></td>
                        <td><?php echo $usuario->getCodigo() ?></td>
                        <td><?php echo $usuario->getNombre() ?></td>
                        <td><?php echo $fichada["procesada"] ?></td>
                        <td>
                          <a
                            href="#"
                            class="btn btn-warning btn-sm">
                            Editar</a>
                          <a
                            href="#"
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
        </div>
      </div>
    </div>
  </div>
</body>

</html>