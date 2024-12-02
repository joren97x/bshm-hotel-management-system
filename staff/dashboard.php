<?php
session_start();
include '../config.php';

// Check if user is logged in and is a staff member
if (!isset($_SESSION['usermail']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'staff') {
    header("Location: ../index.php");
    exit();
}

// Function to get the total number of confirmed bookings
function getConfirmedBookings($conn) {
    $sql = "SELECT COUNT(*) as total FROM roombook WHERE stat = 'Confirm'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

$confirmed_bookings = getConfirmedBookings($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Staff Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Confirmed Bookings</h5>
                        <p class="card-text display-4"><?php echo $confirmed_bookings; ?></p>
                    </div>
                </div>
            </div>
            <!-- Add more dashboard widgets here -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

