<?php
// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';  // Replace with the actual password
$db_name = 'hm_hotels';

// Create the connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
  die("<script>alert('Connection failed: " . mysqli_connect_error() . "')</script>");
}

function checkUserType($conn, $usermail) {
    $sql = "SELECT usertype FROM signup WHERE Email = '$usermail'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['usertype'];
    }
    return false;
   }
   
   function checkAdminPrivileges($conn, $usermail) {
     $sql = "SELECT usertype FROM signup WHERE Email = '$usermail'";
     $result = mysqli_query($conn, $sql);
     if ($result && mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_assoc($result);
         return $row['usertype'] === 'admin';
     }
     return false;
   }
   
   function checkAvailableRooms($conn, $roomType, $bedType, $checkIn, $checkOut) {
      $sql = "SELECT r.quantity - COALESCE(SUM(rb.NoofRoom), 0) as available
              FROM room r
              LEFT JOIN roombook rb ON r.type = rb.RoomType AND r.bedding = rb.Bed
              AND ((rb.cin <= '$checkIn' AND rb.cout > '$checkIn') 
                  OR (rb.cin < '$checkOut' AND rb.cout >= '$checkOut')
                  OR (rb.cin >= '$checkIn' AND rb.cout <= '$checkOut'))
              WHERE r.type = '$roomType' AND r.bedding = '$bedType'
              GROUP BY r.id";
      
      $result = mysqli_query($conn, $sql);
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          return max(0, $row['available']);
      }
      return 0;
   }
   
   function updateRoomStatus($conn) {
      $currentDate = date('Y-m-d');
      $sql = "UPDATE room r
              LEFT JOIN roombook rb ON r.type = rb.RoomType AND r.bedding = rb.Bed
              SET r.status = CASE
                  WHEN rb.cin <= '$currentDate' AND rb.cout > '$currentDate' AND rb.stat = 'Confirm' THEN 'Occupied'
                  ELSE 'Vacant'
              END,
              r.room_condition = CASE
                  WHEN rb.cout = '$currentDate' THEN 'Dirty'
                  WHEN r.status = 'Vacant' AND r.room_condition = 'Dirty' THEN 'In Process'
                  WHEN r.status = 'Vacant' AND r.room_condition = 'In Process' THEN 'Clean'
                  ELSE r.room_condition
              END";
      mysqli_query($conn, $sql);
   }
   
   function updateRoomAvailability($conn, $roomType, $bedType, $change) {
      $sql = "UPDATE room 
              SET quantity = quantity + $change 
              WHERE type = '$roomType' AND bedding = '$bedType'";
      mysqli_query($conn, $sql);
   }
   
   function logRoomStatusChange($conn, $roomId, $newStatus, $updatedBy) {
       $sql = "INSERT INTO housekeeping_log (room_id, status, updated_by, updated_at) 
               VALUES (?, ?, ?, NOW())";
       $stmt = mysqli_prepare($conn, $sql);
       mysqli_stmt_bind_param($stmt, "iss", $roomId, $newStatus, $updatedBy);
       mysqli_stmt_execute($stmt);
       mysqli_stmt_close($stmt);
   }
   
// Function to send email (simulated)
function sendEmail($to, $subject, $message) {
    error_log("Email sent to: $to, Subject: $subject, Message: $message");
    return true;
}

// Function to generate invoice
function generateInvoice($bookingId) {
    return "INV-" . str_pad($bookingId, 6, "0", STR_PAD_LEFT);
}

// Function to get room price
function getRoomPrice($conn, $roomType, $bedType) {
    $sql = "SELECT price FROM room WHERE type = ? AND bedding = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $roomType, $bedType);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['price'] ?? 0;
}
?>
