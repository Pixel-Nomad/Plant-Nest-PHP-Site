<?php
    require ('../../config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if (isset($_SESSION['isLoggedin'])){
        if (isset($_POST['submit2']) && isset($_POST['password3'])){
            $password3    = strval($_POST['password3']);
            $encrypt3     = sha1($password3);
            $id = $_SESSION['user-id'];
            $sql2 = "SELECT * FROM `users` WHERE `user_id`= '$id' AND `password` = '$encrypt3'";
            $result2 = mysqli_query($connection,$sql2);
            $total  = mysqli_num_rows($result2);
            if ($total == 1) {
                if (strlen($password3) >= 6){
                    $password    = strval($_POST['password']);
                    if (strlen($password) >= 6){
                        $password2   = strval($_POST['password2']);
                        $encrypt     = sha1($password);
                        if ($password == $password2) {
                            $sql = "UPDATE `users` SET `password`='$encrypt' WHERE `user_id` = '$id'";
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
            }
        }
        if (isset($_POST['submit3'])){
            $id = $_SESSION['user-id'];
            $sql2 = "DELETE FROM `users` WHERE `user_id` = '$id'";
            $result = mysqli_query($connection,$sql2);
            if ($result) {
                session_unset();
                session_destroy();
                header('location: '.$config['URL'].'/user/login');
                exit();
            }
        }
        if (isset($_POST['submit']) && isset($_POST['password'])){
            $password    = strval($_POST['password']);
            $encrypt     = sha1($password);
            $id = $_SESSION['user-id'];
            if (strlen($password) >= 6) {
                $sql2 = "SELECT * FROM `users` WHERE `user_id`= '$id' AND `password` = '$encrypt'";
                $result2 = mysqli_query($connection,$sql2);
                $total  = mysqli_num_rows($result2);
                $unique      = true;
                if ($_SESSION['user-username'] != $_POST['username']) {
                    $username    = $_POST['username'];
                    echo $username;
                    $search      = "SELECT * FROM users WHERE username = '".$username."'";
                    $result      = mysqli_query($connection, $search);
                    echo $total;
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['username'] == $username){
                                $unique = false;
                            }
                        }
                    }
                }
                $username    = $_POST['username'];
                    echo $username;
                if ($total == 1 && $unique){
                    $username    = $_POST['username'];
                    echo $username;
                    $sql = "SELECT * FROM `users` WHERE `user_id`= '$id' AND `password` = '$encrypt'";
                    $result = mysqli_query($connection,$sql);
                    $total  = mysqli_num_rows($result);
                    $sql2 = "UPDATE `users` SET 
                    `username`='".
                    (($_SESSION['user-username'] != $_POST['username']) ? $_POST['username'] : $_SESSION['user-username'])
                    ."',`fullname`='".
                    (($_SESSION['user-fullname'] != $_POST['fullname']) ? $_POST['fullname'] : $_SESSION['user-fullname'])
                    ."',`contact`='".
                    (($_SESSION['user-contact'] != $_POST['contact']) ? $_POST['contact'] : $_SESSION['user-contact'])
                    ."',`company`='".
                    (($_SESSION['user-company'] != $_POST['comapny']) ? $_POST['comapny'] : $_SESSION['user-company'])
                    ."',`address`='".
                    (($_SESSION['user-address'] != $_POST['address']) ? $_POST['address'] : $_SESSION['user-address'])
                    ."',`country`='".
                    ((isset($_POST['country']) && $_SESSION['user-country'] != $_POST['country'] && $_SESSION['user-country'] != "") ? $_POST['country'] : $_SESSION['user-country'])
                    ."',`city`='".
                    (($_SESSION['user-city'] != $_POST['city']) ? $_POST['city'] : $_SESSION['user-city'])
                    ."' WHERE `user_id` = '$id'";
                    $_SESSION['user-fullname'] = $_SESSION['user-fullname'];
                    $result2 = mysqli_query($connection,$sql2);
                    if ($result2) {
                        echo $_SESSION['user-username'];
                        echo $_POST['username'];
                        $_SESSION['user-username'] = ($_SESSION['user-username'] != $_POST['username']) ? $_POST['username'] : $_SESSION['user-username'];
                        $_SESSION['user-fullname'] = ($_SESSION['user-fullname'] != $_POST['fullname']) ? $_POST['fullname'] : $_SESSION['user-fullname'];
                        $_SESSION['user-contact'] = ($_SESSION['user-contact'] != $_POST['contact']) ? $_POST['contact'] : $_SESSION['user-contact'];
                        $_SESSION['user-company'] = ($_SESSION['user-company'] != $_POST['comapny']) ? $_POST['comapny'] : $_SESSION['user-company'];
                        $_SESSION['user-address'] = ($_SESSION['user-address'] != $_POST['address']) ? $_POST['address'] : $_SESSION['user-address'];
                        $_SESSION['user-country'] = ($_SESSION['user-country'] != $_POST['country']) ? $_POST['country'] : $_SESSION['user-country'];
                        $_SESSION['user-city'] = ($_SESSION['user-city'] != $_POST['city']) ? $_POST['city'] : $_SESSION['user-city'];
                        header('location: '.$config['URL'].'/user/settings');
                        exit();
                    }
                }
            }
        }
    } else {
        header('location: '. $config['URL']);
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
    <h1 class="text-center pt-3 pb-3">Account Settings</h1>
<div class="container mt-4">
  <div class="row">
    <div class="col-md-3">
      <div class="list-group">
        <a href="#account-details" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
          <i class="fas fa-user me-2"></i> Account Details
        </a>
        <a href="#change-password" class="list-group-item list-group-item-action" data-bs-toggle="tab">
          <i class="fas fa-lock me-2"></i> Change Password
        </a>
        <a href="#delete-account" class="list-group-item list-group-item-action" data-bs-toggle="tab">
          <i class="fas fa-trash me-2"></i> Delete Account
        </a>
        <a href="#logout" class="list-group-item list-group-item-action" data-bs-toggle="tab">
          <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div id="account-details" class="tab-pane fade show active">
          <h4>Account Details</h4>
          <form method="post">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-1 m-4">
                    <div class="col">
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-1 m-4">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value='<?php echo $email=$_SESSION['user-username'];?>' required name="username" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">User Name</label>
                                        <p class="card-text text-danger"><?php
                                        if (isset($_POST['submit'])) {
                                            $username       = $_POST['username'];
                                            $search      = "SELECT * FROM users WHERE username='".$username."'";
                                            $result      = mysqli_query($connection, $search);
                                            $unique      = true;
                                            if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($row['username'] == $username){
                                                $unique = false;
                                                }
                                            }
                                            }
                                            if (!$unique) {
                                            echo 'Username Already Taken';
                                            }
                                        }
                                        ?></p>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value='<?php echo $email=$_SESSION['user-fullname'];?>' required name="fullname" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Full Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" value='<?php echo $email=$_SESSION['user-contact'];?>' required name="contact" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Contact Number</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value='<?php echo $email=$_SESSION['user-company'];?>' name="comapny" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Company Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value='<?php echo $email=$_SESSION['user-address'];?>' required name="address" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="country" id="floatingCountry">
                                            <option value="<?php echo $email=$_SESSION['user-country'];?>" disabled selected>Select your country</option>
                                            <option>select country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AX">Aland Islands</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia</option>
                                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BV">Bouvet Island</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, Democratic Republic of the Congo</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Cote D'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CW">Curacao</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                            <option value="FO">Faroe Islands</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GF">French Guiana</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="TF">French Southern Territories</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GP">Guadeloupe</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GG">Guernsey</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HM">Heard Island and Mcdonald Islands</option>
                                            <option value="VA">Holy See (Vatican City State)</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IM">Isle of Man</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JE">Jersey</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="XK">Kosovo</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libyan Arab Jamahiriya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macao</option>
                                            <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="YT">Mayotte</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia, Federated States of</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="AN">Netherlands Antilles</option>
                                            <option value="NC">New Caledonia</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PS">Palestinian Territory, Occupied</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PN">Pitcairn</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RE">Reunion</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="BL">Saint Barthelemy</option>
                                            <option value="SH">Saint Helena</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="MF">Saint Martin</option>
                                            <option value="PM">Saint Pierre and Miquelon</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="CS">Serbia and Montenegro</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SX">Sint Maarten</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UM">United States Minor Outlying Islands</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="VG">Virgin Islands, British</option>
                                            <option value="VI">Virgin Islands, U.s.</option>
                                            <option value="WF">Wallis and Futuna</option>
                                            <option value="EH">Western Sahara</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                        <label for="floatingCountry">Country</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value='<?php echo $email=$_SESSION['user-city'];?>' required name="city" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">City</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Enter Current Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <input type="submit" value="Update" class="btn btn-warning mt-3" name="submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
        <div id="change-password" class="tab-pane fade">
          <h4>Change Password</h4>
          <form method="post">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-1 m-4">
                    <div class="col">
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-1 m-4">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" required name="password3" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Enter Current Password</label>
                                        <p class="card-text text-danger"><?php
                                        if (isset($_POST['submit2'])&&isset($_POST['password3'])) {
                                            $email       = $_SESSION['user-email'];
                                            $password    = strval($_POST['password3']);
                                            if (strlen($password3) >= 6){
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
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Enter New Password</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" required name="password2" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Re-Enter New Password</label>
                                        <p class="card-text text-danger"><?php
                                        if (isset($_POST['submit2']) && isset($_POST['password'])) {
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
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <input type="submit" value="Update" class="btn btn-warning mt-3" name="submit2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
        <div id="delete-account" class="tab-pane fade">
          <h4>Delete Account</h4>
          <p>Are you sure you want to delete your account?</p>
          <form method="post">
            <input type="submit" class="btn btn-danger" name="submit3" value="Yes, Delete">
          </form>
        </div>
        <div id="logout" class="tab-pane fade">
          <h4>Logout</h4>
          <p>Click the button below to logout:</p>
          <a href='<?php echo $config['URL']?>/user/logout' class="btn btn-primary">Logout</a>
        </div>
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
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Feedback Form</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Products</a></li>
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
          <a href="#" class="text-white">Sitemap</a>
       </div>
      </div>
      
    </div>
    </div>
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>