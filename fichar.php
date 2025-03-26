<?php
session_start(); // Debe ir al principio
include('conexion.php'); // Asegúrate de incluir el archivo de conexión

// Verificar si se ha enviado el formulario
if (isset($_POST['tipo_fichaje'])) {
    $tipo_fichaje = $_POST['tipo_fichaje'];
    $usuario_id = $_SESSION['usuario_id'];

    // Consulta para obtener el último fichaje
    $stmt = $conexion->prepare("SELECT tipo_fichaje FROM fichajes WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 1");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $ultimo_fichaje = $stmt->get_result();

    if ($ultimo_fichaje->num_rows > 0) {
        $ultimo = $ultimo_fichaje->fetch_assoc();
        if (($tipo_fichaje == 'entrada' && $ultimo['tipo_fichaje'] == 'entrada') || 
            ($tipo_fichaje == 'salida' && $ultimo['tipo_fichaje'] == 'salida')) {
            echo "No puedes fichar dos veces seguidas sin alternar entre entrada y salida.";
            exit();
        }
    }

    // Registrar el fichaje
    $stmt = $conexion->prepare("INSERT INTO fichajes (usuario_id, tipo_fichaje, fecha) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $usuario_id, $tipo_fichaje);
    
    if ($stmt->execute()) {
        echo "Fichaje registrado con éxito.";
    } else {
        echo "Error al registrar el fichaje: " . $conexion->error;
    }
}

// Mostrar historial de fichajes
$usuario_id = $_SESSION['usuario_id'];
$result = $conexion->query("SELECT tipo_fichaje, fecha FROM fichajes WHERE usuario_id = '$usuario_id' ORDER BY fecha DESC");

echo "<h2>Historial de Fichajes</h2>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>Tipo</th><th>Fecha</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['tipo_fichaje'] . "</td><td>" . $row['fecha'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No tienes fichajes registrados.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichaje de Entrada/Salida</title>
</head>
<body>

    <h1>Fichaje de Entrada/Salida</h1>
    
    <form action="" method="POST">
        <label for="tipo_fichaje">Selecciona el tipo de fichaje:</label>
        <select name="tipo_fichaje" id="tipo_fichaje">
            <option value="entrada">Entrada</option>
            <option value="salida">Salida</option>
        </select>
        <button type="submit">Fichar</button>
    </form>

</body>
</html>