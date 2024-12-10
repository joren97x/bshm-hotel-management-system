<?php
include '../config.php'; // Include your database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;

    // Validate booking_id
    if ($booking_id <= 0) {
        echo "<script>alert('Invalid booking ID.'); window.history.back();</script>";
        exit;
    }

    // Update booking status to complete
    // $update_query = "UPDATE bookings SET status = 'complete', paid_at = 'NOW()' WHERE id = ?";
    $update_query = "UPDATE bookings SET status = 'complete', paid_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('i', $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking marked as complete.'); window.location.href = 'approved_bookings.php';</script>";
    } else {
        echo "<script>alert('Error marking booking as complete.'); window.history.back();</script>";
    }
}
?>
