<?php
include './sidebar.php';
include '../config.php'; // Database connection

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

// Fetch the total users
$userQuery = "SELECT COUNT(*) AS total_users FROM users";
$userResult = mysqli_query($conn, $userQuery);
$totalUsers = mysqli_fetch_assoc($userResult)['total_users'];

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
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard</h2>
        
        <!-- Room Statistics Chart -->
        <canvas id="roomChart"></canvas>
        
        <!-- Booking Status Chart -->
        <canvas id="bookingStatusChart" class="mt-5"></canvas>
        
        <!-- Sales Charts -->
        <h4 class="mt-5">Sales Statistics</h4>
        <canvas id="weeklySalesChart"></canvas>
        <canvas id="monthlySalesChart" class="mt-5"></canvas>
        <canvas id="yearlySalesChart" class="mt-5"></canvas>
    </div>

    <script>
        // Room Statistics Data
        const roomData = {
            labels: <?php echo json_encode(array_keys($roomCounts)); ?>,
            datasets: [{
                label: 'Total Rooms',
                data: <?php echo json_encode(array_values($roomCounts)); ?>,
                backgroundColor: ['#4caf50', '#2196f3', '#ff9800'], // Customize colors
            }]
        };

        // Booking Status Data
        const bookingStatusData = {
            labels: <?php echo json_encode(array_keys($bookingStatusCounts)); ?>,
            datasets: [{
                label: 'Total Bookings',
                data: <?php echo json_encode(array_values($bookingStatusCounts)); ?>,
                backgroundColor: ['#ff5722', '#03a9f4', '#8bc34a'], // Customize colors
            }]
        };

        // Weekly Sales Data
        const weeklySalesData = {
            labels: <?php echo json_encode(array_keys($salesData['weekly'])); ?>,
            datasets: [{
                label: 'Weekly Sales',
                data: <?php echo json_encode(array_values($salesData['weekly'])); ?>,
                backgroundColor: '#673ab7', // Purple
            }]
        };

        // Monthly Sales Data
        const monthlySalesData = {
            labels: <?php echo json_encode(array_keys($salesData['monthly'])); ?>,
            datasets: [{
                label: 'Monthly Sales',
                data: <?php echo json_encode(array_values($salesData['monthly'])); ?>,
                backgroundColor: '#ffeb3b', // Yellow
            }]
        };

        // Yearly Sales Data
        const yearlySalesData = {
            labels: <?php echo json_encode(array_keys($salesData['yearly'])); ?>,
            datasets: [{
                label: 'Yearly Sales',
                data: <?php echo json_encode(array_values($salesData['yearly'])); ?>,
                backgroundColor: '#e91e63', // Pink
            }]
        };

        // Initialize Charts
        new Chart(document.getElementById('roomChart'), {
            type: 'pie',
            data: roomData
        });

        new Chart(document.getElementById('bookingStatusChart'), {
            type: 'bar',
            data: bookingStatusData
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
</body>
</html>
