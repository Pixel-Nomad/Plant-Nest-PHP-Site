<?php
    require ('../config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if (isset($_POST['submit']) && isset($_POST['plant_id'])){
        if (isset($_SESSION['isLoggedin'])){

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
    <title>Document</title>
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
                        <a class="nav-link text-light" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">About Us</a>
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
    <?php
        $query = "SELECT * FROM `plants`";
        if (isset($_GET['id']) && is_numeric($_GET['id'])){
            $id = (int)$_GET['id'];
            $query .= "WHERE `category_id` =$id";
        }
        $result = mysqli_query($connection,$query);
        $total  = mysqli_num_rows($result);
    ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 m-4">
            <div class="col">
                <h1 class="fs-1 ">Products</h1>
            </div>
            <div class="col">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <h4 class="fs-5 pt-2"><?php echo $total.' items'?></h4>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                            <?php
                                $sql2 = "SELECT * FROM `category`";
                                $result2 = mysqli_query($connection,$sql2);
                                $total2  = mysqli_num_rows($result2);
                                echo '<li><a class="dropdown-item" href="'.$config['URL'].'/products">All Products</a></li>';
                                if ($total2 >= 1) {
                                    while ($row = mysqli_fetch_assoc($result2)) {
                                        echo '<li><a class="dropdown-item" href="'.$config['URL'].'/products?id='.$row['category_id'].'">'.$row['Name'].'</a></li>';
                                    }
                                }
                                echo '<li><a class="dropdown-item" href="'.$config['URL'].'/products?id=0">Accessories</a></li>';
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 m-4">
            <?php
                if ($total >= 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col">
                                <div class="card addHover p-3 mb-5 bg-gradient rounded">
                                    <img src="'.$row['image'].'" class="card-img-top image-fluid" alt="Painting"/>
                                    <div class="card-body">
                                        <h5 class="card-title text-center">'.$row['name'].'</h5>
                                        <p class="card-text">'.$row['description'].'</p>
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
                                    <div >';
                                        if ($row['quantity'] >= 1){
                                            echo '<form method="post" class="d-grid gap-2 col-6 mx-auto">
                                                <input type="text" class="d-none" name="plant_id" value="'.$row['plant_id'].'">
                                                <input type="submit" class="btn btn-secondary" name="submit" value="Add To Cart">
                                            </form>';
                                        } else {
                                            echo '<h3 class="text-center">SOLD OUT</h3>';
                                        }
                                    echo '</div>
                                </div>
                            </div>';
                    }
                }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>