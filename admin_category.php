<?php
include('connection.php');
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $categoryName = $_POST['name'];
        $categoryImage = $_FILES['image']['name'];

        $check_sql = "SELECT * FROM category WHERE LOWER(name) = LOWER('$categoryName')";
        $result = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Category already exists.');</script>";
        } else {

            // Move uploaded file to desired location
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $categoryImage);

            // Insert into database
            $sql = "INSERT INTO category (name,image) VALUES ('$categoryName','$categoryImage')";

            // Execute SQL query
            if (mysqli_query($conn, $sql)) {
            } else {
                $_SESSION['status'] = "Category addition failed!";
            }
        }
    } else {
        echo "Category value is not set or empty.";
    }
} elseif (isset($_POST["ids"])) {

    $category_id = $_POST['ids'];
    $sql = "DELETE FROM category WHERE category_id='$category_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "Category deleted successfully!";
    } else {
        $_SESSION['status'] = "Category deletion failed!";
    }
} elseif (isset($_POST['update'])) {
    // Handle category update
    $category_id = $_POST['category_id']; // The category ID for the update
    $categoryName = $_POST['name']; // Updated category name

    // Handle image update
    $categoryImage = $_FILES['image']['name']; // The new image
    if ($categoryImage) {
        // If a new image is uploaded, move the file and update it in the database
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $categoryImage);

        // Update category with new name and new image
        $sql = "UPDATE category SET name='$categoryName', image='$categoryImage' WHERE category_id='$category_id'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = "Category updated successfully!";
        } else {
            $_SESSION['status'] = "Category update failed!";
        }
    } else {
        // If no new image is uploaded, just update the category name
        $sql = "UPDATE category SET name='$categoryName' WHERE category_id='$category_id'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = "Category updated successfully!";
        } else {
            $_SESSION['status'] = "Category update failed!";
        }
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

    <h4 class="page-title" style="margin-bottom: 50px;">Category</h4>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Category Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Category</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="images/*" placeholder="Upload Image" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End Modal -->

    <!-- Category Display Start -->
    <div class="col-md-8" style="margin-left: 150px;">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Category Table</div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add Category
                </button>
                <!-- End Button trigger modal -->
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">CATEGORY NAME</th>
                            <th scope="col">IMAGE</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM category";
                        $count = 0;
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $count += 1;
                        ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><img style="width: 70px; height:70px;" class="img-responsive" src="./uploads/<?php echo $row['image']; ?>" /></td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <button class="btn btn-warning edit-btn" data-toggle="modal" data-target="#editCategoryModal" data-id="<?php echo $row['category_id']; ?>" data-name="<?php echo $row['name']; ?>" data-image="<?php echo $row['image']; ?> " style="margin-right:5px;">Edit</button>

                                        <form method="POST" action="">
                                            <input type="hidden" name="ids" value="<?php echo $row['category_id']; ?>">
                                            <input type="submit" name="id" value="Delete" class="btn btn-danger  delete-category-btn">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Edit Category Form -->
                    <form method="POST" enctype="multipart/form-data" id="editCategoryForm">
                        <input type="hidden" name="category_id" id="category_id"> <!-- Hidden category ID -->
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" name="name" class="form-control" id="categoryName" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryImage">Category Image</label>
                            <input type="file" name="image" class="form-control" id="categoryImage">
                            <img id="currentImage" src="" alt="Current Image" style="width: 100px; height: 100px; margin-top: 10px;">
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Category Display End -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // When the Edit button is clicked, populate the modal with the current category data
        $('.edit-btn').on('click', function() {
            var categoryId = $(this).data('id');
            var categoryName = $(this).data('name');
            var categoryImage = $(this).data('image');

            $('#category_id').val(categoryId);
            $('#categoryName').val(categoryName);
            $('#currentImage').attr('src', './uploads/' + categoryImage);
        });
    </script>
</body>

</html>