<?php

include './sidebar.php';
include '../config.php';
// Create user
if (isset($_POST['create'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (first_name, last_name, email, password, role) VALUES ('$first_name', 'last_name', '$email', '$password', '$role')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "User created successfully!";
    } else {
        $_SESSION['error'] = "Error creating user.";
    }
}

// Update user
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', role='$role' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "User updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating user.";
    }
}

// Delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "User deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting user.";
    }
}

// Fetch users
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>
  <div class="container mt-5">
    <h2>User Management</h2>
    
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

    <!-- Add User Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal">Add New User</button>

    <!-- User Table -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['first_name']; ?></td>
            <td><?= $row['last_name']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= ucfirst($row['role']); ?></td>
            <td>
              <a href="javascript:void(0);" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" onclick="editUser(<?= $row['id']; ?>)">Edit</a>
              <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal for Add/Edit User -->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST">
            <input type="hidden" name="id" id="userId">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="name" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="name" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select class="form-control" name="role" id="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="front_desk">Front Desk</option>
                <option value="house_keeping">House Keeping</option>
              </select>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Create User</button>
            <button type="submit" name="update" class="btn btn-success">Update User</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Edit User Functionality
    function editUser(id) {
      fetch('get_user.php?id=' + id)
        .then(response => response.json())
        .then(data => {
          document.getElementById('userId').value = data.id;
          document.getElementById('name').value = data.name;
          document.getElementById('email').value = data.email;
          document.getElementById('role').value = data.role;
          document.querySelector('button[name="create"]').style.display = 'none';
          document.querySelector('button[name="update"]').style.display = 'inline-block';
          document.querySelector('.modal-title').textContent = 'Edit User';
        });
    }
  </script>
