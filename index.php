<?php
    require ('./config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if (isset($_POST['submit']) && isset($_POST['plant_id'])){
        if (isset($_SESSION['isLoggedin'])){
            $user_id = $_SESSION['user-id'];
            $plant_id = $_POST['plant_id'];
            $sql = "SELECT * FROM `cart` WHERE `user_id` = $user_id AND `plant_id` = $plant_id";
            $result = mysqli_query($connection,$sql);
            $total  = mysqli_num_rows($result);
            if ($total == 1) {
                header('location: '. $config['URL'].'/cart');
                exit();
            } else {
                $sql2 = "INSERT INTO `cart` (`user_id`, `plant_id`, `Quantity`) 
                VALUES ($user_id, $plant_id, 1)";
                $result2 = mysqli_query($connection,$sql2);
                if ($result2) {
                    header('location: '. $config['URL'].'/cart');
                    exit();
                }
            }
        } else {
            header('location: '. $config['URL'].'/user/login');
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
    <?php
        $sql = "SELECT * FROM `sliders`";
        $result = mysqli_query($connection,$sql);
        $total  = mysqli_num_rows($result);
        if ($total >= 1) {
    ?>
    <div id="Sliders_dynamic" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
                for ($i = 0; $i < $total; $i++) {
                    if ($i == 0) {
                        echo '<button type="button" data-bs-target="#Sliders_dynamic" data-bs-slide-to="'.$i.'" class="active" aria-current="true" aria-label="Slide '.$i.'"></button>';
                    } else {
                        echo '<button type="button" data-bs-target="#Sliders_dynamic" data-bs-slide-to="'.$i.'" aria-label="Slide '.$i.'"></button>';
                    }
                }
            ?>
        </div>
        <div class="carousel-inner">
            <?php
                $first = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($first) {
                        $first = false;
                        echo '<div class="carousel-item active">
                                <img src="'.$row['image'].'" class="d-block w-100" alt="'.$row['image'].'">
                                <div class="carousel-caption d-none d-md-block">';
                                if ($row['dark'] == 'yes') { 
                                    echo '<h5 class="text-dark">'.$row['text'].'</h5>
                                    <p class="text-dark">'.$row['description'].'</p>';
                                } else {
                                    echo '<h5>'.$row['text'].'</h5>
                                    <p>'.$row['description'].'</p>';
                                }
                                echo '</div>
                                </div>';
                    } else {
                        echo '<div class="carousel-item">
                                <img src="'.$row['image'].'" class="d-block w-100" alt="'.$row['image'].'">
                                <div class="carousel-caption d-none d-md-block">';
                                if ($row['dark'] == 'yes') { 
                                    echo '<h5 class="text-dark">'.$row['text'].'</h5>
                                    <p class="text-dark">'.$row['description'].'</p>';
                                } else {
                                    echo '<h5>'.$row['text'].'</h5>
                                    <p>'.$row['description'].'</p>';
                                }
                                echo '</div>
                                </div>';
                    }
                }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#Sliders_dynamic" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#Sliders_dynamic" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <?php
        }
    ?>
    <hr class="divider" />
    <div class="container">
        <h1 class="text-center fs-1">Featured Products</h1>
        <?php
            $sql = "SELECT * FROM `plants` WHERE `featured` = 'yes'";
            $result = mysqli_query($connection,$sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
        ?>
        <div class="row row-cols-1 row-cols-md-4 m-4" id="cards">
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col">
                            <div class="card addHover p-3 mb-5 bg-gradient rounded">
                                <img src="'.$row['image'].'" class="card-img-top image-fluid"
                                alt="'.$row['image'].'" />
                                <div class="card-body">
                                    <h5 class="card-title text-center">'.$row['name'].'</h5>
                                </div>
                                <hr class="divider" />
                                <div class="row">
                                    <div class="col">
                                        <p class="fw-bold">Available:</p>
                                        <p class="fw-bold">Price:</p>
                                    </div>
                                    <div class="col">
                                        <p class="fw-normal">'.$row['quantity'].'</p>
                                        <p class="fw-normal text-success">$'.$row['price'].'</p>
                                    </div>
                                </div>
                                <hr class="divider" />
                                <div>';
                                    if ($row['quantity'] >= 1){
                                    echo '<form method="post" class="d-grid gap-2 col-6 mx-auto">
                                            <input type="text" class="d-none" name="plant_id" value="'.$row['plant_id'].'">
                                            <input type="submit" class="btn btn-secondary" name="submit" value="Add To Cart">
                                    </form>';
                                    } else {
                                        echo '<h3 class="text-center">SOLD OUT</h3>';
                                    }
                                echo'</div>
                            </div>
                        </div>';
                }
            ?>
            
        </div>
        <?php
            }
        ?>
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