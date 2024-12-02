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
        <?php
            if (isset($_POST['user_signup_submit'])) {
                $first_name = trim($_POST['first_name']);
                $last_name = trim($_POST['last_name']);
                $email = trim($_POST['Email']);
                $role = "user";
                $password = $_POST['Password'];
                $cpassword = $_POST['CPassword'];

                // Validate required fields
                if (empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
                    echo "<script>swal({ title: 'Fill in all required details', icon: 'error' });</script>";
                } else {
                    // Check if passwords match
                    if ($password === $cpassword) {
                        // Check if email already exists
                        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo "<script>swal({ title: 'Email already exists', icon: 'error' });</script>";
                        } else {
                            // Hash the password
                            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                            // Insert new user
                            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $role);

                            if ($stmt->execute()) {
                                echo "<script>swal({ title: 'Registration successful', icon: 'success' });</script>";
                                header("Location: login.php");
                                exit;
                            } else {
                                echo "<script>swal({ title: 'Something went wrong', icon: 'error' });</script>";
                            }
                        }

                        $stmt->close();
                    } else {
                        echo "<script>swal({ title: 'Passwords do not match', icon: 'error' });</script>";
                    }
                }
            }
            ?>

                <h2>Sign Up</h2>
                <form class="user_signup" id="usersignup" action="" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="first_name" placeholder=" ">
                                <label for="Username">First Name</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="last_name" placeholder=" ">
                                <label for="Username">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating">
                        <input type="email" class="form-control" name="Email" placeholder=" ">
                        <label for="Email">Email</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" name="Password" placeholder=" ">
                        <label for="Password">Password</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" name="CPassword" placeholder=" ">
                        <label for="CPassword">Confirm Password</label>
                    </div>
                    <button type="submit" name="user_signup_submit" class="auth_btn">Sign up</button>
                    <div class="footer_line">
                        <a href="./login.php">
                        <h6>Already have an account? <span class="page_move_btn" >Log in</span></h6>
                        </a>
                    </div>
                </form>
            </div>
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html>
