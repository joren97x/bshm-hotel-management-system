<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect to login or home page
    header("Location: ../login.php");
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Sidebar</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
    }
    #sidebar {
      min-width: 250px;
      max-width: 250px;
      background-color: #343a40;
      color: #fff;
      height: 100vh;
    }
    #sidebar .nav-link {
      color: #fff;
    }
    #sidebar .nav-link:hover {
      background-color: #495057;
    }
    #content {
      flex-grow: 1;
      padding: 20px;
    }
    .sidebar-logo {
      max-width: 200px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div id="sidebar" class="d-flex flex-column p-3">
    <!-- Logo -->
    <img src="../image/hm.jpg" alt="Logo" class="sidebar-logo mx-auto d-block">
    <h4 class="text-center py-3 border-bottom">Admin Panel</h4>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="./dashboard.php">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./user_management.php">User Management</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./rooms.php">Rooms (CRUD)</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./generate_report.php">Generate Report</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?logout=true">Logout</a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <!-- <div id="content">
    <h1>Welcome to the Admin Panel</h1>
    <p>Choose an option from the sidebar to get started.</p>
  </div> -->

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
