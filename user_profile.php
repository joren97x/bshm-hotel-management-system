<?php
include 'config.php';
include 'navbar.php';

?>

    <div class="container mt-5">
    <a href="home.php" class="btn btn-secondary text-center">Back to Home</a>
        <h1 class="mb-4 text-center">User Profile</h1>
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-3">Profile Information</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="new_username" value="<?php echo $_SESSION['user']['first_name'] .  $_SESSION['user']['last_name'] ; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $_SESSION['user']['umail']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password (optional)</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Leave blank to keep current">
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary w-100">Update Profile</button>
                </form>
            </div>
            <div class="col-md-6">
                <h2 class="mb-3">Your Bookings</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Room Type</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($bookings_result) > 0): ?>
                                <?php while ($booking = mysqli_fetch_assoc($bookings_result)) : ?>
                                    <tr>
                                        <td><?php echo $booking['id']; ?></td>
                                        <td><?php echo $booking['RoomType']; ?></td>
                                        <td><?php echo $booking['cin']; ?></td>
                                        <td><?php echo $booking['cout']; ?></td>
                                        <td><?php echo $booking['stat']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No bookings found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
    </div>
