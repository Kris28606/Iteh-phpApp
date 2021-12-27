<?php

require "../dbBroker.php";
require "../model/ocena.php";
require "../model/predmet.php";
require "../model/user.php";

if(isset($_POST['predmet']) && isset($_POST['ucenik']) 
&& isset($_POST['ocena']) && isset($_POST['profesor']) && isset($_POST['datum'])){
    
    $profesor=User::getByName($_POST['profesor'],$conn)->fetch_array();
    $predmet=Predmet::getByName($_POST['predmet'],$conn)->fetch_array();
    $ocena = new Ocena(null,$predmet['id'],$_POST['ucenik'],$_POST['ocena'], $profesor['id'],$_POST['datum'] );
    

    $status = Ocena::add($ocena, $conn);

    if($status){
        echo "Success";
    }else{
        echo $status;
        echo "Failed";
    }
}
?>