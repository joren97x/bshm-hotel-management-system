<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Transactions</title>
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
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Cashier Transactions</h2>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Guest Name</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.id, rb.Name, p.finaltotal, p.payment_status 
                        FROM payment p 
                        JOIN roombook rb ON p.id = rb.id";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['finaltotal']}</td>
                        <td>{$row['payment_status']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
