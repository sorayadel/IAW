<?php

require_once 'conexion.php';

class Usuario extends Conexion
{
    private $id;
    private $nombre;
    private $email;
    private $pass;
    private $codigo;
    private $horas;
    private $rol;

    public function login()
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':email', $this->email);
        $bd_conexion->bindParam(':password', $this->pass);
        $bd_conexion->execute();
        $respuesta = $bd_conexion->fetch(PDO::FETCH_ASSOC);

        if (!$respuesta) return false;

        $this->id = $respuesta["id"];
        $this->nombre = $respuesta["Nombre"];
        $this->email = $respuesta["Email"];
        $this->pass = null;
        $this->codigo = $respuesta["Codigo"];
        $this->horas = $respuesta["Horas"];
        $this->rol = $respuesta["Rol"];

        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getHoras()
    {
        return $this->horas;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setHoras($horas)
    {
        $this->horas = $horas;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPass($password)
    {
        $this->pass = $password;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function listar()
    {
        $sql = "SELECT id, nombre, email, codigo, horas, rol FROM usuarios";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->execute();
        $respuesta = $bd_conexion->fetchAll(PDO::FETCH_ASSOC);

        if (!$respuesta) return false;

        return $respuesta;
    }

    public function cargar($id_usuario)
    {
        $sql = "SELECT id, nombre, codigo, horas, email, rol FROM usuarios WHERE id = :id";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':id', $id_usuario);
        $bd_conexion->execute();
        $respuesta = $bd_conexion->fetch(PDO::FETCH_ASSOC);

        if (!$respuesta) return false;

        $this->setId($respuesta["id"]);
        $this->setNombre($respuesta["nombre"]);
        $this->setCodigo($respuesta["codigo"]);
        $this->setHoras($respuesta["horas"]);
        $this->setEmail($respuesta["email"]);
        $this->setRol($respuesta["rol"]);

        return $respuesta;
    }

    public function editar($id_usuario, $nuevos_datos)
    {
        // Cargamos los datos actuales del usuario
        $usuario = new Usuario();
        $usuario->cargar($id_usuario);
        $campos_actualizar = [];

        if (!$usuario) {
            return false;
        }

        // Creamos las variables de los nuevos valores
        $valores = ['id' => $id_usuario];
        $nuevoNombre = $nuevos_datos["nombre"] ?? null;
        $nuevoCodigo = $nuevos_datos["codigo"] ?? null;
        $nuevoHoras = $nuevos_datos["horas"] ?? null;
        $nuevoEmail = $nuevos_datos["email"] ?? null;
        $nuevoContrasena = $nuevos_datos["contrasena"] ?? null;
        $nuevoRol = $nuevos_datos["rol"] ?? null;

        // Comprobamos que los valores no estén vacíos y sean diferentes a los actuales para actualizarlos
        if (!empty($nuevoNombre) && $nuevoNombre !== $usuario->getNombre()) {
            $campos_actualizar[] = "nombre = :nombre";
            $valores['nombre'] = $nuevoNombre;
        }

        if (!empty($nuevoCodigo) && $nuevoCodigo !== $usuario->getCodigo()) {
            $campos_actualizar[] = "codigo = :codigo";
            $valores['codigo'] = $nuevoCodigo;
        }

        if (!empty($nuevoHoras) && $nuevoHoras !== $usuario->getHoras()) {
            $campos_actualizar[] = "horas = :horas";
            $valores['horas'] = $nuevoHoras;
        }

        if (!empty($nuevoEmail) && $nuevoEmail !== $usuario->getEmail()) {
            $campos_actualizar[] = "email = :email";
            $valores['email'] = $nuevoEmail;
        }

        if (!empty($nuevoContrasena) && $nuevoContrasena !== $usuario->getPass()) {
            $campos_actualizar[] = "password = :password";
            $hashpass = md5($nuevoContrasena);
            $valores['password'] = $hashpass;
        }

        if (!empty($nuevoRol) && $nuevoRol !== $usuario->getRol()) {
            $campos_actualizar[] = "rol = :rol";
            $valores['rol'] = $nuevoRol;
        }

        // Si no hay cambios, no se ejecuta la consulta
        if (!empty($campos_actualizar)) {
            // Construimos la consulta
            $sql = "UPDATE usuarios SET " . implode(", ", $campos_actualizar) . " WHERE id = :id";
            $bd_conexion = $this->conecta()->prepare($sql);
            $bd_conexion->execute($valores);
            
            return true;
        } else {
            return true;
        }
    }

    public function crear($nombre, $codigo, $horas, $email, $contrasena, $rol)
    {
        // Comprobamos si el usuario ya existe en base de datos
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':email', $email);
        $bd_conexion->execute();
        $usuario_existe = $bd_conexion->fetchColumn();

        // En caso de que el usuario exista, devolvemos false
        if ($usuario_existe > 0) return false;

        $sql = "
            INSERT INTO usuarios (nombre, codigo, horas, email, password, rol)
            VALUES (:nombre, :codigo, :horas, :email, :password, :rol)";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':nombre', $nombre);
        $bd_conexion->bindParam(':codigo', $codigo);
        $bd_conexion->bindParam(':horas', $horas);
        $bd_conexion->bindParam(':email', $email);
        $hashpass = md5($contrasena);
        $bd_conexion->bindParam(':password', $hashpass);
        $bd_conexion->bindParam(':rol', $rol);
        $bd_conexion->execute();

        return true;
    }

    public function eliminar($id_usuario)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':id', $id_usuario);
        $respuesta = $bd_conexion->execute();

        return $respuesta;
    }
}
