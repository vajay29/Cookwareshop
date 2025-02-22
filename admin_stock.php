<?php
//session_start();
include('connection.php');
if (isset($_POST['ids'])) {

    $product_id = $_POST['ids'];
    $stock = $_POST['stock'];

    $current_stock = 0;

    $sql = "SELECT stock FROM product WHERE product_id='$product_id'";
    $result = mysqli_fetch_array(mysqli_query($conn, $sql));
    $current_stock = $result['stock'];

    if ($stock) {
        $current_stock += $stock;
    }

    $sql = "UPDATE product SET stock='$current_stock' WHERE product_id='$product_id' ";
    mysqli_query($conn, $sql);
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
    <!-- Stock Display Start -->
    <h4 class="page-title">Stock</h4>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Stock Table</div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">PRODUCT</th>
                            <th scope="col">IMAGE</th>
                            <th scope="col">CATEGORY</th>
                            <th scope="col">MATERIAL</th>
                            <th scope="col">STOCK</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $sql = "SELECT p.*, c.name AS category_name, m.name AS material_name
                                    FROM product p
                                    INNER JOIN category c ON p.category_id = c.category_id
                                    INNER JOIN material m ON p.material_id = m.material_id";
                        $result = mysqli_query($conn, $sql);
                        $count = 0;
                        while ($row = mysqli_fetch_array($result)) {
                            $count++;

                        ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['product_name']; ?> </td>
                                <td><img style="width: 150px; height:150px; " class="img-responsive" src="./uploads/<?php echo $row['image']; ?>" /> </td>
                                <td><?php echo $row['category_name']; ?> </td>
                                <td><?php echo $row['material_name']; ?> </td>
                                <td><?php echo $row['stock']; ?> </td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="number" name="stock" class="form-control">
                                </td>
                                <td> <input type="hidden" name="ids" value="<?php echo $row['product_id']; ?>">
                                    <button type="submit" class="btn btn-success">Update Stock</button>
                                </td>
                                </form>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Stock Display End -->

</body>

</html>