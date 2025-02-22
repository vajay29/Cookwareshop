<?php
session_start();
include('connection.php');

$response = ['success' => false, 'message' => ''];

// Check if user is logged in and POST data is available
if (isset($_SESSION['cust_id']) && isset($_POST['product_id']) && isset($_POST['message']) && isset($_POST['rating'])) {
    $customer_id = $_SESSION['cust_id'];
    $product_id = $_POST['product_id'];
    $review = $_POST['message'];
    $rating = (int)$_POST['rating'];

    // Insert the review
    $sql_review = "INSERT INTO review (customer_id, product_id, review_date, review) VALUES (?, ?, NOW(), ?)";
    $stmt_review = $conn->prepare($sql_review);
    $stmt_review->bind_param('iis', $customer_id, $product_id, $review);

    if ($stmt_review->execute()) {
        $response['success'] = true;

        // Check if rating exists
        $sql_rate = "SELECT * FROM rating WHERE product_id = ? AND customer_id = ?";
        $stmt_rate = $conn->prepare($sql_rate);
        $stmt_rate->bind_param('ii', $product_id, $customer_id);
        $stmt_rate->execute();
        $result_rate = $stmt_rate->get_result();

        if ($result_rate->num_rows > 0) {
            // Update existing rating
            $sql_update = "UPDATE rating SET ratingcount = ? WHERE product_id = ? AND customer_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('iii', $rating, $product_id, $customer_id);
            $stmt_update->execute();
        } else {
            // Insert new rating
            $sql_insert = "INSERT INTO rating (customer_id, product_id, ratingcount) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('iii', $customer_id, $product_id, $rating);
            $stmt_insert->execute();
        }

        $stmt_review->close();
        $stmt_rate->close();
        $conn->close();
    } else {
        $response['message'] = 'Error inserting review: ' . $stmt_review->error;
    }
} else {
    $response['message'] = 'Incomplete request.';
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
