<?php


// Get the data from the URL posted using GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the data and store it in variables
    $pidx = $_GET['pidx'];
    $status = $_GET['status'];
    $transaction_id = $_GET['transaction_id'];
    $tidx = $_GET['tidx'];
    $amount = $_GET['amount'];
    $khalti_id = $_GET['mobile'];
    $purchase_order_id = $_GET['purchase_order_id'];
    $purchase_order_name = $_GET['purchase_order_name'];
    $total_amount = $_GET['total_amount'];

    $background_color = match ($status) {
        'Completed' => 'background-color:rgb(8, 211, 15);',
        'Pending', 'Initiated', 'Refunded', 'Partially Refunded' => 'background-color:rgb(239, 175, 85);',
        'Expired', 'User canceled' => 'background-color: #f44336;', // Red
        default => 'background-color:rgb(253, 246, 185);', // Yellow for unexpected statuses
    };


    // Display the data in a table
    echo "
    <html>
    <head>
        <title>Payment Information</title>
        <style>
            table {
                width: 80%;
                border-collapse: collapse;
                margin: 20px auto;
                font-family: Arial, sans-serif;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
                font-weight: bold;
            }
            h2 {
                text-align: center;
                font-family: Arial, sans-serif;
            }
        </style>
    </head>
    <body>
        <h2>Payment Information</h2>
        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Product ID</td>
                <td>$pidx</td>
            </tr>
            <tr>
                <td>Status</td>
                <td style=\"$background_color\"> $status</td>
            </tr>
            <tr>
                <td>Transaction ID</td>
                <td>$transaction_id</td>
            </tr>
            <tr>
                <td>Transaction Index</td>
                <td>$tidx</td>
            </tr>
            <tr>
                <td>Amount</td>
                <td>Rs. " . ($amount / 100) . "</td>
            </tr>
            <tr>
                <td>Khalti ID</td>
                <td>$khalti_id</td>
            </tr>
            <tr>
                <td>Purchase Order ID</td>
                <td>$purchase_order_id</td>
            </tr>
            <tr>
                <td>Purchase Order Name</td>
                <td>$purchase_order_name</td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td>Rs. " . ($total_amount / 100) . "</td>
            </tr>
        </table>
    </body>
    </html>";
}
