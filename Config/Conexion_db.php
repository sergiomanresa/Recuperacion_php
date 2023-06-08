<?php
    
    class DataBase{

        private $host = "localhost";
        private $dbname = "hospital";
        private $user = "root";
        private $password = "";

        public function conectar_bd(){
            
            try{
                
                $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->password);
                return $PDO;

            }catch(PDOException $e){
                
                return $e->getMessage();

            }
        }
    }
?>