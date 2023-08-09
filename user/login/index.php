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
                        <h5 class="card-title text-center mb-4">Login</h5>
                        <form action="" method="post">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" required id="floatingInput" placeholder="name@example.com">
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
                                  if ($unique) {
                                    echo 'Email Not Found';
                                  }
                                }
                              ?></p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" required id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <p class="card-text text-danger"><?php
                                if (isset($_POST['submit'])&&isset($_POST['email']) && isset($_POST['password'])) {
                                    $email       = $_POST['email'];
                                    $password    = strval($_POST['password']);
                                    if (strlen($password) >= 6){
                                        $search      = "SELECT * FROM users WHERE email='".$email."'";
                                        $result      = mysqli_query($connection, $search);
                                        $unique      = true;
                                        $encrypt     = sha1($password);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['password'] == sha1($password)){
                                                $unique = false;
                                            }
                                            }
                                        }
                                        if ($unique) {
                                            echo 'Password Incorrect';
                                        }
                                    } else {
                                        echo 'Password Must Be 6 Character Long';
                                    }
                                }
                              ?></p>
                            </div>
                            <a href='<?php echo $config['URL']?>/user/forget'><p>Forget Password?.</p></a>
                            <a href='<?php echo $config['URL']?>/user/register'><p>Don't have an account? Get one now.</p></a>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <input type="submit" value="Login" class="btn btn-warning mt-3" name="submit">
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

if (isset($_POST['submit'])&&isset($_POST['email']) && isset($_POST['password'])){
  $email    = $_POST['email'];
  $password = strval($_POST['password']);
  $encrypt  = sha1($password);
  if (strlen($password) >= 6){
    $sql = "SELECT * FROM `users` WHERE `email`= '$email' AND `password`='$encrypt'";

    $result = mysqli_query($connection,$sql);
  
    $total  = mysqli_num_rows($result);
  
    if ($total == 1) {
        session_start();
        $_SESSION['email'] = $email;
        header('location: '.$config['URL']);
        exit();
    }
    }
  ?>
<!-- //   else {
//     <script>alert('Incorrect Email or Password')</script>
//   } -->
<?php
}

?>