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
        require_once "clsUsuario.php";
        if($_SESSION["usuario"]["rol"] !== "admin") {
          header("Location: fichar.php");
          die;
        }
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

        <?php if (isset($_GET["accion"]) && $_GET["accion"] === "crear"): ?>
          <?php
          if (
            !empty($_POST["nombre"]) &&
            isset($_POST["codigo"]) &&
            isset($_POST["horas"]) &&
            !empty($_POST["email"]) &&
            !empty($_POST["contrasena"]) &&
            !empty($_POST["rol"])
          ) {
            $nuevo_usuario = new Usuario();
            $respuestaCrear = $nuevo_usuario->crear(
              $_POST["nombre"],
              $_POST["codigo"],
              $_POST["horas"],
              $_POST["email"],
              $_POST["contrasena"],
              $_POST["rol"]
            );

            if (!$respuestaCrear) {
              $_SESSION["error"] = "El usuario ya existe";
              header("Location: gestionusuarios.php");
              die;
            } else {
              $_SESSION["mensaje"] = "Usuario creado con éxito";
              header("Location: gestionusuarios.php");
              die;
            }
          }
          ?>
        <?php elseif (isset($_GET["accion"]) && $_GET["accion"] === "cargar_editar"): ?>
          <?php
          if (isset($_GET["id"])) {
            $usuario_c_e = new Usuario();
            $usuario_c_e->cargar($_GET["id"]);
          }
          ?>
        <?php elseif (isset($_GET["accion"]) && $_GET["accion"] === "editar"): ?>
          <?php
          if (isset($_GET["id"])) {
            $usuario_editar = new Usuario();
            $respuestaEditar = $usuario_editar->editar(
              $_GET["id"],
              [
                "nombre" => $_POST["nombre"],
                "codigo" => $_POST["codigo"],
                "horas" => $_POST["horas"],
                "email" => $_POST["email"],
                "contrasena" => $_POST["contrasena"],
                "rol" => $_POST["rol"]
              ]
            );

            if (!$respuestaEditar) {
              $_SESSION["error"] = "Error al editar el usuario";
              header("Location: gestionusuarios.php");
              die;
            } else {
              $usuario_actualizado = new Usuario();
              $usuario_actualizado->cargar($_GET["id"]);
              $_SESSION['usuario']["id"] = $usuario_actualizado->getId();
              $_SESSION['usuario']["nombre"] = $usuario_actualizado->getNombre();
              $_SESSION['usuario']["email"] = $usuario_actualizado->getEmail();
              $_SESSION['usuario']["codigo"] = $usuario_actualizado->getCodigo();
              $_SESSION['usuario']["horas"] = $usuario_actualizado->getHoras();
              $_SESSION['usuario']["rol"] = $usuario_actualizado->getRol();
              $_SESSION["mensaje"] = "Usuario actualizado con éxito";
              header("Location: gestionusuarios.php");
              die;
            }
          }
          ?>
        <?php elseif (isset($_GET["accion"]) && $_GET["accion"] === "eliminar"): ?>
          <?php
          if (isset($_GET["id"])) {
            if ($_SESSION["usuario"]["id"] === (int) $_GET["id"]) {
              $_SESSION["error"] = "No puedes eliminar tu propio usuario";
              header("Location: gestionusuarios.php");
              die;
            } else {
              $usuario_eliminar = new Usuario();
              $usuario_eliminar->eliminar((int) $_GET["id"]);
              $_SESSION["mensaje"] = "Usuario eliminado con éxito";
              header("Location: gestionusuarios.php");
              die;
            }
          }
          ?>
        <?php endif; ?>

        <div class="card mt-3">
          <div class="card-body">
            <form
              method="POST"
              <?php if (isset($usuario_c_e)): ?>
              action="gestionusuarios.php?accion=editar&id=<?php echo $usuario_c_e->getId() ?>"
              <?php else: ?>
              action="gestionusuarios.php?accion=crear"
              <?php endif; ?>>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  name="nombre"
                  maxlength="255"
                  required
                  <?php if (isset($usuario_c_e)): ?>value="<?php echo $usuario_c_e->getNombre() ?>" <?php endif; ?>>
              </div>
              <div class="form-group">
                <label for="codigo">Código</label>
                <input
                  type="number"
                  class="form-control"
                  id="codigo"
                  name="codigo"
                  required
                  <?php if (isset($usuario_c_e)): ?>value="<?php echo $usuario_c_e->getCodigo() ?>" <?php endif; ?>>
              </div>
              <div class="form-group">
                <label for="horas">Horas</label>
                <input
                  type="number"
                  class="form-control"
                  id="horas"
                  name="horas"
                  required
                  <?php if (isset($usuario_c_e)): ?>value="<?php echo $usuario_c_e->getHoras() ?>" <?php endif; ?>>
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  required
                  <?php if (isset($usuario_c_e)): ?>value="<?php echo $usuario_c_e->getEmail() ?>" <?php endif; ?>>
              </div>
              <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input
                  type="password"
                  class="form-control"
                  id="contrasena"
                  name="contrasena"
                  <?php if (!isset($usuario_c_e)): ?>required<?php endif; ?>>
              </div>
              <div class="form-group">
                <label for="rol">Rol</label>
                <select
                  class="form-control"
                  id="rol"
                  name="rol"
                  <?php if (isset($usuario_c_e) && $usuario_c_e->getId() === $_SESSION["usuario"]["id"]): ?>disabled<?php endif; ?>
                >
                  <option
                    value="user"
                    <?php if (isset($usuario_c_e) && $usuario_c_e->getRol() === "user"): ?>selected<?php endif; ?>>
                    Usuario
                  </option>
                  <option
                    value="admin"
                    <?php if (isset($usuario_c_e) && $usuario_c_e->getRol() === "admin"): ?>selected<?php endif; ?>>
                    Admin
                  </option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary mt-3">
                <?php if (isset($usuario_c_e)): ?>
                  Editar usuario
                <?php else: ?>
                  Crear usuario
                <?php endif; ?>
              </button>
            </form>
          </div>
        </div>

        <?php
        $usuario = new Usuario();
        $listado_usuarios = $usuario->listar();
        ?>

        <table class="table table-striped mt-3">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Código</th>
              <th>Horas</th>
              <th>E-mail</th>
              <th>Rol</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($listado_usuarios as $usuario_tabla): ?>
              <tr>
                <td><?php echo $usuario_tabla["nombre"] ?></td>
                <td><?php echo $usuario_tabla["codigo"] ?></td>
                <td><?php echo $usuario_tabla["horas"] ?></td>
                <td><?php echo $usuario_tabla["email"] ?></td>
                <td><?php echo $usuario_tabla["rol"] ?></td>
                <td>
                  <a
                    href="gestionusuarios.php?id=<?php echo $usuario_tabla["id"] ?>&amp;accion=cargar_editar"
                    class="btn btn-warning btn-sm">
                    Editar</a>
                  <a
                    href="gestionusuarios.php?id=<?php echo $usuario_tabla["id"] ?>&amp;accion=eliminar"
                    class="btn btn-danger btn-sm <?php if ($usuario_tabla["id"] === $_SESSION["usuario"]["id"]): ?>disabled<?php endif; ?>">
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