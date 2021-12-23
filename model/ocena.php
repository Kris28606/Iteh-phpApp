<?php

    class Ocena{
        public $id;   
        public $predmet;
        public $ucenik; 
        public $ocena; 
        public $profesor;   
        public $datum;
        
        public function __construct($id=null, $predmet=null, $ucenik=null, $ocena=null, $profesor=null, $datum=null)
        {
            $this->id = $id;
            $this->predmet= $predmet;
            $this->ucenik=$ucenik;
            $this->ocena = $ocena;
            $this->profesor = $profesor;
            $this->datum = $datum;
        }

        public static function getAll(mysqli $conn)
        {
            $query = "SELECT * FROM ocena";
            return $conn->query($query);
        }

        public static function getById($id, mysqli $conn){
            $query = "SELECT * FROM ocena WHERE id=$id";
    
            return $conn->query($query);
    
        }

        //poziva se nad obj
        public function deleteById(mysqli $conn)
        {
            $query = "DELETE FROM ocena WHERE id=$this->id";
            return $conn->query($query);
        }

        public static function add(Ocena $ocena, mysqli $conn)
        {
            $query = "INSERT INTO ocena(predmetId, ucenik, ocena, profesorId, datum) VALUES('$ocena->predmet','$ocena->ucenik','$ocena->ocena','$ocena->profesor','$ocena->datum')";
            return $conn->query($query);
        }

        public function update($id, mysqli $conn)
        {
            $query = "UPDATE ocena set predmetId = $this->predmet->id,ucenik = $this->ucenik,ocena = $this->ocena,profesorId = $this->profesor->id, datum = $this->datum WHERE id=$id";
            return $conn->query($query); 
        }

        
    }
?>