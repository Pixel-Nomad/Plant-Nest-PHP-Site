<?php
require ('../../config.php');  
session_start();
session_unset();
session_destroy();
$connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="main">
      <div class="center">
        <form action="" method="post">
          <h1><b>Sign Up </b></h1>
          <div class="text_field">
            <input type="text" name="username" required />
            <span></span>
            <label>User Name</label>
          </div>
          <div class="text_field">
            <input type="text" name="fullname" required />
            <span></span>
            <label>Full Name</label>
          </div>
          <div class="text_field">
            <input type="email" name="email" required />
            <span></span>
            <label>Email</label>
          </div>
          <p style="color: red;">Email is already registered.</p>

          <div class="text_field">
            <input min="0" max="99999999999" type="number" required />
            <span></span>
            <label>Contact Number</label>
          </div>

          <div class="text_field">
            <input type="password" name="password" required />
            <span></span>
            <label>Password</label>
          </div>

          <div class="text_field">
            <input type="password" name="password2" required />
            <span></span>
            <label>Re-enter Password</label>
          </div>
          <p style="color: red;">Password not matched.</p>

          <input type="submit" value="Sign Up" name="submit"/>
          <div class="signup">
            Do You Have An Account ?
            <a href="login.html">Login</a>
          </div>
        </form>
      </div>
    </div>
    
  </body>
</html>

<?php

    if ($connection) {
        if (isset($_POST['submit'])){
            $username    = $_POST['username'];
            $fullname    = $_POST['fullname'];
            $email       = $_POST['email'];
            $password    = strval($_POST['password']);
            $password2   = strval($_POST['password2']);
            $encrypt     = sha1($password);
            $search      = "SELECT * FROM users WHERE email='".$email."'";
            $result      = mysqli_query($connection, $search);
            $unique      = true;
            if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                if ($row['email'] == $email){
                  $unique = false;
                }
              }
            }
            if ($password == $password2 && $unique) {
                $sql = "INSERT INTO `users`( `username`, `fullname`, `email`, `password`) VALUES (
                    '$username','$fullname','$email','$encrypt')";
                $query = mysqli_query($connection, $sql);
                if ($query){
                    header("Location: ".$config['URL']."/user/login/index.php"); 
                    exit();
                } else {
                    echo "<script>alert('Failed To Register');</script>";
                    exit();
                }
            }
        }
    } else {
      echo "<script>alert('Failed To Register');</script>";
    }
?>