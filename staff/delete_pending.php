<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM pending WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: staff-dashboard.php?page=pending");
    exit;
}
?>

