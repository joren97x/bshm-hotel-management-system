<?php
include '../config.php';
include './sidebar.php';

$search_results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_rooms'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $room_type = $_POST['room_type'];

    $search_sql = "
        SELECT r.id, r.name, r.room_type, r.room_number, r.price, r.capacity
        FROM rooms r
        LEFT JOIN bookings b ON r.id = b.room_id 
        AND (
            (b.check_in <= ? AND b.check_out > ?) OR 
            (b.check_in < ? AND b.check_out >= ?) OR 
            (b.check_in >= ? AND b.check_out <= ?)
        )
        WHERE r.status = 'vacant' AND b.id IS NULL";

    if (!empty($room_type)) {
        $search_sql .= " AND r.room_type = ?";
    }

    $stmt = $conn->prepare($search_sql);
    if (!empty($room_type)) {
        $stmt->bind_param('sssssss', $start_date, $start_date, $end_date, $end_date, $start_date, $end_date, $room_type);
    } else {
        $stmt->bind_param('ssssss', $start_date, $start_date, $end_date, $end_date, $start_date, $end_date);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($room = $result->fetch_assoc()) {
        $search_results[] = $room;
    }
}

?>

<form method="POST">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="room_type" class="form-label">Room Type</label>
                <select class="form-select" id="room_type" name="room_type">
                    <option value="">-- All Room Types --</option>
                    <option value="Superior">Superior</option>
                    <option value="Deluxe">Deluxe</option>
                    <option value="Standard">Standard</option>
                    <!-- Add other room types as needed -->
                </select>
            </div>
        </div>
        <button type="submit" name="search_rooms" class="btn btn-primary">Search</button>
    </form>
    <?php if (!empty($search_results)): ?>
        <h2 class="mt-5">Available Rooms</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Name</th>
                    <th>Room Type</th>
                    <th>Capactiy</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($search_results as $room): ?>
                    <tr>
                        <td><?php echo $room['room_number']; ?></td>
                        <td><?php echo $room['name']; ?></td>
                        <td><?php echo $room['room_type']; ?></td>
                        <td><?php echo $room['capacity']; ?></td>
                        <td><?php echo $room['price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-warning mt-4">No available rooms found for the selected criteria.</div>
    <?php endif; ?>