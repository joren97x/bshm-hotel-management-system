<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Update the booking status to 'Confirm'
    $stmt = $conn->prepare("UPDATE roombook SET stat = 'Confirm' WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect back to the reservation page
    header("Location: staff-dashboard.php?page=reservation");
    exit;
}
?>

