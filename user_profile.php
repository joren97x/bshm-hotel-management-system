<?php
session_start();
include 'config.php';

// Ensure user is logged in
// if (!isset($_SESSION['usermail']) || empty($_SESSION['usermail'])) {
//     header("Location: index.php");
//     exit();
// }

// $usermail = $_SESSION['usermail'];

// Fetch user details
// $user_sql = "SELECT * FROM signup WHERE Email='$usermail'";
// $user_result = mysqli_query($conn, $user_sql);
// if (!$user_result) {
//     die("Query Failed: " . mysqli_error($conn));
// }
// $user_data = mysqli_fetch_assoc($user_result);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    
    $update_sql = "UPDATE signup SET Username='$new_username'";
    if (!empty($new_password)) {
        $update_sql .= ", Password='$new_password'";
    }
    $update_sql .= " WHERE Email='$usermail'";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Profile updated successfully!');</script>";
        $user_data['Username'] = $new_username; // Update the username in the local array
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}

// Fetch user's bookings
$bookings_sql = "SELECT * FROM roombook WHERE Email='$usermail' ORDER BY id DESC";
$bookings_result = mysqli_query($conn, $bookings_sql);
if (!$bookings_result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - CPC Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333333;
        }
        .form-label {
            font-weight: bold;
        }
        .table thead {
            background-color: #007bff;
            color: #ffffff;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
    <a href="home.php" class="btn btn-secondary text-center">Back to Home</a>
        <h1 class="mb-4 text-center">User Profile</h1>
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-3">Profile Information</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="new_username" value="<?php echo $user_data['Username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $user_data['Email']; ?>" readonly>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
