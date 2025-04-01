<?php

class HistoricoFichadas {
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

    public function crear() {
        //
    }

    public function eliminar() {
        //
    }
}
