<?php
    require ('../../../config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if (isset($_SESSION['isLoggedin'])){
        if ($_SESSION['isVerified']) {
            if ($_SESSION['user-role'] != 'user') {
                if (isset($_POST['submit']) && isset($_POST['id'])){
                    $id = $_POST['id'];
                    $sql = "DELETE FROM `sliders` WHERE `id` = $id";
                    $result = mysqli_query($connection,$sql);
                    if ($result) {
                        header('location: '. $config['URL'].'/admin/management/sliders');
                    mysqli_close($connection);
                    exit(); 
                    }
                }
                if (isset($_POST['submit2']) && isset($_POST['sliderid'])){
                    $oldid = $_POST['old-sliderid'];
                    $id = $_POST['sliderid'];
                    $sliderimage = $_POST['sliderimage'];
                    $slidertext = $_POST['slidertext'];
                    $sliderdescription = $_POST['sliderdescription'];
                    $sliderdark = $_POST['sliderdark'];
                    if ($sliderdark != 'yes' && $sliderdark != 'no') {
                        $sliderdark = 'no';
                    }
                    
                    $sql = "UPDATE `sliders` SET `id` = $id, `image` = '$sliderimage', 
                    `text` = '$slidertext', `description` = '$sliderdescription' , `dark` = '$sliderdark' WHERE `id` = $oldid";
                    $result = mysqli_query($connection,$sql);
                    if ($result) {
                        header('location: '. $config['URL'].'/admin/management/sliders');
                    mysqli_close($connection);
                    exit(); 
                    }
                }
                if (isset($_POST['submit3']) && isset($_POST['new-id']) && isset($_POST['new-image'])){
                    $id = $_POST['new-id'];
                    $image = $_POST['new-image'];
                    $text = $_POST['new-text'];
                    $description = $_POST['new-description'];
                    $dark = $_POST['new-dark'];
                    if ($dark != 'yes' && $dark != 'no') {
                        $dark = 'no';
                    }
                    if ($id >= 1) {
                        $sql = "SELECT * FROM `sliders` WHERE id = $id";
                        $result = mysqli_query($connection,$sql);
                        $total  = mysqli_num_rows($result);
                        if ($total >= 1) {
                            $sql2 = "INSERT INTO `sliders` (`image`,`text`,`description`,`dark`) 
                            VALUES ('$image','$text','$description','$dark')";
                            $result2 = mysqli_query($connection,$sql2);
                            if ($result2) {
                                header('location: '. $config['URL'].'/admin/management/sliders');
                    mysqli_close($connection);
                    exit(); 
                            }
                        } else {
                            $sql2 = "INSERT INTO `sliders` (`id`,`image`,`text`,`description`,`dark`) 
                            VALUES ('$id','$image','$text','$description','$dark')";
                            $result2 = mysqli_query($connection,$sql2);
                            if ($result2) {
                                header('location: '. $config['URL'].'/admin/management/sliders');
                    mysqli_close($connection);
                    exit(); 
                            }
                        }
                    } else {
                        $sql = "INSERT INTO `sliders` (`image`,`text`,`description`,`dark`) 
                        VALUES ('$image','$text','$description','$dark')";
                        $result = mysqli_query($connection,$sql);
                        if ($result) {
                            header('location: '. $config['URL'].'/admin/management/sliders');
                    mysqli_close($connection);
                    exit(); 
                        }
                    }
                }
            } else {
                header('location: '. $config['URL'].'/user/login');
                    mysqli_close($connection);
                    exit(); 
            }
        } else {
            header('location: '. $config['URL'].'/user/verify');
            mysqli_close($connection);
            exit(); 
        }
    } else {
        header('location: '. $config['URL'].'/user/login');
        mysqli_close($connection);
        exit(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo $config['URL']?>/assets/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $config['URL']?>/assets/css/dataTables.bootstrap5.min.css"/>
   
    <link rel="stylesheet" href="<?php echo $config['URL']?>/assets/css/style.css" />
    <title>Plant Nest</title> 
    <link rel="icon" href='<?php echo $config['URL']?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL']?>/assets/image/fav/fav.ico' type="image/x-icon">
    <style>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="#">Admin Panel ( Logged in as <?php echo $_SESSION['user-role']?> )</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar"
                aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavBar">
                <div class="d-flex ms-auto my-3 my-lg-0">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href='<?php echo $config['URL']?>/user/settings'>Settings</a></li>
                            <li><a class="dropdown-item" href='<?php echo $config['URL']?>/user/logout'>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                <li>
                    <div class="text-muted small fw-bold text-uppercase px-3">
                    CORE
                    </div>
                </li>
                <li>
                    <a href='<?php echo $config['URL']?>/admin/' class="nav-link px-3">
                    <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                    <span>Dashboard</span>
                    </a>
                    <a href='<?php echo $config['URL']?>/' class="nav-link px-3 active">
                    <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                    <span>Go to Main Site</span>
                    </a>
                </li>
                <li class="my-4">
                    <hr class="dropdown-divider bg-light" />
                </li>
                <li>
                    <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                        Production
                    </div>
                </li>
                <li>
                    <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" data-bs-toggle="layouts" href="#layouts">
                    <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                    <span>Products</span>
                    <span class="ms-auto">
                        <span class="right-icon">
                        <i class="bi bi-chevron-down"></i>
                        </span>
                    </span>
                    </a>
                    <div class="collapse" id="layouts">
                    <ul class="navbar-nav ps-3">
                        <li>
                        <a href='<?php echo $config['URL']?>/admin/management/category' class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Category Management</span>
                        </a>
                        </li>
                        <li>
                        <a href='<?php echo $config['URL']?>/admin/management/product' class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Product Management</span>
                        </a>
                        </li>
                        <li>
                          <a href='<?php echo $config['URL']?>/admin/management/orders' class="nav-link px-3">
                              <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                              <span>Order Management</span>
                          </a>
                        </li>
                        <li>
                          <a href='<?php echo $config['URL']?>/admin/management/list' class="nav-link px-3">
                              <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                              <span>Order List</span>
                          </a>
                        </li>
                    </ul>
                    </div>
                </li>
                <li>
                    <a href='<?php echo $config['URL']?>/admin/user/reviews' class="nav-link px-3">
                    <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                    <span>Product Reviews</span>
                    </a>
                </li>
                <li>
                    <a href='<?php echo $config['URL']?>/admin/user/feedbacks' class="nav-link px-3">
                    <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                    <span>User Feedbacks</span>
                    </a>
                </li>
                <li>
                    <a href='<?php echo $config['URL']?>/admin/management/sliders' class="nav-link px-3 active">
                      <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                      <span>Slider Tool</span>
                    </a>
                </li>
                <li class="my-4">
                    <hr class="dropdown-divider bg-light" />
                </li>
                <li>
                    <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                    Admin Work
                    </div>
                </li>
                <li>
                    <a href='<?php echo $config['URL']?>/admin/user/management' class="nav-link px-3">
                    <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                    <span>User Management</span>
                    </a>
                </li>
                </ul>
                
            </nav>
        </div>
    </div>
    <main class="mt-5 pt-3">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h4>Slider Tool</h4>
        </div>
        <div class="col">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <form method="post">
                    <div class="input-group mb-3 mt-5">
                        <div class="row row-cols-1 row-cols-md-1">
                            <div class="col mb-2">
                                <input type="textnumber" class="form-control" value="0" required placeholder="New Slider ID" name="new-id" aria-label="New Slider ID" aria-describedby="button-addon2">
                            </div>
                            <div class="col mb-2">
                                <input type="url" class="form-control" required placeholder="New Slider Image" name="new-image" aria-label="New Slider Image" aria-describedby="button-addon2">
                            </div>
                            <div class="col mb-2">
                                <input type="text" class="form-control" required placeholder="New Slider Text" name="new-text" aria-label="New Slider Text" aria-describedby="button-addon2">
                            </div>
                            <div class="col mb-2">
                                <input type="text" class="form-control" required  placeholder="New Slider Description" name="new-description" aria-label="New Slider Description" aria-describedby="button-addon2">
                            </div>
                            <div class="col mb-2">
                                <input type="text" class="form-control" required  placeholder="New Slider DarkText" name="new-dark" aria-label="New Slider DarkText" aria-describedby="button-addon2">
                            </div>
                            <div class="col mb-2">
                                <input type="submit" class="btn btn-outline-secondary" id="button-addon2" value="Insert" name="submit3">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
      </div>
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-table me-2"></i></span> Slider Tool
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-striped data-table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Text</th>
                      <th>Description</th>
                      <th>Dark Text</th>
                      <th class="d-none"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $sql = "SELECT * FROM `sliders`";
                        $result = mysqli_query($connection,$sql);
                        $total  = mysqli_num_rows($result);
                        if ($total >= 1) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                <td>'.$row['id'].'</td>
                                <td>'.$row['image'].'</td>
                                <td>'.$row['text'].'</td>
                                <td>'.$row['description'].'</td>
                                <td>'.$row['dark'].'</td>
                                <td><button class="btn btn-danger open-review-form"  data-slider-id="'.$row['id'].'" data-slider-image="'.$row['image'].'"
                                data-slider-text="'.$row['text'].'" data-slider-description="'.$row['description'].'" data-slider-dark="'.$row['dark'].'">Update</button>
                                <form method="post" class="mt-3">
                                    <input type="text" class="d-none" value="'.$row['id'].'" name="id"></input>
                                    <input type="submit" class="btn btn-danger" value="Delete" name="submit"></input>
                                </form></td>
                              </tr>';
                            }
                        }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>ID</th>
                      <th>Image</th>
                      <th>Text</th>
                      <th>Description</th>
                      <th>Dark Text</th>
                      <th class="d-none"></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div class="review-form-overlay" id="reviewFormOverlay">
        <div class="review-form">
            <button class="close-review-form" id="closeReviewForm"><i class="fas fa-times"></i></button>
            <h2 class="mb-4">Update</h2>
            <form method="post">
            <label for="reviewText" class="form-label">ID</label>
            <input type="number" class="d-none" id="old-sliderid" name="old-sliderid" value="">
            <input type="number" class="form-control" id="sliderid" name="sliderid" value="">
            <br>
            <label for="reviewText" class="form-label">Image</label>
            <input type="url" class="form-control" id="sliderimage" name="sliderimage" value="">
            <br>
            <label for="reviewText" class="form-label">Text</label>
            <input type="text" class="form-control" id="slidertext" name="slidertext" value="">
            <br>
            <label for="reviewText" class="form-label">Description</label>
            <input type="text" class="form-control" id="sliderdescription" name="sliderdescription" value="">
            <br>
            <label for="reviewText" class="form-label">Dark Text ( yes or no )</label>
            <input type="text" class="form-control" id="sliderdark" name="sliderdark" value="">
            <br>
            <input type="submit" class="btn btn-primary" value="Submit" name="submit2"></input>
            <br>
            </form>
        </div>
    </div>
    <script src="<?php echo $config['URL']?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/jquery-3.5.1.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/script.js"></script>
    <script>
        const openReviewFormButtons = document.querySelectorAll(".open-review-form");

        // Add a click event listener to each button
        openReviewFormButtons.forEach(button => {
        button.addEventListener("click", function () {
            const sliderid = button.getAttribute("data-slider-id");
            const sliderimage = button.getAttribute("data-slider-image");
            const slidertext = button.getAttribute("data-slider-text");
            const sliderdescription = button.getAttribute("data-slider-description");
            const sliderdark = button.getAttribute("data-slider-dark");
            console.log()
            openReviewForm(sliderid, sliderimage, slidertext, sliderdescription, sliderdark);
        });
        });

        // Function to open the review form with a predefined plant_id
        function openReviewForm(sliderid, sliderimage, slidertext, sliderdescription, sliderdark) {
            document.getElementById("sliderid").value = sliderid;
            document.getElementById("old-sliderid").value = sliderid;
            document.getElementById("sliderimage").value = sliderimage;
            document.getElementById("slidertext").value = slidertext;
            document.getElementById("sliderdescription").value = sliderdescription;
            document.getElementById("sliderdark").value = sliderdark;
            document.getElementById("reviewFormOverlay").style.display = "flex";
        }

        document.getElementById("closeReviewForm").addEventListener("click", function () {
            document.getElementById("reviewFormOverlay").style.display = "none";
        });
    </script>
</body>
</html>

<?php
    mysqli_close($connection);
?>