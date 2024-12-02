<?php
function getSuperiorRoomDetails($conn) {
    $sql = "SELECT * FROM room WHERE type = 'Superior Room'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateSuperiorRoomCount($conn, $change) {
    $sql = "UPDATE room SET quantity = quantity + $change WHERE type = 'Superior Room'";
    return mysqli_query($conn, $sql);
}
?>

