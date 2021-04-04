<?php
$page_title = "Register New User";
include_once "layouts/layout_header.php";
error_reporting(0);
?>
<h1>Register New User</h1>
<form method='post' action='register_new_user.php'>
<label>Role: </label>
        <select name='role'>
            <option value='admin'>Admin</option>
            <option value='user' selected>User</option>
        </select>
<span style='color: red;'><?php echo $_GET["emailErr"]; ?></span><br>
<span style='color: red;'><?php echo $_GET["emailExistsErr"]; ?></span><br>
    E-mail: <input name='email' type='text' >   <br />

    password: <input name='password' type='password' > <span style='color: red;'><?php echo $_GET["passErr"]; ?></span><br />
    Re-type Password: <input name='password2' type='password' > <span style='color: red;'><?php echo $_GET["passMatchErr"]; ?></span><br />
    First: <input name='fname' type='text' ><br />
    Last: <input name='lname' type='text' ><br />
    Phone: <input name='phone' type='text' ><br />
    Address: <input name='address' type='text' ><br />
    Address2: <input name='address2' type='text' ><br />
    City: <input name='city' type='text' ><br />
    State: <input name='state' type='text' ><br />
    Zip code: <input name='zip_code' type='text' ><br />
    <input type="submit" value="Submit">
    
</form>
<?php
// read_template.php controls how the product list will be rendered
//include_once "read_template.php";
  
// layout_footer.php holds our javascript and closing html tags
include_once "layouts/layout_footer.php";
?>