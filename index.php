<?php
include("db.php");

$productCount = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];

$passedCount = $conn->query("SELECT COUNT(*) AS total FROM tests WHERE status='Pass'")->fetch_assoc()['total'];
$failedCount = $conn->query("SELECT COUNT(*) AS total FROM tests WHERE status='Fail'")->fetch_assoc()['total'];

$recentProducts = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 5");

$recentTests = $conn->query("SELECT * FROM tests ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Testing System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  
  <div class="d-flex" id="wrapper">
    
    <div class="bg-dark border-end text-white" id="sidebar-wrapper">
      <div class="sidebar-heading py-4 px-3 fw-bold fs-4 border-bottom">⚡ Testing System</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a href="products.php" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="bi bi-box-seam me-2"></i> Products
        </a>
        <a href="tests.php" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="bi bi-check2-circle me-2"></i> Tests
        </a>
        <a href="reports.php" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="bi bi-bar-chart me-2"></i> Reports
        </a>
      </div>
    </div>
    
    <div id="page-content-wrapper" class="flex-grow-1">
      
      <nav class="navbar navbar-light bg-light border-bottom">
        <div class="container-fluid d-flex justify-content-between">
          <h5 class="mb-0">Dashboard :</h5>
        </div>
      </nav>

      <div class="container-fluid px-4 my-4">
        <div class="row g-4">
          <div class="col-md-4 col-sm-6">
            <div class="card text-bg-primary shadow h-100">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h5 class="card-title">Total Products</h5>
                  <p class="fs-3 fw-bold mb-0"><?php echo $productCount; ?></p>
                </div>
                <i class="bi bi-box-seam fs-1"></i>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card text-bg-success shadow h-100">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h5 class="card-title">Passed Tests</h5>
                  <p class="fs-3 fw-bold mb-0"><?php echo $passedCount; ?></p>
                </div>
                <i class="bi bi-check2-circle fs-1"></i>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card text-bg-danger shadow h-100">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h5 class="card-title">Failed Tests</h5>
                  <p class="fs-3 fw-bold mb-0"><?php echo $failedCount; ?></p>
                </div>
                <i class="bi bi-x-circle fs-1"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row my-5">
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-header bg-success text-white">Recent Tests</div>
              <div class="card-body" style="max-height:300px; overflow-y:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Product</th>
                      <th>Status</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($t = $recentTests->fetch_assoc()): ?>
                      <tr>
                        <td><?php echo $t['id']; ?></td>
                        <td><?php echo $t['product_id']; ?></td>
                        <td><?php echo $t['status']; ?></td>
                        <td><?php echo $t['created_at']; ?></td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row my-5">
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-header bg-primary text-white">Recent Products</div>
              <div class="card-body" style="max-height:300px; overflow-y:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Product-Id</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($p = $recentProducts->fetch_assoc()): ?>
                      <tr>
                        <td><?php echo $p['id']; ?></td>
                        <td><?php echo $p['product_name']; ?></td>
                        <td><?php echo $p['product_id']; ?></td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <footer class="bg-dark text-white text-center py-2 mt-auto">
        <p class="mb-0">&copy; 2025 Aptech Learning E-Project | All Rights Reserved</p>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
