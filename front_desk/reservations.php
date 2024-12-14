<?php
include '../config.php';
include './sidebar.php';

function generateCode($length = 6)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    // Collect data from the form
    $room_type = $_POST['room_type'];
    $number_of_rooms = (int)$_POST['room_id'];
    $name = $_POST['name'];
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : null;
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $guests = $_POST['guests'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $booking_type = $_POST['booking_type'];

    $check_in_date = new DateTime($check_in);
    $check_out_date = new DateTime($check_out);
    $days = $check_in_date->diff($check_out_date)->days;

    $status = ($booking_type === 'walk_in') ? 'approved' : 'pending';
    
    // Prepare an SQL statement to fetch available rooms
    $available_rooms_sql = "
        SELECT r.id, r.name, r.room_type, r.room_number, r.price, r.capacity
        FROM rooms r
        LEFT JOIN bookings b ON r.id = b.room_id 
        AND (
            (b.check_in <= ? AND b.check_out > ?) OR 
            (b.check_in < ? AND b.check_out >= ?) OR 
            (b.check_in >= ? AND b.check_out <= ?)
        )
        WHERE r.status = 'vacant' AND b.id IS NULL";
    
    if (!empty($room_type)) {
        $available_rooms_sql .= " AND r.room_type = ?";
    }

    $stmt = $conn->prepare($available_rooms_sql);
    
    if (!empty($room_type)) {
        // Ensure to bind the correct number of parameters
        $stmt->bind_param('sssssss', $check_in, $check_in, $check_out, $check_out, $check_in, $check_out, $room_type);
    } else {
        $stmt->bind_param('ssssss', $check_in, $check_in, $check_out, $check_out, $check_in, $check_out);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $rooms = $result->fetch_all(MYSQLI_ASSOC);
    if (count($rooms) < $number_of_rooms) {
        $_SESSION['errors'][] = 'Not enough available rooms for the selected type.';
    } else {
        foreach (array_slice($rooms, 0, $number_of_rooms) as $room) {
            $room_id = $room['id'];
            $room_price = $room['price'];
            $total_price = $days * $room_price;
            $code = generateCode(); // Assuming this function exists
            $booking_sql = "INSERT INTO bookings (room_id, name, contact, total_price, gender, status, code, guests, address, email, check_in, check_out, booking_type, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($booking_sql);
$stmt->bind_param('ississsisssss', $room_id, $name, $contact, $total_price, $gender, $status, $code, $guests, $address, $email, $check_in, $check_out, $booking_type);

            $stmt->execute();
        }
        echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Bookings created successfully',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'reservations.php';
        });
    </script>
";
        // echo "<script>alert('Bookings created successfully'); window.location.href = 'reservations.php';</script>";
    }
}




$default_room_type = 'Standard';
$default_price_sql = "SELECT price, capacity FROM rooms WHERE room_type = ? LIMIT 1";
$stmt = $conn->prepare($default_price_sql);
$stmt->bind_param('s', $default_room_type);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$default_price = $row['price'];
$default_capacity = $row['capacity'];
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
        <h1 class="mb-4">Booking Management</h1>

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

            <div class="row">
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="room_type" class="form-label">Room Type</label>
                    <select class="form-control" name="room_type" id="room_type" required>
                        <option value="Superior">Superior</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Standard">Standard</option>
                    </select>
                </div>
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    Room Price: 
                    <div id="room_price">
                    <?php echo $default_price; ?>
                    </div>
                </div>
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="room_id" class="form-label">Number of Rooms</label>
                    <select class="form-select" id="room_id" name="room_id" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="guests" class="form-label">Number of Guests</label>
                    <input type="number" class="form-control"  id="guests"  max="<?php echo $default_capacity; ?>"  name="guests" required>
                </div>
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                
                <!-- <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
            </div> -->
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="contact" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="contact" name="contact" required>
                </div>
                <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="check_in" class="form-label">Check-in Date</label>
                        <input type="datetime-local" class="form-control" id="check_in" name="check_in" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="check_out" class="form-label">Check-out Date</label>
                        <input type="date" class="form-control" id="check_out" name="check_out" required>
                    </div>
                </div>
                <div class="col-4">
                    <label for="booking_type" class="form-label">Booking Type</label>
                    <select class="form-control" name="booking_type" id="booking_type" required>
                        <option value="walk_in">Walk in</option>
                        <option value="reserve">Reservation</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <label>Room Price:</label>
    <span id="room_price">0</span>
</div>
<div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <label>Total Price:</label>
    <span id="total_price">0.00</span>
</div>

            <button type="submit" name="book" class="btn btn-primary">Book Now</button>
        </form>
    </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Update Room Price when Room Type changes
    $('#room_type').change(function () {
        const roomType = $(this).val();
        if (roomType) {
            $.ajax({
                url: 'get_room_price.php', // Create this PHP script to fetch room price
                type: 'POST',
                data: { room_type: roomType },
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        $('#room_price').text(data.price); // Update room price display
                        $('#guests').attr('max', data.capacity);
                        $('#guests').attr('placeholder', 'Max ' + data.capacity);
                        calculateTotalPrice();
                    } else {
                        alert('Failed to fetch room price.');
                    }
                }
            });
        }
    });

    // Calculate Total Price
    function calculateTotalPrice() {
        const roomPrice = parseFloat($('#room_price').text());
        const numberOfRooms = parseInt($('#room_id').val()) || 0;
        const checkInDate = new Date($('#check_in').val());
        const checkOutDate = new Date($('#check_out').val());

        if (!isNaN(roomPrice) && numberOfRooms > 0 && checkInDate && checkOutDate) {
            const timeDiff = checkOutDate - checkInDate;
            const days = timeDiff > 0 ? Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) : 0;
            const totalPrice = roomPrice * numberOfRooms * days;
            $('#total_price').text(totalPrice.toFixed(2)); // Display total price
        }
    }

    // Trigger total price calculation on field changes
    $('#check_in, #check_out, #room_id').change(calculateTotalPrice);
});
</script>
