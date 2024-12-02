<h2>Reservation Requests</h2>
<table>
    <thead>
        <tr>
            <th>Reservation ID</th>
            <th>Guest Name</th>
            <th>Room</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM roombook WHERE stat = 'NotConfirm'";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['Name']}</td>
                <td>{$row['RoomType']}</td>
                <td>{$row['stat']}</td>
                <td>
                    <form method='POST' action='confirm_reservation.php'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit'>Confirm</button>
                    </form>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>
