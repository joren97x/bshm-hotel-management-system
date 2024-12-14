<?php
include './sidebar.php';
include '../config.php'; // Database connection

// Fetch the total facilities
$facilityQuery = "SELECT COUNT(*) AS total_facilities FROM facilities";
$facilityResult = mysqli_query($conn, $facilityQuery);
$totalFacility = mysqli_fetch_assoc($facilityResult)['total_facilities'];


// Fetch the total users
$userQuery = "SELECT COUNT(*) AS total_users FROM users";
$userResult = mysqli_query($conn, $userQuery);
$totalUsers = mysqli_fetch_assoc($userResult)['total_users'];


// Fetch the total rooms by type
$roomQuery = "
    SELECT 
        room_type, 
        COUNT(*) AS total_rooms 
    FROM rooms 
    GROUP BY room_type
";

$roomResult = mysqli_query($conn, $roomQuery);
$roomCounts = [];
while ($row = mysqli_fetch_assoc($roomResult)) {
    $roomCounts[$row['room_type']] = $row['total_rooms'];
}

$userQuery = "
    SELECT 
        role, 
        COUNT(*) AS total_users 
    FROM users 
    GROUP BY role
";

$userResult = mysqli_query($conn, $userQuery);
$userCountsByRole = [];
while ($row = mysqli_fetch_assoc($userResult)) {
    $userCountsByRole[$row['role']] = $row['total_users']; // Store role and user count
}

// Fetch bookings grouped by status
$bookingStatusQuery = "
    SELECT 
        status, 
        COUNT(*) AS total_bookings 
    FROM bookings 
    GROUP BY status
";

$bookingStatusResult = mysqli_query($conn, $bookingStatusQuery);
$bookingStatusCounts = [];
while ($row = mysqli_fetch_assoc($bookingStatusResult)) {
    $bookingStatusCounts[$row['status']] = $row['total_bookings'];
}

// Fetch sales for completed bookings
$salesQuery = "
    SELECT 
        SUM(total_price) AS total_sales,
        DATE_FORMAT(created_at, '%Y-%u') AS week,
        DATE_FORMAT(created_at, '%Y-%m') AS month,
        DATE_FORMAT(created_at, '%Y') AS year
    FROM bookings 
    WHERE status = 'complete'
    GROUP BY week, month, year
";

