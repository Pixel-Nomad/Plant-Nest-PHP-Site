<?php
require('../../config.php');
require '../../vendor/phpmailer/Exception.php';
require '../../vendor/phpmailer/PHPMailer.php';
require '../../vendor/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$alert = "";
$wrong = "";

if (isset($_SESSION['isLoggedin'])) {
    if (!$_SESSION['isVerified']) {
        $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        if (isset($_POST['getcode'])) {
            $email = $_SESSION['user-email'];
            $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'verify'";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $code = $row['code'];
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
                        $mail->setFrom('mr.tgamer247797704@gmail.com', 'NoReply - Verification Code');
                        $mail->addAddress($_SESSION['user-email'], $_SESSION['user-username']); // Email and name of recipient

                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Email Verification';
                        $mail->Body    = 'This is Your Code:' . $code;

                        $mail->send();
                        $wrong = '<div class="row row-cols-1 row-cols-md-3">
                            <div class="col">
                                <div class="alert alert-warning text-success" role="alert">
                                    Code Sended
                                </div>
                            </div>
                        </div>';
                    } catch (Exception $e) {
                        echo $e;
                        // goto  SkipChecks;
                    }
                }
            } else {
                GenerateCode:
                $randomNumber = mt_rand(100000, 999999);
                $sql2 = "SELECT * FROM `codes` WHERE `mail`= '$email' AND `type`='verify' AND `code`= '$randomNumber'";
                $result2 = mysqli_query($connection, $sql2);
                $total2  = mysqli_num_rows($result2);
                if ($total2 == 1) {
                    goto GenerateCode;
                } else {
                    $sql3 = "INSERT INTO `codes`( `mail`, `type`, `code`) VALUES (
                        '$email', 'verify','$randomNumber')";
                    $query = mysqli_query($connection, $sql3);
                    if (!$query) {
                        $wrong = '<div class="row row-cols-1 row-cols-md-3">
                            <div class="col">
                                <div class="alert alert-danger text-center" role="alert">
                                    Failed To Get Code Try Again
                                </div>
                            </div>
                        </div>';
                    } else {
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
                            $mail->setFrom('mr.tgamer247797704@gmail.com', 'NoReply - Verification Code');
                            $mail->addAddress($_SESSION['user-email'], $_SESSION['user-username']); // Email and name of recipient

                            // Content
                            $mail->isHTML(true); // Set email format to HTML
                            $mail->Subject = 'Email Verification';
                            $mail->Body    = 'This is Your Code:' . $randomNumber;

                            $mail->send();
                            $wrong = '<div class="row row-cols-1 row-cols-md-3">
                                <div class="col">
                                    <div class="alert alert-warning text-success" role="alert">
                                        Code Sended
                                    </div>
                                </div>
                            </div>';
                        } catch (Exception $e) {
                            // goto  SkipChecks;
                        }
                    }
                    // SkipChecks:
                    // header('location: '.$config['URL'].'/user/verify');
                    // exit();
                }
            }
        }
        if (isset($_POST['verify'])) {
            $email = $_SESSION['user-email'];
            $code = $_POST['VerificationCode'];
            $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'verify' AND `code` = '$code'";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                $user_id = $_SESSION['user-id'];
                $sql2 = "DELETE FROM `codes` WHERE `mail` = '$email' AND `type`='verify'";
                $sql3 = "UPDATE `users` SET `verified`='true' WHERE user_id = '$user_id'";
                $result2 = mysqli_query($connection, $sql2);
                $result3 = mysqli_query($connection, $sql3);
                if ($result3) {
                    $_SESSION['isVerified'] = true;
                    header('location: ' . $config['URL']);
                    exit();
                }
            } else {
                $wrong = '<div class="row row-cols-1 row-cols-md-3">
                    <div class="col">
                        <div class="alert alert-danger text-center" role="alert">
                            Wrong Code Try Again
                        </div>
                    </div>
                </div>';
            }
        }
    } else {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('location: ' . $config['URL']);
            exit();
        }
    }
} else {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header('location: ' . $config['URL']);
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
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .addHover:hover {
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.306) !important;
        }

        .background {
            background-image: url('your-image.jpg');
            /* Replace with the path to your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            /* Adjust to your needs */
            color: white;
            /* Adjust text color for readability */
            text-align: center;
            padding: 100px 0;
        }

        .remove-submit-button {
            background-color: initial;
            /* Reset the background color */
            border: none;
            /* Remove the border */
            color: initial;
            /* Reset the text color */
            text-decoration: none;
            /* Reset text decoration */
            /* Add more styles as needed */
        }
    </style>
</head>

<body background='<?php echo $config['URL'] ?>/assets/image/pics/bg.jpg'>
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
                        <li class="nav-item dropdown text-light pe-5">
                            <a class="nav-link dropdown-toggle" href='<?php echo $config['URL'] ?>/cart/' id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
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
    <br>
    <br>
    <br>
    <div class="container">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Verify!</h4>
            <p>Please verify your email address before proceeding to any page. It is necessary to ensure everything is secured for you.</p>
            <hr>
            <p class="mb-0">
            <form method="post">
                <input type="submit" name="getcode" class="remove-submit-button text-primary" value="Get Verification code!">
            </form>
            </p>
        </div>
        <br>
        <br>
        <br>
        <form method="post">
            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control" required name="VerificationCode" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Enter Verification Code</label>
                </div>
                <input type="submit" class="btn btn-primary" id="button-addon2" value="Verify" name="verify">
            </div>
        </form>
        <?php
        echo $wrong
        ?>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<?php
    mysqli_close($connection);
?>