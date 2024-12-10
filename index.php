<?php
include 'config.php';
include 'navbar.php';

// Fetch rooms
$rooms_query = "SELECT * FROM rooms WHERE status = 'vacant'";
$rooms_result = mysqli_query($conn, $rooms_query);

// Fetch facilities
$facilities_query = "SELECT * FROM facilities";
$facilities_result = mysqli_query($conn, $facilities_query);
?>

    <style>
        /* Hero Section */
        .hero {
        position: relative;
        background: url('./image/hotel1.jpg') no-repeat center center/cover;
        height: 80vh;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
    }

    /* Dark overlay */
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
        z-index: 1;
    }

    /* Text content */
    .hero > div {
        position: relative;
        z-index: 2; /* Place content above the overlay */
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .hero p {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .hero .btn {
        margin: 10px;
        padding: 10px 20px;
    }

        /* Card Styling */
        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        /* Section Titles */
        .section-title {
            margin: 50px 0 20px;
            text-align: center;
            font-weight: bold;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #343a40;
        }

        .section-title p {
            color: #6c757d;
        }
    </style>
    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>Welcome to Our Hotel</h1>
            <p>Experience luxury and comfort like never before.</p>
            <a href="#rooms" class="btn btn-primary">Explore Rooms</a>
            <a href="#facilities" class="btn btn-outline-light">View Facilities</a>
        </div>
    </div>

    <div class="container my-5">
        <!-- Rooms Section -->
        <div id="rooms" class="section-title">
            <h2>Our Rooms</h2>
            <p>Discover the perfect space for your stay.</p>
        </div>
        <div class="row">
            <!-- Room Card -->
            <?php
                // Query to fetch all rooms from the database
                $sql = "SELECT * FROM rooms GROUP BY room_type";
                $result = mysqli_query($conn, $sql);

                // Check if the query returned results
                if (mysqli_num_rows($result) > 0) {
                    // Loop through the rooms and display them
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col-md-4">
                            <div class="room-card">
                                <!-- Carousel for Room Images -->
                                <div id="roomCarousel<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php
                                        // Get room images (assuming you have multiple images in a directory or database)
                                        $images = explode(',', $row['images']); // assuming images are stored as a comma-separated string in the database
                                        $isActive = true; // Make the first image active
                                        foreach ($images as $image) {
                                            ?>
                                            <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>">
                                                <img src="<?php echo './uploads/' . $image; ?>" alt="Room Image" style="height: 300px; width: 100%">
                                            </div>
                                            <?php
                                            $isActive = false;
                                        }
                                        ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel<?php echo $row['id']; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel<?php echo $row['id']; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>

                                <div class="card-body">
                                    <a href="./view_room.php?id=<?php echo $row['id']; ?>">
                                        <div class="room-name"><?php echo $row['name']; ?></div>
                                    </a>
                                    <div class="room-details"><?php echo $row['room_type']; ?></div>
                                    <div class="price">₱<?php echo number_format($row['price'], 2); ?> / night</div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "No rooms found.";
                }
                ?>

        </div>

        <!-- Facilities Section -->
        <div id="facilities" class="section-title">
            <h2>Our Facilities</h2>
            <p>Enjoy world-class amenities and services.</p>
        </div>
        <div class="row g-4">
            <?php while ($facility = mysqli_fetch_assoc($facilities_result)): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="uploads/<?php echo htmlspecialchars($facility['photo']); ?>" 
                             alt="<?php echo htmlspecialchars($facility['name']); ?>" 
                             class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($facility['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($facility['description']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

<?php include './footer.php'; ?>