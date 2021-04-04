<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}
$email = $_SESSION['email'];
$sql = "SELECT role FROM persons WHERE email='$email'";
$result = $db->query($sql);

echo "hello";

//to delete they need to be an admin
if($result == "admin") {
// check if value was posted
if($_POST){
  
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/persons.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
  
    // prepare product object
    $persons = new Persons($db);
      
    // set product id to be deleted
    $persons->id = $_POST['id'];
    

    // delete the product
    if($persons->delete()){
        echo "User was deleted.";
    }
      
    // if unable to delete the product
    else{
        echo "Unable to delete user.";
    }
}
}
else {
   echo "<div class='alert alert-danger'>Only admins are allowed to delete users.</div>";
}
?>