<?php
include 'config.php'; // Database connection
include 'navbar.php'; // Navigation bar

// Assume a logged-in user (replace with actual session-based logic)
$user_id = 1; // Replace with the logged-in user's ID

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch user bookings
$bookings_query = "SELECT b.id, r.name AS room_name, b.check_in, b.check_out, b.status, b.total_price 
                   FROM bookings b 
                   JOIN rooms r ON b.room_id = r.id 
                   WHERE b.user_id = $user_id";
$bookings_result = mysqli_query($conn, $bookings_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Profile Page</title>
</head>
<body>
<div class="container my-5">
    <div class="row">
        <!-- User Details Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My Profile</h5>
                    <?php echo ($user); ?>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user']['first_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAccountModal">Edit Account</button>
                </div>
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
                                    <th>#</th>
                                    <th>Room</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Status</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                                    <tr>
                                        <td><?php echo $booking['id']; ?></td>
                                        <td><?php echo htmlspecialchars($booking['room_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['check_in']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['check_out']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['status']); ?></td>
                                        <td>₱<?php echo number_format($booking['total_price'], 2); ?></td>
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

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="update_account.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAccountModalLabel">Edit Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
