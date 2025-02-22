    <?php
    session_start();
    include('connection.php');

    // Check if the user is logged in
    if (!isset($_SESSION['cust_id'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit(); // Ensure no further code is executed
    }

    header('Content-Type: application/json');
    $response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = $_POST['product_id'] ?? '';
        $cust_id = $_SESSION['cust_id'];

        // Check if product ID is provided
        if ($product_id) {
            // Check if product is already in wishlist
            $check_query = "SELECT * FROM wishlist WHERE product_id = ? AND customer_id = ?";
            if ($stmt = $conn->prepare($check_query)) {
                $stmt->bind_param('ii', $product_id, $cust_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Product is already in wishlist, remove it
                    $delete_query = "DELETE FROM wishlist WHERE product_id = ? AND customer_id = ?";
                    if ($delete_stmt = $conn->prepare($delete_query)) {
                        $delete_stmt->bind_param('ii', $product_id, $cust_id);
                        if ($delete_stmt->execute()) {
                            $response = [
                                'status' => 'success',
                                'message' => 'Product removed from wishlist',
                                'action' => 'removed'
                            ];
                        } else {
                            $response['message'] = 'Failed to remove product from wishlist';
                        }
                    } else {
                        $response['message'] = 'Failed to prepare delete statement.';
                    }
                } else {
                    // Product is not in wishlist, add it
                    $insert_query = "INSERT INTO wishlist (product_id, customer_id) VALUES (?, ?)";
                    if ($insert_stmt = $conn->prepare($insert_query)) {
                        $insert_stmt->bind_param('ii', $product_id, $cust_id);
                        if ($insert_stmt->execute()) {
                            $response = [
                                'status' => 'success',
                                'message' => 'Product added to wishlist',
                                'action' => 'added'
                            ];
                        } else {
                            $response['message'] = 'Failed to add product to wishlist';
                        }
                    } else {
                        $response['message'] = 'Failed to prepare insert statement.';
                    }
                }

                // Get updated wishlist count regardless of add/remove action
                $count_query = "SELECT COUNT(*) AS count FROM wishlist WHERE customer_id = ?";
                if ($count_stmt = $conn->prepare($count_query)) {
                    $count_stmt->bind_param('i', $cust_id);
                    $count_stmt->execute();
                    $count_result = $count_stmt->get_result();
                    $count_row = $count_result->fetch_assoc();
                    $response['wishlistCount'] = $count_row['count'];
                }
            } else {
                $response['message'] = 'Failed to prepare select statement.';
            }
        } else {
            $response['message'] = 'Missing product ID.';
        }
    }

    // Send JSON response
    echo json_encode($response);
    ?>
