<?php

class User{
    public $id;
    public $username;
    public $password;
    public $imePrezime;

    public function __construct($id=null,$username=null,$password=null, $imePrezime=null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->imePrezime=$imePrezime;
    }

    public static function logInUser($usr, mysqli $conn)
    {
        $query = "SELECT * FROM profesor WHERE username='$usr->username' and password='$usr->password'";
        return $conn->query($query);
    }


    public static function getById($id, mysqli $conn){
        $query = "SELECT * FROM profesor WHERE id=$id";
        return $conn->query($query);

    }
    public static function getByUsername($ime, mysqli $conn){
        $query = "SELECT * FROM profesor WHERE username='$ime'";
        return $conn->query($query);

    }
    public static function getByName($ime, mysqli $conn) {
        $query = "SELECT * FROM profesor WHERE imePrezime='$ime'";
        return $conn->query($query);
    }
}


?>