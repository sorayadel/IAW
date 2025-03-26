<?php	
    class Connexion {
        
        public function conecta(){
            try {
                $link = new PDO("mysql:host=localhost;dbname=sallepresencia","root","");
                return $link;
            } catch (PDOException $e) {
                die("Error connecting to the database: ". $e->getMessage());
            }
        }
    }
?>
	





