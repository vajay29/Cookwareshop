<?php
include('connection.php');
if (isset($_POST["ids"])) {
    $customer_id = $_POST['ids'];
    $sql = "DELETE FROM customer WHERE customer_id='$customer_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "Message deleted successfully!";
    } else {
        $_SESSION['status'] = " deletion failed!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookVerse</title>

</head>

<body>

    <!-- Customer Display Start -->
    <h4 class="page-title" style="margin-bottom: 50px;">Customer</h4>
    <div class="col-md-8" style="margin-left: 150px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Customer Table</div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">CUSTOMER ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">PHONE</th>
                            <!-- <th scope="col">ACTIONS</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM customer";
                        $count = 0;
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $count += 1;
                        ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['customer_id']; ?> </td>
                                <td><?php echo $row['name']; ?> </td>
                                <td><?php echo $row['email']; ?> </td>
                                <td><?php echo $row['phone']; ?> </td>
                                <!-- <td>
                            <form method="POST" action="">
                                <input type="hidden" name="ids" value="<?php echo $row['customer_id']; ?>">
                                <input type="submit" name="id" value="Delete" class="btn btn-danger delete-category-btn">
                            </form>
                            </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Customer Display End -->

</body>

</html>