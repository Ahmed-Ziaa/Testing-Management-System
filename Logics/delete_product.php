<?php
include("../db.php");

if (!isset($_GET['id'])) {
    die("Product ID missing.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM products WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../success.php?msg=Product deleted successfully&type=product");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
