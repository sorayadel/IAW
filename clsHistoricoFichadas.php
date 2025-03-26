<?php
    require_once 'conexion.php';
    require_once 'clsUsuario.php';
    require_once 'fichar.php';
    class User extends conexion{
        public $id;
        public $nombre;
        public $email;
        public $pass;
        public $rol;
    }

    function registrarFichaje($usuario_id, $tipo) {
        global $conn;
        $sql = "INSERT INTO fichajes (usuario_id, tipo) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $tipo);
        return $stmt->execute();
    }

    function obtenerHistorialFichajes($usuario_id = null) {
        global $conn;
        $sql = "SELECT f.id, u.nombre, f.fecha, f.tipo FROM fichajes f INNER JOIN usuarios u ON f.usuario_id = u.id";
        if ($usuario_id !== null) {
            $sql .= " WHERE f.usuario_id = ?";
        }
        $sql .= " ORDER BY f.fecha DESC";
        
        $stmt = $conn->prepare($sql);
        if ($usuario_id !== null) {
            $stmt->bind_param("i", $usuario_id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Función para eliminar un fichaje
    function eliminarFichaje($fichaje_id) {
        global $conn;
        $sql = "DELETE FROM fichajes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fichaje_id);
        return $stmt->execute();
    }
    
    // Función para actualizar un fichaje
    function actualizarFichaje($fichaje_id, $tipo) {
        global $conn;
        $sql = "UPDATE fichajes SET tipo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $tipo, $fichaje_id);
        return $stmt->execute();
    }

    $usuario_id = $_SESSION['usuario_id'];  // Supongamos que usas sesiones para el usuario, impedir que fiche dos veces seguidas.
    $ultimo_fichaje = $conexion->query("SELECT tipo_fichaje FROM fichajes WHERE usuario_id = '$usuario_id' ORDER BY fecha DESC LIMIT 1");
    
    if ($ultimo_fichaje->num_rows > 0) {
        $ultimo = $ultimo_fichaje->fetch_assoc();
        if ($ultimo['tipo_fichaje'] == 'entrada') {
            echo "Ya has fichado la entrada, debes fichar la salida antes de volver a fichar la entrada.";
            exit();
        }
    }

    $tipo_fichaje = $_POST['tipo_fichaje'];  // Entrada o salida, según lo que el usuario seleccione
    $usuario_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO fichajes (usuario_id, tipo_fichaje, fecha) 
            VALUES ('$usuario_id', '$tipo_fichaje', NOW())";

    if ($conexion->query($sql) === TRUE) {
        echo "Fichaje registrado con éxito.";
    } else {
        echo "Error al registrar el fichaje: " . $conexion->error;
    }

    ?>