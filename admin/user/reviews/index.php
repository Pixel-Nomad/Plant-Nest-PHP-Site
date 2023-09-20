<?php
require('../../../config.php');
session_start();
$connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
$export = false;
if (isset($_SESSION['isLoggedin'])) {
  if ($_SESSION['isVerified']) {
    if ($_SESSION['user-role'] != 'user') {
      if (isset($_POST['Export1'])) {
        $option = $_POST['option'];
        $currentTime = date("Y-m-d H:i:s");
        $startDate = date("Y-m-d H:i:s", strtotime("-$option days", strtotime($currentTime)));
        $query = "SELECT * FROM reviews WHERE Review_Date >= '$startDate' AND Review_Date <= '$currentTime'";
        $result = mysqli_query($connection, $query);
        if ($result) {
          $filename = "$startDate _ $currentTime.csv";
          header("Content-Type: text/csv");
          header("Content-Disposition: attachment; filename=$filename");
          $output = fopen("php://output", "w");
          fputcsv($output, array("id", "plant_id", "user_id", "Review_Date", "stars", "review"));
          while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
          }
          $export = true;
        }
      }
      if (isset($_POST['Export2'])) {
        $currentTime = $_POST['time_after'];
        $currentTime = date("Y-m-d H:i:s", strtotime($currentTime));
        $startDate = $_POST['time_before'];
        $startDate = date("Y-m-d H:i:s", strtotime($startDate));
        $query = "SELECT * FROM reviews WHERE Review_Date >= '$startDate' AND Review_Date <= '$currentTime'";
        $result = mysqli_query($connection, $query);
        if ($result) {
          $filename = "$startDate _ $currentTime.csv";
          header("Content-Type: text/csv");
          header("Content-Disposition: attachment; filename=$filename");
          $output = fopen("php://output", "w");
          fputcsv($output, array("id", "plant_id", "user_id", "Review_Date", "stars", "review"));
          while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
          }
          $export = true;
        }
      }
    } else {
      header('location: ' . $config['URL'] . '/user/login');
      mysqli_close($connection);
      exit();
    }
  } else {
    header('location: ' . $config['URL'] . '/user/verify');
    mysqli_close($connection);
    exit();
  }
} else {
  header('location: ' . $config['URL'] . '/user/login');
  mysqli_close($connection);
  exit();
}
?>

