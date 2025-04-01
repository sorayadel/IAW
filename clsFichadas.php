<?php
class Fichadas extends Conexion
{
  private $id;
  private $id_usuario;
  private $fecha;
  private $fichada_inicio_1;
  private $fichada_inicio_2;
  private $fichada_inicio_3;
  private $fichada_inicio_4;
  private $fichada_fin_1;
  private $fichada_fin_2;
  private $fichada_fin_3;
  private $fichada_fin_4;
  private $tiempo;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getFecha()
  {
    return $this->fecha;
  }

  public function setFecha($fecha)
  {
    $this->fecha = $fecha;
  }

  public function getFichadaInicio1()
  {
    return $this->fichada_inicio_1;
  }

  public function setFichadaInicio1($fichada_inicio_1)
  {
    $this->fichada_inicio_1 = $fichada_inicio_1;
  }

  public function getFichadaInicio2()
  {
    return $this->fichada_inicio_2;
  }

  public function setFichadaInicio2($fichada_inicio_2)
  {
    $this->fichada_inicio_2 = $fichada_inicio_2;
  }

  public function getFichadaInicio3()
  {
    return $this->fichada_inicio_3;
  }

  public function setFichadaInicio3($fichada_inicio_3)
  {
    $this->fichada_inicio_3 = $fichada_inicio_3;
  }

  public function getFichadaInicio4()
  {
    return $this->fichada_inicio_4;
  }

  public function setFichadaInicio4($fichada_inicio_4)
  {
    $this->fichada_inicio_4 = $fichada_inicio_4;
  }

  public function getFichadaFin1()
  {
    return $this->fichada_fin_1;
  }

  public function setFichadaFin1($fichada_fin_1)
  {
    $this->fichada_fin_1 = $fichada_fin_1;
  }

  public function getFichadaFin2()
  {
    return $this->fichada_fin_2;
  }

  public function setFichadaFin2($fichada_fin_2)
  {
    $this->fichada_fin_2 = $fichada_fin_2;
  }

  public function getFichadaFin3()
  {
    return $this->fichada_fin_3;
  }

  public function setFichadaFin3($fichada_fin_3)
  {
    $this->fichada_fin_3 = $fichada_fin_3;
  }

  public function getFichadaFin4()
  {
    return $this->fichada_fin_4;
  }
    
  public function setFichadaFin4($fichada_fin_4)
  {
    $this->fichada_fin_4 = $fichada_fin_4;
  }

  public function getTiempo()
  {
    return $this->tiempo;
  }

  public function setTiempo($tiempo)
  {
    $this->tiempo = $tiempo;
  }

  public function getUsuario()
  {
    return $this->usuario;
  }

  public function setUsuario($usuario)
  {
    $this->usuario = $usuario;
  }

  /* Métodos */

  public function listar()
  {
    //
  }

  public function cargar()
  {
    //
  }

  public function editar()
  {
    //
  }

  public function crear($id_usuario)
  {
    //
  }

  public function eliminar()
  {
    //
  }

}
