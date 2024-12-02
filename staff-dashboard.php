<?php
session_start();
include '../config.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['usermail']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'admin') {
   header("Location: ../index.php");
   exit();
}

// Fetch recent bookings
$bookings_sql = "SELECT * FROM roombook ORDER BY id DESC LIMIT 10";
$bookings_result = mysqli_query($conn, $bookings_sql);

// Fetch rooms data
$rooms_sql = "SELECT * FROM room ORDER BY id";
$rooms_result = mysqli_query($conn, $rooms_sql);

// Handle room status updates
if (isset($_POST['update_room_status'])) {
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['room_condition']);
    
    $update_sql = "UPDATE room SET room_condition = '$new_status' WHERE id = '$room_id'";
    if (mysqli_query($conn, $update_sql)) {
        logRoomStatusChange($conn, $room_id, $new_status, $_SESSION['usermail']);
        echo "<script>alert('Room status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating room status: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - CPC Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        .status-clean { color: #198754; }
        .status-dirty { color: #dc3545; }
        .status-process { color: #ffc107; }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Staff Dashboard</h2>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="front-desk-tab" data-bs-toggle="tab" data-bs-target="#front-desk" type="button" role="tab" aria-controls="front-desk" aria-selected="true">Front Desk</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="housekeeping-tab" data-bs-toggle="tab" data-bs-target="#housekeeping" type="button" role="tab" aria-controls="housekeeping" aria-selected="false">Housekeeping</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="front-desk" role="tabpanel" aria-labelledby="front-desk-tab">
                <h3 class="mt-4">Recent Bookings</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Room Type</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = mysqli_fetch_assoc($bookings_result)) : ?>
                            <tr>
                                <td><?php echo $booking['id']; ?></td>
                                <td><?php echo htmlspecialchars($booking['Name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['RoomType']); ?></td>
                                <td><?php echo $booking['cin']; ?></td>
                                <td><?php echo $booking['cout']; ?></td>
                                <td><?php echo htmlspecialchars($booking['stat']); ?></td>
                                <td>
                                    <a href="roombookedit.php?id=<?php echo $booking['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <?php if ($booking['stat'] == 'NotConfirm') : ?>
                                        <a href="roomconfirm.php?id=<?php echo $booking['id']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="housekeeping" role="tabpanel" aria-labelledby="housekeeping-tab">
                <h3 class="mt-4">Room Status</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Condition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($room = mysqli_fetch_assoc($rooms_result)) : ?>
                            <tr>
                                <td><?php echo $room['id']; ?></td>
                                <td><?php echo htmlspecialchars($room['type']); ?></td>
                                <td><?php echo htmlspecialchars($room['status']); ?></td>
                                <td class="<?php echo 'status-' . strtolower($room['room_condition']); ?>"><?php echo htmlspecialchars($room['room_condition']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $room['id']; ?>">
                                        Update
                                    </button>
                                </td>
                            </tr>

                            <!-- Update Modal for each room -->
                            <div class="modal fade" id="updateModal<?php echo $room['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?php echo $room['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel<?php echo $room['id']; ?>">Update Room <?php echo $room['id']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="room_condition" class="form-label">Room Condition:</label>
                                                    <select name="room_condition" class="form-select" required>
                                                        <option value="Clean" <?php echo $room['room_condition'] == 'Clean' ? 'selected' : ''; ?>>Clean</option>
                                                        <option value="Dirty" <?php echo $room['room_condition'] == 'Dirty' ? 'selected' : ''; ?>>Dirty</option>
                                                        <option value="In Process" <?php echo $room['room_condition'] == 'In Process' ? 'selected' : ''; ?>>In Process</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="update_room_status">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>