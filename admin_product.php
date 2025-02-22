<?php

include('connection.php');
ini_set('display_errors', 1);

if (isset($_POST["productsave"])) {
  if (isset($_POST['name']) && !empty($_POST['name'])) {
    $productName = $_POST['name'];
    $category = $_POST['category'];
    $material = $_POST['material'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $productImage = $_FILES['image']['name'];

    // Check if product name already exists
    $checkQuery = "SELECT * FROM product WHERE product_name='$productName'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      echo "<script>alert('Product name already exists. Please choose a different name.');</script>";
    } else {
      // Proceed with inserting the new product
      move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $productImage);
      $sql = "INSERT INTO product (product_name, image, price, stock, description, material_id, category_id, brand_id) 
                  VALUES ('$productName', '$productImage', '$price', '$stock', '$description', '$material', '$category', '$brand')";
      if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "Product added successfully!";
      } else {
        $_SESSION['status'] = "Product addition failed!";
      }
    }
  } else {
    $_SESSION['status'] = "Product name is not set or empty.";
  }
} elseif (isset($_POST["ids"])) {
  $product_id = $_POST['ids'];
  $sql = "DELETE FROM product WHERE product_id='$product_id'";
  if (mysqli_query($conn, $sql)) {
    $_SESSION['status'] = "Product deleted successfully!";
  } else {
    $_SESSION['status'] = "Product deletion failed!";
  }
} elseif (isset($_POST["productupdate"])) {
  $product_id = $_POST['edit_product_id'];
  $productName = $_POST['name'];
  $category = $_POST['category'];
  $material = $_POST['material'];
  $brand = $_POST['brand'];
  $price = $_POST['price'];
  $description = $_POST['description'];

  // Check if another product with the same name exists
  $checkQuery = "SELECT * FROM product WHERE product_name='$productName' AND product_id != '$product_id'";
  $checkResult = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    echo "<script>alert('Product name already exists. Please choose a different name.');</script>";
  } else {
    // Proceed with the update
    if (!empty($_FILES['image']['name'])) {
      $productImage = $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $productImage);
      $sql = "UPDATE product SET product_name='$productName', image='$productImage', price='$price', description='$description', material_id='$material', category_id='$category', brand_id='$brand' WHERE product_id='$product_id'";
    } else {
      $sql = "UPDATE product SET product_name='$productName', price='$price', description='$description', material_id='$material', category_id='$category', brand_id='$brand' WHERE product_id='$product_id'";
    }

    if (mysqli_query($conn, $sql)) {
      $_SESSION['status'] = "Product updated successfully!";
    } else {
      $_SESSION['status'] = "Product update failed!";
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
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


</head>

<body>

  <h4 class="page-title" style="margin-bottom: 50px;">Product</h4>
  <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="container-fluid">
              <div class="row">
                <!-- Product Name and Image -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Product</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Product Name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category" required>
                      <option value="" selected disabled>Select category</option>
                      <?php
                      $sql = "SELECT * FROM category";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
                        }
                      } else {
                        echo '<option>Error fetching categories: ' . mysqli_error($conn) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="brand">Brand</label>
                    <select class="form-control" id="brand" name="brand" required>
                      <option value="" selected disabled>Select brand</option>
                      <?php
                      $sql = "SELECT * FROM brand";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<option value="' . $row['brand_id'] . '">' . $row['name'] . '</option>';
                        }
                      } else {
                        echo '<option>Error fetching brands: ' . mysqli_error($conn) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="material">Material</label>
                    <select class="form-control" id="material" name="material" required>
                      <option value="" selected disabled>Select material</option>
                      <?php
                      $sql = "SELECT * FROM material";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<option value="' . $row['material_id'] . '">' . $row['name'] . '</option>';
                        }
                      } else {
                        echo '<option>Error fetching materials: ' . mysqli_error($conn) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" placeholder="Stock" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- Stock and Description -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Description" rows="4" required></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="productsave" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal -->

  <!-- Product Display Start -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-title">Product Table</div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Add Product
        </button>
        <!-- End Button trigger modal -->
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">NO</th>
              <th>PRODUCT NAME</th>
              <th>IMAGE</th>
              <th>PRICE</th>
              <th>STOCK</th>
              <th>ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM product";
            $count = 0;
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
              $count += 1;
            ?>
              <tr>
                <td><?php echo $count; ?></td>

                <td><?php echo $row['product_name']; ?> </td>

                <td><img style="width: 70px; height:70px; " class="img-responsive" src="./uploads/<?php echo $row['image']; ?>" /> </td>
                <td><?php echo $row['price']; ?> </td>
                <td><?php echo $row['stock']; ?> </td>
                <!-- <td><?php echo $row['description']; ?> </td> -->
                <td>
                  <div class="d-flex">
                    <button type="button" class="btn btn-success  edit-product-btn"
                      data-toggle="modal" data-target="#editModal"
                      data-id="<?php echo $row['product_id']; ?>"
                      data-name="<?php echo $row['product_name']; ?>"
                      data-image="<?php echo $row['image']; ?>"
                      data-price="<?php echo $row['price']; ?>"
                      data-description="<?php echo $row['description']; ?>"
                      data-category="<?php echo $row['category_id']; ?>"
                      data-material="<?php echo $row['material_id']; ?>"
                      data-brand="<?php echo $row['brand_id']; ?>">Edit Product
                    </button>
                    <form method="POST" action="" style="margin-left:10px ;">
                      <input type="hidden" name="ids" value="<?php echo $row['product_id']; ?>">
                      <input type="submit" name="id" value="Delete" class="btn btn-danger delete-category-btn">
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
  <!-- Product Display End -->

  <!-- Edit Product Modal -->
  <div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" enctype="multipart/form-data" id="editProductForm">
            <input type="hidden" name="edit_product_id" id="edit_product_id">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_name">Product</label>
                    <input type="text" class="form-control" id="edit_name" name="name" placeholder="ProductName">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_name">Category</label>
                    <select class="form-control" id="edit_category" name="category">
                      <option value="" selected disabled>Select category</option>
                      <?php
                      $sql = "SELECT * FROM category";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
                        }
                      } else {
                        echo '<option>Error fetching categories: ' . mysqli_error($conn) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_name">Brand</label>
                    <select class="form-control" id="edit_brand" name="brand">
                      <option value="" selected disabled>Select brand</option>
                      <?php
                      $sql = "SELECT * FROM brand";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<option value="' . $row['brand_id'] . '">' . $row['name'] . '</option>';
                        }
                      } else {
                        echo '<option>Error fetching brands: ' . mysqli_error($conn) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_name">Material</label>
                    <select class="form-control" id="edit_material" name="material">
                      <option value="" selected disabled>Select material</option>
                      <?php
                      $sql = "SELECT * FROM material";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<option value="' . $row['material_id'] . '">' . $row['name'] . '</option>';
                        }
                      } else {
                        echo '<option>Error fetching materials: ' . mysqli_error($conn) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="edit_price">Price</label>
                    <input type="text" class="form-control" id="edit_price" name="price" placeholder="Price">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="edit_image">Upload Image(Optional)</label>
                    <input type="file" class="form-control" id="edit_image" name="image" accept="images/*">
                    <img id="current_image" style="width: 150px; height:150px; margin-top: 10px;" src="" alt="Current Image">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="edit_image">Description</label>
                    <textarea class="form-control" name="description" id="edit_description" placeholder="Description" rows="5" cols="10"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="productupdate" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Product Modal End-->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.edit-product-btn').on('click', function() {
        var productId = $(this).data('id');
        var productName = $(this).data('name');
        var productImage = $(this).data('image');
        var productPrice = $(this).data('price');
        var productDescription = $(this).data('description');
        var productCategory = $(this).data('category');
        var productMaterial = $(this).data('material');
        var productBrand = $(this).data('brand');

        $('#edit_product_id').val(productId);
        $('#edit_name').val(productName);
        $('#edit_price').val(productPrice);
        $('#edit_description').val(productDescription);
        $('#edit_category').val(productCategory);
        $('#edit_material').val(productMaterial);
        $('#edit_brand').val(productBrand);

        // Set the current image if available
        if (productImage) {
          $('#current_image').attr('src', './uploads/' + productImage).show();
        } else {
          $('#current_image').attr('src', '').hide();
        }
      });

      $('.edit-stock-btn').on('click', function() {
        var productId = $(this).data('id');
        var oldStock = $(this).data('stock');

        $('#edit_stock_product_id').val(productId);
        $('#edit_stock_old').val(oldStock);

      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (isset($_SESSION['status'])): ?>
        Swal.fire({
          title: '<?php echo $_SESSION['status']; ?>',
          icon: '<?php echo strpos($_SESSION['status'], 'failed') !== false ? 'error' : 'success'; ?>',
          confirmButtonText: 'OK'
        });
        <?php unset($_SESSION['status']); ?>
      <?php endif; ?>
    });
  </script>

</body>

</html>