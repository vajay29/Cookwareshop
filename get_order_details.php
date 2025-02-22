<?php
session_start();
include 'connection.php';

if (isset($_POST['ordermaster_id'])) {
    $ordermaster_id = $_POST['ordermaster_id'];
    $_SESSION['master_id'] = $ordermaster_id;

    // Fetch order summary
    $sql = "SELECT p.*, od.quantity, (od.quantity * p.price) as total 
            FROM product p
            JOIN orders od ON p.product_id = od.product_id
            WHERE od.ordermaster_id = '$ordermaster_id'";
    $result = mysqli_query($conn, $sql);

    $items = [];
    $total_price = 0;
    $total_items = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $total_price += $row['total'];
        $total_items += $row['quantity'];
        $items[] = [
            'product_id' =>$row['product_id'],
            'product_name' => $row['product_name'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'total' => $row['total'],
            'image' => $row['image']
        ];
    }

    // Fetch shipping details
    $shipping_sql = "SELECT d.name, d.address, d.city, d.pincode, d.mobile,o.status as order_status  FROM delivery_address d JOIN ordermaster o
ON o.deliveryaddress_id=d.deliveryaddress_id WHERE o.ordermaster_id = '$ordermaster_id'";
    $shipping_result = mysqli_query($conn, $shipping_sql);
    $shipping = mysqli_fetch_assoc($shipping_result);

    // Fetch payment details
    $payment_sql = "SELECT payment_method, payment_status FROM payment WHERE ordermaster_id = '$ordermaster_id'";
    $payment_result = mysqli_query($conn, $payment_sql);
    $payment = mysqli_fetch_assoc($payment_result);

    $response = [
        'total_price' => $total_price + 50, // Adding fixed shipping cost
        'total_items' => $total_items,
        'items' => $items,
        'shipping' => $shipping,
        'payment_method' => $payment['payment_method'],
        'status' => $payment['payment_status']
    ];

    echo json_encode($response);
}

?>
