<?php
require "../dbBroker.php";
require "../home.php";
if(isset($_POST['id'])){
  $id=($_POST['id']);
  $query = "DELETE FROM ocena WHERE id=$id";
  $stmt = $conn->prepare($query);
  $stmt->execute();

}

?>