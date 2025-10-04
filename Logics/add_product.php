<?php
include("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $revise = $_POST['revise'];

    $datePart = date("ymd"); 
    $randomPart = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    $product_id = $datePart . $randomPart; 

    $sql = "INSERT INTO products (product_id, product_name, revise, created_at) 
            VALUES ('$product_id', '$product_name', '$revise', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../success.php?msg=" . urlencode("Product added successfully! Product ID: $product_id"));
        exit();
    } else {
        header("Location: ../success.php?msg=" . urlencode("Error: " . $conn->error));
        exit();
    }
}
?>
