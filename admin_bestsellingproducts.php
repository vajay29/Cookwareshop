<?php
include('connection.php');

$query = "
    SELECT p.product_name, SUM(o.total_price) AS total_amount
    FROM orders o
    JOIN product p ON o.product_id = p.product_id
    GROUP BY p.product_id
    ORDER BY total_amount DESC
    LIMIT 5"; // Adjust the limit if needed
$result = mysqli_query($conn, $query);

$productNames = [];
$totalAmounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $productNames[] = $row['product_name'];
    $totalAmounts[] = $row['total_amount'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookVerse</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <h4 class="page-title" style="margin-bottom: 50px;">Best Selling Products</h4>

    <div class="col-md-8" style="margin-left: 150px;margin-bottom: 100px;  ">
        <div class="card">
            <canvas id="bestSellingChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('bestSellingChart').getContext('2d');
        const bestSellingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productNames); ?>,
                datasets: [{
                    label: 'Total Amount Sold',
                    data: <?php echo json_encode($totalAmounts); ?>, // No need to concatenate '₹' here
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


</body>

</html>