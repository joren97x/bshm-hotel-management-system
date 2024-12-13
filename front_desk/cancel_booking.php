<?php
include '../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking'])) {
    $booking_id = (int)$_POST['booking_id_hidden'];  // Accessing the hidden input value

    // Update the booking status to 'cancelled'
    $cancel_booking_sql = "UPDATE bookings SET status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($cancel_booking_sql);
    $stmt->bind_param('i', $booking_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Booking cancelled successfully.';
        header('Location: approved_bookings.php');
        exit();
    } else {
        $_SESSION['errors'][] = 'Failed to cancel the booking.';
    }
    echo $booking_id;
}
