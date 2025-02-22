<?php
session_start();
include('connection.php');
$customer_id = $_SESSION['cust_id'];
$response = ["success" => false];

if (isset($_POST["delete"])) {
    $product_id = $_POST['delete'];

    // Delete the product from the cart
    $sql = "DELETE FROM cart WHERE customer_id='$customer_id' AND product_id='$product_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "Product deleted from cart successfully!";

        // Calculate the new cart count after deletion
        $count_query = "SELECT COUNT(*) AS count FROM cart WHERE customer_id='$customer_id'";
        $count_result = mysqli_query($conn, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);

        // Calculate the new subtotal after deletion
        $subtotal_query = "SELECT SUM(p.price * c.qty) AS subtotal 
                           FROM cart c
                           JOIN product p ON c.product_id = p.product_id
                           WHERE c.customer_id='$customer_id'";
        $subtotal_result = mysqli_query($conn, $subtotal_query);
        $subtotal_row = mysqli_fetch_assoc($subtotal_result);
        $new_subtotal = $subtotal_row['subtotal'] ? (float)$subtotal_row['subtotal'] : 0.00;

        $response = [
            "success" => true,
            "message" => $_SESSION['status'],
            "cart_count" => $count_row['count'],
            "cart_total" => number_format($new_subtotal, 2) // format the subtotal for display
        ];
    } else {
        $response["message"] = "Product deletion from cart failed!";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
