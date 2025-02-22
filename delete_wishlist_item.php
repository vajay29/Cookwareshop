<?php
session_start();
include('connection.php'); // include your database connection file

$response = ['success' => false];

if (isset($_POST['product_id']) && isset($_SESSION['cust_id'])) {
    $product_id = $_POST['product_id'];
    $cust_id = $_SESSION['cust_id'];

    // Delete the item from the wishlist table
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE product_id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $product_id, $cust_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Check if there are remaining items in the wishlist
        $count_query = "SELECT COUNT(*) AS total FROM wishlist WHERE customer_id = ?";
        $count_stmt = $conn->prepare($count_query);
        $count_stmt->bind_param("i", $cust_id);
        $count_stmt->execute();
        $result = $count_stmt->get_result();
        $row = $result->fetch_assoc();

        $response['success'] = true;
        $response['wishlist_empty'] = ($row['total'] == 0);

        $response['totalWishlistItems'] =$row['total'] ?? 0;
    }
}

echo json_encode($response);
?>
