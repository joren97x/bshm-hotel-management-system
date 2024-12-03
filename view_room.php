<?php
include 'config.php';
// session_start();
include 'navbar.php';

// Get room ID from URL (e.g., /view_room.php?id=1)
$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query to get room data based on room ID
$sql = "SELECT * FROM rooms WHERE id = $room_id";
$result = mysqli_query($conn, $sql);

// Check if the room exists
if ($row = mysqli_fetch_assoc($result)) {
    // Room details
    $room_name = $row['name'];
    $room_type = $row['room_type'];
    $room_price = $row['price'];
    $room_description = $row['description'];
    $room_amenities = $row['amenities'];
    $images = explode(',', $row['images']); // Assuming images are stored as a comma-separated string
} else {
    echo "Room not found.";
    exit;
}

// Query to count available rooms of the same type
$available_sql = "SELECT COUNT(*) AS available_count FROM rooms WHERE room_type = '" . mysqli_real_escape_string($conn, $row['room_type']) . "' AND status = 'Vacant'";
$available_result = mysqli_query($conn, $available_sql);
$available_data = mysqli_fetch_assoc($available_result);
$available_rooms = (int)$available_data['available_count']; // Number of available rooms

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = 1; // Replace with actual logged-in user ID
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $number_of_rooms = (int)$_POST['number_of_rooms'];
    $total_price = $number_of_rooms * $room_price;

    for ($i = 0; $i < $number_of_rooms; $i++) {
        $insert_sql = "INSERT INTO bookings (user_id, room_id, status, check_in, check_out, total_price, created_at) 
                       VALUES ('$user_id', '$room_id', 'pending', '$check_in', '$check_out', '$room_price', NOW())";

        if (!mysqli_query($conn, $insert_sql)) {
            echo "Error: " . mysqli_error($conn);
        }
    }

    echo "Booking successful!";
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-6">
            <!-- Carousel for Room Images -->
            <img src="./uploads/<?php echo $images[0] ?>" alt="" style="width: 100%; height: 412px">
        </div>
        <div class="col-6">
            <div class="row">
                <?php
                // Skip the first image and show the rest
                foreach (array_slice($images, 1) as $image) {
                    echo '<div class="col-6 p-1">';
                    echo '<img src="./uploads/' . $image . '" style="width: 100%; height: 200px" alt="Room Image">';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Room Description -->
        <div class="col-lg-7">
            <div class="room-description mt-4">
                <h3><?php echo htmlspecialchars($room_name); ?></h3>
                <p class="room-details"><?php echo htmlspecialchars($room_type); ?></p>
                <p class="room-details"><?php echo htmlspecialchars($room_description); ?></p>

                <div class="text-h6">Amenities</div>
                <p class="room-details mt-2"><?php echo htmlspecialchars($room_amenities); ?></p>
            </div>
        </div>

        <!-- Right Column - Reservation Section -->
        <div class="col-lg-5">
            <form method="POST" action="">
                <div class="border p-3 rounded shadow-sm">
                    <h4 class="price">₱<?php echo number_format($room_price, 2); ?> / night</h4>
                    <div class="row">
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="checkIn" class="form-label">Check-in</label>
                            <input type="date" class="form-control" id="checkIn" name="check_in" required>
                        </div>
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="checkOut" class="form-label">Check-out</label>
                            <input type="date" class="form-control" id="checkOut" name="check_out" required>
                        </div>
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="guests" class="form-label">Guests</label>
                            <select class="form-select" id="guests">
                                <option value="1">1 guest</option>
                                <option value="2">2 guests</option>
                                <option value="3">3 guests</option>
                                <option value="4">4 guests</option>
                            </select>
                        </div>
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="number_of_rooms" class="form-label">No. of Rooms</label>
                            <select class="form-select" id="number_of_rooms" name="number_of_rooms" required>
                                <?php
                                // Generate room options based on available rooms
                                for ($i = 1; $i <= $available_rooms; $i++) {
                                    echo "<option value='$i'>$i room" . ($i > 1 ? 's' : '') . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn reserve-btn w-100">Reserve</button>
                </div>
            </form>
        </div>
    </div>
</div>
