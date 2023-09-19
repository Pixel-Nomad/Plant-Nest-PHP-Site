<?php
require('../config.php');
session_start();
$connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
function isWhitespaceString($str)
{
    echo $str;
    echo trim($str);
    return (trim($str) === '');
}
if (isset($_POST['submit']) && isset($_POST['plant_id'])) {
    if (isset($_SESSION['isLoggedin'])) {
        if ($_SESSION['isVerified']) {
            $user_id = $_SESSION['user-id'];
            $plant_id = $_POST['plant_id'];
            $sql = "SELECT * FROM `cart` WHERE `user_id` = $user_id AND `plant_id` = $plant_id";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total == 1) {
                header('location: ' . $config['URL'] . '/cart');
                exit();
            } else {
                $sql2 = "INSERT INTO `cart` (`user_id`, `plant_id`, `Quantity`) 
                    VALUES ($user_id, $plant_id, 1)";
                $result2 = mysqli_query($connection, $sql2);
                if ($result2) {
                    header('location: ' . $config['URL'] . '/cart');
                    exit();
                }
            }
        } else {
            header('location: ' . $config['URL'] . '/user/verify');
            exit();
        }
    } else {
        header('location: ' . $config['URL'] . '/user/login');
        exit();
    }
}
if (isset($_POST['submit2']) && isset($_POST['plantId'])) {
    $user_id = $_SESSION['user-id'];
    $plant_id = $_POST['plantId'];
    $stars = $_POST['review-stars'];
    $review = $_POST['review-text'];
    $sql = "INSERT INTO `reviews` (`plant_id`, `user_id`, `stars`, `review`) 
        VALUES ($plant_id, $user_id, $stars,'$review')";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header('location: ' . $config['URL'] . '/products');
        exit();
    }
}
if (isset($_POST['submit3']) && isset($_POST['search-type'])) {
    if ($_POST['search-type'] == 'name' || $_POST['search-type'] == 'description') {
        if (isWhitespaceString($_POST['search-data'])) {
            header('location: ' . $config['URL'] . '/products');
            exit();
        } else {
            header('location: ' . $config['URL'] . '/products/index.php?type=' . $_POST['search-type'] . '&data=' . $_POST['search-data']);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Nest</title>
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .addHover:hover {
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.306) !important;
        }

        /* Add your custom styles here */

        /* Overlay */
        .review-form-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        /* Form */
        .review-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 500px;
            position: relative;
        }

        /* Close button */
        .close-review-form {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src='<?php echo $config['URL'] ?>/assets/image/logos/logo7.png' alt="Site Logo" width="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL'] ?>/'>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href='<?php echo $config['URL'] ?>/about'>About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <?php
                            $sql = "SELECT * FROM `category`";
                            $result = mysqli_query($connection, $sql);
                            $total  = mysqli_num_rows($result);
                            if ($total >= 1) {
                                echo '<li><a class="dropdown-item" href="' . $config['URL'] . '/products">All Products</a></li>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<li><a class="dropdown-item" href="' . $config['URL'] . '/products?id=' . $row['category_id'] . '">' . $row['Name'] . '</a></li>';
                                }
                            }
                            echo '<li><a class="dropdown-item" href="' . $config['URL'] . '/products?id=0">Accessories</a></li>';
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            More Pages
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/contact'>Contact Us</a></li>
                            <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/feedback'>Feedback Form</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['isLoggedin'])) {
                            if ($_SESSION['isVerified']) {
                                if ($_SESSION['user-role'] != 'user') {
                        ?>
                                <a class="nav-link text-light" href='<?php echo $config['URL'] ?>/admin'>Admin Login</a>
                        <?php
                                }
                            }
                        }
                        ?>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION['isLoggedin'])) {
                ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-light">
                                Welcome <strong><?php echo $_SESSION['user-username']; ?></strong>
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
                            <a class="nav-link text-light" href='<?php echo $config['URL'] ?>/cart/'>
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown text-light pe-5">
                            <a class="nav-link dropdown-toggle" href='<?php echo $config['URL'] ?>/cart/' id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/user/orders'>My Orders</a></li>
                                <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/user/settings'>Settings</a></li>
                                <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/user/logout'>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php
                } else {
                ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-light" href='<?php echo $config['URL'] ?>/user/login'>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href='<?php echo $config['URL'] ?>/user/register'>Sign up</a>
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
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query .= "WHERE `category_id` =$id";
    } elseif (isset($_GET['type']) && isset($_GET['data'])) {
        if ($_GET['type'] == 'name' || $_GET['type'] == 'description') {
            $type = $_GET['type'];
            $data = $_GET['data'];
            $query .= "WHERE `$type` LIKE '%$data%'";
        }
    }
    $result = mysqli_query($connection, $query);
    $total  = mysqli_num_rows($result);
    ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 m-4">
            <div class="col">
                <h1 class="fs-1 ">Products</h1>
                <h4 class="fs-5 pt-2"><?php echo $total . ' items' ?></h4>
            </div>
            <div class="col">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                            <?php
                            $sql2 = "SELECT * FROM `category`";
                            $result2 = mysqli_query($connection, $sql2);
                            $total2  = mysqli_num_rows($result2);
                            echo '<li><a class="dropdown-item" href="' . $config['URL'] . '/products">All Products</a></li>';
                            if ($total2 >= 1) {
                                while ($row = mysqli_fetch_assoc($result2)) {
                                    echo '<li><a class="dropdown-item" href="' . $config['URL'] . '/products?id=' . $row['category_id'] . '">' . $row['Name'] . '</a></li>';
                                }
                            }
                            echo '<li><a class="dropdown-item" href="' . $config['URL'] . '/products?id=0">Accessories</a></li>';
                            ?>
                        </ul>
                    </div>
                    <form method="post">
                        <div class="input-group mb-3">
                            <select class="form-select" id="rating" required name="search-type">
                                <option value="name" selected>Search In Names</option>
                                <option value="description">Search In Description</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Search Products" name="search-data" aria-label="Search Products" aria-describedby="button-addon2">
                            <input type="submit" class="btn btn-outline-secondary" id="button-addon2" value="Search" name="submit3">
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 m-4">
            <?php
            if ($total >= 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col">
                                <div class="card addHover p-3 mb-5 bg-gradient rounded">
                                    <img src="' . $row['image'] . '" class="card-img-top image-fluid" alt="Painting"/>
                                    <div class="card-body">
                                        <h5 class="card-title text-center">' . $row['name'] . '</h5>
                                        <p class="card-text">' . $row['description'] . '</p>
                                    </div>
                                    <hr class="divider" />
                                    <div class="row">
                                        <div class="col">
                                            <p class="fw-bold">Available:</p>
                                            <p class="fw-bold">Price:</p>
                                        </div>
                                        <div class="col">
                                            <p class="fw-normal">' . $row['quantity'] . '</p>
                                            <p class="fw-normal text-success">Rs.' . $row['price'] . '</p>
                                        </div>
                                    </div>
                                    <hr class="divider" />
                                    <div >';
                    if ($row['quantity'] >= 1) {
                        echo '<form method="post" class="d-grid gap-2 col-6 mx-auto">
                                                <input type="text" class="d-none" name="plant_id" value="' . $row['plant_id'] . '">
                                                <input type="submit" class="btn btn-secondary" name="submit" value="Add To Cart">
                                            </form>';
                    } else {
                        echo '<h3 class="text-center">SOLD OUT</h3>';
                    }
                    if (isset($_SESSION['isLoggedin'])) {
                        if ($_SESSION['isVerified']) {
                            echo ' 
                            <div class="d-grid gap-2">
                                <a href="' . $config['URL'] . '/user/register."></a>
                                <button class="btn btn-primary open-review-form"  data-plant-id="' . $row['plant_id'] . '">Submit Review</button>
                            </div>';
                        }
                    }
                    echo '</div>
                                </div>
                            </div>';
                }
            } else {
            ?>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
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
    </div>
    <?php
    if (isset($_SESSION['isLoggedin'])) {
        if ($_SESSION['isVerified']) {
    ?>
        <div class="review-form-overlay" id="reviewFormOverlay">
            <div class="review-form">
                <button class="close-review-form" id="closeReviewForm"><i class="fas fa-times"></i></button>
                <h2 class="mb-4">Submit a Review</h2>
                <form method="post">
                    <input type="text" class="d-none" id="plantId" name="plantId" value="">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select class="form-select" id="rating" required name="review-stars">
                            <option value="" disabled selected>Select rating...</option>
                            <option value="5">5 stars</option>
                            <option value="4">4 stars</option>
                            <option value="3">3 stars</option>
                            <option value="2">2 stars</option>
                            <option value="1">1 star</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Review</label>
                        <textarea class="form-control" id="reviewText" name="review-text" rows="4" required></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit2"></input>
                </form>
            </div>
        </div>
    <?php
        }
    }
    ?>


    <footer class="bg-dark text-white p-4">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-4">
                <div class="col">
                    <img src='<?php echo $config['URL'] ?>/assets/image/logos/logo10.png' alt="Website Logo" class="mb-3 ms-3">

                </div>
                <div class="col pt-5">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href='<?php echo $config['URL'] ?>/'>Home</a></li>
                        <li><a href='<?php echo $config['URL'] ?>/about'>About Us</a></li>
                        <li><a href='<?php echo $config['URL'] ?>/feedback'>Feedback Form</a></li>
                        <?php
                        if (isset($_SESSION['isLoggedin'])) {
                        ?>
                            <li><a href='<?php echo $config['URL'] ?>/user/settings'>Settings</a></li>
                        <?php
                        }
                        ?>
                        <li><a href='<?php echo $config['URL'] ?>/products'>Products</a></li>
                        <li><a href='<?php echo $config['URL'] ?>/user/orders'>My Orders</a></li>
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
                    <a href='<?php echo $config['URL'] ?>/sitemap' class="text-white me-3">Site Map</a>
                </div>
            </div>

        </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        const openReviewFormButtons = document.querySelectorAll(".open-review-form");

        // Add a click event listener to each button
        openReviewFormButtons.forEach(button => {
            button.addEventListener("click", function() {
                const plantId = button.getAttribute("data-plant-id");
                console.log()
                openReviewForm(plantId);
            });
        });

        // Function to open the review form with a predefined plant_id
        function openReviewForm(plantId) {
            document.getElementById("plantId").value = plantId;
            document.getElementById("reviewFormOverlay").style.display = "flex";
        }

        document.getElementById("closeReviewForm").addEventListener("click", function() {
            document.getElementById("reviewFormOverlay").style.display = "none";
        });
    </script>
</body>

</html>