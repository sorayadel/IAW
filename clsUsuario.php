<?php

require_once 'conexion.php';

class Usuario extends Conexion {
    public $id;
    public $nombre;
    public $email;
    public $pass;
    public $codigo;
    public $horas;
    public $rol;

    public function login() {
        try {
            $sql = "SELECT email, password FROM usuarios WHERE email = :email AND password = :password";
            $bd_conexion = $this->conecta()->prepare($sql);
            $bd_conexion->bindParam(':email', $this->email);
            $bd_conexion->bindParam(':password', $this->pass);
            $bd_conexion->execute();
            $respuesta = $bd_conexion->fetch();
            
            if(!$respuesta) throw new Exception("El usuario no es correcto o no existe");

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

?>  

