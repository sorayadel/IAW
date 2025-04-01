<?php

class HistoricoFichadas extends Conexion {
    private $id;
    private $id_usuario;
    private $fecha;
    private $procesada;

    // Getters y Setters

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getProcesada() {
        return $this->procesada;
    }

    public function setProcesada($procesada) {
        $this->procesada = $procesada;
    }

    // Métodos

    public function cargar() {
        //
    }

    public function editar() {
        //
    }

    public function crear($id_usuario) {
        if(!isset($id_usuario)) {
            throw new Exception("El ID de usuario no puede ser nulo.");
        }

        $fecha = date("Y-m-d H:i:s");
        $id_usuario = $id_usuario;
        $procesada = 0; // Por defecto, no procesada

        // Si entre la fichada anterior y la nueva hay menos de 5 minutos, no se permite la fichada
        $sql = "SELECT * FROM historico_fichadas WHERE id_usuario = :id_usuario ORDER BY fecha DESC LIMIT 1";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':id_usuario', $id_usuario);
        $bd_conexion->execute();
        $fichada_anterior = $bd_conexion->fetch(PDO::FETCH_ASSOC);

        // Si entre $fichada_anterior y $fecha hay menos de 5 minutos, no se permite la fichada
        if ($fichada_anterior) {
            $fecha_anterior = new DateTime($fichada_anterior["fecha"]);
            $fecha_actual = new DateTime($fecha);
            $diferencia = $fecha_actual->getTimestamp() - $fecha_anterior->getTimestamp();

            if ($diferencia < 300) {
                throw new Exception("No se puede fichar antes de 5 minutos desde la última fichada.");
            }
        }

        $sql = "INSERT INTO historico_fichadas (id_usuario, fecha, procesada) VALUES (:id_usuario, :fecha, :procesada)";
        $bd_conexion = $this->conecta()->prepare($sql);
        $bd_conexion->bindParam(':id_usuario', $id_usuario);
        $bd_conexion->bindParam(':fecha', $fecha);
        $bd_conexion->bindParam(':procesada', $procesada);
        $bd_conexion->execute();

        return true;
    }

    public function eliminar() {
        //
    }
}
