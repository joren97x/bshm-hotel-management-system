<?php
include './sidebar.php';
include '../config.php'; // Include database connection

// Check if a search term is provided
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Build the query
$query = "
    SELECT 
        bookings.*, 
        IF(users.id IS NULL OR bookings.user_id = 0, bookings.name, CONCAT(users.first_name, ' ', users.last_name)) AS full_name,
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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking'])) {
    $booking_id = (int)$_POST['booking_id_hidden'];  // Accessing the hidden input value

    // Update the booking status to 'cancelled'
    $cancel_booking_sql = "UPDATE bookings SET status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($cancel_booking_sql);
    $stmt->bind_param('i', $booking_id);

    echo $booking_id;  // Echoing booking ID to check in console
    echo $_POST['booking_id_hidden'];  // Check if POST data matches the expected ID
    echo 'hii';
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Booking cancelled successfully.';
        header('Location: approved_bookings.php');
        exit();
    } else {
        $_SESSION['errors'][] = 'Failed to cancel the booking.';
    }
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
                    <th>Guests</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Actions</th> <!-- Added Actions column for buttons -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['room_number']; ?></td>
                        <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['guests']); ?></td>
                        <td>
                            <?php
                            $check_in = new DateTime($row['check_in']);
                            echo $check_in->format('D, M j, Y \a\t g A'); // e.g., "Wed, Dec 2, 2024 at 5 PM"
                            ?>
                        </td>
                        <td>
                            <?php
                            $check_out = new DateTime($row['check_out']);
                            echo $check_out->format('D, M j, Y'); // e.g., "Thu, Dec 3, 2024 at 10 AM"
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['code']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_type']); ?></td>
                        <td>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewDetailsModal" onclick="viewBooking(<?php echo $row['id']; ?>)">View</button>
                            <?php
                            $today = date('Y-m-d');
                            $checkInDate = substr($row['check_in'], 0, 10); // Extract date portion (YYYY-MM-DD)
                            // Show the Check-in button only if the status is 'approved' and the check-in date is today or in the future
                            if ($row['status'] == 'approved' && $checkInDate == $today):
                            ?>
                                <button type="button" class="btn btn-success"
                                    data-bs-toggle="modal" data-bs-target="#actionModal"
                                    onclick="showModal(<?php echo $row['id']; ?>, 'check_in')">Check In</button>
                            <?php elseif ($checkInDate < $today): ?>
                                <!-- Cancel Booking Button (Only if Checked In) -->
                                <button type="button" class="btn btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#cancelModal"
                                    onclick="showCancelModal(<?php echo $row['id']; ?>, 'cancel')">Cancel</button>
                            <?php elseif ($row['status'] == 'checked_in'): ?>
                                <!-- Check-out Button (Only if Checked In) -->
                                <button type="button" class="btn btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#actionModal"
                                    onclick="showModal(<?php echo $row['id']; ?>, 'check_out')">Check Out</button>
                            <?php elseif ($row['status'] == 'checked_out'): ?>
                                <!-- Payment Button -->
                                <button type="button" class="btn btn-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#paymentModal"
                                    onclick="showPaymentModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">Payment</button>
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

<!-- Modal for Cancel Booking -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this booking?</p>
                <input type="hidden" name="booking_id" id="booking_id">
                <div id="booking_id_display"></div> <!-- This is to display the booking ID for confirmation purposes -->
            </div>
            <div class="modal-footer">
                <form method="POST" action="cancel_booking.php">
                    <input type="hidden" name="booking_id_hidden" id="booking_id_hidden">
                    <button type="submit" name="cancel_booking" class="btn btn-danger">Cancel Booking</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>


<!-- Modal for displaying booking details -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailsModalLabel">Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loader -->
                <div id="modal-loader" class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                
                <!-- Booking details -->
                <div id="modal-details" style="display: none;">
                    <div class="row mb-2">
                        <div class="col-6"><strong>Name:</strong></div>
                        <div class="col-6" id="modal-name">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Email:</strong></div>
                        <div class="col-6" id="modal-email">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Contact:</strong></div>
                        <div class="col-6" id="modal-contact">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Address:</strong></div>
                        <div class="col-6" id="modal-address">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Check-In:</strong></div>
                        <div class="col-6" id="modal-check-in">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Check-Out:</strong></div>
                        <div class="col-6" id="modal-check-out">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Total Price:</strong></div>
                        <div class="col-6" id="modal-total-price">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Guests:</strong></div>
                        <div class="col-6" id="modal-guests">N/A</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Booking Code:</strong></div>
                        <div class="col-6" id="modal-code">N/A</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>Booking Type:</strong></div>
                        <div class="col-6" id="modal-booking-type">N/A</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function viewBooking(bookingId) {
        // Show loader
        document.getElementById('modal-loader').style.display = 'block';
        document.getElementById('modal-details').style.display = 'none';

        // Fetch booking details
        fetch(`get_booking_details.php?id=${bookingId}`)
            .then(response => response.json())
            .then(data => {
                // Populate modal fields
                document.getElementById('modal-name').textContent = data.full_name || 'N/A';
                document.getElementById('modal-email').textContent = data.email || 'N/A';
                document.getElementById('modal-contact').textContent = data.contact || 'N/A';
                document.getElementById('modal-address').textContent = data.address || 'N/A';
                document.getElementById('modal-check-in').textContent = new Date(data.check_in).toLocaleString() || 'N/A';
                document.getElementById('modal-check-out').textContent = new Date(data.check_out).toLocaleString() || 'N/A';
                document.getElementById('modal-total-price').textContent = `$${data.total_price || '0.00'}`;
                document.getElementById('modal-guests').textContent = data.guests || 'N/A';
                document.getElementById('modal-code').textContent = data.code || 'N/A';
                document.getElementById('modal-booking-type').textContent = data.booking_type || 'N/A';

                // Hide loader and show details
                document.getElementById('modal-loader').style.display = 'none';
                document.getElementById('modal-details').style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching booking details:', error);
                alert('Failed to load booking details. Please try again later.');
                document.getElementById('modal-loader').style.display = 'none';
            });
    }
    function showCancelModal(bookingId) {
        document.getElementById('booking_id_hidden').value = bookingId;
        document.getElementById('booking_id_display').textContent = `Booking ID: ${bookingId}`;
    }
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