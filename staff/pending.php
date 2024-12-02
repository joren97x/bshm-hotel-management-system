

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9f1f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            padding-top: 50px;
            color: #333;
        }

        h2 {
            font-size: 40px;
            color: #005f73;
            text-align: center;
            margin-bottom: 50px;
        }

        /* Container for the table */
        .table-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            width: 80%;
            max-width: 1100px;
            margin-top: 50px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Table Header */
        table th {
            background-color: #008C75;
            color: white;
            padding: 20px;
            font-size: 22px;
            text-align: left;
            border-radius: 10px 10px 0 0;
        }

        /* Table Body */
        table td {
            padding: 18px;
            text-align: left;
            font-size: 18px;
            color: #555;
            border-bottom: 2px solid #ddd;
        }

        /* Table Rows Hover Effect */
        table tr:hover {
            background-color: #f0f8f9;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Even Row Background */
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Table Border */
        table td, table th {
            border-bottom: 2px solid #ddd;
        }

        /* Action Button Style */
        .action form {
            display: inline;
        }

        .delete {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Pending Approvals</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Room</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM pending";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['room']}</td>
                        <td class='action'>
                            <form method='POST' action='delete_pending.php'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' class='delete'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>