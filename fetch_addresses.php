<?php
include('connection.php');
session_start();

// Assuming customer_id is stored in the session
$customer_id = $_SESSION['cust_id'];

// Fetch saved addresses for the logged-in user
$sql = "SELECT * FROM delivery_address WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$addresses = [];
while ($row = $result->fetch_assoc()) {
    $addresses[] = $row;
}

echo json_encode($addresses);
?>
