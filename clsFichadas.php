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

  public function getIdUsuario()
  {
    return $this->id_usuario;
  }

  public function setIdUsuario($id_usuario)
  {
    $this->id_usuario = $id_usuario;
  }

  /* Métodos */

  public function listar()
  {
    //
  }

  public function cargar($id_usuario = null)
  {
    if ($id_usuario !== null) {
      $sql = "
        SELECT *
        FROM historico_fichadas hf
        LEFT JOIN usuarios u ON hf.id_usuario = u.id_usuario
        WHERE hf.id_usuario = :id_usuario
        ORDER BY fecha DESC";
      $bd_conexion = $this->conecta()->prepare($sql);
      $bd_conexion->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    } else {
      $sql = "
        SELECT *
        FROM historico_fichadas hf
        LEFT JOIN usuarios u ON hf.id_usuario = u.id_usuario
        ORDER BY fecha DESC";
      $bd_conexion = $this->conecta()->prepare($sql);
    }

    $bd_conexion->execute();
    $fichadas = $bd_conexion->fetchAll(PDO::FETCH_ASSOC);
    $resultado = [];

    foreach ($fichadas as $fichada) {
      $datetime = "2025-04-03 19:21:57";
      $fecha = date("Y-m-d", strtotime($datetime));

      // Inicializamos el array si no existe
      if (!isset($resultado[$fichada["id_usuario"]][$fecha])) {
        $resultado[$fichada["id_usuario"]][$fecha] = [];
      }

      // Verificamos si ya hay 8 elementos antes de añadir más
      if (count($resultado[$fichada["id_usuario"]][$fecha]) < 8) {
        $resultado[$fichada["id_usuario"]][$fecha][] = $fichada["fecha"];
        $resultado[$fichada["id_usuario"]]["procesada"] = $fichada["procesada"];
        $resultado[$fichada["id_usuario"]]["nombre"] = $fichada["nombre"];
        $resultado[$fichada["id_usuario"]]["codigo"] = $fichada["codigo"];
      }
    }

    $resultado_final = [];
    $posicion = 0;
    
    foreach ($resultado as $id_usuario => $informacion) {
      foreach ($informacion as $clave => $info) {
        if ($clave === "procesada") {
          $resultado_final[$posicion]["id_usuario"] = $id_usuario;
          $resultado_final[$posicion]["procesada"] = $info;
        } elseif ($clave === "nombre") {
          $resultado_final[$posicion]["nombre"] = $info;
        } elseif ($clave === "codigo") {
          $resultado_final[$posicion]["codigo"] = $info;
        } else {
          $resultado_final[$posicion]["fecha"] = $clave;
          if (isset($info[0])) {
            $resultado_final[$posicion]["fichada_inicio_1"] = $info[0];
          }

          if (isset($info[1])) {
            $resultado_final[$posicion]["fichada_fin_1"] = $info[1];
          }

          if (isset($info[2])) {
            $resultado_final[$posicion]["fichada_inicio_2"] = $info[2];
          }

          if (isset($info[3])) {
            $resultado_final[$posicion]["fichada_fin_2"] = $info[3];
          }

          if (isset($info[4])) {
            $resultado_final[$posicion]["fichada_inicio_3"] = $info[4];
          }

          if (isset($info[5])) {
            $resultado_final[$posicion]["fichada_fin_3"] = $info[5];
          }

          if (isset($info[6])) {
            $resultado_final[$posicion]["fichada_inicio_4"] = $info[6];
          }

          if (isset($info[7])) {
            $resultado_final[$posicion]["fichada_fin_4"] = $info[7];
          }
        }
      }
      $posicion++;
    }

    if ($resultado_final) {
      return $resultado_final;
    } else {
      throw new Exception("No se encontraron fichadas.");
    }
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
