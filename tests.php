<?php
include("db.php");

$sql = "SELECT * FROM tests ORDER BY id DESC";

if (isset($_GET['search']) || isset($_GET['status'])) {
    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? '';

    $sql = "SELECT * FROM tests WHERE 1=1";

    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (product_id LIKE '%$search%' OR test_id LIKE '%$search%')";
    }

    if (!empty($status)) {
        $status = $conn->real_escape_string($status);
        $sql .= " AND status = '$status'";
    }

    $sql .= " ORDER BY id DESC";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Testing Records - SRS Electricals</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 0; }
    header { background: #007bff; color: white; padding: 15px 20px; text-align: center; font-size: 22px; font-weight: bold; }
    .container { width: 90%; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); }
    h2 { margin-bottom: 15px; font-size: 20px; color: #333; }
    .add-btn { background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-size: 14px; margin-bottom: 20px; display: inline-block; }
    .search-box { margin-bottom: 20px; display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
    .search-box input, .search-box select { padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; flex: 1; }
    .search-box button { background: #007bff; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; }
    table { width: 100%; border-collapse: collapse; }
    table thead { background: #007bff; color: white; }
    table th, table td { padding: 12px; border: 1px solid #ddd; text-align: center; font-size: 14px; }
    table tr:nth-child(even) { background: #f2f2f2; }
    .status-pass { color: green; font-weight: bold; }
    .status-fail { color: red; font-weight: bold; }
    .actions button { padding: 6px 12px; margin: 2px; border: none; border-radius: 5px; cursor: pointer; font-size: 12px; }
    .view-btn { background: #28a745; color: white; }
    .edit-btn { background: #ffc107; color: black; }
    .delete-btn { background: #dc3545; color: white; }
    @media (max-width: 768px) {
      table thead { display: none; }
      table, table tbody, table tr, table td { display: block; width: 100%; }
      table tr { margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; padding: 10px; }
      table td { text-align: right; padding-left: 50%; position: relative; }
      table td::before { content: attr(data-label); position: absolute; left: 15px; width: 45%; padding-left: 10px; font-weight: bold; text-align: left; }
    }
  </style>
</head>
<body>

<header>Testing Records - SRS Electricals</header>

<div class="container">
  <h2>All Testing Records</h2>
  <a href="add_test.html" class="add-btn">+ Add New Test</a>

  <form method="GET" class="search-box">
    <input type="text" name="search" placeholder="Enter Product ID or Test ID" value="<?= $_GET['search'] ?? '' ?>">
    <select name="status">
      <option value="">Filter by Status</option>
      <option value="pass" <?= (($_GET['status'] ?? '') == 'pass') ? 'selected' : '' ?>>Pass</option>
      <option value="fail" <?= (($_GET['status'] ?? '') == 'fail') ? 'selected' : '' ?>>Fail</option>
    </select>
    <button type="submit">Search</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Test ID</th>
        <th>Product ID</th>
        <th>Type of Testing</th>
        <th>Tester Name</th>
        <th>Status</th>
        <th>Remarks</th>
        <th>Tested At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && mysqli_num_rows($result) > 0): ?> 
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td data-label="ID"><?= $row['id'] ?></td>
            <td data-label="Test ID"><?= $row['test_id'] ?></td>
            <td data-label="Product ID"><?= $row['product_id'] ?></td>
            <td data-label="Type of Testing"><?= $row['type_of_testing'] ?></td>
            <td data-label="Tester Name"><?= $row['tester_name'] ?></td>
            <td data-label="Status" class="<?= strtolower($row['status'])=='pass'?'status-pass':'status-fail' ?>">
              <?= ucfirst($row['status']) ?>
            </td>
            <td data-label="Remarks"><?= $row['remarks'] ?></td>
            <td data-label="Created At"><?= $row['created_at'] ?></td>
            <td data-label="Actions" class="actions">
              <a href="Logics/edit_test.php?id=<?= $row['id'] ?>"><button class="edit-btn">Edit</button></a>
              <a href="Logics/delete_test.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">
                <button class="delete-btn">Delete</button>
              </a>
            </td>
          </tr> 
        <?php endwhile; ?>
      <?php else: ?>
       <tr><td colspan="9">No records found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
