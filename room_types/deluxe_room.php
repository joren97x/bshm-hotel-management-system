<?php
function getDeluxeRoomDetails($conn) {
    $sql = "SELECT * FROM room WHERE type = 'Deluxe Room'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateDeluxeRoomCount($conn, $change) {
    $sql = "UPDATE room SET quantity = quantity + $change WHERE type = 'Deluxe Room'";
    return mysqli_query($conn, $sql);
}
?>

