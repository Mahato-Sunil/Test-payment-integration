<?php
require "../Configuration/config.php"; // for secret key 

// function to initiate the payment 
function initiate_payment($response_data)
{
    echo "<pre>" . print_r($response_data, true) . "</pre>";

    // retrieve the payment URL from the response data 
    $payment_url = $response_data['payment_url'];
    // echo $payment_url;

    // redirect the user to the payment URL 
    header('Location:' . $payment_url);
}

// retrieve the data sent from the form 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay_btn'])) {

    $full_name = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['number'];
    $total_price = $_POST['amount'];
    $product_id = $_POST['pid'];
    $product_name = $_POST['pname'];

    echo $full_name;

    // create the payment data 
    $transaction_data = [
        'return_url' => 'http://localhost/test_payment_integration/Main/payment_verification.php',
        'website_url' => 'http://localhost/test_payment_integration',
        'amount' => $total_price * 100, // in paisa
        'purchase_order_id' => $product_id,
        'purchase_order_name' => $product_name,

        'customer_info' => [
            'name' => $full_name,
            'email' => $email,
            'phone' => $phone,
        ],
    ];

    // Khalti payment gateway 
    // The code is from the Khalti payment gateway documentation 

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($transaction_data),

        CURLOPT_HTTPHEADER => array(
            'Authorization: Key ' . $khalti_secret_key,
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);
    $response_data = json_decode($response, true);

    // echo json_encode($response_data);

    // For error handling and debugging 
    if ($response === false)
        echo "Curl error: " . curl_error($curl);
    else {
        if (isset($response_data['error_key']))
            echo "Error from Khalti : " . $response_data['error_key'];
        else
            initiate_payment($response_data);
    }
    curl_close($curl);
}
