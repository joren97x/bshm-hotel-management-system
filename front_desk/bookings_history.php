<?php 
include './sidebar.php';
include '../config.php'; // Include database connection

$query = "
    SELECT bookings.*, users.first_name, users.last_name, rooms.name AS room_name, rooms.room_type, rooms.room_number
    FROM bookings
    JOIN users ON bookings.user_id = users.id
    JOIN rooms ON bookings.room_id = rooms.id
    WHERE bookings.status = 'complete'
    ORDER BY bookings.created_at DESC
";

$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>
<body>
    <div class="container mt-5">
        <h2 class="mb-4"> Booking History</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Room Type</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Paid At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['room_number']; ?></td>
                        <td><?php echo htmlspecialchars($row['room_type']); ?></td> <!-- User name -->
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo htmlspecialchars($row['check_out']); ?></td>
                        <td><?php echo htmlspecialchars($row['paid_at']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
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

<script>
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
