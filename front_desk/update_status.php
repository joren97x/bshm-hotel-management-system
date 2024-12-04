<?php
include '../config.php'; // Include database connection

// Function to generate a 6-character code
function generateCode($length = 6) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
}

if (isset($_POST['booking_id']) && isset($_POST['action'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    
    // Determine the new status based on the action
    if ($action === 'approve') {
        $new_status = 'approved';
        // Generate a unique code for the approved booking
        $code = generateCode();
    } elseif ($action === 'cancel') {
        $new_status = 'cancelled';
        $code = null; // No code for canceled bookings
    } else {
        echo 'error';
        exit;
    }
    
    // Update the booking status and code in the database
    $query = "UPDATE bookings SET status = ?, code = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind the parameters (if the code is null, the database will handle it as NULL)
    mysqli_stmt_bind_param($stmt, 'ssi', $new_status, $code, $booking_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo 'success';
    } else {
        echo 'error';
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo 'error';
}
?>
