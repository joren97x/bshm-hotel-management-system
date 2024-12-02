<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $room = $_POST['room'];

    $stmt = $conn->prepare("INSERT INTO pending (name, address, room) VALUES (?, ?, ?)");
    $stmt->execute([$name, $address, $room]);

    header("Location: staff-dashboard.php?page=pending");
    exit;
}
?>

