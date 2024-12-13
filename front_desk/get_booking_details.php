<?php
include '../config.php';

if (isset($_GET['id'])) {
    $bookingId = (int)$_GET['id'];

    $query = "
        SELECT 
            IF(users.id IS NULL, bookings.name, CONCAT(users.first_name, ' ', users.last_name)) AS full_name,
            IF(users.id IS NULL, bookings.email, users.email) AS email,
            IF(users.id IS NULL, bookings.contact, users.phone_number) AS contact,
            IF(users.id IS NULL, bookings.address, users.address) AS address,
            bookings.*, 
            rooms.name AS room_name, 
            rooms.room_type
        FROM bookings
        LEFT JOIN users ON bookings.user_id = users.id
        JOIN rooms ON bookings.room_id = rooms.id
        WHERE bookings.id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookingDetails = $result->fetch_assoc();

    echo json_encode($bookingDetails);
}
?>
