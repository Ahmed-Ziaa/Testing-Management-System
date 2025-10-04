<?php
include("../db.php");

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM tests WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $type_of_testing = $_POST['type_of_testing'];
    $tester_name = $_POST['tester_name'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    $update = "UPDATE tests SET 
                type_of_testing='$type_of_testing', 
                tester_name='$tester_name', 
                status='$status', 
                remarks='$remarks' 
               WHERE id=$id";

    if ($conn->query($update)) {
        header("Location: ../tests.php?msg=updated");
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
  <title>Edit Test</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin:0; padding:0; }
    header { background:#007bff; color:white; padding:15px; text-align:center; font-size:22px; font-weight:bold; }
    .container { width:50%; margin:30px auto; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
    h2 { margin-bottom:20px; color:#333; }
    form label { display:block; margin-top:10px; font-weight:bold; }
    form input, form select, form textarea { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; font-size:14px; }
    .form-btns { margin-top:20px; display:flex; gap:10px; }
    .form-btns button { padding:10px 15px; border:none; border-radius:5px; cursor:pointer; font-size:14px; }
    .save-btn { background:#28a745; color:white; }
    .cancel-btn { background:#dc3545; color:white; text-decoration:none; padding:10px 15px; display:inline-block; }
  </style>
</head>
<body>

<header>Edit Test Record</header>

<div class="container">
  <h2>Edit Test</h2>
  <form method="POST">
    <label for="product_id">Product ID</label>
    <input type="text" name="product_id" value="<?php echo $row['product_id']; ?>" readonly>

    <label for="test_name">Type of Testing</label>
    <input type="text" name="type_of_testing" value="<?= $row['type_of_testing'] ?>" required>

    <label for="tester_name">Tester Name</label>
    <input type="text" name="tester_name" value="<?= $row['tester_name'] ?>" required>

    <label for="status">Status</label>
    <select name="status" required>
      <option value="pass" <?= $row['status']=='pass'?'selected':'' ?>>Pass</option>
      <option value="fail" <?= $row['status']=='fail'?'selected':'' ?>>Fail</option>
    </select>

    <label for="remarks">Remarks</label>
    <textarea name="remarks"><?= $row['remarks'] ?></textarea>

    <div class="form-btns">
      <button type="submit" class="save-btn">Update Test</button>
      <a href="../tests.php" class="cancel-btn">Cancel</a>
    </div>
  </form>
</div>

</body>
</html>
