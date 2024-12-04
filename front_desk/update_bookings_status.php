<?php
include '../config.php'; // Include database connection

if (isset($_POST['booking_id']) && isset($_POST['action'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    // Check action and update accordingly
    if ($action === 'check_in') {
        $booking_query = "UPDATE bookings SET status = 'checked_in' WHERE id = ?";
        $room_query = "
            UPDATE rooms 
            SET status = 'not available' 
            WHERE id = (SELECT room_id FROM bookings WHERE id = ?)";
    } elseif ($action === 'check_out') {
        $booking_query = "UPDATE bookings SET status = 'checked_out' WHERE id = ?";
        $room_query = "
            UPDATE rooms 
            SET status = 'available' 
            WHERE id = (SELECT room_id FROM bookings WHERE id = ?)";
    } else {
        echo 'error';
        exit;
    }

    // Prepare and execute the update query for bookings
    $stmt_booking = mysqli_prepare($conn, $booking_query);
    mysqli_stmt_bind_param($stmt_booking, 'i', $booking_id);

    // Prepare and execute the update query for rooms
    $stmt_room = mysqli_prepare($conn, $room_query);
    mysqli_stmt_bind_param($stmt_room, 'i', $booking_id);

    // Execute the queries and check for success
    if (mysqli_stmt_execute($stmt_booking) && mysqli_stmt_execute($stmt_room)) {
        // If both updates are successful, redirect back to the approved bookings page
        header("Location: approved_bookings.php");
        exit;
    } else {
        echo 'Error updating status';
    }

    // Close the prepared statements
    mysqli_stmt_close($stmt_booking);
    mysqli_stmt_close($stmt_room);
} else {
    echo 'Invalid request';
}
?>
