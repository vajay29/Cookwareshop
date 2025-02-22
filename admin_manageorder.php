<?php
include('connection.php');
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookVerse</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


</head>

<body>
    <!-- Orders Display Start -->
    <h4 class="page-title" style="margin-bottom: 50px;">Orders</h4>
    <div class="col-md-12" style="margin-bottom: 350px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Order Table</div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">SL. NO.</th>
                            <th scope="col">ORDER NO</th>
                            <th scope="col">CUSTOMER</th>
                            <th scope="col">ORDER DATE</th>
                            <th scope="col">TOTAL AMOUNT</th>
                            <th scope="col">STATUS</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $sql = "SELECT o.*,c.*,d.* FROM ordermaster o JOIN customer c ON o.customer_id=c.customer_id 
                                JOIN delivery_address d ON d.deliveryaddress_id=o.deliveryaddress_id WHERE status NOT IN ('delivered','cancelled')";;
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $count++;
                        ?>
                            <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td class="order-number"><?php echo $row['ordermaster_id']; ?></td>
                                <td class="tm-product-name"><?php echo $row['name']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo number_format($row['total_amount'], 2); ?></td>
                                <td>
                                    <a class="btn btn-primary" href="AdminHome.php?page=orderdetails&ordermaster_id=<?php echo $row['ordermaster_id']; ?>">View Details</a>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Orders Display End -->

</body>

</html>