<?php
include("../db.php");
function generateTestID($conn) {
    $result = $conn->query("SELECT test_id FROM tests ORDER BY id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastID = $row['test_id'];
        
        $lastNum = is_numeric(substr($lastID, -4)) ? intval(substr($lastID, -4)) : 0;
        $newNum = str_pad($lastNum + 1, 4, "0", STR_PAD_LEFT);
    } else {
        $newNum = "0001";
    }
    $date = date("Ymd");
    return "T" . $date . $newNum;
}

function redirect_back_with_error($msg, $old = []) {
    
    $base = "../add_test.html";
    
    $params = ['error' => $msg];
    foreach ($old as $k => $v) {
        $params[$k] = $v;
    }
    $qs = http_build_query($params);
    header("Location: $base?$qs");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id      = isset($_POST['product_id']) ? trim($_POST['product_id']) : '';
    $type_of_testing = isset($_POST['type_of_testing']) ? trim($_POST['type_of_testing']) : '';
    $tester_name     = isset($_POST['tester_name']) ? trim($_POST['tester_name']) : '';
    $status          = isset($_POST['status']) ? trim($_POST['status']) : '';
    $remarks         = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';

    $old = [
        'product_id' => $product_id,
        'type_of_testing' => $type_of_testing,
        'tester_name' => $tester_name,
        'status' => $status,
        'remarks' => $remarks
    ];

    if ($product_id === '' || $type_of_testing === '' || $tester_name === '' || $status === '') {
        redirect_back_with_error("Please fill all required fields.", $old);
    }

    $status_l = strtolower($status);
    if (!in_array($status_l, ['pass', 'fail'])) {
        redirect_back_with_error("Invalid status selected. Choose Pass or Fail.", $old);
    }
    
    $status = $status_l;

    $chkStmt = $conn->prepare("SELECT product_id FROM products WHERE product_id = ? LIMIT 1");
    $chkStmt->bind_param("s", $product_id);
    $chkStmt->execute();
    $chkStmt->store_result();
    if ($chkStmt->num_rows === 0) {
        $chkStmt->close();
        redirect_back_with_error("Invalid Product ID. Please enter a valid Product ID.", $old);
    }
    $chkStmt->close();

    $test_id = generateTestID($conn);

    $insert = $conn->prepare("INSERT INTO tests (test_id, product_id, type_of_testing, tester_name, status, remarks, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    if (!$insert) {
        
        redirect_back_with_error("Server error (prepare failed). Try again later.", $old);
    }
    $insert->bind_param("ssssss", $test_id, $product_id, $type_of_testing, $tester_name, $status, $remarks);
    $ok = $insert->execute();

    if ($ok) {
        header("Location: ../submit.php?test_id=" . urlencode($test_id));
        exit();
    } else {
        $err = $insert->error ? $insert->error : "Insert failed";
        $insert->close();
        redirect_back_with_error("Database error: " . $err, $old);
    }
}
?>
