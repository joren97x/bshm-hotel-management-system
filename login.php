<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- aos animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- loading bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="./css/flash.css">
    <title>CPC HOTELS</title>
</head>
<style>
    
</style>

<body>
    <!-- Carousel Section -->
    <section id="carouselExampleControls" class="carousel slide carousel_section" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="carousel-image" src="./image/hotel1.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="./image/hotel2.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="./image/hotel3.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="./image/hotel4.jpg">
            </div>
        </div>
    </section>
    <!-- Authentication Section -->
    <section id="auth_section">
        <div class="logo">
            <img class="HMLOGO" src="./image/hm.jpg" alt="logo">
            <p>CPC HOTELS</p>
        </div>
        <div class="auth_container">
            <!-- Log In -->
            <div id="Log_in">
                <h2>Log In</h2>
                <!-- <div class="role_btn">
                    <div class="btns active">User</div>
                    <div class="btns">Staff</div>
                    <div class="btns">Admin</div>
                </div> -->
                <!-- User Login -->
                <?php
if (isset($_POST['user_login_submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Debug the form inputs
    var_dump($email, $password);

    // Use prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE LOWER(email) = LOWER(?)");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            // header("Location: home.php");

            // Check user role and redirect accordingly
            if ($user['role'] === 'admin') {
                header("Location: ./admin/room.php");
            } elseif ($user['role'] === 'house_keeping') {
                header("Location: ./house_keeping/dashboard.php");
            } elseif ($user['role'] === 'front_desk') {
                header("Location: ./front_desk/dashboard.php");
            } elseif ($user['role'] === 'user') {
                header("Location: user_dashboard.php");
            } else {
                echo "<script>swal({ title: 'Unknown role', icon: 'error' });</script>";
            }

            exit;
        } else {
            echo "<script>swal({ title: 'Invalid password', icon: 'error' });</script>";
        }
    } else {
        echo "<script>swal({ title: 'User not found', icon: 'error' });</script>";
    }

    $stmt->close();
}
?>

                <form class="user_login authsection active" id="userlogin" action="login.php" method="POST">
                    <!-- <div class="form-floating">
                        <input type="text" class="form-control" name="Username" placeholder=" ">
                        <label for="Username">Username</label>
                    </div> -->
                    <div class="form-floating">
                        <input type="email" class="form-control" name="email" placeholder=" ">
                        <label for="Email">Email</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" name="password" placeholder=" ">
                        <label for="Password">Password</label>
                    </div>
                    <button type="submit" name="user_login_submit" class="auth_btn">Log in</button>
                    <div class="footer_line">
                        <a href="./register.php">
                            <h6>Don't have an account? <span class="page_move_btn">sign up</span></h6>
                        </a>
                    </div>
                </form>
                
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>
