<?php
include '../config.php';

if (isset($_GET['id'])) {
    $bookingId = (int)$_GET['id'];

    // Check database connection
    if (!$conn) {
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }

    // Query to fetch booking details
//     SELECT 
//     IF(bookings.user_id IS NULL, 'hi', 'hii') AS email,
// IF(bookings.user_id IS NULL, bookings.contact, users.phone_number) AS contact,
// IF(bookings.user_id IS NULL, bookings.address, users.address) AS address,
// IF(bookings.user_id IS NULL, bookings.name, CONCAT(users.first_name, ' ', users.last_name)) AS full_name,

// bookings.*, 
// rooms.name AS room_name, 
// rooms.room_type
// FROM bookings
// LEFT JOIN users ON bookings.user_id = users.id
// JOIN rooms ON bookings.room_id = rooms.id
// WHERE bookings.id = ?
    $query = "
        SELECT 
            IF(bookings.user_id IS NULL, bookings.contact, users.phone_number) AS contact,
            IF(bookings.user_id IS NULL, bookings.address, users.address) AS address,
            IF(bookings.user_id IS NULL, bookings.email, users.email) AS email,
            IF(bookings.user_id IS NULL, bookings.name, CONCAT(users.first_name, ' ', users.last_name)) AS full_name,
            rooms.name AS room_name, rooms.room_type, bookings.code, bookings.booking_type, bookings.check_in, bookings.check_out, bookings.guests, bookings.total_price
        FROM bookings
        LEFT JOIN users ON bookings.user_id = users.id
        JOIN rooms ON bookings.room_id = rooms.id
        WHERE bookings.id = ?;

    ";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $bookingId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $bookingDetails = $result->fetch_assoc();
                echo json_encode($bookingDetails);
            } else {
                echo json_encode(['error' => 'No booking found for the provided ID.']);
            }
        } else {
            echo json_encode(['error' => 'Failed to execute query: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare query: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'No booking ID provided.']);
}
?>
