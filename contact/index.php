<?php
    require ('../config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .addHover:hover {
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.306) !important;
        }
        .background {
            background-image: url('your-image.jpg'); /* Replace with the path to your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh; /* Adjust to your needs */
            color: white; /* Adjust text color for readability */
            text-align: center;
            padding: 100px 0;
        }
    </style>
</head>
<body background='<?php echo $config['URL']?>/assets/image/pics/bg.jpg'>
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
                                if ($_SESSION['isVerified']) {
                                    if ($_SESSION['user-role'] != 'user') {
                        ?>
                            <a class="nav-link text-light" href='<?php echo $config['URL']?>/admin'>Admin Login</a>
                        <?php
                                    }
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
                    <?php
                        if (!$_SESSION['isVerified']){
                    ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="<?php echo $config['URL'] ?>/user/verify">Verify</a>
                        </li>
                    <?php
                        }
                    ?>
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
    <br>
    <br>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 ">
                <div class="ratio addHover ratio-4x3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7241.851049452093!2d67.03347706701418!3d24.832220398310515!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33dc90e075d63%3A0xc5be26a200669971!2sBlock%208%20Clifton%2C%20Karachi%2C%20Karachi%20City%2C%20Sindh%2075600%2C%20Pakistan!5e0!3m2!1sen!2sus!4v1695146733579!5m2!1sen!2sus" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card mt-5 addHover p-3 mb-5 bg-gradient rounded">
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Email:</p>
                            <a href="mailto:mr.tgamer247797704@gmail.com">Email: mr.tgamer247797704@gmail.com</a>
                            <br>
                            <br>
                            <p class="fw-bold">Address:</p>
                            <p class="fw-normal">Clifton Block 8,Karachi, Pakistan</p>
                            <p class="fw-bold">Number:</p>
                            <p class="fw-normal">+923082838448</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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