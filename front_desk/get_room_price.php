<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['room_type'])) {
    $room_type = $_POST['room_type'];
    $sql = "SELECT price, capacity FROM rooms WHERE room_type = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $room_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'price' => $row['price'], 'capacity' => $row['capacity']]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
