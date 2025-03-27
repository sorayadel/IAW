<?php

require_once 'conexion.php';

class Usuario extends Conexion {
    private $id;
    private $nombre;
    private $email;
    private $pass;
    private $codigo;
    private $horas;
    private $rol;

    public function login() {
        $sql = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':email', $this->email);
        $bd_conexion->bindParam(':password', $this->pass);
        $bd_conexion->execute();
        $respuesta = $bd_conexion->fetch();
        
        if(!$respuesta) return false;

        $this->id = $respuesta["id"];
        $this->nombre = $respuesta["Nombre"];
        $this->email = $respuesta["Email"];
        $this->pass = null;
        $this->codigo = $respuesta["Codigo"];
        $this->horas = $respuesta["Horas"];
        $this->rol = $respuesta["Rol"];

        return true;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getHoras() {
        return $this->horas;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPass($password) {
        $this->pass = $password;
    }
}

?>  

