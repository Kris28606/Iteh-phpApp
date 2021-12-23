<?php
    class Predmet{
        public $id;   
        public $naziv;
        
        public function __construct($id=null, $naziv=null)
        {
            $this->id = $id;
            $this->naziv = $naziv;
        }

        public static function getById($id, mysqli $conn){
            $query = "SELECT * FROM predmet WHERE id=$id";
            
            return $conn->query($query);
    
        }

        public static function getAll(mysqli $conn)
        {
            $query = "SELECT * FROM predmet";
            return $conn->query($query);
        }

        public static function getByName($ime,mysqli $conn) {
            $query = "SELECT * FROM predmet WHERE naziv='$ime'";
            return $conn->query($query);
        }
    }
?>