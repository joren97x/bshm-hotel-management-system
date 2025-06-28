<?php
include './sidebar.php';
include '../config.php'; // Include database connection

// Handle search input
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Base query
$query = "
    SELECT bookings.*, 
           IF(users.id IS NULL, bookings.name, CONCAT(users.first_name, ' ', users.last_name)) AS user_name, 
           rooms.name AS room_name, rooms.room_type, rooms.room_number
    FROM bookings
    LEFT JOIN users ON bookings.user_id = users.id
    JOIN rooms ON bookings.room_id = rooms.id
    WHERE bookings.status = 'pending'
";

// Add search filter if a search term is provided
if (!empty($searchTerm)) {
    $query .= " AND (
        CONCAT(users.first_name, ' ', users.last_name) LIKE '%" . mysqli_real_escape_string($conn, $searchTerm) . "%' OR
        bookings.name LIKE '%" . mysqli_real_escape_string($conn, $searchTerm) . "%' OR
        rooms.room_number LIKE '%" . mysqli_real_escape_string($conn, $searchTerm) . "%'
    )";
}

// Append sorting order
$query .= " ORDER BY bookings.created_at DESC";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Pending Bookings</h2>
        
        <!-- Search Form -->
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Name or Room Number" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Room Type</th>
                    <th>Guests</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['room_number']); ?></td>
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
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_type']); ?></td>
                        <td>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewDetailsModal" onclick="viewBooking(<?php echo $row['id']; ?>)">View</button>
                            <button class="btn btn-success approve-btn" data-id="<?php echo $row['id']; ?>">Approve</button>
                            <button class="btn btn-danger cancel-btn" data-id="<?php echo $row['id']; ?>">Cancel</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Booking Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <span id="statusAction"></span> this booking?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmStatusChange">Yes, change status</button>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
    // Variables to track the booking id and action
    let bookingId = null;
    let action = '';

    // Handle Approve button click
    $(document).on('click', '.approve-btn', function() {
        bookingId = $(this).data('id');
        action = 'approve';
        $('#statusAction').text('approve');
        $('#statusModal').modal('show');
    });

    // Handle Cancel button click
    $(document).on('click', '.cancel-btn', function() {
        bookingId = $(this).data('id');
        action = 'cancel';
        $('#statusAction').text('cancel');
        $('#statusModal').modal('show');
    });

    // Confirm the status change (approve or cancel)
    $('#confirmStatusChange').click(function() {
        // Send AJAX request to update the booking status
        $.ajax({
            url: 'update_status.php',
            method: 'POST',
            data: {
                booking_id: bookingId,
                action: action
            },
            success: function(response) {
                if (response === 'success') {
                    // Close the modal
                    $('#statusModal').modal('hide');
                    // Reload the page to show updated status
                    location.reload();
                } else {
                    alert('Failed to update booking status. Please try again.');
                }
            }
        });
    });
</script>