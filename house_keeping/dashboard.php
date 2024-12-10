<?php
session_start();
include '../config.php'; // Database connection

// Initialize filters
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch rooms with filters and search
$rooms_query = "SELECT * FROM rooms WHERE 1=1";
if (!empty($status_filter)) {
    $rooms_query .= " AND status = '" . mysqli_real_escape_string($conn, $status_filter) . "'";
}
if (!empty($type_filter)) {
    $rooms_query .= " AND room_type = '" . mysqli_real_escape_string($conn, $type_filter) . "'";
}
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $rooms_query .= " AND (name LIKE '%$search%' OR room_number LIKE '%$search%')";
}
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
    <style>
        .filter-form select,
        .filter-form input {
            margin-right: 10px;
        }

        .status-badge.vacant {
            background-color: #28a745 !important;
        }

        .status-badge.occupied {
            background-color: #ffc107 !important;
        }

        .status-badge.not-available {
            background-color: #6c757d !important;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Housekeeping Dashboard</h1>
        <a class="btn btn-danger mb-3" href="?logout=true">Logout</a>

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

        <!-- Filters -->
        <form class="filter-form mb-4 d-flex justify-content-between" method="GET">
            <div>
                <select name="status" class="form-select" style="width: 200px; display: inline-block;">
                    <option value="">All Status</option>
                    <option value="vacant" <?php echo $status_filter == 'vacant' ? 'selected' : ''; ?>>Vacant</option>
                    <option value="occupied" <?php echo $status_filter == 'occupied' ? 'selected' : ''; ?>>Occupied</option>
                    <option value="not available" <?php echo $status_filter == 'not available' ? 'selected' : ''; ?>>Not Available</option>
                </select>

                <select name="type" class="form-select" style="width: 200px; display: inline-block;">
                    <option value="">All Room Types</option>
                    <option value="single" <?php echo $type_filter == 'single' ? 'selected' : ''; ?>>Single</option>
                    <option value="double" <?php echo $type_filter == 'double' ? 'selected' : ''; ?>>Double</option>
                    <option value="suite" <?php echo $type_filter == 'suite' ? 'selected' : ''; ?>>Suite</option>
                </select>
            </div>
            <div>
                <input type="text" name="search" class="form-control" placeholder="Search by name or room number" value="<?php echo htmlspecialchars($search); ?>" style="width: 300px; display: inline-block;">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- Rooms Table -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Room Number</th>
                    <th>Room Name</th>
                    <th>Room Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($room = mysqli_fetch_assoc($rooms_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($room['room_number']); ?></td>
                        <td><?php echo htmlspecialchars($room['name']); ?></td>
                        <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                        <td>
                            <span class="badge status-badge <?php echo str_replace(' ', '-', $room['status']); ?>">
                                <?php echo htmlspecialchars($room['status']); ?>
                            </span>
                        </td>
                        <td>
                            <!-- Buttons for Updating Room Status -->
                            <?php if ($room['status'] !== 'vacant'): ?>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                                    <button type="submit" name="status" value="vacant" class="btn btn-success btn-sm">Mark Vacant</button>
                                </form>
                            <?php endif; ?>
                            <!-- <?php if ($room['status'] !== 'not available'): ?>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                                    <button type="submit" name="status" value="not available" class="btn btn-secondary btn-sm">Mark Not Available</button>
                                </form>
                            <?php endif; ?>
                            <?php if ($room['status'] !== 'occupied'): ?>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                                    <button type="submit" name="status" value="occupied" class="btn btn-warning btn-sm">Mark Occupied</button>
                                </form>
                            <?php endif; ?> -->
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
