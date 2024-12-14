    <?php
    include 'config.php';
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
        $capacity = $row['capacity'];
        $images = explode(',', $row['images']); // Assuming images are stored as a comma-separated string
    } else {
        echo "Room not found.";
        exit;
    }

    $missing_data = [];

    if (isset($_SESSION['user'])) {

        $user_id = $_SESSION['user']['id']; // Replace with actual user session ID

        // Fetch user details
        $user_query = "SELECT * FROM users WHERE id = $user_id";
        $user_result = mysqli_query($conn, $user_query);
        $user = mysqli_fetch_assoc($user_result);

        // Check if any required field is null
        if (is_null($user['birthdate'])) $missing_data[] = 'birthdate';
        if (is_null($user['gender'])) $missing_data[] = 'gender';
        if (is_null($user['address'])) $missing_data[] = 'address';
        if (is_null($user['phone_number'])) $missing_data[] = 'phone_number';

        $missing_data_json = json_encode($missing_data); // Pass missing fields to JavaScript

    }

    // Query to count available rooms of the same type
    $available_sql = "SELECT COUNT(*) AS available_count FROM rooms WHERE room_type = '" . mysqli_real_escape_string($conn, $row['room_type']) . "' AND status = 'vacant'";
    $available_result = mysqli_query($conn, $available_sql);
    $available_data = mysqli_fetch_assoc($available_result);
    $available_rooms = (int)$available_data['available_count']; // Number of available rooms


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($missing_data)) {
        if (!isset($_SESSION['user'])) {
            echo "<script>window.location.href = 'login.php';</script>";
            exit;
        }

        $user_id = $_SESSION['user']['id']; // Logged-in user ID
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];
        $number_of_rooms = (int)$_POST['number_of_rooms'];
        $guests = $_POST['guests'];
        $booking_type = 'book';

        // Validate dates
        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);
        $days = $check_in_date->diff($check_out_date)->days;

        if ($days <= 0) {
            echo "Check-out date must be after check-in date.";
            exit;
        }

        // Calculate total price
        $total_price = $days * $number_of_rooms * $room_price;

        // Fetch the total count of available rooms for the given dates and room type
        $available_rooms_count_sql = "
            SELECT COUNT(r.id) AS available_count
            FROM rooms r
            WHERE r.room_type = '" . mysqli_real_escape_string($conn, $row['room_type']) . "' 
            AND r.id NOT IN (
                SELECT b.room_id 
                FROM bookings b
                WHERE ('$check_in' < b.check_out AND '$check_out' > b.check_in)
                AND b.status NOT IN ('cancelled', 'complete', 'checked_out')
            )";

        $available_rooms_count_result = mysqli_query($conn, $available_rooms_count_sql);
        $available_rooms_count_data = mysqli_fetch_assoc($available_rooms_count_result);
        $available_count = (int)$available_rooms_count_data['available_count'];

        if ($number_of_rooms > $available_count) {
            // SweetAlert Error Modal
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient Rooms Available',
                    text: 'You requested $number_of_rooms room(s), but only $available_count room(s) are available.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.back();
                });
            </script>";
            exit;
        }

        // Fetch available rooms excluding those with active bookings
        $available_rooms_sql = "
            SELECT r.id 
            FROM rooms r
            WHERE r.room_type = '" . mysqli_real_escape_string($conn, $row['room_type']) . "' 
            AND r.id NOT IN (
                SELECT b.room_id 
                FROM bookings b
                WHERE ('$check_in' < b.check_out AND '$check_out' > b.check_in)
                AND b.status NOT IN ('cancelled', 'complete', 'checked_out')
            )
            LIMIT $number_of_rooms";

        $available_rooms_result = mysqli_query($conn, $available_rooms_sql);

        if (!$available_rooms_result) {
            die("Error fetching available rooms: " . mysqli_error($conn));
        }

        $booked_rooms = [];
        while ($room = mysqli_fetch_assoc($available_rooms_result)) {
            $room_id = $room['id'];

            // Insert booking for each room
            $insert_sql = "
                INSERT INTO bookings (user_id, room_id, guests, status, check_in, check_out, total_price, booking_type, created_at) 
                VALUES ('$user_id', '$room_id', '$guests', 'pending', '$check_in', '$check_out', '$total_price', '$booking_type', NOW())";

            if (mysqli_query($conn, $insert_sql)) {
                $booked_rooms[] = $room_id; // Keep track of successfully booked rooms
            } else {
                echo "Error inserting booking for room $room_id: " . mysqli_error($conn);
            }
        }

        if (count($booked_rooms) > 0) {
            echo "<script>window.location.href = 'profile.php';</script>";
            exit;
        } else {
            echo "No rooms were booked.";
        }
    }




    ?>
    <link rel="stylesheet" href="./admin/css/roombook.css">
    <script>
        // Show modal if there are missing user details
        document.addEventListener("DOMContentLoaded", function() {
            const missingData = <?php echo $missing_data_json; ?>;
            if (missingData.length > 0) {
                const modal = new bootstrap.Modal(document.getElementById("userDetailsModal"));
                modal.show();
            }
        });
    </script>
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
                                <input type="datetime-local" class="form-control" id="checkIn" name="check_in" required>
                                <input type="hidden" id="roomType" value="<?php echo $room_type; ?>">
                            </div>
                            <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label for="checkOut" class="form-label">Check-out</label>
                                <input type="date" class="form-control" id="checkOut" name="check_out" required>
                            </div>
                            <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label for="guests" class="form-label">Guests</label>
                                <select class="form-select" id="guests" name="guests">
                                    <?php 
                                    for ($i = 1; $i <= $capacity; $i++): 
                                    ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $i . ($i === 1 ? ' guest' : ' guests'); ?>
                                        </option>
                                    <?php 
                                    endfor; 
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label for="number_of_rooms" class="form-label">No. of Rooms</label>
                                <select class="form-select" id="number_of_rooms" name="number_of_rooms" required>
                                    <?php
                                    // Check if there are any available rooms
                                    if ($available_rooms > 0) {
                                        // Generate room options based on available rooms
                                        for ($i = 1; $i <= $available_rooms; $i++) {
                                            echo "<option value='$i'>$i room" . ($i > 1 ? 's' : '') . "</option>";
                                        }
                                    } else {
                                        // Display a message when no rooms are available
                                        echo "<option value='' disabled selected>No rooms available</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button class="btn reserve-btn w-100 btn-primary" type="submit">Book</button>
                    </div>
                </form>
                <div id="availableRooms" class="mt-3"></div>

                <script>
                    document.getElementById('checkOut').addEventListener('change', function() {
                        const checkIn = document.getElementById('checkIn').value;
                        const roomType = document.getElementById('roomType').value;
                        const checkOut = this.value;
                        console.log('hi')
                        if (checkIn && checkOut) {
                            fetch('check_availability.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: new URLSearchParams({
                                        check_in: checkIn,
                                        check_out: checkOut,
                                        room_type: roomType
                                    })
                                })
                                .then(response => response.json())
                                .then(rooms => {
                                    const availableRoomsDiv = document.getElementById('availableRooms');
                                    availableRoomsDiv.innerHTML = '';

                                    if (rooms.length > 0) {
                                        let roomList = '<h5>Available Rooms:</h5><ul>';
                                        rooms.forEach(room => {
                                            roomList += `<li>${room.room_number} - ${room.name}</li>`;
                                        });
                                        roomList += '</ul>';
                                        availableRoomsDiv.innerHTML = roomList;
                                    } else {
                                        availableRoomsDiv.innerHTML = '<p>No rooms available for the selected dates.</p>';
                                    }
                                })
                                .catch(error => console.error('Error fetching rooms:', error));
                        }
                    });
                </script>


            </div>
        </div>
    </div>


<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateUserDetailsForm" method="POST" action="update_user.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel">Complete Your Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($_SESSION['errors'])) {
                        echo '<div class="alert alert-danger">';
                        foreach ($_SESSION['errors'] as $error) {
                            echo "<p>$error</p>";
                        }
                        echo '</div>';
                        unset($_SESSION['errors']); // Clear errors after displaying
                    }

                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">';
                        echo $_SESSION['success'];
                        echo '</div>';
                        unset($_SESSION['success']); // Clear success message after displaying
                    }

                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">';
                        echo $_SESSION['error'];
                        echo '</div>';
                        unset($_SESSION['error']); // Clear error message after displaying
                    }
                    ?>
                    <p>Please fill in the missing details to proceed:</p>
                    <?php if (in_array('birthdate', $missing_data)): ?>
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('gender', $missing_data)): ?>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('address', $missing_data)): ?>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('phone_number', $missing_data)): ?>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <!-- Include the room ID in a hidden input -->
                    <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                    <button type="submit" class="btn btn-primary">Save Details</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include './footer.php'; ?>