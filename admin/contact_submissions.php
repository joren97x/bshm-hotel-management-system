<?php
include '../config.php'; // Database connection
include './sidebar.php'; // Sidebar for admin navigation

// Fetch all contact submissions
$query = "SELECT * FROM contact_submissions ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Submissions</title>
    <style>
        .container {
            padding: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.8rem;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Contact Submissions</h2>
    <p>Below is a list of all messages submitted through the contact form:</p>

    <!-- Check if there are any submissions -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through each submission -->
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($row['created_at']))); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No contact submissions found.</p>
    <?php endif; ?>

</div>

</body>
</html>