$salesResult = mysqli_query($conn, $salesQuery);
$salesData = ['weekly' => [], 'monthly' => [], 'yearly' => []];
while ($row = mysqli_fetch_assoc($salesResult)) {
    $salesData['weekly'][$row['week']] = $row['total_sales'];
    $salesData['monthly'][$row['month']] = $row['total_sales'];
    $salesData['yearly'][$row['year']] = $row['total_sales'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
<h1 class="text-center mb-4">Admin Dashboard</h1>

<div class="row mb-5">
    <!-- Total Users -->
    <div class="col-2">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Users</h5>
                <h3><?php echo $totalUsers; ?></h3>
            </div>
        </div>
    </div>

    <!-- Total Rooms -->
    <div class="col-2">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Rooms</h5>
                <h3>
                    <?php 
                        echo array_sum($roomCounts); // Sum of all rooms
                    ?>
                </h3>
            </div>
        </div>
    </div>

    <!-- Total Bookings -->
    <div class="col-2">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5>Total Bookings</h5>
                <h3>
                    <?php 
                        echo array_sum($bookingStatusCounts); // Sum of all bookings
                    ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-2">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5>Total Facilities</h5>
                <h3>
                    <?php 
                        echo $totalFacility; // Sum of all bookings
                    ?>
                </h3>
            </div>
        </div>
    </div>

    <!-- Total Sales -->
    <div class="col-2">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5>Total Sales</h5>
                <h3>
                    <?php 
                        $totalSales = array_sum($salesData['yearly']);
                        echo number_format($totalSales, 2); // Format to 2 decimal places
                    ?>
                </h3>
            </div>
        </div>
    </div>
</div>

    <!-- First Row: Rooms and Bookings -->
    <div class="row">
    <!-- <div class="row mb-5">
        <div class="col-md-12">
            <h4 class="text-center">User Statistics</h4>
            <canvas id="userRoleChart"></canvas>
        </div>
    </div> -->
    <div class="col-md-4">
    <h4 class="text-center">User Statistics</h4>
    <canvas id="userRoleChart" style="height: 300px; max-height: 300px"></canvas>
        </div>
        <div class="col-md-4">
            <h4 class="text-center">Room Statistics</h4>
            <canvas id="roomChart"  style="height: 300px; max-height: 300px"></canvas>
        </div>
        <div class="col-md-4">
            <h4 class="text-center">Booking Status</h4>
            <canvas id="bookingStatusChart"></canvas>
        </div>
    </div>

    <!-- Second Row: Sales Charts -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="text-center">Sales Statistics</h4>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Weekly Sales</h5>
            <canvas id="weeklySalesChart"></canvas>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Monthly Sales</h5>
            <canvas id="monthlySalesChart"></canvas>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Yearly Sales</h5>
            <canvas id="yearlySalesChart"></canvas>
        </div>
    </div>
</div>

<script>
    const userRoleData = {
        labels: <?php echo json_encode(array_keys($userCountsByRole)); ?>,
        datasets: [{
            label: 'Total Users by Role',
            data: <?php echo json_encode(array_values($userCountsByRole)); ?>,
            backgroundColor: ['#4caf50', '#2196f3', '#ff9800', '#9c27b0', '#e91e63'], // Customize colors
            hoverOffset: 4
        }]
    };

    // Render User Statistics Chart
    new Chart(document.getElementById('userRoleChart'), {
        type: 'doughnut', // Doughnut chart for user roles
        data: userRoleData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'User Distribution by Role'
                }
            }
        }
    });
    // Room Statistics Data
    const roomData = {
        labels: <?php echo json_encode(array_keys($roomCounts)); ?>,
        datasets: [{
            label: 'Total Rooms',
            data: <?php echo json_encode(array_values($roomCounts)); ?>,
            backgroundColor: ['#4caf50', '#2196f3', '#ff9800', '#9c27b0'], // Colors
            hoverOffset: 4
        }]
    };

    // Booking Status Data
    const bookingStatusData = {
        labels: <?php echo json_encode(array_keys($bookingStatusCounts)); ?>,
        datasets: [{
            label: 'Total Bookings',
            data: <?php echo json_encode(array_values($bookingStatusCounts)); ?>,
            backgroundColor: ['#ff5722', '#03a9f4', '#8bc34a', '#ff9800'], // Colors
        }]
    };

    // Weekly Sales Data
    const weeklySalesData = {
        labels: <?php echo json_encode(array_keys($salesData['weekly'])); ?>,
        datasets: [{
            label: 'Weekly Sales',
            data: <?php echo json_encode(array_values($salesData['weekly'])); ?>,
            borderColor: '#673ab7',
            backgroundColor: 'rgba(103, 58, 183, 0.2)',
            borderWidth: 2,
            fill: true
        }]
    };

    // Monthly Sales Data
    const monthlySalesData = {
        labels: <?php echo json_encode(array_keys($salesData['monthly'])); ?>,
        datasets: [{
            label: 'Monthly Sales',
            data: <?php echo json_encode(array_values($salesData['monthly'])); ?>,
            borderColor: '#ffeb3b',
            backgroundColor: 'rgba(255, 235, 59, 0.2)',
            borderWidth: 2,
            fill: true
        }]
    };

    // Yearly Sales Data
    const yearlySalesData = {
        labels: <?php echo json_encode(array_keys($salesData['yearly'])); ?>,
        datasets: [{
            label: 'Yearly Sales',
            data: <?php echo json_encode(array_values($salesData['yearly'])); ?>,
            backgroundColor: '#e91e63',
            hoverBackgroundColor: '#f06292',
            borderWidth: 1
        }]
    };

    // Initialize Charts
    new Chart(document.getElementById('roomChart'), {
        type: 'pie',
        data: roomData
    });

    new Chart(document.getElementById('bookingStatusChart'), {
        type: 'bar',
        data: bookingStatusData,
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('weeklySalesChart'), {
        type: 'line',
        data: weeklySalesData
    });

    new Chart(document.getElementById('monthlySalesChart'), {
        type: 'line',
        data: monthlySalesData
    });

    new Chart(document.getElementById('yearlySalesChart'), {
        type: 'bar',
        data: yearlySalesData
    });
</script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
