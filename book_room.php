<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usermail'])) {
    header("Location: index.php");
    exit();
}

$usermail = $_SESSION['usermail'];

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $room_sql = "SELECT * FROM room WHERE id = $room_id";
    $room_result = mysqli_query($conn, $room_sql);
    $room = mysqli_fetch_assoc($room_result);
} else {
    header("Location: home.php");
    exit();
}

if (isset($_POST['book_room'])) {
    $cin = $_POST['cin'];
    $cout = $_POST['cout'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];

    $sql = "INSERT INTO roombook (Email, RoomType, Bed, NoofRoom, Meal, cin, cout, nodays, stat) 
            VALUES ('$usermail', '{$room['type']}', '{$room['bedding']}', 1, 'Room only', '$cin', '$cout', DATEDIFF('$cout', '$cin'), 'NotConfirm')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Booking request submitted successfully!');</script>";
        header("Location: user_profile.php");
        exit();
    } else {
        echo "<script>alert('Error submitting booking request.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - CPC Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Book Room</h1>
        <div class="row">
            <div class="col-md-6">
                <h2><?php echo $room['type']; ?></h2>
                <p>Bed Type: <?php echo $room['bedding']; ?></p>
                <p>Price: $<?php echo number_format($room['price'], 2); ?> per night</p>
            </div>
            <div class="col-md-6">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="cin" class="form-label">Check-in Date</label>
                        <input type="date" class="form-control" id="cin" name="cin" required>
                    </div>
                    <div class="mb-3">
                        <label for="cout" class="form-label">Check-out Date</label>
                        <input type="date" class="form-control" id="cout" name="cout" required>
                    </div>
                    <div class="mb-3">
                        <label for="adults" class="form-label">Number of Adults</label>
                        <input type="number" class="form-control" id="adults" name="adults" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="children" class="form-label">Number of Children</label>
                        <input type="number" class="form-control" id="children" name="children" min="0" required>
                    </div>
                    <button type="submit" name="book_room" class="btn btn-primary">Book Now</button>
                </form>
            </div>
        </div>
        <a href="home.php" class="btn btn-secondary mt-3">Back to Home</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

