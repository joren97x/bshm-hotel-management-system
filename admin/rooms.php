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

    // Image upload handling
    // Image upload handling (create room)
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
        header("Location: room_management.php");
        exit;
    }

    // Save the image paths (separated by commas)
    $imagePaths = implode(',', $images);

    // Insert into the database (create room)
    $sql = "INSERT INTO rooms (name, room_type, price, capacity, amenities, description, images) 
            VALUES ('$name', '$room_type', '$price', '$capacity', '$amenities', '$description', '$imagePaths')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Room created successfully!";
    } else {
        $_SESSION['error'] = "Error creating room.";
    }

    // $sql = "INSERT INTO rooms (name, room_type, price, capacity, amenities, description, image) 
    //         VALUES ('$name', '$room_type', '$price', '$capacity', '$amenities', '$description', '$image')";
    // if (mysqli_query($conn, $sql)) {
    //     $_SESSION['success'] = "Room created successfully!";
    // } else {
    //     $_SESSION['error'] = "Error creating room.";
    // }
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

// Fetch rooms
$sql = "SELECT * FROM rooms";
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
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php elseif (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <!-- Add Room Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#roomModal">Add New Room</button>

    <!-- Room Table -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Room Type</th>
          <th>Price</th>
          <th>Capacity</th>
          <th>Amenities</th>
          <th>Description</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['room_type']; ?></td>
            <td><?= $row['price']; ?></td>
            <td><?= $row['capacity']; ?></td>
            <td><?= $row['amenities']; ?></td>
            <td><?= $row['description']; ?></td>
            <td>
                <?php 
                    $images = explode(',', $row['images']);
                    echo "<img src='$images[0]' width='100' alt='Room Image' class='me-2'>";
                ?>
                </td>
            <td>
              <a href="javascript:void(0);" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#roomModal" onclick="editRoom(<?= $row['id']; ?>)">Edit</a>
              <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
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
                <option value="Deluxe">Deluxe</option>
                <option value="Standard">Standard</option>
                <option value="Suite">Suite</option>
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
            <button type="submit" name="create" class="btn btn-primary">Create Room</button>
            <button type="submit" name="update" class="btn btn-success">Update Room</button>
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

