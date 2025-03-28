<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
  unset($_SESSION['error']);
?>

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

            <?php if ($error): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
              </div>
            <?php endif; ?>

            <h1>Login</h1>

            <?php
              if (isset($_POST['login'])) {
                if(empty($_POST['email']) || empty($_POST['pass'])) {
                  $_SESSION["error"] = "La contraseña y el email no pueden estar vacíos";
                  header("Location: index.php");
                  die;
                }
                
                require 'clsUsuario.php';
                $user = new Usuario();
                $user->setEmail($_POST['email']);
                $hashpass = md5($_POST['pass']);
                $user->setPass($hashpass);
                
                try {
                  $respuesta = $user->login();
                  if(!$respuesta) throw new Exception("El usuario no es correcto o no existe");
                } catch (Exception $e) {
                  $_SESSION["error"] = $e->getMessage();
                  header("Location: index.php");
                  die;
                }

                if ($respuesta) {
                  if (!isset($_SESSION['usuario'])) {
                    $_SESSION['user']["nombre"] = $user->getNombre();
                    $_SESSION['user']["email"] = $user->getEmail();
                    $_SESSION['user']["codigo"] = $user->getCodigo();
                    $_SESSION['user']["horas"] = $user->getHoras();
                    $_SESSION['user']["rol"] = $user->getRol();

                    if ($user->getRol() == 'admin') {
                      header('Location: gestionfichadas.php');
                    } else {
                      header('Location: fichar.php');
                    }
                  }
                }
              }
            ?>
            <form method="POST" name="login">
              <div class="#">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
              </div>

              <div class="#">
                <label for="pass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="pass">
              </div>

                <button type="submit" class="#" name= "login" value="login">Login</button>
                
            </form>
          </div>
        </div>
      </div>
    </body>
</html>