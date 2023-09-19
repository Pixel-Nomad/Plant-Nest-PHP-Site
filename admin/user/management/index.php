<?php
    require ('../../../config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if (isset($_SESSION['isLoggedin'])){
        if ($_SESSION['isVerified']) {
            if ($_SESSION['user-role'] != 'user') {
            if (isset($_POST['submit']) && isset($_POST['options'])){
                $id = $_POST['old-userid'];
                $role = $_POST['options'];
                $sql = "UPDATE `users` SET `role` = '$role' WHERE `user_id` = $id";
                $result = mysqli_query($connection,$sql);
                if ($result) {
                    if ( $_SESSION['user-role'] == $_POST['old-userid']) {
                        $_SESSION['user-role'] = $role;
                    }
                    header('location: '. $config['URL'].'/admin/user/management');
                    exit(); 
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
                    <a href='<?php echo $config['URL']?>/admin/user/management' class="nav-link active px-3">
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
          <h4>User Management</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-table me-2"></i></span> User Management
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-striped data-table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User Name</th>
                      <th>Full Name</th>
                      <th>Email</th>
                      <th>Contact</th>
                      <th>Company</th>
                      <th>Address</th>
                      <th>Country</th>
                      <th>City</th>
                      <th>Role</th>
                      <th>Date Created</th>
                      <th class="d-none"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT * FROM `users`";
                      $result = mysqli_query($connection,$sql);
                      $total  = mysqli_num_rows($result);
                      if ($total >= 1) {
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo '<tr>
                              <td>'.$row['user_id'].'</td>
                              <td>'.$row['username'].'</td>
                              <td>'.$row['fullname'].'</td>
                              <td>'.$row['email'].'</td>
                              <td>'.$row['contact'].'</td>
                              <td>'.$row['company'].'</td>
                              <td>'.$row['address'].'</td>
                              <td>'.$row['country'].'</td>
                              <td>'.$row['city'].'</td>
                              <td>'.$row['role'].'</td>
                              <td>'.$row['date'].'</td>';
                              if ($_SESSION['user-role'] == 'master' ){
                                if ($row['user_id'] != $_SESSION['user-id']) {
                                    echo '<td><button class="btn btn-danger open-review-form"  
                                    data-user-id='.$row['user_id'].'
                                    data-user-role="'.$row['role'].'">Update Status</button></td>
                                    </tr>';
                                } else {
                                    echo "<td>Can't Manage self role</td>";
                                }
                              }
                          }
                      }
                    ?>
                    
                    
                  </tbody>
                  <tfoot>
                  <th>ID</th>
                      <th>User Name</th>
                      <th>Full Name</th>
                      <th>Email</th>
                      <th>Contact</th>
                      <th>Company</th>
                      <th>Address</th>
                      <th>Country</th>
                      <th>City</th>
                      <th>Role</th>
                      <th>Date Created</th>
                      <th class="d-none"></th>
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
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="user" value="user" checked>
                <label class="form-check-label" for="user">
                    user
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="admin" value="admin" checked>
                <label class="form-check-label" for="admin">
                admin
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="master" value="master" checked>
                <label class="form-check-label" for="master">
                    master
                </label>
            </div>
            <input type="number" class="d-none" id="old-userid" name="old-userid" value="">
            <br>
            <input type="submit" class="btn btn-primary" value="Update" name="submit"></input>
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
        function replaceSpacesWithHyphens(inputString) {
            return inputString.replace(/\s/g, '-');
        }
        const openReviewFormButtons = document.querySelectorAll(".open-review-form");

        // Add a click event listener to each button
        openReviewFormButtons.forEach(button => {
        button.addEventListener("click", function () {
            const id = button.getAttribute("data-user-id");
            const role = button.getAttribute("data-user-role");
            openReviewForm(id, role);
        });
        });

        // Function to open the review form with a predefined plant_id
        function openReviewForm(id, role) {
            document.getElementById("old-userid").value = id;
            document.getElementById(replaceSpacesWithHyphens(role)).checked = true;
            document.getElementById("reviewFormOverlay").style.display = "flex";
        }

        document.getElementById("closeReviewForm").addEventListener("click", function () {
            document.getElementById("reviewFormOverlay").style.display = "none";
        });
    </script>
</body>
</html>