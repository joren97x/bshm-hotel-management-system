<?php
include '../config.php';
include './sidebar.php';

// Fetch available rooms
$available_rooms_sql = "SELECT id, name FROM rooms WHERE status = 'vacant'";
$available_rooms_result = mysqli_query($conn, $available_rooms_sql);
$rooms = [];
while ($room = mysqli_fetch_assoc($available_rooms_result)) {
    $rooms[] = $room;
}

function generateCode($length = 6) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
}

// Handle Admin Booking Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = (int)$_POST['room_id'];
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : null;
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $room_price_sql = "SELECT price FROM rooms WHERE id = $room_id";
    $room_price_result = mysqli_query($conn, $room_price_sql);
    $room_data = mysqli_fetch_assoc($room_price_result);
    $room_price = $room_data['price'];

    $check_in_date = new DateTime($check_in);
    $check_out_date = new DateTime($check_out);
    $days = $check_in_date->diff($check_out_date)->days;
    $total_price = $days * $room_price;


    $status = 'approved';
    $code = generateCode();

    // Validation
    $errors = [];
    if (empty($room_id)) $errors[] = 'Room is required.';
    if (empty($name)) $errors[] = 'User name is required.';
    if (empty($contact)) $errors[] = 'User contact is required.';
    if (empty($check_in) || empty($check_out)) $errors[] = 'Check-in and check-out dates are required.';
    if ($total_price <= 0) $errors[] = 'Total price must be a positive value.';

    if (empty($errors)) {
        // Insert Booking
        $booking_sql = "INSERT INTO bookings (room_id, name, contact, total_price, status, code, check_in, check_out, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($booking_sql);
        $stmt->bind_param('issdssss', $room_id, $name, $contact, $total_price, $status, $code, $check_in, $check_out);

        if ($stmt->execute()) {
            // Update room status to "occupied"
            $update_room_sql = "UPDATE rooms SET status = 'occupied' WHERE id = ?";
            $update_stmt = $conn->prepare($update_room_sql);
            $update_stmt->bind_param('i', $room_id);
            $update_stmt->execute();

            echo "<script>alert('Booking created successfully'); window.location.href = 'reservations.php';</script>";
        } else {
            echo "<script>alert('Error creating booking');</script>";
        }
    } else {
        $_SESSION['errors'] = $errors;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Admin Booking</h1>

    <!-- Display Errors -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Booking Form -->
    <form method="POST">
        <div class="mb-3">
            <label for="room_id" class="form-label">Select Room</label>
            <select class="form-select" id="room_id" name="room_id" required>
                <option value="">-- Select a Room --</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room['id']; ?>"><?php echo $room['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">User Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">User Contact (Phone/Email)</label>
            <input type="text" class="form-control" id="contact" name="contact" required>
        </div>
        <div class="mb-3">
            <label for="check_in" class="form-label">Check-in Date</label>
            <input type="date" class="form-control" id="check_in" name="check_in" required>
        </div>
        <div class="mb-3">
            <label for="check_out" class="form-label">Check-out Date</label>
            <input type="date" class="form-control" id="check_out" name="check_out" required>
        </div>
        <!-- <div class="mb-3">
            <label for="total_price" class="form-label">Total Price</label>
            <input type="number" step="0.01" class="form-control" id="total_price" name="total_price" required>
        </div> -->
        <button type="submit" class="btn btn-primary">Create Booking</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
