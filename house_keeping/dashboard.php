<?php
session_start();
include '../config.php'; // Database connection

// Fetch all rooms
$rooms_query = "SELECT * FROM rooms";
$rooms_result = mysqli_query($conn, $rooms_query);

// Handle status update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['room_id'], $_POST['status'])) {
    $room_id = (int)$_POST['room_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $update_query = "UPDATE rooms SET status = '$status' WHERE id = $room_id";
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Room status updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating room status: " . mysqli_error($conn);
    }

    header("Location: ./dashboard.php");
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Housekeeping Dashboard</title>
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Housekeeping Dashboard</h1>
    <a class="nav-link" href="?logout=true">Logout</a>
    <!-- Display Success or Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
            ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Rooms Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Room Name</th>
                <th>Room Type</th>
                <th>Status</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($room = mysqli_fetch_assoc($rooms_result)): ?>
                <tr>
                    <td><?php echo $room['room_number']; ?></td>
                    <td><?php echo htmlspecialchars($room['name']); ?></td>
                    <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                    <td>
                        <?php 
                if($room['status'] == 'vacant') {
                    echo 'clean';
                }
                elseif($room['status'] == 'not available') {
                    echo 'dirty';
                }
                else {
                    echo 'in proccess';
                }

?>
                    </td>
                    <td>
                        <span class="badge bg-<?php echo $room['status'] === 'vacant' ? 'success' : ($room['status'] === 'occupied' ? 'warning' : 'secondary'); ?>">
                            <?php echo htmlspecialchars($room['status']); ?>
                        </span>
                    </td>
                    <td>
                        <!-- Buttons for Updating Room Status -->
                       <?php if($room['status'] == 'not available') {?>
                       <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                            <button type="submit" name="status" value="vacant" class="btn btn-success btn-sm">Vacant</button>
                        </form>

                       <?php } ?>
                        <!-- <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                            <button type="submit" name="status" value="not available" class="btn btn-secondary btn-sm">Not Available</button>
                        </form> -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
