<?php
include '../config.php';
include './sidebar.php';

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
    $roomCounts[] = $row; // Store room type and count as associative array
}

// Fetch the total users
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
    $userCountsByRole[] = $row; // Store role and user count
}

// Fetch the total facilities
$facilityQuery = "SELECT COUNT(*) AS total_facilities FROM facilities";
$facilityResult = mysqli_query($conn, $facilityQuery);
$totalFacility = mysqli_fetch_assoc($facilityResult)['total_facilities'];

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
    $bookingStatusCounts[] = $row; // Store booking status and count
}
?>

<div>
    <!-- Total Rooms by Type -->
    <section>
        <h3>Total Rooms by Type</h3>
        <table>
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Total Rooms</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roomCounts as $room): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                        <td><?php echo htmlspecialchars($room['total_rooms']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Users by Role -->
    <section>
        <h3>Users by Role</h3>
        <table>
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Total Users</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userCountsByRole as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['total_users']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Total Facilities -->
    <section>
        <h3>Total Facilities</h3>
        <p><strong><?php echo htmlspecialchars($totalFacility); ?></strong> facilities available.</p>
    </section>

    <!-- Bookings by Status -->
    <section>
        <h3>Bookings by Status</h3>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total Bookings</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingStatusCounts as $status): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($status['status']); ?></td>
                        <td><?php echo htmlspecialchars($status['total_bookings']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
