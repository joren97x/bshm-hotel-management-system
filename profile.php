<?php
include 'config.php';
include 'navbar.php';

$user_id = $_SESSION['user']['id']; // Replace with the logged-in user's ID

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch user bookings
$bookings_query = "SELECT b.id, b.code, r.name, r.room_type, r.room_number AS room_name, b.check_in, b.check_out, b.status, b.total_price 
                   FROM bookings b 
                   JOIN rooms r ON b.room_id = r.id 
                   WHERE b.user_id = $user_id";
$bookings_result = mysqli_query($conn, $bookings_query);
?>


    <title>My Profile</title>
    <style>
        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-card {
            text-align: center;
            padding: 20px;
        }

        .profile-card h5 {
            margin-top: 10px;
        }

        .table-striped th,
        .table-striped td {
            vertical-align: middle;
        }

        .modal-body {
            background-color: #f8f9fa;
        }
    </style>
<div class="container my-5">
    <div class="row">
        <!-- User Details Section -->
        <div class="col-md-4">
            <div class="card profile-card">
                <!-- <img src="./uploads/default-user.png" alt="User Avatar" class="rounded-circle" width="150"> -->
                <h5><?php echo htmlspecialchars($_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']); ?></h5>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>

        <!-- Bookings Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My Bookings</h5>
                    <?php if (mysqli_num_rows($bookings_result) > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['room_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['status']); ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#bookingModal" 
                                                    onclick="viewBooking(<?php echo htmlspecialchars(json_encode($booking)); ?>)">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>You have no bookings yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Details Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Room Number:</strong> <span id="roomNumber"></span></p>
                <p><strong>Room Type:</strong> <span id="roomType"></span></p>
                <p><strong>Check-In:</strong> <span id="checkIn"></span></p>
                <p><strong>Check-Out:</strong> <span id="checkOut"></span></p>
                <p><strong>Status:</strong> <span id="status"></span></p>
                <p><strong>Booking Code:</strong> <span id="bookingCode"></span></p>
                <p><strong>Total Price:</strong> ₱<span id="totalPrice"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Format date to a more readable format
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' }; // Customize the format here
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', options);
    }

    // Populate modal with booking details
    function viewBooking(booking) {
        document.getElementById('roomNumber').textContent = booking.room_name;
        document.getElementById('roomType').textContent = booking.room_type;
        document.getElementById('checkIn').textContent = formatDate(booking.check_in);
        document.getElementById('checkOut').textContent = formatDate(booking.check_out);
        document.getElementById('status').textContent = booking.status;
        document.getElementById('bookingCode').textContent = booking.code;
        document.getElementById('totalPrice').textContent = booking.total_price;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
