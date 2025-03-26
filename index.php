
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
      <h1>Login</h1>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

      <?php
        require_once 'connexion.php';
        $conn = new Connexion();
        $login = false;
        require 'clsUsuario.php';
            if (isset($_GET['login'])) {
                $user = new User();
                $user->email = $_GET['email'];
                $respuesta = true;
                $user->pass = $_GET['pass'];
                $hashpass = md5($user->pass);
                $user->pass = $hashpass;
                $respuesta = $user->login();
                
                //verificar contraseña
                if ($respuesta){

                  //session_start();  
                    if (!isset($_SESSION['rol'])) {
                      $_SESSION['id'] = $user->getId();
                      $_SESSION['email'] = $user->getEmail();
                      $_SESSION['nombre'] = $user->getNombre();
                      $_SESSION['rol'] = $user->getRol();

                      if ($user->getRol() == 'Admin'){
                        header('');
                      }else{
                        header('');  
                      }
                    } else {
                      
                    }
                }
                    else{
                    $login = false;
                    echo "Su email o contraseña no son correctos, por favor, vuelva a intentarlo";
                    }
            }
        ?>
      <form method="get" name="login">
        <div class="#">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>

        <div class="#">
          <label for="pass" class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="pass">
        </div>

          <button type="submit" class="#" name= "login" value="login">Login</button>
          
      </form>
    </body>
</html>