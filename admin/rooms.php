<?php
include '../config.php';
include './sidebar.php';
// Check if user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Create room
if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $amenities = $_POST['amenities'];
    $description = $_POST['description'];
    $no_of_rooms = $_POST['no_of_rooms'];
    $status = 'vacant';

    // Image upload handling
    $images = [];
    if (isset($_FILES['images']) && count($_FILES['images']['name']) == 5) {
        for ($i = 0; $i < 5; $i++) {
            $imageName = time() . '_' . $_FILES['images']['name'][$i];
            $imagePath = '../uploads/' . $imageName;
            move_uploaded_file($_FILES['images']['tmp_name'][$i], $imagePath);
            $images[] = $imagePath;
        }
    } else {
        $_SESSION['error'] = "You must upload exactly 5 images.";
        header("Location: rooms.php");
        exit;
    }

    // Save the image paths (separated by commas)
    $imagePaths = implode(',', $images);

    // Get the last room number from the database
    $lastRoomNumber = 3000; // Default start number
    $result = mysqli_query($conn, "SELECT room_number FROM rooms ORDER BY id DESC LIMIT 1");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastRoomNumber += (int)$row['room_number']; // Get the last room number
    }

    // Create rooms based on the number of rooms specified
    for ($i = 1; $i <= $no_of_rooms; $i++) {
        $newRoomNumber = $lastRoomNumber + $i; // Increment room number

        // Insert into the database
        $sql = "INSERT INTO rooms (room_number, name, room_type, price, capacity, amenities, description, images, status) 
                VALUES ('$newRoomNumber', '$name', '$room_type', '$price', '$capacity', '$amenities', '$description', '$imagePaths', '$status')";
        
        if (!mysqli_query($conn, $sql)) {
            $_SESSION['error'] = "Error creating room: " . mysqli_error($conn);
            header("Location: rooms.php");
            exit;
        }
    }

    $_SESSION['success'] = "$no_of_rooms room(s) created successfully!";
    header("Location: rooms.php");
    exit;
}


// Update room
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $amenities = $_POST['amenities'];
    $description = $_POST['description'];

    // Handle image update
    $image = $_POST['existing_image']; // Keep the old image if no new one is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imagePath = 'uploads/' . time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $image = $imagePath;
    }

    $sql = "UPDATE rooms SET name='$name', room_type='$room_type', price='$price', capacity='$capacity', 
            amenities='$amenities', description='$description', image='$image' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Room updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating room.";
    }
}

// Delete room
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM rooms WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Room deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting room.";
    }
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$room_type_filter = isset($_GET['room_type']) ? mysqli_real_escape_string($conn, $_GET['room_type']) : '';

// Build the query with search and filter
$sql = "SELECT * FROM rooms WHERE 1=1";
if (!empty($search)) {
    $sql .= " AND (name LIKE '%$search%' OR room_number LIKE '%$search%' OR room_type LIKE '%$search%')";
}
if (!empty($room_type_filter)) {
    $sql .= " AND room_type = '$room_type_filter'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Room Management</h2>

        <!-- Success or error messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Add Room Button -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#roomModal">Add New Room</button>

        <!-- Room Table -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by Name, Number, or Type" value="<?= htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-4">
                <select name="room_type" class="form-select">
                    <option value="">All Room Types</option>
                    <option value="Deluxe" <?= $room_type_filter === 'Deluxe' ? 'selected' : ''; ?>>Deluxe</option>
                    <option value="Standard" <?= $room_type_filter === 'Standard' ? 'selected' : ''; ?>>Standard</option>
                    <option value="Suite" <?= $room_type_filter === 'Suite' ? 'selected' : ''; ?>>Suite</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="rooms.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Room Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Price</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <?php
                                $images = explode(',', $row['images']);
                                echo "<img src='$images[0]' width='100' alt='Room Image' class='me-2'>";
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['room_number']); ?></td>
                            <td><?= htmlspecialchars($row['room_type']); ?></td>
                            <td>₱<?= number_format($row['price'], 2); ?></td>
                            <td><?= htmlspecialchars($row['capacity']); ?></td>
                            <td>
                                <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No rooms found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Add/Edit Room -->
    <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomModalLabel">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="roomId">
                        <input type="hidden" name="existing_image" id="existing_image">
                        <div class="mb-3">
                            <label for="name" class="form-label">Room Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="room_type" class="form-label">Room Type</label>
                            <select class="form-control" name="room_type" id="room_type" required>
                                <option value="Superior">Superior</option>
                                <option value="Deluxe">Deluxe</option>
                                <option value="Standard">Standard</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="price" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" name="capacity" id="capacity" required>
                        </div>
                        <div class="mb-3">
                            <label for="amenities" class="form-label">Amenities</label>
                            <textarea class="form-control" name="amenities" id="amenities" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Room Images (Exactly 5 images)</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Number of Rooms</label>
                            <input type="number" class="form-control" name="no_of_rooms" id="no_of_rooms" required>
                        </div>
                        
                        <button type="submit" name="create" class="btn btn-primary">Create Room</button>
                        <!-- <button type="submit" name="update" class="btn btn-success">Update Room</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function editRoom(id) {
            // Get the room details and populate the modal
            fetch(`get_room.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('roomId').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('room_type').value = data.room_type;
                    document.getElementById('price').value = data.price;
                    document.getElementById('capacity').value = data.capacity;
                    document.getElementById('amenities').value = data.amenities;
                    document.getElementById('description').value = data.description;
                    document.getElementById('existing_image').value = data.image;
                    document.getElementById('existing_image').src = data.image;
                    document.querySelector('button[name="create"]').style.display = 'none';
                    document.querySelector('button[name="update"]').style.display = 'inline-block';
                });
        }
    </script>
</body>

</html>