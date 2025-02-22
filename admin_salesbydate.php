<?php
include('connection.php');

$dates = [];
$totals = [];

// Check if dates are submitted
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // SQL query to get total sales per day between selected dates
    $query = "
        SELECT om.date AS sale_date, SUM(o.total_price) AS daily_total
        FROM ordermaster om
        JOIN orders o ON om.ordermaster_id = o.ordermaster_id
        WHERE om.date BETWEEN '$start_date' AND '$end_date'
        GROUP BY om.date
        ORDER BY om.date";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $dates[] = $row['sale_date'];
        $totals[] = $row['daily_total'];
    }
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
 <!-- Sales Between Dates Start -->
    <h4 class="page-title" style="margin-bottom: 50px;">Sales Between Dates</h4>

    <div class="col-md-5" style="margin-left: 293px;">
        <div class="card">

            <div class="card-body">
                <form method="post" style="margin-bottom: 30px;">
                    <div class="row">
                        <div class="col-md-10" style="margin-bottom:5px; margin-left: 128px;">
                            <h6>Select The Dates Here</h6>
                        </div>

                        <div class="col-md-5" style="margin-left: 45px;">
                            <label for="start_date" style="display: block; margin-bottom: 8px;">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>" required style=" padding: 10px; margin-bottom: 16px;">
                        </div>
                        <div class="col-md-5">
                            <label for="end_date" style="display: block; margin-bottom: 8px;">End Date:</label>
                            <input type="date" id="end_date" name="end_date" value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>" required style=" padding: 10px; margin-bottom: 16px;">
                        </div>
                    </div>
                    <button type="submit" style="margin-left: 165px; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Show Sales</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Sales Between Dates End -->


    <div class="col-md-8" style="margin-left: 150px; margin-bottom: 100px;">
        <div class="card">
            <canvas id="salesByDateChart" style="width: 500px; height: 500px;"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('salesByDateChart').getContext('2d');
        const salesByDateChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'Total Sales Amount',
                    data: <?php echo json_encode($totals); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Sales Amount'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>