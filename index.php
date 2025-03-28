<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php require_once "headContenido.php"; ?>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php require_once "cabecera.php"; ?>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
          </div>
        <?php endif; ?>

        <h1>Login</h1>

        <?php
        if (isset($_POST['login'])) {
          if (empty($_POST['email']) || empty($_POST['pass'])) {
            $_SESSION["error"] = "La contraseña y el email no pueden estar vacíos";
            header("Location: index.php");
            die;
          }

          require 'clsUsuario.php';
          $usuario = new Usuario();
          $usuario->setEmail($_POST['email']);
          $hashpass = md5($_POST['pass']);
          $usuario->setPass($hashpass);

          try {
            $respuesta = $usuario->login();
            if (!$respuesta) throw new Exception("El usuario no es correcto o no existe");
          } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            header("Location: index.php");
            die;
          }

          if ($respuesta) {
            if (!isset($_SESSION['usuario'])) {
              $_SESSION['usuario']["id"] = $usuario->getId();
              $_SESSION['usuario']["nombre"] = $usuario->getNombre();
              $_SESSION['usuario']["email"] = $usuario->getEmail();
              $_SESSION['usuario']["codigo"] = $usuario->getCodigo();
              $_SESSION['usuario']["horas"] = $usuario->getHoras();
              $_SESSION['usuario']["rol"] = $usuario->getRol();

              if ($usuario->getRol() == 'admin') {
                header('Location: gestionfichadas.php');
              } else {
                header('Location: fichar.php');
              }
            }
          }
        }
        ?>
        <form method="POST" name="login">
          <div>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div>
            <label for="pass" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="pass">
          </div>
          <button type="submit" class="btn btn-primary mt-2" name="login" value="login" required>Login</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>