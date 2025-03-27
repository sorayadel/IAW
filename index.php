<?php
  session_start();
  $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
  unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">

    <head>
      
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>sallepresencia-form</title>

    </head>
    <body>

    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

      <h1>Login</h1>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
              $_SESSION['user'] = $user;

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
    </body>
</html>