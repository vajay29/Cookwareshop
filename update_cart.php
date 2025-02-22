<?php
session_start();
include 'connection.php';
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

if (isset($_POST['product_id']) && isset($_POST['qty'])) {
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    $customer_id = $_SESSION['cust_id'];

    // Update the cart quantity in the database
    $sql = "UPDATE cart SET qty = '$qty' WHERE product_id = '$product_id' AND customer_id = '$customer_id'";
    if (mysqli_query($conn, $sql)) {
        // Fetch the updated cart information
        $sql = "SELECT p.product_id, p.price, c.qty FROM cart c JOIN product p ON c.product_id = p.product_id WHERE c.customer_id = '$customer_id'";
        $result = mysqli_query($conn, $sql);
        $cart_total = 0;
        $item_total = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['product_id'] == $product_id) {
                $item_total = $row['price'] * $row['qty'];  // Calculate item total
            }
            $cart_total += $row['price'] * $row['qty'];  // Calculate total cart sum
        }


        $cart_count_sql = "SELECT SUM(qty) AS totalItems FROM cart WHERE customer_id = '$customer_id'";
        $cart_count_result = mysqli_fetch_assoc(mysqli_query($conn, $cart_count_sql));
       $cart_item_total = $cart_count_result['totalItems'] ?? 0;

        // Return the new totals as JSON
        echo json_encode([
            'success' => true,
            'item_total' => $item_total,
            'cart_total' => $cart_total,
            'cart_item_total'=>$cart_item_total
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update cart.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input.']);
}
?>
