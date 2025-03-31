<?php	
    class Conexion {
        const HOST = "localhost";
        const BASE_DE_DATOS = "sallepresencia";
        const USUARIO = "root";
        const CONTRASENA = "";

        public function conecta(
            $host = self::HOST,
            $base_de_datos = self::BASE_DE_DATOS,
            $usuario = self::USUARIO,
            $contrasena = self::CONTRASENA,
        ) {
            try {
                $link = new PDO(
                    "mysql:host=".$host.";dbname=".$base_de_datos,
                    $usuario,
                    $contrasena,
                );
                return $link;
            } catch (PDOException $e) {
                die("Error connecting to the database: ". $e->getMessage());
            }
        }
    }
?>
	





