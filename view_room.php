<?php
include 'config.php';
// session_start();
include 'navbar.php';

// Get room ID from URL (e.g., /view_room.php?id=1)
$room_id = isset($_GET['id']) ? $_GET['id'] : 0;

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
    $images = explode(',', $row['images']); // Assuming images are stored as comma-separated string
} else {
    echo "Room not found.";
    exit;
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-6">
            <!-- Carousel for Room Images -->
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $isActive = true; // First image should be active
                    foreach ($images as $image) {
                        echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                        echo '<img src="./uploads/' . $image . '" style="width: 100%" alt="Room Image">';
                        echo '</div>';
                        $isActive = false;
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <?php
                // Show additional images in a grid
                foreach ($images as $image) {
                    echo '<div class="col-6">';
                    echo '<img src="./uploads/' . $image . '" style="width: 100%" alt="Room Image">';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Room Description -->
        <div class="col-lg-8">
            <div class="room-description mt-4">
                <h3><?php echo htmlspecialchars($room_name); ?></h3>
                <p class="room-details"><?php echo htmlspecialchars($room_type); ?></p>
                <p class="room-details"><?php echo htmlspecialchars($room_description); ?></p>

                <div class="text-h6">Amenities</div>
                <p class="room-details mt-2"><?php echo htmlspecialchars($room_amenities); ?></p>
            </div>
        </div>

        <!-- Right Column - Reservation Section -->
        <div class="col-lg-4">
            <div class="border p-3 rounded shadow-sm">
                <h4 class="price">₱<?php echo number_format($room_price, 2); ?> / night</h4>
                <div class="mb-3">
                    <label for="checkIn" class="form-label">Check-in</label>
                    <input type="date" class="form-control" id="checkIn" value="2024-12-07">
                </div>
                <div class="mb-3">
                    <label for="checkOut" class="form-label">Check-out</label>
                    <input type="date" class="form-control" id="checkOut" value="2024-12-12">
                </div>
                <div class="mb-3">
                    <label for="guests" class="form-label">Guests</label>
                    <select class="form-select" id="guests">
                        <option value="1">1 guest</option>
                        <option value="2">2 guests</option>
                        <option value="3">3 guests</option>
                        <option value="4">4 guests</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="guests" class="form-label">No. of Rooms</label>
                    <select class="form-select" id="guests">
                        <option value="1">1 room</option>
                        <option value="2">2 rooms</option>
                        <option value="3">3 rooms</option>
                        <option value="4">4 rooms</option>
                    </select>
                </div>
                <button class="btn reserve-btn w-100">Reserve</button>
            </div>
        </div>
    </div>
</div>
