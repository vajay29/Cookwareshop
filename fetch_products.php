<?php
include 'connection.php'; // Adjust this to include your DB connection file

$searchQuery = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Start with the base query
$productQuery = "SELECT * FROM product";
$conditions = [];

// Add search condition if a query is provided
if (!empty($searchQuery)) {
    $conditions[] = "product_name LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'";
}

// Combine any conditions with AND if they exist
if (!empty($conditions)) {
    $productQuery .= " WHERE " . implode(" AND ", $conditions);
}

// Execute the query
$result = mysqli_query($conn, $productQuery);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        // Include the HTML structure for each product
        ?>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="product-default-single-item product-color--golden" data-aos="fade-up">
                <div class="image-box">
                    <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>" class="image-link">
                        <img src="./uploads/<?php echo $row['image']; ?>" alt="" style="width: 300px; height: 300px;">
                    </a>
                    <div class="action-link">
                        <div class="action-link-left">
                            <a href="#" onclick="handleAddToCart(<?php echo $row['product_id']; ?>)">Add to Cart</a>
                        </div>
                        <div class="action-link-right">
                            <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>"><i class="icon-eye"></i></a>
                            <a href="#" class="add-to-wishlist" data-product-id="<?php echo $row['product_id']; ?>" onclick="handleAddToWishlist(event, this)">
                                <i class="icon-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="content-left">
                        <h6 class="title"><?php echo $row['product_name']; ?></h6>
                        <ul class="review-star">
                            <?php
                            // Display average rating stars logic here
                            ?>
                        </ul>
                    </div>
                    <div class="content-right">
                        <span class="price">₹<?php echo $row['price']; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No products found.</p>";
}

mysqli_close($conn);
?>
