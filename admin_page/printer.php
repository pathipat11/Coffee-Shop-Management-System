<?php
include('database.php');

$orderID = $_GET['orderID'];

$sql = "SELECT c.*, d.*, m.menuname, d.orderDate
        FROM orderDetail c 
        JOIN coffeeOrder d ON c.orderID = d.orderID 
        JOIN menu m ON m.menuID = c.menuID 
        WHERE d.orderID = '$orderID'";


$result = mysqli_query($conn, $sql);

$totalPrice = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            width: 350px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-info {
            margin-bottom: 15px;
        }
        .order-info p {
            margin: 5px 0;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            font-size: 18px;
            text-align: right;
            padding-top: -5px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ใบเสร็จรับเงิน</h1>
        </div>
        <div class="order-info">
            <?php
                if ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>คำสั่งซื้อที่: <strong>$orderID</strong></p>";
                    echo "<p>วันที่: <strong>{$row['orderDate']}</strong></p>";
                }
            ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>เมนู</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['menuname']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>{$row['totalprice']} บาท</td>";
                        echo "</tr>";
                        $totalPrice += $row['totalprice'];
                    }
                ?>
            </tbody>
        </table>
        <div class="total">
            <?php
                echo "<p>ราคารวม <strong>$totalPrice บาท</strong></p>";
            ?>
        </div>
        <div class="footer">
            <p>ขอบคุณที่ใช้บริการ</p>
        </div>
        <script>
            window.onload = function() {
                window.print();
            };
            window.onafterprint = function(event) {
                window.close();
            };
        </script>
    </div>
</body>
</html>
