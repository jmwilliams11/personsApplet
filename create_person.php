<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}
error_reporting(0);
// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$person = new Persons($db);

// set page headers
$page_title = "Create Person";
include_once "layouts/layout_header.php";
  
echo "<div class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Read Products</a>
    </div>";
  
?>
<?php 

//make sure they are admin to create
//check to make sure user is not there
$email = $_SESSION['email'];
$sql = "SELECT role FROM persons WHERE email='$email'";
$result = $db->query($sql);

//to create they need to be an admin
if($result == "admin") {

    // if the form was submitted - PHP OOP CRUD Tutorial
    if($_POST){
  
        // set product property values
        $person->role = $_POST['role'];
        $person->fname = $_POST['fname'];
        $person->lname = $_POST['lname'];
        $person->email = $_POST['email'];
        $person->phone = $_POST['phone'];
        //$person->password = $_POST['password'];
        $salt = MD5(microtime(true));
        $person->password_hash = $_POST['password'] . $salt;
        $person->password_salt = $salt;

        $dbvalue = $password_hash;
        $dbsalt = $password_salt;
        $usereneteredpass = $_POST['password'];

    //see if dbvalue = md
    //if $dbvalue == MD5($_POST['password'] . $dbsalt) {
        //do login stuff i think
    //}

        $person->address = $_POST['address'];
        $person->address2 = $_POST['address2'];
        $person->city = $_POST['city'];
        $person->state = $_POST['state'];
        $person->zip_code = $_POST['zip_code'];

    
    
        // create the product
        if($person->create()){
            echo "<div class='alert alert-success'>User was created.</div>";
        
        }
  
    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create User.</div>";
    }
    }

}
else {
    echo "<div class='alert alert-danger'>Only admins are allowed to create new users.</div>";
}
?>
  
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
  
    <table class='table table-hover table-responsive table-bordered'>
  
        <!--<tr><td>Role</td><td><input type='text' name='role' class='form-control' /></td></tr> -->
        <!-- <tr><td>Role</td></tr> -->
        <label>Role: </label>
        <select name='role'>
            <option value='admin'>Admin</option>
            <option value='user'>User</option>
        </select>
        <tr><td>First</td><td><input type='text' name='fname' class='form-control' /></td></tr>
        <tr><td>Last</td><td><input type='text' name='lname' class='form-control' /></td></tr>
        
        <tr><td>Email</td><td><input type='text' name='email' class='form-control' /></td></tr>
        <tr><td>Phone</td><td><input type='text' name='phone' class='form-control' /></td></tr>
        <tr><td>Password</td><td><input type='password' name='password' class='form-control' /></td></tr>
        <!--
        <tr><td>password_hash</td><td><input type='text' name='password_hash' class='form-control' /></td></tr>
        <tr><td>password_salt</td><td><input type='text' name='password_salt' class='form-control' /></td></tr>
        !-->
        <tr><td>Address</td><td><input type='text' name='address' class='form-control' /></td></tr>
        <tr><td>Address 2</td><td><input type='text' name='address2' class='form-control' /></td></tr>
        <tr><td>City</td><td><input type='text' name='city' class='form-control' /></td></tr>
        <tr><td>State</td><td><input type='text' name='state' class='form-control' /></td></tr>
        <tr><td>Zip_code</td><td><input type='text' name='zip_code' class='form-control' /></td></tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
  
    </table>
</form>
<?php
  
// footer
include_once "layouts/layout_footer.php";
?>