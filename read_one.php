<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}
// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
//include_once 'objects/category.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$persons = new Persons($db);
//$category = new Category($db);
  
// set ID property of product to be read
$persons->id = $id;
  
// read the details of product to be read
$persons->readOne();

// set page headers
$page_title = "Read One User";
include_once "layouts/layout_header.php";
  
// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Users";
    echo "</a>";
echo "</div>";

// HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
        echo "<td>Role</td>";
        echo "<td>{$persons->role}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>First</td>";
        echo "<td>{$persons->fname}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Last</td>";
        echo "<td>{$persons->lname}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>E-mail</td>";
        echo "<td>{$persons->email}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Phone</td>";
        echo "<td>{$persons->phone}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Address</td>";
        echo "<td>{$persons->address}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Address 2</td>";
        echo "<td>{$persons->address2}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>City</td>";
        echo "<td>{$persons->city}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>State</td>";
        echo "<td>{$persons->state}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Zip_Code</td>";
        echo "<td>{$persons->zip_code}</td>";
    echo "</tr>";
    
echo "</table>";
  
// set footer
include_once "layouts/layout_footer.php";
?>