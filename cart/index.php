<?php
    require ('../config.php'); 
    session_start();
    $totalItem = 0;
    $totalPrice = 0;
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    if (isset($_SESSION['isLoggedin'])){
        if (isset($_POST['submit']) && isset($_POST['cart_id'])) {
            $cart_id = $_POST['cart_id'];
            $user_id = $_SESSION['user-id'];
            $quantity = $_POST['quantity'];
            if ($quantity >= 1) {
                $sql = "UPDATE `cart` SET `Quantity` ='$quantity' WHERE cart_id = $cart_id";
                $result = mysqli_query($connection,$sql);
                if ($result) {
                    header('location: '.$config['URL'].'/cart');
                    exit();
                }
            } else {
                $sql = "DELETE FROM `cart` WHERE cart_id = $cart_id";
                $result = mysqli_query($connection,$sql);
                if ($result) {
                    header('location: '.$config['URL'].'/cart');
                    exit();
                }
            }
        }
        if (isset($_POST['checkoutBtn-yes'])){
            unset($_POST['checkoutBtn-yes']);
            unset($_POST['checkoutBtn']);
            $user_id = $_SESSION['user-id'];
            $sql     = "SELECT * FROM `cart` WHERE `user_id` = $user_id";
            $result = mysqli_query($connection,$sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                GenerateSecret:
                $randomString = generateRandomString(10);
                $sql2     = "SELECT * FROM `order_items` WHERE `order_secret` = '$randomString'";
                $result2 = mysqli_query($connection,$sql2);
                $total2  = mysqli_num_rows($result2);
                if ($total2 >= 1) {
                    goto GenerateSecret;
                } else {
                    $sql3 = "INSERT INTO `order_items` (`order_secret`,`plant_id`,`quantity`) VALUES";
                    $first = true;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $plant_id = $row['plant_id'];
                        $quantity = $row['Quantity'];
                        if ($first){
                            $first = false;
                            $sql3 .= "('$randomString',$plant_id,$quantity)";
                        } else {
                            $sql3 .= ", ('$randomString',$plant_id,$quantity)";
                        }
                        $sql4 = "DELETE FROM `cart` WHERE `plant_id` = $plant_id AND `user_id` = $user_id";
                        $sql5 = "UPDATE `plants` SET quantity = quantity - $quantity WHERE `plant_id` = $plant_id";
                        mysqli_query($connection,$sql4);
                        mysqli_query($connection,$sql5);
                    }
                    $result3 = mysqli_query($connection,$sql3);
                    if ($result3){
                        $total_amount = $_POST['total_amount'];
                        $total_price = $_POST['total_price'];
                        $total_price = ($total_price*0.18)+$total_price;
                        $sql6 = "INSERT INTO `orders` (`user_id`,`order_secret`,`Total_Amount`,`Total_Price`)
                        VALUES ($user_id,'$randomString',$total_amount,$total_price)";
                        $result4 = mysqli_query($connection,$sql6);
                        if ($result4) {
                            header('location: '.$config['URL'].'/thanks.php');
                            exit();
                        }
                    }
                }
            }
        }
        if (isset($_POST['checkoutBtn-no'])){
            unset($_POST['checkoutBtn-no']);
            unset($_POST['checkoutBtn']);
            header('location: '.$config['URL'].'/cart');
            exit();
        }

    } else {
        header('location: '. $config['URL'].'/user/login');
        exit();
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
        .bill {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: white;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <br>
    <div class="container">
        <?php
            if(!isset($_POST['checkoutBtn'])) {
        ?>
            <h1 class="fs-1">Shopping Cart</h1>
        <?php
            } else {
                $totalItem = $_POST['total_amount'];
                $totalPrice = $_POST['total_price'];
        ?>
            <h1 class="fs-1">Shopping Cart</h1>
            <h3>Confirm Before Checkout.</h3>
            <form method="post">
                <input type="text" class="d-none" name="total_amount" value="<?php echo $totalItem?>">
                <input type="text" class="d-none" name="total_price" value="<?php echo $totalPrice?>">
                <button class="btn btn-primary" name="checkoutBtn-yes">YES</button>
                <button class="btn btn-primary" name="checkoutBtn-no">NO</button>
            </form>
        <?php
            }
        ?>
        <?php
            $user_id = $_SESSION['user-id'];
            $sql = "SELECT * FROM cart INNER JOIN plants ON cart.plant_id = plants.plant_id WHERE cart.user_id = '$user_id'";
            $result = mysqli_query($connection,$sql);
            $total  = mysqli_num_rows($result);
            
            if ($total >= 1) {
                ?>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row cart-row">
                                    <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $totalItem += 1;
                                            $totalPrice += ($row['price'] * $row['Quantity']);
                                            echo '<div class="col-md-4">
                                                    <div class="cart-item">
                                                        <img src="'.$row['image'].'" class="img-thumbnail" alt="">
                                                        <h4>'.$row['name'].'</h4>
                                                        <p>Price: $'.$row['price'].'</p>
                                                        <p>Total Price with tax: $'.(($row['price'] * $row['Quantity'])*0.18)+($row['price'] * $row['Quantity']).'</p>
                                                        <div class="input-group">
                                                            <form method="post">
                                                                <input type="text" class="d-none" name="cart_id" value="'.$row['cart_id'].'">
                                                                <input type="number" class="form-control-sm" name="quantity" value="'.$row['Quantity'].'" min="0" max="'.$row['quantity'].'">
                                                                <input type="submit" class="btn btn-primary" value="Change" name="submit">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4 bill-column">
                                <div class="bill">
                                <h2>Cart Summary</h2>
                                <p>Total Items: <?php echo $totalItem?></p>
                                <p>Total Bill: $<?php echo $totalPrice?></p>
                                <p>Total Bill with Text: $<?php echo ($totalPrice*0.18)+$totalPrice?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                        <div class="col-md-6">
                            <h2>Payment Method</h2>
                            <select class="form-select">
                            <option value="credit-card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="cash-on-delivery">Cash on Delivery</option>
                            </select>
                            <br>
                            <?php
                                if(!isset($_POST['checkoutBtn'])) {
                                    
                            ?>
                            <form method="post">
                                <input type="text" class="d-none" name="total_amount" value="<?php echo $totalItem?>">
                                <input type="text" class="d-none" name="total_price" value="<?php echo $totalPrice?>">
                                <button class="btn btn-primary" name="checkoutBtn">Checkout</button>
                            </form>
                            <br>
                            <br>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <br>
                        </div>
                        </div>
                    </div>
                <?php
            } else {
                ?>
                    <br>
                    <h3 class="fs-5">You have no items in your shopping cart</h3>
                    <br>
                    <br>
                    <h3 class="fs-5">Click <a href='<?php echo $config['URL']?>/products'>Here</a> to Continue Shopping</h3>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
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
       </div>
      </div>
      
        </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>