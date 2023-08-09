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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <img src='<?php echo $config['URL']?>/assets/image/logos/logo8.png' class="rounded mx-auto d-block" alt="..." onclick="redirect('<?php echo $config['URL']?>')">
        <div class="row row-cols-1 row-cols-md-3 m-4">
            <div class="col">
                <br>
            </div>
            <div class="col">
                <div class="card addHover p-3 mb-5 bg-gradient rounded">
                    <div class="card-body">
                        <h5 class="card-title text-center pb-6">Create Account</h5>
                        <form method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Username</label>
                                <p class="card-text text-danger"><?php
                                if (isset($_POST['submit'])) {
                                  $username       = $_POST['username'];
                                  $search      = "SELECT * FROM users WHERE username='".$username."'";
                                  $result      = mysqli_query($connection, $search);
                                  $unique      = true;
                                  if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                      if ($row['username'] == $username){
                                        $unique = false;
                                      }
                                    }
                                  }
                                  if (!$unique) {
                                    echo 'Username Already Taken';
                                  }
                                }
                              ?></p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="fullname" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Full Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                              <p class="card-text text-danger"><?php
                                if (isset($_POST['submit'])) {
                                  $email       = $_POST['email'];
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
                                  if (!$unique) {
                                    echo 'Email Already Registered';
                                  }
                                }
                              ?></p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="contact" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Contact Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password2" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Re-Enter Password</label>
                                <p class="card-text mt-2 mb-3">Enter Password That Contain Atleat 6 Characters</p>
                              <p class="card-text text-danger"><?php
                                if (isset($_POST['submit']) && isset($_POST['password'])) {
                                  $password    = strval($_POST['password']);
                                  $password2   = strval($_POST['password2']);
                                  if (strlen($password) >= 6){
                                    if (!($password == $password2)) {
                                      echo 'Password Not Match';
                                    }
                                  } else {
                                    echo 'Password Must be 6 Characters long';
                                  }
                                }
                              ?></p>
                              </div>
                                <a href='<?php echo $config['URL']?>/user/login/'><p>Already have an account? Login now.</p></a>
                              <div class="d-grid gap-2 col-6 mx-auto">
                                <input type="submit" value="Sign Up" class="btn btn-warning mt-3" name="submit">
                              </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <br>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<?php

    if ($connection) {
        if (isset($_POST['submit'])){
            $username    = $_POST['username'];
            $fullname    = $_POST['fullname'];
            $email       = $_POST['email'];
            $contact       = $_POST['contact'];
            $password    = strval($_POST['password']);
            if (strlen($password) >= 6){
              $password2   = strval($_POST['password2']);
              $encrypt     = sha1($password);
              $search      = "SELECT * FROM users WHERE email='".$email."' OR '".$username."'";
              $result      = mysqli_query($connection, $search);
              $unique      = true;
              $unique2     = true;
              if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($row['email'] == $email){
                    $unique = false;
                  }
                  if ($row['username'] == $username){
                    $unique2 = false;
                  }
                }
              }
              if ($password == $password2 && $unique && $unique2) {
                  $sql = "INSERT INTO `users`( `username`, `fullname`, `email`, `contact`, `password`) VALUES (
                      '$username','$fullname','$email','$contact','$encrypt')";
                  $query = mysqli_query($connection, $sql);
                  if ($query){
                      header("location: ".$config['URL']."/user/login"); 
                      exit();
                  } else {
                      echo "<script>alert('Failed To Register');</script>";
                      exit();
                  }
              }
          }
        }
    } else {
      echo "<script>alert('Failed To Register');</script>";
    }
?>