<?php
class HistoricoFichadas extends Conexion
{
  private $id;
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
  private $procesada;
  private $usuario;

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

  public function getProcesada()
  {
    return $this->procesada;
  }

  public function setProcesada($procesada)
  {
    $this->procesada = $procesada;
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
    $usuario = new Usuario();
    $usuario->cargar($id_usuario);

    if ($usuario->getId() === null) {
      throw new Exception("El usuario no existe.");
    }
    
    $this->setUsuario($usuario);
    $this->setFecha(date("Y-m-d"));
    $this->setFichadaInicio1(date("H:i:s"));
    $this->setFichadaFin1(null);
    $this->setFichadaInicio2(null);
    $this->setFichadaFin2(null);
    $this->setFichadaInicio3(null);
    $this->setFichadaFin3(null);
    $this->setFichadaInicio4(null);
    $this->setFichadaFin4(null);
    $this->setTiempo(0);

    $sql = "
      INSERT INTO fichadas (
        id_usuario,
        fecha,
        fichada_inicio_1,
        fichada_fin_1,
        fichada_inicio_2,
        fichada_fin_2,
        fichada_inicio_3,
        fichada_fin_3,
        fichada_inicio_4,
        fichada_fin_4,
        tiempo
      ) 
        VALUES (
        :id_usuario,
        :fecha,
        :fichada_inicio_1,
        :fichada_fin_1,
        :fichada_inicio_2,
        :fichada_fin_2,
        :fichada_inicio_3,
        :fichada_fin_3,
        :fichada_inicio_4,
        :fichada_fin_4,
        :tiempo)";

    $id_usuario = $this->getUsuario()->getId();
    $fecha = $this->getFecha();
    $fichada_inicio_1 = $this->getFichadaInicio1();
    $fichada_fin_1 = $this->getFichadaFin1();
    $fichada_inicio_2 = $this->getFichadaInicio2();
    $fichada_fin_2 = $this->getFichadaFin2();
    $fichada_inicio_3 = $this->getFichadaInicio3();
    $fichada_fin_3 = $this->getFichadaFin3();
    $fichada_inicio_4 = $this->getFichadaInicio4();
    $fichada_fin_4 = $this->getFichadaFin4();
    $tiempo = $this->getTiempo();

    $bd_conexion = $this->conecta()->prepare($sql);
    $bd_conexion->bindParam(':id_usuario', $id_usuario);
    $bd_conexion->bindParam(':fecha', $fecha);
    $bd_conexion->bindParam(':fichada_inicio_1', $fichada_inicio_1);
    $bd_conexion->bindParam(':fichada_fin_1', $fichada_fin_1);
    $bd_conexion->bindParam(':fichada_inicio_2', $fichada_inicio_2);
    $bd_conexion->bindParam(':fichada_fin_2', $fichada_fin_2);
    $bd_conexion->bindParam(':fichada_inicio_3', $fichada_inicio_3);
    $bd_conexion->bindParam(':fichada_fin_3', $fichada_fin_3);
    $bd_conexion->bindParam(':fichada_inicio_4', $fichada_inicio_4);
    $bd_conexion->bindParam(':fichada_fin_4', $fichada_fin_4);
    $bd_conexion->bindParam(':tiempo', $tiempo);

    $respuesta = $bd_conexion->execute();

    if (!$respuesta) {
      throw new Exception("Error al registrar la fichada.");
    }

    return $bd_conexion->execute();
  }

  public function eliminar()
  {
    //
  }

}
