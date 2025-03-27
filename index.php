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
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

      <h1>Login</h1>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

      <?php
        if (isset($_POST['login'])) {
          require 'clsUsuario.php';
          $user = new Usuario();
          $user->email = $_POST['email'];
          $respuesta = true;
          $hashpass = md5($_POST['pass']);
          $user->pass = $hashpass;
          
          try {
            $respuesta = $user->login();
          } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            header("Location: index.php");
          }

          var_dump($respuesta);
          die;
            
          if ($respuesta) {
            if (!isset($_SESSION['rol'])) {
              $_SESSION['id'] = $user->getId();
              $_SESSION['email'] = $user->getEmail();
              $_SESSION['nombre'] = $user->getNombre();
              $_SESSION['rol'] = $user->getRol();

              if ($user->getRol() == 'Admin') {
                header('');
              } else {
                header('');  
              }
            }
          } else{
            $login = false;
            echo "Su email o contraseña no son correctos, por favor, vuelva a intentarlo";
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