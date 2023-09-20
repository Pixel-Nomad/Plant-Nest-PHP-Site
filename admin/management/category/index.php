<?php
    require ('../../../config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if (isset($_SESSION['isLoggedin'])){
        if ($_SESSION['isVerified']) {
            if ($_SESSION['user-role'] != 'user') {
                if (isset($_POST['submit']) && isset($_POST['category_id'])){
                    $id = $_POST['category_id'];
                    $sql = "DELETE FROM `category` WHERE `category_id` = '$id'";
                    $result = mysqli_query($connection,$sql);
                    if ($result) {
                        header('location: '. $config['URL'].'/admin/management/category');
                        exit(); 
                    }
                }
                if (isset($_POST['submit2']) && isset($_POST['categoryid'])){
                    $oldid = $_POST['old-categoryid'];
                    $id = $_POST['categoryid'];
                    $name = $_POST['categoryname'];
                    echo $id;
                    echo $name;
                    $sql = "UPDATE `category` SET `category_id` = $id, `Name` = '$name' WHERE `category_id` = $oldid";
                    $sql2 = "UPDATE `plants` SET `category_id` = '$id' WHERE `category_id` = '$oldid'";
                    $result = mysqli_query($connection,$sql);
                    $result2 = mysqli_query($connection,$sql2);
                    if ($result) {
                        header('location: '. $config['URL'].'/admin/management/category');
                        exit(); 
                    }
                }
                if (isset($_POST['submit3']) && isset($_POST['new-id']) && isset($_POST['new-name'])){
                    $id = $_POST['new-id'];
                    $name = $_POST['new-name'];
                    if ($id >= 1) {
                        $sql = "SELECT * FROM `category` WHERE category_id = $id";
                        $result = mysqli_query($connection,$sql);
                        $total  = mysqli_num_rows($result);
                        if ($total >= 1) {
                            $sql2 = "INSERT INTO `category` (`Name`) VALUES ('$name')";
                            $result2 = mysqli_query($connection,$sql2);
                            if ($result2) {
                                header('location: '. $config['URL'].'/admin/management/category');
                                exit(); 
                            }
                        } else {
                            $sql2 = "INSERT INTO `category` (`category_id`,`Name`) VALUES ($id,'$name')";
                            $result2 = mysqli_query($connection,$sql2);
                            if ($result2) {
                                header('location: '. $config['URL'].'/admin/management/category');
                                exit(); 
                            }
                        }
                    } else {
                        $sql = "INSERT INTO `category` (`Name`) VALUES ('$name')";
                        $result = mysqli_query($connection,$sql);
                        if ($result) {
                            header('location: '. $config['URL'].'/admin/management/category');
                            exit(); 
                        }
                    }
                }
            } else {
                header('location: '. $config['URL'].'/user/login');
                exit(); 
            }
        } else {
            header('location: '. $config['URL'].'/user/verify');
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
                        <a class="nav-link px-3 sidebar-link active" data-bs-toggle="collapse" data-bs-toggle="layouts" href="#layouts">
                        <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                        <span>Products</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                            <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                        </a>
                        <div class="collapse show" id="layouts">
                        <ul class="navbar-nav ps-3">
                            <li>
                            <a href='<?php echo $config['URL']?>/admin/management/category' class="nav-link px-3 active">
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
                                <li>
                            <a href='<?php echo $config['URL']?>/admin/management/list' class="nav-link px-3">
                                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                                <span>Order List</span>
                            </a>
                            </li>
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
                    <a href='<?php echo $config['URL']?>/admin/management/sliders' class="nav-link px-3">
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
          <h4>Category Management</h4>
        </div>
        <div class="col">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <form method="post">
                        <div class="input-group mb-3">
                            <input required  type="text" class="form-control" placeholder="New category ID" name="new-id" aria-label="New category ID" aria-describedby="button-addon2">
                            <input required  type="text" class="form-control" placeholder="New category Name" name="new-name" aria-label="New category Name" aria-describedby="button-addon2">
                            <input required  type="submit" class="btn btn-outline-secondary" id="button-addon2" value="Insert" name="submit3">
                        </div>
                    </form>
                </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-table me-2"></i></span> Catagory Management
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-striped data-table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th class="d-none"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $sql = "SELECT * FROM `category`";
                        $result = mysqli_query($connection,$sql);
                        $total  = mysqli_num_rows($result);
                        if ($total >= 1) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                <td>'.$row['category_id'].'</td>
                                <td>'.$row['Name'].'</td>
                                <td><button class="btn btn-danger open-review-form"  data-category-id="'.$row['category_id'].'" data-category-name="'.$row['Name'].'">Update</button>
                                <form method="post" class="mt-3">
                                <input type="text" class="d-none" value="'.$row['category_id'].'" name="category_id"></input>
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
                      <th>Name</th>
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
            <label for="reviewText" class="form-label">Category ID</label>
            <input type="number" class="d-none" id="old-categoryid" name="old-categoryid" value="">
            <input type="number" class="form-control" id="categoryid" name="categoryid" value="">
            <br>
            <label for="reviewText" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="categoryname" name="categoryname" value="">
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
            const categoryid = button.getAttribute("data-category-id");
            const categoryname = button.getAttribute("data-category-name");
            console.log()
            openReviewForm(categoryid, categoryname);
        });
        });

        // Function to open the review form with a predefined plant_id
        function openReviewForm(categoryid, categoryname) {
            document.getElementById("categoryid").value = categoryid;
            document.getElementById("old-categoryid").value = categoryid;
            document.getElementById("categoryname").value = categoryname;
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