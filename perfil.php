<!DOCTYPE html>
<html lang="es">

<head>
  <?php require_once "headContenido.php"; ?>
</head>

<body>
  <?php
  require_once "cabecera.php";
  ?>
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

        require_once "clsUsuario.php";
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
        ?>

        <?php if (isset($_GET["accion"]) && $_GET["accion"] === "editar_contrasena"): ?>
          <?php
          if (isset($_GET["id"])) {
            $usuario_contrasena_actual = $usuario->getPass();
            $contrasena_actual = $_POST["contrasena_actual"];
            $contrasena_nueva = $_POST["contrasena_nueva"];
            $contrasena_nueva_rep = $_POST["contrasena_nueva_rep"];

            try {
              $respuestaEditar = $usuario->editarContrasena(
                $_GET["id"],
                $contrasena_actual,
                $contrasena_nueva,
                $contrasena_nueva_rep
              );

            } catch (Exception $e) {
              $_SESSION["error"] = $e->getMessage();
              header("Location: perfil.php");
              die;
            }
            
            if (!$respuestaEditar) {
              $_SESSION["error"] = "Error al editar la contraseña";
              header("Location: perfil.php");
              die;
            } else {
              $_SESSION["mensaje"] = "Contraseña actualizada con éxito";
              header("Location: perfil.php");
              die;
            }
          }
          ?>
        <?php endif; ?>

        <div class="card mt-3">
          <div class="card-body">
            <h5 class="card-title">Mis datos</h5>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input
                type="text"
                class="form-control"
                id="nombre"
                name="nombre"
                disabled
                <?php if (isset($usuario)): ?>value="<?php echo $usuario->getNombre() ?>" <?php endif; ?>>
            </div>
            <div class="form-group">
              <label for="codigo">Código</label>
              <input
                type="number"
                class="form-control"
                id="codigo"
                name="codigo"
                disabled
                <?php if (isset($usuario)): ?>value="<?php echo $usuario->getCodigo() ?>" <?php endif; ?>>
            </div>
            <div class="form-group">
              <label for="horas">Horas</label>
              <input
                type="number"
                class="form-control"
                id="horas"
                name="horas"
                disabled
                <?php if (isset($usuario)): ?>value="<?php echo $usuario->getHoras() ?>" <?php endif; ?>>
            </div>
            <div class="form-group">
              <label for="email">E-mail</label>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                disabled
                <?php if (isset($usuario)): ?>value="<?php echo $usuario->getEmail() ?>" <?php endif; ?>>
            </div>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <h5 class="card-title">Modificar contraseña</h5>
            <form
              method="POST"
              action="perfil.php?accion=editar_contrasena&id=<?php echo $usuario->getId() ?>">
              <div class="form-group">
                <label for="contrasena_actual">Contraseña actual *</label>
                <input
                  type="password"
                  class="form-control"
                  id="contrasena_actual"
                  name="contrasena_actual"
                  required
                >
              </div>
              <div class="form-group">
                <label for="contrasena_nueva">Nueva contraseña *</label>
                <input
                  type="password"
                  class="form-control"
                  id="contrasena_nueva"
                  name="contrasena_nueva"
                  required
                >
              </div>
              <div class="form-group">
                <label for="contrasena_nueva_rep">Repite tu nueva contraseña *</label>
                <input
                  type="password"
                  class="form-control"
                  id="contrasena_nueva_rep"
                  name="contrasena_nueva_rep"
                  required
                >
              </div>
              <button type="submit" class="btn btn-primary mt-3">
                Enviar
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>
    
  </div>
</body>

</html>