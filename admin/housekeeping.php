<!-- <?php
session_start();
include '../config.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['usermail']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'admin') {
   header("Location: ../index.php");
   exit();
}

// Handle room status updates
if (isset($_POST['update_status'])) {
    $room_id = $_POST['room_id'];
    $new_status = $_POST['room_condition'];
    
    $update_sql = "UPDATE room SET room_condition = '$new_status' WHERE id = $room_id";
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Room status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating room status');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeping Management - CPC Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        .status-clean { color: #198754; }
        .status-dirty { color: #dc3545; }
        .status-process { color: #ffc107; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Housekeeping Management</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Room</th>
                        <th>Room Type</th>
                        <th>Room Status</th>
                        <th>FO Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rooms_sql = "SELECT * FROM room ORDER BY id";
                    $rooms_result = mysqli_query($conn, $rooms_sql);
                    
                    while($room = mysqli_fetch_assoc($rooms_result)) :
                        $status_class = '';
                        switch($room['room_condition']) {
                            case 'Clean':
                                $status_class = 'status-clean';
                                break;
                            case 'Dirty':
                                $status_class = 'status-dirty';
                                break;
                            case 'In Process':
                                $status_class = 'status-process';
                                break;
                        }
                    ?>
                    <tr>
                        <td><?php echo $room['id']; ?></td>
                        <td><?php echo $room['type']; ?></td>
                        <td class="<?php echo $status_class; ?>"><?php echo $room['room_condition']; ?></td>
                        <td><?php echo $room['status']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#statusModal" 
                                    data-room-id="<?php echo $room['id']; ?>"
                                    data-current-status="<?php echo $room['room_condition']; ?>">
                                Edit
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Room Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="room_id" id="modalRoomId">
                        <div class="mb-3">
                            <label for="roomStatus" class="form-label">Status:</label>
                            <select name="room_condition" id="roomStatus" class="form-select">
                                <option value="Clean">Clean</option>
                                <option value="Dirty">Dirty</option>
                                <option value="In Process">In Process</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_status" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle status modal
        const statusModal = document.getElementById('statusModal');
        statusModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const roomId = button.getAttribute('data-room-id');
            const currentStatus = button.getAttribute('data-current-status');
            
            statusModal.querySelector('#modalRoomId').value = roomId;
            statusModal.querySelector('#roomStatus').value = currentStatus;
        });
    </script>
</body>
</html>
 -->
