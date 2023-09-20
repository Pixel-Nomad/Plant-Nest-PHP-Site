<?php
    require ('../../../config.php'); 
    session_start();
    $connection = mysqli_connect($config['DB_URL'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);
    if (isset($_SESSION['isLoggedin'])){
        if ($_SESSION['isVerified']) {
          if ($_SESSION['user-role'] != 'user') {
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
    <link rel="stylesheet" href="<?php echo $config['URL']?>/assets/css/dataTables.bootstrap5.min.css"/>
   
    <link rel="stylesheet" href="<?php echo $config['URL']?>/assets/css/style.css" />
    <title>Plant Nest</title> 
    <link rel="icon" href='<?php echo $config['URL']?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL']?>/assets/image/fav/fav.ico' type="image/x-icon">
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
                    <a href='<?php echo $config['URL']?>/admin/user/feedbacks' class="nav-link px-3 active">
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
          <h4>User Feedbacks</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-table me-2"></i></span> User Feedbacks
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-striped data-table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User ID</th>
                      <th>Message</th>
                      <th>Satisfaction</th>
                      <th>Feedback Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $sql = "SELECT * FROM `feedbacks`";
                        $result = mysqli_query($connection,$sql);
                        $total  = mysqli_num_rows($result);
                        if ($total >= 1) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                <td>'.$row['id'].'</td>
                                <td>'.$row['user_id'].'</td>
                                <td>'.$row['message'].'</td>
                                <td>'.$row['satisfaction'].'</td>
                                <td>'.$row['Feedback_Date'].'</td>
                              </tr>';
                            }
                        }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>ID</th>
                      <th>User ID</th>
                      <th>Message</th>
                      <th>Satisfaction</th>
                      <th>Feedback Date</th>
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
    <script src="<?php echo $config['URL']?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/jquery-3.5.1.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?php echo $config['URL']?>/assets/js/script.js"></script>
</body>
</html>

<?php
    mysqli_close($connection);
?>