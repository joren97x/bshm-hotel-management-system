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
    <title>Staff Dashboard - Hotel Reservation System</title>
    <link rel="stylesheet" href="../admin/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <nav class="uppernav">
        <div class="logo">
            <img class="CPCLOGO" src="../image/hm.jpg" alt="logo">
            <p>CPC HOTELS</p>
        </div>
        <div class="logout">
            <a href="../logout.php"><button class="btn btn-danger">Logout</button></a>
        </div>
    </nav>
    <nav class="sidenav">
        <ul>
            <li class="pagebtn active"><img src="../image/icon/dashboard.png" alt="Dashboard">&nbsp;&nbsp;&nbsp;Dashboard</li>
            <li class="pagebtn"><img src="../image/icon/bed.png" alt="Pending">&nbsp;&nbsp;&nbsp;Pending</li>
            <li class="pagebtn"><img src="../image/icon/wallet.png" alt="Booking">&nbsp;&nbsp;&nbsp;Booking</li>
            <li class="pagebtn"><img src="../image/icon/bedroom.png" alt="Reservation">&nbsp;&nbsp;&nbsp;Reservation</li>
            <li class="pagebtn"><img src="../image/icon/staff.png" alt="Cashier">&nbsp;&nbsp;&nbsp;Cashier</li>
        </ul>
    </nav>

    <div class="mainscreen">
        <iframe class="frames frame1 active" src="dashboard.php" frameborder="0"></iframe>
        <iframe class="frames frame2" src="pending.php" frameborder="0"></iframe>
        <iframe class="frames frame3" src="booking.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="reservation.php" frameborder="0"></iframe>
        <iframe class="frames frame5" src="cashier.php" frameborder="0"></iframe>
    </div>

    <script src="../admin/javascript/script.js"></script>
</body>
</html>

