<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}
echo  "<a style='color: orange;' href='logout.php'>Logout</a>";

// core.php holds pagination variables
include_once 'config/core.php';
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
//include_once 'objects/category.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
$persons = new Persons($db);
//$category = new Category($db);
  
$page_title = "Read Users";
include_once "layouts/layout_header.php";
  
// query products
$stmt = $persons->readAll($from_record_num, $records_per_page);
  
// specify the page where paging is used
$page_url = "index.php?";
  
// count total rows - used for pagination
$total_rows=$persons->countAll();
  
// read_template.php controls how the product list will be rendered
include_once "read_template.php";
  
// layout_footer.php holds our javascript and closing html tags
include_once "layouts/layout_footer.php";
?>