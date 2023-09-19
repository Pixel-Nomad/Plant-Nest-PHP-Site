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
    <div class="main" style="background-color: azure">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col-md-6 mt-4 pt-5">
                    <h2 class="text-center">About us</h2>
                    <p>Plant Nest is an online facility for plant enthusiasts who have a habit of collecting and treasuring many plant species. Rather than spending tiring hours in traditional plant shops and markets, we provide an online platform for researching and purchasing various gardening essentials from the comfort of our own homes. We aim to modify and ease the process of setting up and maintaining personal gardens which is a great source of pleasure for many. Our objective is to create an interactive and satisfied customer outreach. Due to the nature of our business, we are available 24/7 and we hope to provide you key gardening requisites at reasonable prices and favorable delivery times.</p>
                </div>
                <div class="col-md-4 mt-4">
                    <img src='<?php echo $config['URL']?>/assets/image/logos/logo.png' class="rounded mx-auto d-block ps-5" alt='<?php echo $config['URL']?>/assets/image/logos/logo7.png'>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
        <!-- Left Image Card -->
        <div class="col-md-6">
            <div class="card mb-4">
            <img src='<?php echo $config['URL']?>/assets/image/about/7.webp' class="card-img-top" alt="Left Image">
            </div>
        </div>

        <!-- Right Image Card -->
        <div class="col-md-6">
            <div class="card mb-4">
            <img src='<?php echo $config['URL']?>/assets/image/about/6.webp' class="card-img-top" alt="Right Image">

            </div>
        </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Who we are.</h2>
                <p style="text-align: left;">Plant Nest is a dedicated online haven designed for passionate plant enthusiasts who revel in cultivating and cherishing diverse plant varieties. Our platform reimagines the conventional plant shopping experience, offering a virtual space to explore, research, and acquire an array of gardening essentials. With a commitment to convenience and a shared love for cultivating green sanctuaries, Plant Nest is your gateway to a rewarding and interactive gardening journey.</p>
            </div>
            <div class="col-md-6">
                <h2>What we do.</h2>
                <p style="text-align: left;">At Plant Nest, we revolutionize the process of curating and maintaining personal gardens by providing a seamless online marketplace. By transcending the confines of traditional brick-and-mortar plant shops and markets, we bring gardening aficionados an unparalleled selection of plants and gardening supplies, accessible anytime, anywhere. Our mission is to simplify the journey of setting up and nurturing gardens, offering a diverse range of quality products at affordable prices, coupled with efficient delivery options. With round-the-clock availability, Plant Nest stands as your steadfast companion in creating thriving garden sanctuaries that bring joy and satisfaction.</p>
            </div>
        </div>
    </div>
    <hr class="divider" />
    <div class="container">
      <p class="text-center fs-1">Our Team</p>

      <div class="row row-cols-1 row-cols-md-3 m-4" id="cards">
        <div class="col">
          <div class="card addHover p-3 mb-5 bg-gradient rounded">
            <img
              src='<?php echo $config['URL']?>/assets/image/about/3.jpeg'
              class="card-img-top image-fluid"
              alt="picture"
            />
            <div class="card-body">
              <h5 class="card-title text-center">Sujal Shah Gopalani</h5>
              <p class="card-text text-center">Frontend Developer & Tester</p>
            </div>
            <div class="card-footer text-center">Since 2022</div>
          </div>
        </div>
        
        <div class="col">
          <div class="card addHover p-3 mb-5 bg-gradient rounded">
            <img
              src='<?php echo $config['URL']?>/assets/image/about/2.jpeg'
              class="card-img-top image-fluid"
              alt="picture"
            />
            <div class="card-body">
              <h5 class="card-title text-center">Tayyab Naseem</h5>
              <p class="card-text text-center">Project Leader & Backend Developer</p>
            </div>
            <div class="card-footer text-center">Since 2022</div>
          </div>
        </div>
        <div class="col">
          <div class="card addHover p-3 mb-5 bg-gradient rounded">
            <img
              src='<?php echo $config['URL']?>/assets/image/about/4.jpeg'
              class="card-img-top image-fluid"
              alt="picture"
            />
            <div class="card-body">
              <h5 class="card-title text-center">Usaid Aamir</h5>
              <p class="card-text text-center">Frontend Developer & Tester</p>
            </div>
            <div class="card-footer text-center">Since 2022</div>
          </div>
        </div>
        <div class="col">
          <div class="card addHover p-3 mb-5 bg-gradient rounded">
            <img
              src='<?php echo $config['URL']?>/assets/image/about/5.jpeg'
              class="card-img-top image-fluid"
              alt="picture"
            />
            <div class="card-body">
              <h5 class="card-title text-center">Atta Ur Rehman</h5>
              <p class="card-text text-center">Frontend Developer</p>
            </div>
            <div class="card-footer text-center">Since 2022</div>
          </div>
        </div>
        <div class="col">
          <div class="card addHover p-3 mb-5 bg-gradient rounded">
            <img
              src='<?php echo $config['URL']?>/assets/image/about/1.jpeg'
              class="card-img-top image-fluid"
              alt="picture"
            />
            <div class="card-body">
              <h5 class="card-title text-center">Ayat Shah</h5>
              <p class="card-text text-center">Frontend Developer</p>
            </div>
            <div class="card-footer text-center">Since 2022</div>
          </div>
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