<?php
include 'config.php';
include 'navbar.php';

$user_id = $_SESSION['user']['id']; // Replace with the logged-in user's ID

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $birthdate = trim($_POST['birthdate']);
    $address = trim($_POST['address']);
    $gender = trim($_POST['gender']);

    $update_query = "UPDATE users SET 
    first_name = '$first_name', 
    last_name = '$last_name', 
    phone_number = '$phone_number', 
    birthdate = '$birthdate', 
    address = '$address', 
    gender = '$gender', 
    email = '$email' WHERE id = $user_id";
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Profile updated successfully!";
        $_SESSION['user']['first_name'] = $first_name;
        $_SESSION['user']['last_name'] = $last_name;
        $_SESSION['user']['email'] = $email;
    } else {
        $_SESSION['error'] = "Error updating profile: " . mysqli_error($conn);
    }

    echo "<script>window.location.href = 'edit_profile.php';</script>";
    exit;
}

// Handle Password Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Password fields cannot be empty!";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_query = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
        if (mysqli_query($conn, $password_query)) {
            $_SESSION['success'] = "Password updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating password: " . mysqli_error($conn);
        }
    }

    echo "<script>window.location.href = 'edit_profile.php';</script>";
    exit;
}

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
?>

<div class="container my-5">
    <h1>Edit Profile</h1>


    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>


    <form method="POST">
        <input type="hidden" name="update_profile" value="1">
        <div class="row">
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
            
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label for="gender" class="form-label">Gender</label>
                <!-- <input class="form-control" id="gender" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" required> -->
                <select class="form-select" id="gender" name="gender" required value="<?php echo htmlspecialchars($user['gender']); ?>">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>


    <div class="col-md-6 mt-5">
        <form method="POST">
            <input type="hidden" name="update_password" value="1">
            <h4>Change Password</h4>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-warning">Change Password</button>
        </form>
    </div>

</div>
