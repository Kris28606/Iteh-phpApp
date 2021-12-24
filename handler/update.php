<?php
    require "../dbBroker.php";
    require "../model/predmet.php";
    require "../model/user.php";

    if(isset($_POST['action']) && $_POST['action'] == 'update_ocena') {

       
        $profesor=User::getByName($_POST['profesor'],$conn)->fetch_array();
        $predmet=Predmet::getByName($_POST['predmet'],$conn)->fetch_array();
        
        $predmet_id=$predmet['id'];
        $profesor_id=$profesor['id'];
        $id=$_POST['id'];
        $ucenik=$_POST['ucenik'];
        $ocena=$_POST['ocena'];
        $datum=$_POST['datum'];

        $query = "UPDATE ocena 
            SET predmetId = '$predmet_id',
                ucenik = '$ucenik',
                ocena = '$ocena',
                profesorId = '$profesor_id',
                datum = '$datum' 
            WHERE id = '$id'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        
    }
?>