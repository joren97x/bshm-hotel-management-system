<?php
include './sidebar.php';
include '../config.php'; // Include database connection

// Check if a search term is provided
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Build the query
$query = "
    SELECT 
        bookings.*, 
        IF(users.id IS NULL OR bookings.user_id = 0, 'Manual Booking', CONCAT(users.first_name, ' ', users.last_name)) AS full_name,
        rooms.name AS room_name, 
        rooms.room_type, 
        rooms.room_number
    FROM bookings
    LEFT JOIN users ON bookings.user_id = users.id
    JOIN rooms ON bookings.room_id = rooms.id
    WHERE bookings.status IN ('approved', 'checked_in', 'checked_out')
";

// Add search condition if a search term is provided
if (!empty($searchTerm)) {
    $query .= " AND (CONCAT(users.first_name, ' ', users.last_name) LIKE ? 
                  OR rooms.name LIKE ? 
                  OR bookings.code LIKE ?)";
}

$query .= " ORDER BY bookings.created_at DESC";

// Prepare and execute the query
$stmt = mysqli_prepare($conn, $query);

// If a search term is provided, bind the parameters
if (!empty($searchTerm)) {
    $searchTermWithWildcards = "%" . $searchTerm . "%";
    mysqli_stmt_bind_param($stmt, 'sss', $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards);
}

// Execute the query
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Approved Bookings</h2>

        <!-- Search Form -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Name, Room, or Code" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Table with results -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Actions</th> <!-- Added Actions column for buttons -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['room_number']; ?></td>
                        <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo htmlspecialchars($row['check_out']); ?></td>
                        <td><?php echo htmlspecialchars($row['code']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <!-- Check-in Button -->
                            <?php if ($row['status'] == 'approved'): ?>
                                <button type="button" class="btn btn-success"
                                    data-bs-toggle="modal" data-bs-target="#actionModal"
                                    onclick="showModal(<?php echo $row['id']; ?>, 'check_in')">Check In</button>
                            <?php elseif ($row['status'] == 'checked_in'): ?>
                                <!-- Check-out Button (Only if Checked In) -->
                                <button type="button" class="btn btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#actionModal"
                                    onclick="showModal(<?php echo $row['id']; ?>, 'check_out')">
                                    
                                    Check Out</button>
                            <?php elseif ($row['status'] == 'checked_out'): ?>
                                <!-- Check-out Button (Only if Checked In) -->
                                <button type="button" class="btn btn-info"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#paymentModal"
                                    onclick="showPaymentModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                    Payment
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="paymentDetails">
                        <!-- Receipt details will be populated here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- Form to handle payment -->
                    <form id="paymentForm" method="POST" action="mark_booking_complete.php">
                        <input type="hidden" name="booking_id" id="bookingId">
                        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="actionForm" method="POST" action="update_bookings_status.php">
                        <input type="hidden" name="booking_id" id="booking_id">
                        <input type="hidden" name="action" id="action">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    // JavaScript to handle the modal and form submission
    function showModal(booking_id, action) {
        // Set the action and booking ID dynamically
        document.getElementById('booking_id').value = booking_id;
        document.getElementById('action').value = action;
        console.log(document.getElementById('booking_id').value)
        console.log(booking_id)
        // Change the modal message based on the action
        const message = action === 'check_in' ? "Are you sure you want to check in this booking?" :
            "Are you sure you want to check out this booking?";
        document.getElementById('modalMessage').textContent = message;
    }

    function showPaymentModal(booking) {
        // Calculate total price
        const checkInDate = new Date(booking.check_in);
        const checkOutDate = new Date(booking.check_out);
        const days = (checkOutDate - checkInDate) / (1000 * 60 * 60 * 24);
        const totalPrice = booking.total_price;

        // Format the modal content
        const paymentDetails = `
            <h5>Booking Code: ${booking.code}</h5>
            <p><strong>Name:</strong> ${booking.full_name}</p>
            <p><strong>Room Number:</strong> ${booking.room_number}</p>
            <p><strong>Room Type:</strong> ${booking.room_type}</p>
            <p><strong>Check-in:</strong> ${booking.check_in}</p>
            <p><strong>Check-out:</strong> ${booking.check_out}</p>
            <hr>
            <p><strong>Total Price:</strong> ₱${totalPrice}</p>
        `;

        // Inject content into modal
        document.getElementById('paymentDetails').innerHTML = paymentDetails;

        // Optionally, add booking_id to a hidden input for form submission
        document.getElementById('bookingId').value = booking.id;
    }
</script>