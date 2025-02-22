<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_SESSION['cust_id']; // Assume customer_id is stored in session
    $current_password = mysqli_real_escape_string($conn, $_POST['current-password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new-password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

    if ($new_password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'New password and confirm password do not match.']);
        exit;
    }

    // Retrieve the customer email from the customer table
    $sql = "SELECT email FROM customer WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if ($customer) {
        $email = $customer['email'];

        // Retrieve the current password from the login table
        $login_sql = "SELECT password FROM login WHERE email = ?";
        $stmt = $conn->prepare($login_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $login_result = $stmt->get_result();
        $login = $login_result->fetch_assoc();

        if ($login && ($current_password== $login['password'])) {
       
            // Update the password in the login table
            $update_sql = "UPDATE login SET password = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $new_password, $email);

            if ($update_stmt->execute()) {
                session_destroy(); // Log out the user
                echo json_encode(['status' => 'success', 'message' => 'Password changed successfully! Logging out...']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating password.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Customer not found.']);
    }
}

?>
