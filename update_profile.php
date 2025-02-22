<?php
include 'connection.php';
session_start();

$customer_id = $_SESSION['cust_id']; // Assume customer_id is stored in session
$name = $_POST['name'];
$phone = $_POST['phone'];

$sql = "UPDATE customer SET name = ?, phone = ? WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $phone, $customer_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
}
?>
