<?php
    require ('../../config.php'); 
    session_start();
    if (!isset($_SESSION['isLoggedin'])){
    session_unset();
    session_destroy();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
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
              while ($row = mysqli_fetch_assoc($result)) {
                  $_SESSION['user-id'] = $row['user_id'];
                  $_SESSION['user-username'] = $row['username'];
                  $_SESSION['user-fullname'] = $row['fullname'];
                  $_SESSION['user-email'] = $row['email'];
                  $_SESSION['user-contact'] = $row['contact'];
                  $_SESSION['user-role'] = $row['role'];
                  $_SESSION['user-company'] = $row['company'];
                  $_SESSION['user-address'] = $row['address'];
                  $_SESSION['user-country'] = $row['country'];
                  $_SESSION['user-city'] = $row['city'];
              }
              $_SESSION['email'] = $email;
              $_SESSION['isLoggedin'] = true;
              header('location: '.$config['URL']);
              exit();
          }
          }
      }
      } else {
          header('location: '.$config['URL']);
      }
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src='<?php echo $config['URL']?>/assets/image/logos/logo7.png' alt="Site Logo" width="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL']?>/'>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL']?>/about'>About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <?php
                                $sql = "SELECT * FROM `category`";
                                $result = mysqli_query($connection,$sql);
                                $total  = mysqli_num_rows($result);
                                if ($total >= 1) {
                                    echo '<li><a class="dropdown-item" href="'.$config['URL'].'/products">All Products</a></li>';
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<li><a class="dropdown-item" href="'.$config['URL'].'/products?id='.$row['category_id'].'">'.$row['Name'].'</a></li>';
                                    }
                                }
                                echo '<li><a class="dropdown-item" href="'.$config['URL'].'/products?id=0">Accessories</a></li>';
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL']?>/contact'>Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <?php
                            if (isset($_SESSION['isLoggedin'])){
                                if ($_SESSION['user-role'] != 'user') {
                        ?>
                            <a class="nav-link text-light" href="#">Admin Login</a>
                        <?php
                                }
                            } 
                        ?>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION['isLoggedin'])){
                ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL']?>/cart/'>
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown text-light pe-5">
                        <a class="nav-link dropdown-toggle" href='<?php echo $config['URL']?>/cart/' id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href='<?php echo $config['URL']?>/user/settings'>Settings</a></li>
                            <li><a class="dropdown-item" href='<?php echo $config['URL']?>/user/logout'>Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
                    } else {
                ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL']?>/user/login'>Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL']?>/user/register'>Sign up</a>
                    </li>
                </ul>
                
                <?php
                    }
                ?>
                
            </div>
        </div>
    </nav>
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
    <footer class="bg-dark text-white p-4">
        <div class="container">
      <div class="row row-cols-1 row-cols-md-4">
        <div class="col">
        <img src='<?php echo $config['URL']?>/assets/image/logos/logo10.png' alt="Website Logo" class="mb-3 ms-3" >

        </div>
        <div class="col pt-5">
            <h5>Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href='<?php echo $config['URL']?>/'>Home</a></li>
            <li><a href='<?php echo $config['URL']?>/about'>About Us</a></li>
            <li><a href='<?php echo $config['URL']?>/feedback'>Feedback Form</a></li>
            <?php
                if (isset($_SESSION['isLoggedin'])){
            ?>
                <li><a href='<?php echo $config['URL']?>/user/settings'>Settings</a></li>
            <?php
                } 
            ?>
            <li><a href='<?php echo $config['URL']?>/products'>Products</a></li>
            <li><a href='<?php echo $config['URL']?>/user/orders'>My Orders</a></li>
          </ul>
        </div>
        <div class="col pt-5">
            <h5>Contact Us</h5>
            <p>Email: plantnest@gmail.com</p>
            <p>Phone: 0000-0000000</p>
            <p>Address: Clifton,Karachi, Pakistan</p>
        </div>
       <div class="col pt-5">
        <a href="https://www.facebook.com/" class="fa fa-facebook pe-2"></a>
          <a href="https://www.instagram.com/" class="fa fa-instagram pe-2"></a>
          <a href="https://www.twitter.com/" class="fa fa-twitter pe-2"></a>
          <a href="https://www.youtube.com/" class="fa fa-youtube pe-2"></a>
          <br>
          <br>
          <a href="#" class="text-white me-3">Privacy Policy</a>
          <a href="#" class="text-white me-3">Terms of Service</a>
       </div>
      </div>
      
        </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>