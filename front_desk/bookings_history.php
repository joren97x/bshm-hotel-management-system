<?php
include './sidebar.php';
include '../config.php'; // Include database connection

// Initialize search and filter variables
$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Build the base query
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
    WHERE bookings.status IN ('complete', 'cancelled')
";

// Add search filter
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " AND (bookings.name LIKE '%$search%' OR CONCAT(users.first_name, ' ', users.last_name) LIKE '%$search%')";
}

// Add status filter
if (!empty($statusFilter)) {
    $statusFilter = mysqli_real_escape_string($conn, $statusFilter);
    $query .= " AND bookings.status = '$statusFilter'";
}

$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<body>
    <div class="container mt-5">
        <h2 class="mb-4"> Booking History</h2>

        <!-- Filters and Search -->
        <form method="GET" class="d-flex align-items-center mb-3">
            <select name="status" class="form-select me-2" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="complete" <?php echo $statusFilter === 'complete' ? 'selected' : ''; ?>>Complete</option>
                <option value="cancelled" <?php echo $statusFilter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
            <input type="text" name="search" class="form-control me-2" placeholder="Search by name or code">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Booking Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Room Type</th>
                    <th>Guests</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Paid At</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                            echo $check_in->format('D, M j, Y \a\t g A');
                            ?>
                        </td>
                        <td>
                            <?php
                            $check_out = new DateTime($row['check_out']);
                            echo $check_out->format('D, M j, Y');
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['paid_at']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewDetailsModal" onclick="showModal(<?php echo $row['id']; ?>)">View</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
    function showModal(bookingId) {
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
</script>

</body>
