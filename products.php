<?php
include("db.php");

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $sql = "SELECT * FROM products 
            WHERE product_name LIKE '%$search%' OR product_id LIKE '%$search%' 
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products - SRS Electricals</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    header {
      background: #007bff;
      color: white;
      padding: 15px 20px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }

    .container {
      width: 90%;
      margin: 20px auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
    }

    h2 {
      margin-bottom: 15px;
      font-size: 20px;
      color: #333;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      flex-wrap: wrap;
    }

    .add-btn {
      background: #28a745;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 14px;
    }

    .search-box {
      display: flex;
      margin-top: 10px;
    }

    .search-box input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px 0 0 5px;
      outline: none;
    }

    .search-box button {
      padding: 8px 15px;
      border: none;
      background: #007bff;
      color: white;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table thead {
      background: #007bff;
      color: white;
    }

    table th, table td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
      font-size: 14px;
    }

    table tr:nth-child(even) {
      background: #f2f2f2;
    }

    .actions button {
      padding: 6px 12px;
      margin: 2px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 12px;
    }

    .edit-btn { background: #ffc107; color: black; }
    .delete-btn { background: #dc3545; color: white; }

    @media (max-width: 768px) {
      table thead { display: none; }
      table, table tbody, table tr, table td {
        display: block;
        width: 100%;
      }
      table tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
      }
      table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
      }
      table td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: 45%;
        padding-left: 10px;
        font-weight: bold;
        text-align: left;
      }
    }
  </style>
</head>
<body>

<header>Products - SRS Electricals</header>

<div class="container">
  <h2>All Products</h2>

  <div class="top-bar">
    <a href="add_product.html" class="add-btn">+ Add New Product</a>
    <form method="GET" class="search-box">
      <input type="text" name="search" placeholder="Search by ID or Name" value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Search</button>
    </form>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Revision</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td data-label='ID'>".$row['id']."</td>
                      <td data-label='Product ID'>".$row['product_id']."</td>
                      <td data-label='Product Name'>".$row['product_name']."</td>
                      <td data-label='Revision'>".$row['revise']."</td>
                      <td data-label='Created At'>".$row['created_at']."</td>
                      <td data-label='Actions' class='actions'>
                          <a href='Logics/edit_product.php?id=".$row['id']."'><button class='edit-btn'>Edit</button></a>
                          <a href='Logics/delete_product.php?id=".$row['id']."' onclick=\"return confirm('Are you sure?')\">
                              <button class='delete-btn'>Delete</button>
                          </a>
                      </td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No products found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
