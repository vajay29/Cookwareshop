<!-- Dashboard Display Start -->
<h4 class="page-title">Dashboard</h4>
<div class="row">
  <?php
  $cilent_sql = "SELECT COUNT(*) AS clients FROM customer";
  $cilent_result = mysqli_query($conn, $cilent_sql); // Corrected variable name

  if ($cilent_result && mysqli_num_rows($cilent_result) > 0) {
    $cilent_row = mysqli_fetch_assoc($cilent_result);
    $clients = $cilent_row['clients'];
  }

  ?>
  <div class="col-md-3">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5">
            <div class="icon-big text-center icon-warning">
              <i class="la la-pie-chart text-warning"></i>
            </div>
          </div>
          <div class="col-7 d-flex align-items-center">
            <div class="numbers">
              <p class="card-category">Customers</p>
              <h4 class="card-title"><?php echo $clients; ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  $sale_sql = "SELECT COUNT(*) AS sales FROM payment WHERE payment_status = 'Completed'";
  $sale_result = mysqli_query($conn, $sale_sql); // Corrected variable name

  if ($sale_result && mysqli_num_rows($sale_result) > 0) {
    $sale_row = mysqli_fetch_assoc($sale_result);
    $sales = $sale_row['sales'];
  }

  ?>
  <div class="col-md-3">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5">
            <div class="icon-big text-center">
              <i class="la la-bar-chart text-success"></i>
            </div>
          </div>
          <div class="col-7 d-flex align-items-center">
            <div class="numbers">
              <p class="card-category">Total Sales</p>
              <h4 class="card-title"><?php echo $sales; ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  $pending_sql = "SELECT COUNT(*) AS pending_orders FROM ordermaster om JOIN customer c ON om.customer_id=c.customer_id 
                WHERE status NOT IN ('Delivered', 'Cancelled')";
  $pending_result = mysqli_query($conn, $pending_sql);

  if ($pending_result && mysqli_num_rows($pending_result) > 0) {
    $pending_row = mysqli_fetch_assoc($pending_result);
    $pending_orders = $pending_row['pending_orders'];
  }
  ?>
  <div class="col-md-3">
    <div class="card card-stats">
      <div class="card-body">
        <div class="row">
          <div class="col-5">
            <div class="icon-big text-center">
              <i class="la la-times-circle-o text-danger"></i>
            </div>
          </div>
          <div class="col-7 d-flex align-items-center">
            <div class="numbers">
              <p class="card-category">Pending Orders</p>
              <h4 class="card-title"><?php echo $pending_orders; ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard Display End -->


  <!-- Sales Report -->
  <div class="row mt-5">
    <div>
      <h4 class="page-title" style="margin-top:10px;margin-left:20px;">Sales Report</h4>
    </div>
    <div class="col-md-12">
      <?php
      // Fetch data for best-selling products
      $query = "
      SELECT p.product_name, SUM(o.total_price) AS total_amount
      FROM orders o
      JOIN product p ON o.product_id = p.product_id
      GROUP BY p.product_id
      ORDER BY total_amount DESC
      LIMIT 5";
      $result = mysqli_query($conn, $query);

      $productNames = [];
      $totalAmounts = [];

      while ($row = mysqli_fetch_assoc($result)) {
        $productNames[] = $row['product_name'];
        $totalAmounts[] = $row['total_amount'];
      }
      ?>
      <div class="card" style="height: 500px; padding: 20px; width:1200px;">
        <h4 class="card-header">Best Selling Products</h4>
        <div class="card-body" style="height: 400px;">
          <canvas id="bestSellingChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  <!-- Sales Report -->


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('bestSellingChart').getContext('2d');
    const bestSellingChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($productNames); ?>,
        datasets: [{
          label: 'Total Revenue ₹',
          data: <?php echo json_encode($totalAmounts); ?>,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '₹' + value; // Add ₹ before each tick value
              }
            }
          }
        },
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script>