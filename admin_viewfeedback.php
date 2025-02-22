<?php
include('connection.php');
if (isset($_POST["ids"])) {
  $feedback_id = $_POST['ids'];
  $sql = "DELETE FROM feedback WHERE feedback_id='$feedback_id'";
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

  <!-- Feedback Display Start -->
  <h4 class="page-title" style="margin-bottom: 50px;">Feedback</h4>

  <div class="col-md-8" style="margin-left: 150px;">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Feedback Table</div>
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">NO</th>
              <th scope="col">CUSTOMER ID</th>
              <th scope="col">DATE</th>
              <th scope="col">MESSAGE</th>
              <th scope="col">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM feedback";
            $count = 0;
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
              $count += 1;
            ?>
              <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $row['customer_id']; ?> </td>
                <td><?php echo $row['date']; ?> </td>
                <td><?php echo $row['message']; ?> </td>
                <td>
                  <form method="POST" action="">
                    <input type="hidden" name="ids" value="<?php echo $row['feedback_id']; ?>">
                    <input type="submit" name="id" value="Delete" class="btn btn-danger delete-category-btn">
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Feedback Display End -->

</body>

</html>