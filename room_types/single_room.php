<?php
function getSingleRoomDetails($conn) {
    $sql = "SELECT * FROM room WHERE type = 'Single Room'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateSingleRoomCount($conn, $change) {
    $sql = "UPDATE room SET quantity = quantity + $change WHERE type = 'Single Room'";
    return mysqli_query($conn, $sql);
}
?>

