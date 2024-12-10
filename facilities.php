<?php
include 'config.php'; // Include database connection
include 'navbar.php'; // Include navigation bar

// Fetch all facilities
$query = "SELECT * FROM facilities";
$result = mysqli_query($conn, $query);

// Check if query failed
if (!$result) {
    die("Error fetching facilities: " . mysqli_error($conn));
}
?>
<style>
    .facility-card {
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .facility-card:hover {
        transform: translateY(-10px);
    }

    .facility-image {
        object-fit: cover;
        height: 200px;
    }
</style>
<div class="container my-5">
    <h1 class="text-center mb-4">Our Facilities</h1>
    <div class="row g-4">
        <?php while ($facility = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4">
                <div class="card facility-card">
                    <img src="uploads/<?php echo htmlspecialchars($facility['photo']); ?>"
                        alt="<?php echo htmlspecialchars($facility['name']); ?>"
                        class="card-img-top facility-image">
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