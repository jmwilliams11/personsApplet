<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
//$email2 = $_GET['email'];

// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
//include_once 'objects/category.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$person = new Persons($db);
//$category = new Category($db);
  
// set ID property of product to be edited
$person->id = $id;
  
// read the details of product to be edited
$person->readOne();
  
// set page header
$page_title = "Update User";
include_once "layouts/layout_header.php";
  
echo "<div class='right-button-margin'>
          <a href='index.php' class='btn btn-default pull-right'>Read Persons</a>
     </div>";
  
?>
<?php 
//each person can update self only admin can update evryone
$email = $_SESSION['email'];
$sql = "SELECT role FROM persons WHERE email='$email'";
$result = $db->query($sql);

//to delete they need to be an admin
if($result == "admin" || $person->email == $email) {
// if the form was submitted
if($_POST){
  
    // set product property values
    $person->role = $_GET['role'];
    $person->fname = $phone;
    $person->lname = $_POST['lname'];
    $person->email = $_POST['email'];
    $person->phone = $phone;
    //$salt = MD5(microtime(true));
    $person->password_hash = $_GET['password_hash'];
    $person->password_salt = $_GET['password_salt'];



    $person->address = $_POST['address'];
    $person->address2 = $_POST['address2'];
    $person->city = $_POST['city'];
    $person->state = $_POST['state'];
    $person->zip_code = $_POST['zip_code'];
  
    // update the product
    if($person->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "User was updated.";
        echo "</div>";
    }
  
    // if unable to update the product, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update user.";
        echo "</div>";
    }
}
else {
    echo "<div class='alert alert-danger'>Only admins are allowed to update all users and only users can update themselves.</div>";
}
}
?>
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
  
        <tr>
            <td>First Name</td>
            <td><input type='text' name='fname' value='<?php echo $person->fname; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lname' value='<?php echo $person->lname; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>E-Mail</td>
            <td><input type='text' name='email' value='<?php echo $person->email; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Phone</td>
            <td><input type='text' name='phone' value='<?php echo $person->phone; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Address</td>
            <td><input type='text' name='address' value='<?php echo $person->address; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Address 2</td>
            <td><input type='text' name='address2' value='<?php echo $person->address2; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>City</td>
            <td><input type='text' name='city' value='<?php echo $person->city; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>State</td>
            <td><input type='text' name='state' value='<?php echo $person->state; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Zip Code</td>
            <td><input type='text' name='zip_code' value='<?php echo $person->zip_code; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
  
    </table>
</form>
 <?php 
// set page footer
include_once "layouts/layout_footer.php";
?>