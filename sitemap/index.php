<?php
    require ('../config.php'); 
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

<div class="container mt-5">
    
  <h1 class="mb-4">Site Map</h1>
  
  <ul class="list-group">
    <li class="list-group-item">
      <i class="fas fa-home me-2"></i>
      <a href='<?php echo $config['URL']?>/'>Home</a>
      <a>Here you can check featured products</a>
    </li>
    <li class="list-group-item">
      <i class="fas fa-info-circle me-2"></i>
      <a href='<?php echo $config['URL']?>/about'>About Us</a>
      <a>Here you can learn about US</a>
    </li>
    <li class="list-group-item">
      <i class="fab fa-opencart me-2"></i>
      <a href='<?php echo $config['URL']?>/products'>Products</a>
      <a>Here you can see All products and give reviews on products</a>
      <p> (LOGIN REQUIRED for review and add items to cart)</p>
    </li>
    <li class="list-group-item">
    <i class="fas fa-envelope me-2"></i>
      <a href='<?php echo $config['URL']?>/contact'>Contact</a>
      <a>Here you can see All contact details</a>
    </li>
    <li class="list-group-item">
      <i class="fas fa-envelope me-2"></i>
      <a href='<?php echo $config['URL']?>/feedback'>Feedback</a>
      <a>Here you can give your feedbacks</a>
      <p>(LOGIN REQUIRED)</p>
    </li>
    <li class="list-group-item">
    <i class="fas fa-cart-plus"></i>
      <a href='<?php echo $config['URL']?>/cart'>Cart</a>
      <a>Here you can see all you items in cart</a>
      <p>(LOGIN REQUIRED)</p>
    </li>
    <li class="list-group-item">
    <i class="fas fa-cogs"></i>
      <a href='<?php echo $config['URL']?>/user/settings'>Settings (LOGIN REQUIRED)</a>
      <a>Here you can update and delete your profile, or change your password</a>
      <p>(LOGIN REQUIRED)</p>
    </li>
    <li class="list-group-item">
    <i class="fas fa-cart-plus"></i>
      <a href='<?php echo $config['URL']?>/user/orders'>Orders</a>
      <a>Here you can see all your placed order and you can cancel pending one</a>
      <p>(LOGIN REQUIRED)</p>
    </li>
    <li class="list-group-item">
        <i class="fas fa-sign-in-alt"></i>
      <a href='<?php echo $config['URL']?>/user/login'>Log In</a>
      <a>Already Have an account? Login now.</a>
    </li>
    <li class="list-group-item">
        <i class="fas fa-user-plus"></i>
      <a href='<?php echo $config['URL']?>/user/register'>Sign UP</a>
      <a>Don't have an account? get one now.</a>
    </li>
  </ul>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
