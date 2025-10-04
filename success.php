<?php $msg = isset($_GET['msg']) ? $_GET['msg'] : "No message."; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Status</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .message-box {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .message-box h2 {
      color: #28a745;
      margin-bottom: 20px;
    }
    .message-box a {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      background: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="message-box">
    <h2><?php echo $msg; ?></h2>
    <a href="./add_product.html">➕ Add Another Product</a>
    <a href="./products.php">📋 View Products</a>
  </div>
</body>
</html>
