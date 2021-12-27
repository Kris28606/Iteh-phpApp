<?php

require "dbBroker.php";
require "model/user.php";

session_start();
if(isset($_POST['username']) && isset($_POST['password'])){
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    
    $korisnik = new User(1,$uname, $upass);
   
    $odg = User::logInUser($korisnik, $conn); 

    if($odg->num_rows == 1){
       
        $odgovor=$odg->fetch_array();
        $_SESSION['user_id'] = $odgovor['id'];
        header('Location: ../home.php');
        exit();
    }else{
        
    }

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>HRS: Heroj Radmila Siskovic</title>
</head>

<body>

    <div class="login-form">
            <div class="main-div">
                <form method="POST" action="#">
                    <div class="container">
                        <input type="text" name="username" class="form-control" placeholder="Korisnicko ime"  required>
                    <br>
                        <input type="password" name="password" class="form-control" placeholder="Lozinka" required>
                        <button type="submit" class="btn btn-primary" name="submit">Prijavi se</button>
                    </div>
                </form>
            </div>
    </div>
        
</body>
</html>