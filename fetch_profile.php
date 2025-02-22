<?php
include 'connection.php';
session_start();

$customer_id = $_SESSION['cust_id']; // Assume customer_id is stored in session

$sql = "SELECT name, phone FROM customer WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>
