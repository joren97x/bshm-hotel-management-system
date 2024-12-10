<?php
include 'config.php';
// session_start();
include 'navbar.php';

?>
  <link rel="stylesheet" href="./admin/css/roombook.css">

<style>
    .room-card {
      max-width: 100%;
      margin: 20px auto;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .carousel-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .room-card .card-body {
      padding: 15px;
    }

    .room-card .room-name {
      font-size: 1.1rem;
      font-weight: bold;
    }

    .room-card .room-details {
      font-size: 0.9rem;
      color: #6c757d;
    }

    .room-card .price {
      font-size: 1.3rem;
      font-weight: bold;
      color: #007bff;
    }

    .room-card .rating {
      display: flex;
      align-items: center;
    }

    .room-card .rating i {
      color: #ffb400;
    }

    .room-card .rating span {
      margin-left: 5px;
    }

    .room-card .heart-icon {
      color: #007bff;
    }
  </style>
<section id="room-list">
    <h1 class="head text-center">≼ Our Rooms ≽</h1>
    <div class="container">
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
                                                <img src="<?php echo './uploads/' . $image; ?>" alt="Room Image">
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
    </div>
</section>
<?php include './footer.php'; ?>