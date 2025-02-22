<?php
include 'connection.php';

if (isset($_POST['order_id'])) {
    $ordermaster_id = $_POST['order_id'];
    
    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Step 1: Update ordermaster status to 'cancelled'
        $updateOrderMaster = "UPDATE ordermaster SET status = 'cancelled' WHERE ordermaster_id = ?";
        $stmtOrderMaster = mysqli_prepare($conn, $updateOrderMaster);
        mysqli_stmt_bind_param($stmtOrderMaster, "i", $ordermaster_id);
        mysqli_stmt_execute($stmtOrderMaster);
        mysqli_stmt_close($stmtOrderMaster);

        // Step 2: Update stock in product table based on the quantities in the orders table
        $fetchOrders = "SELECT product_id, quantity FROM orders WHERE ordermaster_id = ?";
        $stmtOrders = mysqli_prepare($conn, $fetchOrders);
        mysqli_stmt_bind_param($stmtOrders, "i", $ordermaster_id);
        mysqli_stmt_execute($stmtOrders);
        $resultOrders = mysqli_stmt_get_result($stmtOrders);

        while ($order = mysqli_fetch_assoc($resultOrders)) {
            $product_id = $order['product_id'];
            $quantity = $order['quantity'];
            
            // Update product stock
            $updateStock = "UPDATE product SET stock = stock + ? WHERE product_id = ?";
            $stmtStock = mysqli_prepare($conn, $updateStock);
            mysqli_stmt_bind_param($stmtStock, "ii", $quantity, $product_id);
            mysqli_stmt_execute($stmtStock);
            mysqli_stmt_close($stmtStock);
        }

        mysqli_stmt_close($stmtOrders);

        // Step 3: Update payment status to 'cancelled' in payment table
        $updatePayment = "UPDATE payment SET payment_status = 'cancelled' WHERE ordermaster_id = ?";
        $stmtPayment = mysqli_prepare($conn, $updatePayment);
        mysqli_stmt_bind_param($stmtPayment, "i", $ordermaster_id);
        mysqli_stmt_execute($stmtPayment);
        mysqli_stmt_close($stmtPayment);

        // Fetch payment method for the order
        $getPaymentMethod = "SELECT payment_method FROM payment WHERE ordermaster_id = ?";
        $stmtPaymentMethod = mysqli_prepare($conn, $getPaymentMethod);
        mysqli_stmt_bind_param($stmtPaymentMethod, "i", $ordermaster_id);
        mysqli_stmt_execute($stmtPaymentMethod);
        mysqli_stmt_bind_result($stmtPaymentMethod, $payment_method);
        mysqli_stmt_fetch($stmtPaymentMethod);
        mysqli_stmt_close($stmtPaymentMethod);

        // Commit the transaction if all updates are successful
        mysqli_commit($conn);

        // Return success response with payment method
        echo json_encode([
            'status' => 'success',
            'message' => 'Order cancelled successfully.',
            'payment_method' => $payment_method
        ]);
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($conn);
        echo json_encode(['status' => 'error', 'message' => 'Failed to cancel order. Please try again.']);
    }
}

?>
