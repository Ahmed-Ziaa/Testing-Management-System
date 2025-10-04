<?php
include("db.php");

$passedCount = $conn->query("SELECT COUNT(*) AS total FROM tests WHERE status='pass'")->fetch_assoc()['total'];
$failedCount = $conn->query("SELECT COUNT(*) AS total FROM tests WHERE status='fail'")->fetch_assoc()['total'];

$monthlyData = [];
$result = $conn->query("
    SELECT MONTH(created_at) as month, 
           SUM(CASE WHEN status='pass' THEN 1 ELSE 0 END) as passed,
           SUM(CASE WHEN status='fail' THEN 1 ELSE 0 END) as failed
    FROM tests
    GROUP BY MONTH(created_at)
    ORDER BY MONTH(created_at)
");
while ($row = $result->fetch_assoc()) {
    $monthlyData['months'][] = "Month ".$row['month'];
    $monthlyData['passed'][] = $row['passed'];
    $monthlyData['failed'][] = $row['failed'];
}

$productData = [];
$result = $conn->query("
    SELECT p.product_name,
           SUM(CASE WHEN t.status='pass' THEN 1 ELSE 0 END) as passed,
           SUM(CASE WHEN t.status='fail' THEN 1 ELSE 0 END) as failed
    FROM products p
    LEFT JOIN tests t ON p.product_id = t.product_id
    GROUP BY p.product_id
");
while ($row = $result->fetch_assoc()) {
    $productData['products'][] = $row['product_name'];
    $productData['passed'][] = $row['passed'];
    $productData['failed'][] = $row['failed'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports - Testing System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <a href="reports.php" class="list-group-item list-group-item-action bg-dark text-white active">
          <i class="bi bi-bar-chart me-2"></i> Reports
        </a>
      </div>
    </div>

    <div id="page-content-wrapper" class="flex-grow-1">
      
      <nav class="navbar navbar-light bg-light border-bottom">
        <div class="container-fluid d-flex justify-content-between">
          <h5 class="mb-0">Reports</h5>
          <span class="nav-link">Hello, Admin</span>
        </div>
      </nav>

      <div class="container-fluid px-4 my-4">

        <div class="row g-4">
          <div class="col-md-4">
            <div class="card shadow">
              <div class="card-header bg-primary text-white">Pass vs Fail</div>
              <div class="card-body">
                <canvas id="pieChart"></canvas>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card shadow">
              <div class="card-header bg-success text-white">Monthly Test Trends</div>
              <div class="card-body">
                <canvas id="barChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="row my-5">
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-header bg-info text-white">Product-wise Test Results</div>
              <div class="card-body">
                <canvas id="productChart"></canvas>
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
  <script>
    
    new Chart(document.getElementById("pieChart"), {
      type: "pie",
      data: {
        labels: ["Passed", "Failed"],
        datasets: [{
          data: [<?= $passedCount ?>, <?= $failedCount ?>],
          backgroundColor: ["#28a745", "#dc3545"]
        }]
      }
    });

    new Chart(document.getElementById("barChart"), {
      type: "bar",
      data: {
        labels: <?= json_encode($monthlyData['months'] ?? []) ?>,
        datasets: [
          {
            label: "Passed",
            backgroundColor: "#28a745",
            data: <?= json_encode($monthlyData['passed'] ?? []) ?>
          },
          {
            label: "Failed",
            backgroundColor: "#dc3545",
            data: <?= json_encode($monthlyData['failed'] ?? []) ?>
          }
        ]
      }
    });

    new Chart(document.getElementById("productChart"), {
      type: "bar",
      data: {
        labels: <?= json_encode($productData['products'] ?? []) ?>,
        datasets: [
          {
            label: "Passed",
            backgroundColor: "#28a745",
            data: <?= json_encode($productData['passed'] ?? []) ?>
          },
          {
            label: "Failed",
            backgroundColor: "#dc3545",
            data: <?= json_encode($productData['failed'] ?? []) ?>
          }
        ]
      }
    });
  </script>
</body>
</html>
