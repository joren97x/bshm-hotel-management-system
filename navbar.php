<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Navbar Styling */
        .navbar {
            background-color: #343a40; /* Dark grey */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: #ffffff;
            font-weight: bold;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .nav-link {
            color: #ffffff;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffc107;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            filter: brightness(0) invert(1);
        }

        /* Hide the menu dropdown on larger screens */
        @media (min-width: 576px) {
            .dropdown-menu {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <?php session_start(); ?>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo and Brand -->
            <a class="navbar-brand" href="index.php">
                <img src="image/hm.jpg" alt="Logo" width="40" height="40">
                MySite
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <!-- Always visible links for md and larger -->
                <ul class="navbar-nav d-none d-sm-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facilities.php">Facilities</a>
                    </li>
                </ul>

                <!-- Dropdown menu for sm and smaller -->
                <ul class="navbar-nav d-flex d-sm-none">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php">Home</a></li>
                            <li><a class="dropdown-item" href="rooms.php">Rooms</a></li>
                            <li><a class="dropdown-item" href="facilities.php">Facilities</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if (isset($_SESSION['user'])): ?>
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <li><a class="dropdown-item" href="register.php">Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>

                <!-- User Links for larger screens -->
                <ul class="navbar-nav d-none d-sm-flex">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
