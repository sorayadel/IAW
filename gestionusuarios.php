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
                <?php elseif (isset($_GET["accion"]) && $_GET["accion"] === "editar"): ?>
                    // @TODO
                <?php elseif (isset($_GET["accion"]) && $_GET["accion"] === "eliminar"): ?>
                    <?php
                    if (!empty(isset($_GET["id"]))) {
                        if($_SESSION["usuario"]["id"] === (int) $_GET["id"]) {
                            $_SESSION["error"] = "No puedes eliminar tu propio usuario";
                            header("Location: gestionusuarios.php");
                            die;
                        } else {
                            $usuario_eliminar = new Usuario();
                            $usuario_eliminar->eliminar((int) $_GET["id"]);
                        }
                    }
                    ?>
                <?php endif; ?>

                <div class="card mt-3">
                    <div class="card-body">
                        <form method="POST" action="gestionusuarios.php?accion=crear">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="number" class="form-control" id="codigo" name="codigo" required>
                            </div>
                            <div class="form-group">
                                <label for="horas">Horas</label>
                                <input type="number" class="form-control" id="horas" name="horas" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="contrasena">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            </div>
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select class="form-control" id="rol" name="rol">
                                    <option value="user">Usuario</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Crear usuario</button>
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
                                        href="gestionusuarios.php?id=<?php echo $usuario_tabla["id"] ?>&amp;accion=editar"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Editar</a>
                                    <a
                                        href="gestionusuarios.php?id=<?php echo $usuario_tabla["id"] ?>&amp;accion=eliminar"
                                        class="btn btn-danger btn-sm <?php if ($usuario_tabla["id"] === $_SESSION["usuario"]["id"]): ?>disabled<?php endif; ?>"
                                    >
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