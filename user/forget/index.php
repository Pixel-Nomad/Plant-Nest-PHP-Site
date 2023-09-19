<?php
    session_start();
    require ('../../config.php'); 
    require '../../vendor/phpmailer/Exception.php';
    require '../../vendor/phpmailer/PHPMailer.php';
    require '../../vendor/phpmailer/SMTP.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    if (!isset($_SESSION['isLoggedin'])){

    if (!isset($_SESSION['forget'])){
        session_unset();
        session_destroy();
    }
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if ($connection) {
        if (isset($_POST['submit']) && isset($_POST['email'])){
            $email    = $_POST['email'];
            $sql = "SELECT * FROM `users` WHERE `email`= '$email'";
            $result = mysqli_query($connection,$sql);
            $total  = mysqli_num_rows($result);
  
            if ($total == 1) {
                session_start();
                $_SESSION['forget'] = true;
                $_SESSION['forget-code-check'] = true;
                $_SESSION['forget-email'] = $email;
                $sql2 = "SELECT * FROM `codes` WHERE `mail`= '$email'";
                $result2 = mysqli_query($connection,$sql2);
                $total2  = mysqli_num_rows($result2);
                if ($total2 == 1) {
                    goto  SkipChecks;
                }
                GenerateCode:
                $randomNumber = mt_rand(100000, 999999);
                $newrandomNumber = sha1($randomNumber);
                $sql3 = "SELECT * FROM `codes` WHERE `mail`= '$email' AND `type`='forget' AND `code`= '$newrandomNumber'";
                $result2 = mysqli_query($connection,$sql2);
                $total3  = mysqli_num_rows($result2);
                if ($total3 == 1) {
                    goto GenerateCode;
                } else {
                    $sql4 = "INSERT INTO `codes`( `mail`, `code`, `type`) VALUES (
                        '$email','$newrandomNumber','forget')";
                    $query4 = mysqli_query($connection, $sql4);
                    if (!$query4){ 
                        echo "Failed To insert code";
                    }
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'mr.tgamer247797704@gmail.com'; 
                        $mail->Password   = 'seasiuyldxhdnahs';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;
                        // Recipients
                        $mail->setFrom('mr.tgamer247797704@gmail.com', 'NoReply - Reset Code');
                        $mail->addAddress($_SESSION['forget-email'], $_SESSION['forget-email']); // Email and name of recipient
                        
                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Password Reset Request';
                        $mail->Body    = 'This is Your Code:'.$randomNumber;

                        $mail->send();
                    } catch (Exception $e) {
                        goto  SkipChecks;
                    }
                }
                SkipChecks:
                header('location: '.$config['URL'].'/user/forget');
                exit();
                check:
            }
        }
        if (isset($_POST['submit2']) && isset($_POST['code'])) {
            $code    = $_POST['code'];
            $code = sha1($code);
            $email   = $_SESSION['forget-email'];
            $sql = "SELECT * FROM `codes` WHERE `mail`= '$email' AND `type`='forget' AND `code`= '$code'";
            $result = mysqli_query($connection,$sql);
            $total  = mysqli_num_rows($result);
            if ($total == 1) {
                unset($_SESSION['forget-code-check']);
                $_SESSION['forget-code-confirmed'] = true;
                $sql2 = "DELETE FROM `codes` WHERE mail = '$email' AND `type`='forget'";
                $result = mysqli_query($connection,$sql2);
            }
        }
        if (isset($_POST['submit3']) && isset($_POST['password'])) {
            $password    = strval($_POST['password']);
            if (strlen($password) >= 6){
                $password2   = strval($_POST['password2']);
                $encrypt     = sha1($password);
                if ($password == $password2) {
                    $email   = $_SESSION['forget-email'];
                    $sql = "UPDATE `users` SET `password`='$encrypt' WHERE email = '$email'";
                    $result = mysqli_query($connection,$sql);
                    if ($result) {
                        session_unset();
                        session_destroy();
                        header('location: '.$config['URL'].'/user/login');
                        exit();
                    }
                }
            }
        }
    } else {
      echo "<script>alert('Failed To Register');</script>";
    }
} else {
    if(isset($_SERVER['HTTP_REFERER'])) {
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header('location: '. $config['URL']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Nest</title>
    <link rel="icon" href='<?php echo $config['URL']?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL']?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .addHover:hover {
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.306) !important;
        }
    </style>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            More Pages
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href='<?php echo $config['URL']?>/contact'>Contact Us</a></li>
                            <li><a class="dropdown-item" href='<?php echo $config['URL']?>/feedback'>Feedback Form</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <?php
                            if (isset($_SESSION['isLoggedin'])){
                                if ($_SESSION['user-role'] != 'user') {
                        ?>
                            <a class="nav-link text-light" href='<?php echo $config['URL']?>/admin'>Admin Login</a>
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
                        <a class="nav-link text-light">
                          Welcome <strong><?php echo $_SESSION['user-username'];?></strong>
                        </a>
                    </li>
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
                            <li><a class="dropdown-item" href='<?php echo $config['URL']?>/user/orders'>My Orders</a></li>
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
        <?php
            if (!isset($_SESSION['forget'])) {
        ?>
            <div class="forget-1">
            <div class="row row-cols-1 row-cols-md-3 m-4">
                <div class="col">
                    <br>
                </div>
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Forget Password</h5>
                            <form action="" method="post">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" name="email" required id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Email address</label>
                                    <p class="card-text text-danger"><?php
                                        if (isset($_POST['submit'])) {
                                        $email       = $_POST['email'];
                                        $search      = "SELECT * FROM users WHERE email='".$email."'";
                                        $result      = mysqli_query($connection, $search);
                                        $unique      = false;
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['email'] == $email){
                                                $unique = true;
                                            }
                                            }
                                        }
                                        if (!$unique) {
                                            echo 'Email Not Found';
                                        }
                                        }
                                    ?></p>
                                </div>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <input type="submit" value="Continue" name="submit" class="btn btn-warning mt-3">
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
        <?php
            }
            if (isset($_SESSION['forget-code-check'])) {
        ?>
        <div class="forget-2">
            <div class="row row-cols-1 row-cols-md-3 m-4">
                <div class="col">
                    <br>
                </div>
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Forget Password</h5>
                            <form  method="post">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="code" required id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Enter Code</label>
                                </div>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <input type="submit" value="Submit" name="submit2" class="btn btn-warning mt-3">
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
        <?php
            }
            if (isset($_SESSION['forget-code-confirmed'])) {
        ?>
        <div class="forget-3">
            <div class="row row-cols-1 row-cols-md-3 m-4">
                <div class="col">
                    <br>
                </div>
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Forget Password</h5>
                            <form action="" method="post">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name='password' required id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingInput" name='password2' required placeholder="name@example.com">
                                    <label for="floatingInput">Re-Enter Password</label>
                                    <p class="card-text text-danger"><?php
                                        if (isset($_POST['submit3']) && isset($_POST['password'])) {
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
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <input type="submit" value="Reset" name='submit3' class="btn btn-warning mt-3">
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
        <?php
            }
        ?>
        
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
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
            <a href="mailto:mr.tgamer247797704@gmail.com">Email: mr.tgamer247797704@gmail.com</a>
            <br>
            <br>
            <p>Phone: +923082838448</p>
            <p>Address: Clifton Block 8,Karachi, Pakistan</p>
        </div>
       <div class="col pt-5">
        <a href="https://www.facebook.com/" class="fa fa-facebook pe-2" target="_blank"></a>
          <a href="https://www.instagram.com/" class="fa fa-instagram pe-2" target="_blank"></a>
          <a href="https://www.twitter.com/" class="fa fa-twitter pe-2" target="_blank"></a>
          <a href="https://www.youtube.com/" class="fa fa-youtube pe-2" target="_blank"></a>
          <br>
          <br>
          <a href="#" class="text-white me-3">Privacy Policy</a>
          <a href="#" class="text-white me-3">Terms of Service</a>
          <br>
          <a href='<?php echo $config['URL']?>/sitemap' class="text-white me-3">Site Map</a>
       </div>
      </div>
      
        </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>