<?php
require ('../../config.php'); 
session_start();
if (!isset($_SESSION['isLoggedin'])){

session_unset();
session_destroy();
$connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);

if ($connection) {
  if (isset($_POST['submit'])){
      $username    = $_POST['username'];
      $fullname    = $_POST['fullname'];
      $email       = $_POST['email'];
      $contact       = strval($_POST['contact']);
      $comapny       = $_POST['comapny'];
      $address       = $_POST['address'];
      $country       = $_POST['country'];
      $city       = $_POST['city'];
      $password    = strval($_POST['password']);
      if (strlen($password) >= 6){
        $password2   = strval($_POST['password2']);
        $encrypt     = sha1($password);
        $search      = "SELECT * FROM users WHERE email='".$email."' OR '".$username."'";
        $result      = mysqli_query($connection, $search);
        $unique      = true;
        $unique2     = true;
        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            if ($row['email'] == $email){
              $unique = false;
            }
            if ($row['username'] == $username){
              $unique2 = false;
            }
          }
        }
        if ($password == $password2 && $unique && $unique2) {
            $sql = "INSERT INTO `users`( `username`, `fullname`, `email`, `contact`, `company`, `address`, `country`, `city`, `password`) VALUES (
                '$username','$fullname','$email','$contact','$comapny','$address','$country','$city','$encrypt')";
            $query = mysqli_query($connection, $sql);
            if ($query){
                header("location: " . $config['URL'] . "/user/login"); 
                exit();
            } else {
                echo "<script>alert('Failed To Register');</script>";
                exit();
            }
        }
    }
  }
} else {
echo "<script>alert('Failed To Register');</script>";
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
    <link rel="stylesheet" href="style.css">
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
                        <a class="nav-link text-light" href="#">Category</a>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pe-5" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                </ul>
                
                <?php
                    }
                ?>
                
            </div>
        </div>
    </nav>
    <div class="container">
        <img src='<?php echo $config['URL']?>/assets/image/logos/logo8.png' class="rounded mx-auto d-block" alt="..." onclick="redirect('<?php echo $config['URL']?>')">
        <div class="row row-cols-1 row-cols-md-1 m-4">
            <div class="col">
                <div class="card addHover p-3 mb-5 bg-gradient rounded">
                    <div class="card-body">
                        <h5 class="card-title text-center pb-6">Create Account</h5>
                        <form method="post">
                        <div class="row row-cols-1 row-cols-md-2 m-4">
                            <div class="col">
                              <div class="form-floating mb-3">
                                  <input type="text" class="form-control" required name="username" id="floatingInput" placeholder="name@example.com">
                                  <label for="floatingInput">Username</label>
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
                                  <input type="text" class="form-control" required name="fullname" id="floatingInput" placeholder="name@example.com">
                                  <label for="floatingInput">Full Name</label>
                              </div>
                              <div class="form-floating mb-3">
                                  <input type="email" class="form-control" required name="email" id="floatingInput" placeholder="name@example.com">
                                  <label for="floatingInput">Email address</label>
                                <p class="card-text text-danger"><?php
                                  if (isset($_POST['submit'])) {
                                    $email       = $_POST['email'];
                                    $search      = "SELECT * FROM users WHERE email='".$email."'";
                                    $result      = mysqli_query($connection, $search);
                                    $unique      = true;
                                    if ($result) {
                                      while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row['email'] == $email){
                                          $unique = false;
                                        }
                                      }
                                    }
                                    if (!$unique) {
                                      echo 'Email Already Registered';
                                    }
                                  }
                                ?></p>
                              </div>
                              <div class="form-floating mb-3">
                                  <input type="password" class="form-control" required name="password" id="floatingPassword" placeholder="Password">
                                  <label for="floatingPassword">Password</label>
                              </div>
                              <div class="form-floating mb-3">
                                  <input type="password" class="form-control" required name="password2" id="floatingPassword" placeholder="Password">
                                  <label for="floatingPassword">Re-Enter Password</label>
                                  <p class="card-text mt-2 mb-3">Enter Password That Contain Atleat 6 Characters</p>
                                <p class="card-text text-danger"><?php
                                  if (isset($_POST['submit']) && isset($_POST['password'])) {
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
                              <div class="col">
                              <div class="form-floating mb-3">
                                  <input type="number" class="form-control" required name="contact" id="floatingInput" placeholder="name@example.com">
                                  <label for="floatingInput">Contact Number</label>
                              </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="comapny" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Company Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" required name="address" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Address</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <select class="form-select" name="country" id="floatingCountry">
                                      <option value="" disabled selected>Select your country</option>
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
                                    <input type="text" class="form-control" required name="city" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">City</label>
                                </div>
                              </div>
                          </div>
                          <a href='<?php echo $config['URL']?>/user/login/'><p>Already have an account? Login now.</p></a>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                  <input type="submit" value="Sign Up" class="btn btn-warning mt-3" name="submit">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>