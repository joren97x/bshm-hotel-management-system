<?php
include '../config.php';
include './sidebar.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $delete_sql = "DELETE FROM facilities WHERE id = $id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Facility deleted successfully'); window.location.href = 'facilities.php';</script>";
    } else {
        echo "<script>alert('Error deleting facility');</script>";
    }
}

// Handle Add or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $photo = $_FILES['photo']['name'] ?? null;

    // Handle file upload if provided
    if ($photo) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    }

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update facility
        $id = (int)$_POST['id'];
        $update_sql = "UPDATE facilities SET 
                       name = '$name', 
                       description = '$description'";
        if ($photo) {
            $update_sql .= ", photo = '$photo'";
        }
        $update_sql .= " WHERE id = $id";
        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Facility updated successfully'); window.location.href = 'facilities.php';</script>";
        } else {
            echo "<script>alert('Error updating facility');</script>";
        }
    } else {
        // Add new facility
        $insert_sql = "INSERT INTO facilities (name, photo, description) VALUES ('$name', '$photo', '$description')";
        if (mysqli_query($conn, $insert_sql)) {
            echo "<script>alert('Facility added successfully'); window.location.href = 'facilities.php';</script>";
        } else {
            echo "<script>alert('Error adding facility');</script>";
        }
    }
}

// Fetch all facilities
$facilities = mysqli_query($conn, "SELECT * FROM facilities");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Facilities Management</h1>
    
    <!-- Button to open Add Facility Modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#facilityModal">Add New Facility</button>
    
    <!-- Facilities Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($facility = mysqli_fetch_assoc($facilities)): ?>
                <tr>
                    <td><?php echo $facility['id']; ?></td>
                    <td><img src="../uploads/<?php echo $facility['photo']; ?>" alt="Facility Photo" style="width: 100px; height: 100px; object-fit: cover;"></td>
                    <td><?php echo htmlspecialchars($facility['name']); ?></td>
                    <td><?php echo htmlspecialchars($facility['description']); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#facilityModal"
                                onclick="editFacility(<?php echo htmlspecialchars(json_encode($facility)); ?>)">Edit</button>
                        <a href="facilities.php?delete=<?php echo $facility['id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this facility?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Facility Modal -->
<div class="modal fade" id="facilityModal" tabindex="-1" aria-labelledby="facilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="facilityModalLabel">Add/Edit Facility</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="facilityId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="facilityName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="facilityDescription" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="facilityPhoto" name="photo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function editFacility(facility) {
        document.getElementById('facilityId').value = facility.id;
        document.getElementById('facilityName').value = facility.name;
        document.getElementById('facilityDescription').value = facility.description;
        document.getElementById('facilityPhoto').value = ''; // Photo upload must be re-selected
    }
</script>
</body>
</html>
