<?php
include '../db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM tests WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: ../tests.php?msg=deleted");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
} else {
    die("Invalid ID");
}
?>
