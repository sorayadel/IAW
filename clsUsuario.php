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
        $usuario = new Usuario();
        $usuario->cargar($id_usuario);
        $campos_actualizar = [];

        foreach ($nuevos_datos as $campo => $nuevo_valor) {
            // Convertir el nombre del campo a método getter (ej: 'nombre' -> 'getNombre')
            $getter = 'get' . ucfirst($campo);

            // Verificar si el método existe en la clase Usuario
            if (method_exists($usuario, $getter)) {
                $valor_actual = $usuario->$getter();

                // Comparar valores y agregar solo los que han cambiado
                if ($nuevo_valor !== null && $nuevo_valor !== $valor_actual) {
                    $campos_actualizar[$campo] = $nuevo_valor;
                }
            }
        }

        if (empty($campos_actualizar)) {
            return false;
        }

        // Construir la consulta SQL dinámicamente
        $setClause = implode(", ", array_map(fn($campo) => "$campo = :$campo", array_keys($campos_actualizar)));
        $sql = "UPDATE usuarios SET $setClause WHERE id = :id";

        // Agregar el ID al array de valores
        $campos_actualizar['id'] = $id_usuario;

        // Ejecutar la consulta
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->execute($campos_actualizar);

        return true;
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
