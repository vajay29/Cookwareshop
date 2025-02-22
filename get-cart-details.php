<?php
session_start();
include('connection.php');

header('Content-Type: application/json');

// Ensure session variable is set
if (!isset($_SESSION['cust_id'])) {
    echo json_encode(['success' => false, 'message' => 'Customer ID is not set in session.']);
    exit();
}

$customer_id = $_SESSION['cust_id'];

// Get the count of items in the cart
$sql_count = "SELECT COUNT(*) AS totalitem FROM cart WHERE customer_id='$customer_id'";
$result_count = mysqli_query($conn, $sql_count);
if ($result_count) {
    $row_count = mysqli_fetch_array($result_count);
    $count = $row_count['totalitem'];
} else {
    echo json_encode(['success' => false, 'message' => 'Error in count query: ' . mysqli_error($conn)]);
    exit();
}

// Get the total amount
$sql_amount = "
    SELECT SUM(p.price * c.qty) AS total_amount
    FROM cart c
    JOIN product p ON c.product_id = p.product_id
    WHERE c.customer_id='$customer_id'
";
$result_amount = mysqli_query($conn, $sql_amount);
if ($result_amount) {
    $row_amount = mysqli_fetch_array($result_amount);
    $amount = $row_amount['total_amount'] ?? 0;
} else {
    echo json_encode(['success' => false, 'message' => 'Error in total amount query: ' . mysqli_error($conn)]);
    exit();
}

// Return JSON response
echo json_encode(['success' => true, 'totalitem' => $count, 'total_amount' => $amount]);

?>
