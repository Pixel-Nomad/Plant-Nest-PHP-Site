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
  <title>About Us - Your E-Commerce Project</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
                        <a class="nav-link text-light" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Contact Us</a>
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
                        <a class="nav-link text-light" href="#">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown text-light pe-5">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
<div class="container my-5">
  <div class="row">
    <div class="col-lg-6">
      <h2>About Our Company</h2>
      <p>Welcome to GreenThumb Haven, your one-stop destination for all things related to plants and gardening! At GreenThumb Haven, we're passionate about bringing the beauty of nature into your life.

Our online store offers a wide variety of exquisite plants that cater to both beginners and seasoned gardeners. From vibrant flowering plants to lush greenery, we have something to suit every taste and style. Whether you're looking to add a touch of elegance to your indoor space or transform your outdoor garden into a botanical paradise, we've got you covered.

But that's not all – we also provide a curated selection of top-notch planting accessories to help you nurture your green companions. From ergonomic tools and premium soil blends to stylish pots and eco-friendly fertilizers, we believe that the right tools can make all the difference in your gardening journey.

What sets us apart is our commitment to quality and customer satisfaction. Our plants are carefully sourced and nurtured to ensure they arrive at your doorstep healthy and thriving. Our friendly team of gardening experts is always here to offer guidance and support, whether you're a novice or a seasoned pro.

At GreenThumb Haven, we're not just selling plants – we're fostering a community of plant enthusiasts who share a common love for all things green. Join us in creating a greener, more vibrant world, one plant at a time. Explore our online store and let nature's beauty inspire your space and life.</p>
    </div>
    <div class="col-lg-6">
      <img src='<?php echo $config['URL']?>/assets/image/logos/logo3.png' alt="Company Logo" class="img-fluid">
    </div>
  </div>
  
  <div class="row mt-5">
    <div class="col-lg-6">
      <h3>Who We Are</h3>
      <p>Description of who your company is...</p>
    </div>
    <div class="col-lg-6">
      <h3>What We Do</h3>
      <p>Description of what your company does...</p>
    </div>
  </div>
  
  <div class="row mt-5">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Team Member 1</h4>
          <p class="card-text">Role: </p>
          <p class="card-text">Description: </p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Team Member 2</h4>
          <p class="card-text">Role: </p>
          <p class="card-text">Description: </p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Team Member 3</h4>
          <p class="card-text">Role: </p>
          <p class="card-text">Description: </p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Team Member 4</h4>
          <p class="card-text">Role: </p>
          <p class="card-text">Description: </p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Team Member 5</h4>
          <p class="card-text">Role: </p>
          <p class="card-text">Description: </p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