<?php
if (!$export) {
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/dataTables.bootstrap5.min.css" />

    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/style.css" />
    <title>Plant Nest</title>
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous" />
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
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="#">Admin Panel ( Logged in as <?php echo $_SESSION['user-role'] ?> )</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
          <div class="d-flex ms-auto my-3 my-lg-0">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-fill"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/user/settings'>Settings</a></li>
                  <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/user/logout'>Logout</a></li>
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
              <a href='<?php echo $config['URL'] ?>/admin/' class="nav-link px-3">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>Dashboard</span>
              </a>
              <a href='<?php echo $config['URL'] ?>/' class="nav-link px-3 active">
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
                    <a href='<?php echo $config['URL'] ?>/admin/management/category' class="nav-link px-3">
                      <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                      <span>Category Management</span>
                    </a>
                  </li>
                  <li>
                    <a href='<?php echo $config['URL'] ?>/admin/management/product' class="nav-link px-3">
                      <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                      <span>Product Management</span>
                    </a>
                  </li>
                  <li>
                    <a href='<?php echo $config['URL'] ?>/admin/management/orders' class="nav-link px-3">
                      <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                      <span>Order Management</span>
                    </a>
                  </li>
                  <li>
                    <a href='<?php echo $config['URL'] ?>/admin/management/list' class="nav-link px-3">
                      <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                      <span>Order List</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <a href='<?php echo $config['URL'] ?>/admin/user/reviews' class="nav-link active px-3">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>Product Reviews</span>
              </a>
            </li>
            <li>
              <a href='<?php echo $config['URL'] ?>/admin/user/feedbacks' class="nav-link px-3">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>User Feedbacks</span>
              </a>
            </li>
            <li>
              <a href='<?php echo $config['URL'] ?>/admin/management/sliders' class="nav-link px-3">
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
              <a href='<?php echo $config['URL'] ?>/admin/user/management' class="nav-link px-3">
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
            <h4>Product Reviews</h4>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary open-review-form2" type="button">Export Reviews</button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Product Reviews
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example" class="table table-striped data-table" style="width: 100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Plant ID</th>
                        <th>User ID</th>
                        <th>review</th>
                        <th>Stars</th>
                        <th>Review Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM `reviews`";
                      $result = mysqli_query($connection, $sql);
                      $total  = mysqli_num_rows($result);
                      if ($total >= 1) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo '<tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['plant_id'] . '</td>
                                <td>' . $row['user_id'] . '</td>
                                <td>' . $row['review'] . '</td>
                                <td>' . $row['stars'] . '</td>
                                <td>' . $row['Review_Date'] . '</td>
                              </tr>';
                        }
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th>Plant ID</th>
                        <th>User ID</th>
                        <th>review</th>
                        <th>Stars</th>
                        <th>Review Date</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="review-form-overlay" id="reviewFormOverlay2">
        <div class="review-form">
          <button class="close-review-form" id="closeReviewForm2"><i class="fas fa-times"></i></button>
          <h2 class="mb-4">Export All Reviews</h2>
          <form method="post">
            <div class="form-floating mb-3">
              <select class="form-select" name="option" required id="floatingCountry">
                <option value="" disabled selected>Select Duration</option>
                <option value="1">1 Day</option>
                <option value="7">7 Day</option>
                <option value="30">30 Day</option>
              </select>
              <label for="floatingCountry">Duration</label>
            </div>
            <input type="submit" class="btn btn-primary" value="Export" name="Export1"></input>
          </form>
          <br>
          <button class="btn btn-primary open-review-form4">Export By Dates</button>
        </div>
      </div>
      <div class="review-form-overlay" id="reviewFormOverlay4">
        <div class="review-form">
          <button class="close-review-form" id="closeReviewForm4"><i class="fas fa-times"></i></button>
          <h2 class="mb-4">Export All Reviews</h2>
          <form method="post">
            <label>From</label>
            <input type="datetime-local" name="time_before" required>
            <br>
            <br>
            <label>To</label>
            <input type="datetime-local" name="time_after" required>
            <br>
            <br>
            <input type="submit" class="btn btn-primary" value="Export" name="Export2"></input>
          </form>
          <br>
          <button class="btn btn-primary open-review-form2">Export By Option</button>
        </div>
      </div>
    </main>
    <script src="<?php echo $config['URL'] ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/jquery-3.5.1.js"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/script.js"></script>
    <script>
      const openReviewFormButtons2 = document.querySelectorAll(".open-review-form2");

      // Add a click event listener to each button
      openReviewFormButtons2.forEach(button => {
        button.addEventListener("click", function() {
          document.getElementById("reviewFormOverlay4").style.display = "none";
          document.getElementById("reviewFormOverlay2").style.display = "flex";
        });
      });
      document.getElementById("closeReviewForm2").addEventListener("click", function() {
        document.getElementById("reviewFormOverlay2").style.display = "none";
      });
    </script>
    <script>
      const openReviewFormButtons4 = document.querySelectorAll(".open-review-form4");

      // Add a click event listener to each button
      openReviewFormButtons4.forEach(button => {
        button.addEventListener("click", function() {
          document.getElementById("reviewFormOverlay2").style.display = "none";
          document.getElementById("reviewFormOverlay4").style.display = "flex";
        });
      });
      document.getElementById("closeReviewForm4").addEventListener("click", function() {
        document.getElementById("reviewFormOverlay4").style.display = "none";
      });
    </script>
  </body>

  </html>

<?php
}
mysqli_close($connection);
?>