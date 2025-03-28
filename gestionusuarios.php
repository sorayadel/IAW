<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "headContenido.php"; ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                require_once "cabecera.php";
                ?>
                <?php
                require_once "clsUsuario.php";
                ?>

                <table class="table table-striped">
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
                        <?php
                        $usuario = new Usuario();
                        $listado_usuarios = $usuario->listar();
                        ?>

                        <?php foreach ($listado_usuarios as $usuario_tabla): ?>
                            <tr>
                                <td><?php echo $usuario_tabla["nombre"] ?></td>
                                <td><?php echo $usuario_tabla["codigo"] ?></td>
                                <td><?php echo $usuario_tabla["horas"] ?></td>
                                <td><?php echo $usuario_tabla["email"] ?></td>
                                <td><?php echo $usuario_tabla["rol"] ?></td>
                                <td>
                                    <a href="gestionusuarios.php?id_usuari=15&amp;accion=editar" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="gestionusuarios.php?id_usuari=15&amp;accion=eliminar" class="btn btn-danger btn-sm">Borrar</a>
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