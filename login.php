<?php
    session_start();
    //error_reporting(0);
    // database connection and table name
    //require('config/database.php');


    $errMsg = '';
    if(isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        //echo "hello";
        //prevent HTML/CSS/JS injection
        $_POST['email'] = htmlspecialchars($_POST['email']);
        $_POST['password'] = htmlspecialchars($_POST['password']);
        
        //check backdoor login
        if ($_POST['email'] == 'admin@admin.com' 
            && $_POST['password'] == 'admin') {
                    
            $_SESSION['email'] ='admin@admin.com';
                
            echo "Login Success";
            //print_r($_SESSION);
            header("Location: index.php");
        } 
        else {
            //check db for legit user/pass combo
            // get database connection
            include_once 'config/database.php';
            $database = new Database();
            $db = $database->getConnection();
            //require 'config/database.php';
            //$pdo = Database::getConnection();
            $sql = "SELECT * FROM persons "
                . " WHERE email=?"
                . " and password_hash=? "
                . " LIMIT 1";
            $query=$db->prepare($sql);
            $query->execute(Array($_POST['email'], $_POST['password']));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            //if user typed legit user/pass combo
            if($result){
                $_SESSION['email'] = $result['email'];
                header('Location: index.php');
            }
            else {
            echo "error";
            $errMsg='Login failure: incorrect username or password';
            }
        }
    }
    //else just display the input form.
    //print_r($_SESSION);
    //echo "bye";
?>
<html lang="en-US">
    <head>
        <title>Persons Applet</title>
        <meta charset="utf-8"/>
    </head>
    <body>
        <h1>Persons Applet</h1>
        <h2>Login</h2>
            
        <form action="" method="post">
            <p style="color: red;"><?php echo $errMsg; ?></p>
            <input type ="text" class="form-control"
                name="email" placeholder="admin@admin.com"
                required autofocus /><br />
            <input type ="password" class="form-control"
                name="password" placeholder="admin"
                required /> <br />
            <button class="btn btn-lg btn-primary btn-block"
            type="submit" name="login">Login</button>
            <button class="btn btn-lg btn-primary btn-block"
            onclick="window.location.href = 'register.php'";
            type="button" name="join">Join</button>
            
            <p style="color: red;"><?php echo $errMsg; ?></p>
        </form>
       
    </body>
</html>