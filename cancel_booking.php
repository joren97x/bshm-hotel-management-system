<?php
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $booking_id = isset($data['booking_id']) ? (int)$data['booking_id'] : 0;

    if ($booking_id > 0) {
        $cancel_query = "UPDATE bookings SET status = 'cancelled' WHERE id = $booking_id";
        if (mysqli_query($conn, $cancel_query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid booking ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
