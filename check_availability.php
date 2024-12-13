<?php
// check_availability.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include './config.php';

    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_type = $_POST['room_type']; // Accept room_type from the client

    // Query to get available rooms based on date range and room type
    $sql = "SELECT id, name, room_type, room_number
            FROM rooms 
            WHERE status = 'vacant' 
            AND room_type = ? 
            AND id NOT IN (
                SELECT room_id 
                FROM bookings 
                WHERE (check_in <= ? AND check_out >= ?)
                OR (check_in < ? AND check_out >= ?)
                OR (check_in >= ? AND check_out <= ?)
            )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssss', $room_type, $check_out, $check_in, $check_out, $check_in, $check_in, $check_out);
    $stmt->execute();
    $result = $stmt->get_result();

    $rooms = [];
    while ($room = $result->fetch_assoc()) {
        $rooms[] = $room;
    }

    header('Content-Type: application/json');
    echo json_encode($rooms);
    exit;
}
