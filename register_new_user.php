<?php

#1. connect to db
//require 'config/database.php';
//$pdo = Database::getConnection();
include_once 'config/database.php';
include_once 'objects/persons.php';
$database = new Database();
$db = $database->getConnection();
$person = new Persons($db);



#2. assign user/pass
$role = $_POST['role'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

$salt = MD5(microtime(true));
$password_hash = $_POST['password'] . $salt;
$password_salt = $salt;

//code injection
$email = htmlspecialchars($email);
$password = htmlspecialchars($password);
$fname = htmlspecialchars($fname);
$lname = htmlspecialchars($lname);
$phone = htmlspecialchars($phone);
$address = htmlspecialchars($address);
$address2 = htmlspecialchars($address2);
$city = htmlspecialchars($city);
$state = htmlspecialchars($state);
$zip_code = htmlspecialchars($zip_code);



//password validate variables : codexworld
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);
$emailErr = "";
$emailExistsErr = "";
$passMatchErr = "";
$passErr = "";

$anyErr = false;

//both passwords need to be same
if(!$password==$password2){
    $passMatchErr = "Passwords must match";
    $anyErr = true;
}
//email validation -w3 schools
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "invalid email format";
    $anyErr = true;
}
//validate pass : codexworld
if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 17) {
    $passErr = "Password should be at least 16 characters in length and should include at least one upper case letter, one number, and one special character.";
    $anyErr = true;
}
//check to make sure user is not there

$sql = "SELECT id FROM persons WHERE email='$email'";
$result = $db->query($sql);
if(!$result) {
    $emailExistsErr = "Email already exists";
    $anyErr = true;
    
}
if($emailErr || $passErr || $passMatchErr){
    $anyErr = true;
    header("Location: register.php?"
    . "fname=$fname"
    . "&" . "role=$role"
    . "&" . "lname=$lname"
    . "&" . "phone=$phone"
    . "&" . "address=$address"
    . "&" . "address2=$address2"
    . "&" . "city=$city"
    . "&" . "state=$state"
    . "&" . "zip_code=$zip_code"
    . "&" . "passErr=$passErr"
    . "&" . "passMatchErr=$passMatchErr"
    . "&" . "emailErr=$emailErr"
    . "&" . "emailExistsErr=$emailExistsErr");
    
}

//no errors, login went smoothly
if(!$anyErr) {

    // set product property values
    $person->role = $role;
    $person->fname = $fname;
    $person->lname = $lname;
    $person->email = $email;
    $person->phone = $phone;
    $person->password_hash = $password_hash;
    $person->password_salt = $salt;


//see if dbvalue = md
//if $dbvalue == MD5($_POST['password'] . $dbsalt) {
    //do login stuff i think
//}

    $person->address = $address;
    $person->address2 = $address2;
    $person->city = $city;
    $person->state = $state;
    $person->zip_code = $zip_code;

    // create the product
    if($person->create()){
        echo "<div class='alert alert-success'>User was created.</div>";
        echo "<p>Your info has been added. You can now log in.</p><br>";
        echo "<a href='login.php'>Back to list</a>";
    
    }

    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create User.</div>";
        echo "<a href='register.php'>Back to Register</a>";
    }
}
?>