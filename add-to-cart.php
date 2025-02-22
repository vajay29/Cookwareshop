<?php
session_start();
include('connection.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_POST['product_id'])) {
    if (!isset($_SESSION['cust_id'])) {
        $response['redirect'] = true;
        echo json_encode($response);
        exit;
    }

    $product_id = $_POST['product_id'];
    $customer_id = $_SESSION['cust_id'];
    $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1;

    if ($conn) {
        $check_sql = "SELECT * FROM cart WHERE customer_id = '$customer_id' AND product_id = '$product_id'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $response['message'] = 'Item already added to your cart!';
        } else {
            $sql = "INSERT INTO cart (customer_id, product_id, qty) VALUES ('$customer_id', '$product_id', '$qty')";
            if (mysqli_query($conn, $sql)) {
                $response['success'] = true;
                $response['message'] = 'Product added to cart successfully!';

                $product_sql = "SELECT image as image_url FROM product WHERE product_id = '$product_id'";
                $product_result = mysqli_query($conn, $product_sql);
                if ($product_result && mysqli_num_rows($product_result) > 0) {
                    $product_row = mysqli_fetch_assoc($product_result);
                    $response['image_url'] = $product_row['image_url'];
                }
            } else {
                $response['message'] = 'Error adding product to cart.';
            }
        }

        // Get updated cart and wishlist counts
        $cart_count_sql = "SELECT SUM(qty) AS totalItems FROM cart WHERE customer_id = '$customer_id'";
        $cart_count_result = mysqli_fetch_assoc(mysqli_query($conn, $cart_count_sql));
        $response['totalCartItems'] = $cart_count_result['totalItems'] ?? 0;

        $wishlist_count_sql = "SELECT COUNT(*) AS totalItems FROM wishlist WHERE customer_id = '$customer_id'";
        $wishlist_count_result = mysqli_fetch_assoc(mysqli_query($conn, $wishlist_count_sql));
        $response['totalWishlistItems'] = $wishlist_count_result['totalItems'] ?? 0;

    } else {
        $response['message'] = 'Database connection failed.';
    }
} else {
    $response['message'] = 'Error: Missing product details.';
}

echo json_encode($response);
?>
