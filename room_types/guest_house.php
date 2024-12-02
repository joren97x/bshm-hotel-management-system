<?php
function getGuestHouseDetails($conn) {
    $sql = "SELECT * FROM room WHERE type = 'Guest House'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateGuestHouseCount($conn, $change) {
    $sql = "UPDATE room SET quantity = quantity + $change WHERE type = 'Guest House'";
    return mysqli_query($conn, $sql);
}
?>

