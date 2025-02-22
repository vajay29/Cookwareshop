<?php
include('connection.php');
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {

  if (isset($_POST['name']) && !empty($_POST['name'])) {
    $brandName = $_POST['name'];

    $check_sql = "SELECT * FROM brand WHERE LOWER(name) = LOWER('$brandName')";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('Brand already exists.');</script>";
    } else {
      // Insert into database
      $sql = "INSERT INTO brand (name) VALUES ('$brandName')";

      // Execute SQL query
      if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "Brand added successfully!";
      } else {
        $_SESSION['status'] = "Brand addition failed!";
      }
    }
  } else {
    echo "Brand value is not set or empty.";
  }
} elseif (isset($_POST["ids"])) {

  $brand_id = $_POST['ids'];
  $sql = "DELETE FROM brand WHERE brand_id='$brand_id'";
  if (mysqli_query($conn, $sql)) {
    $_SESSION['status'] = "Brand deleted successfully!";
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

  <h4 class="page-title" style="margin-bottom: 50px;">Brand</h4>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Brand Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                <label for="name">Brand</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
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

  <!-- Brand Display Start -->
  <div class="col-md-8" style="margin-left: 150px;">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-title">Brand Table</div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          New Brand
        </button>
        <!-- End Button trigger modal -->
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">NO</th>
              <th scope="col">BRAND NAME</th>
              <th scope="col">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM brand";
            $count = 0;
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
              $count += 1;
            ?>
              <tr>
                <td><?php echo $count; ?></td>

                <td><?php echo $row['name']; ?> </td>

                <td>
                  <form method="POST" action="">
                    <input type="hidden" name="ids" value="<?php echo $row['brand_id']; ?>">
                    <input type="submit" name="id" value="Delete" class="btn btn-danger">
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Brand Display End -->

</body>

</html>