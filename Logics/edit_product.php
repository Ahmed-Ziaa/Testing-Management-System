<?php
include("../db.php");

if (!isset($_GET['id'])) {
    die("Product ID missing.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = trim($_POST['product_id']);
    $product_name = trim($_POST['product_name']);
    $revise = trim($_POST['revise']);

    $update_sql = "UPDATE products 
                   SET product_id='$product_id', product_name='$product_name', revise='$revise' 
                   WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: ../success.php?msg=Product updated successfully&type=product");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 90%;
      max-width: 500px;
      margin: 40px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      background: #007bff;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Product</h2>
    <form method="POST">
      <label>Product ID</label>
      <input type="text" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>" maxlength="10" required>

      <label>Product Name</label>
      <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>

      <label>Revision</label>
      <input type="text" name="revise" value="<?= htmlspecialchars($product['revise']) ?>" required>

      <button type="submit">Update Product</button>
    </form>
  </div>
</body>
</html>
