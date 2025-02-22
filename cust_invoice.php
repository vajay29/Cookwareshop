<?php
session_start();
include('connection.php');
require 'vendor/autoload.php'; // Ensure this path is correct for PHPMailer and Dompdf

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;

$master_id = $_SESSION['master_id'];

// Set the desired time zone
date_default_timezone_set('Asia/Kolkata'); // Change to your preferred time zone

// Fetch product details including product names based on the master_id
$sql = "SELECT om.*, p.*,od.* 
        FROM ordermaster om 
        JOIN orders od ON om.ordermaster_id = od.ordermaster_id 
        JOIN product p ON od.product_id = p.product_id 
        WHERE om.ordermaster_id = '$master_id'";


$result = mysqli_query($conn, $sql);

$products = array();
while ($row = mysqli_fetch_assoc($result)) {
  $products[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GST Bill</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    .bill {
      border: 1px solid #000;
      padding: 20px;
    }

    .header {
      text-align: center;
    }

    .customer-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    /* .customer-info div {
      width: 15%; 
    } */

    .items {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    .items th,
    .items td {
      border: 1px solid #000;
      padding: 10px;
      text-align: left;
    }

    .total {
      margin-top: 20px;
    }

    .total p,
    .total h3 {
      text-align: right;
    }

    .preloader-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 9999;
      transition: opacity 0.3s ease;
    }

    .preloader-text {
      color: #fff;
      font-size: 24px;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="preloader-container" id="preloader">
    <div class="preloader-text" style="text-align: center;">
      Order place<br>Generating Bill...
    </div>

  </div>
  <div id="billContainer" style="display: none;">
    <div class="bill">
      <div class="header">
        <h1>Cook Verse</h1>
        <h3>GSTIN: 32ABEPN1239AA<br>Ernakulam,Kerala</h3>
      </div>
      <div class="customer-info">
        <div>
          <p>Invoice No: <?php echo $_SESSION['master_id']; ?><br>Name: <?php echo $_SESSION['CustomerName'] ?><br></p>
          <p></p>
        </div>
        <div>
          <p>Date: <?php echo date('d-m-Y'); ?><br>Time: <?php echo date('h:i A'); ?></p>
          <p></p>
        </div>
      </div>

      <table class="items">
        <thead>
          <tr>
            <th>SI NO</th>
            <th>Item</th>
            <th>Quantity</th>
            <!-- <th>Tax %</th> -->
            <th>Price (per unit)</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $serialNumber = 1; // Initialize the serial number
          foreach ($products as $product) : ?>
            <tr>
              <td><?php echo $serialNumber++; ?></td> <!-- Increment serial number for each row -->
              <td><?php echo $product['product_name']; ?></td>
              <td><?php echo $product['quantity']; ?></td>
              <!-- <td>18.00</td> -->
              <td>₹<?php echo $product['price']; ?></td>
              <td>₹<?php echo $product['total_price']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="total">
        <?php
        $totalAmount = array_reduce($products, function ($sum, $product) {
          return $sum + $product['total_price'];
        }, 0);

        $Shipping = 40.00;
        $grandTotal = $totalAmount + $Shipping;

        $email = $_SESSION['username']; // Adjust as needed

        $invoiceHtml = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>GST Bill</title>
            <style>
                body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
                .bill { border: 1px solid #000; padding: 20px; }
                .header, .company, .description { text-align: center; }
                .customer-info, .total { margin-bottom: 20px; }
                .items { width: 100%; border-collapse: collapse; }
                .items th, .items td { border: 1px solid #000; padding: 10px; text-align: left; }
                .total p, .total h3 { text-align: right; }
            </style>
        </head>
        <body>
        <div class="bill">
            <div class="header">
                <h1>Cook Verse</h1>
                <h3>GSTIN: 32ABEPN1239AA<br>Ernakulam,Kerala</h3>
            </div>
            <div class="customer-info">
                <p>Invoice No: ' . $_SESSION['master_id'] . '<br>Name: ' . $_SESSION['CustomerName'] . '</p>
                <p>Date: ' . date('d-m-Y') . '<br>Time: ' . date('h:i A') . '</p>
            </div>
            <table class="items">
                <thead>
                    <tr><th>SI NO</th><th>Item</th><th>Quantity</th><th>Price (per unit)</th><th>Total</th></tr>
                </thead>
                <tbody>';
        $serialNumber = 1;
        foreach ($products as $product) {
          $invoiceHtml .= "<tr><td>{$serialNumber}</td><td>{$product['product_name']}</td><td>{$product['quantity']}</td><td>&#8377;{$product['price']}</td><td>&#8377;{$product['total_price']}</td></tr>";

          $serialNumber++;
        }
        $invoiceHtml .= '
                </tbody>
            </table>
            <div class="total">
                <p>Total Amount: ₹' . number_format($totalAmount, 2) . '</p>
                <p>Shipping: ₹' . number_format($Shipping, 2) . '</p>
                <h3>Grand Total: ₹' . number_format($grandTotal, 2) . '</h3>
            </div>
            <div class="description">
                <h4><u>DESCRIPTION</u></h4>
                <p>I/ We hereby certify that my / our Registration certificate under The GST Act 2017 <br>
          is in force on the date on which the sale of the goods specified in this bill / cash <br>
          Memorandum is made by me /lus and that the transaction of sale covered by this bill/ cash <br>
          memorandum has been effected by my hus in the regular course of my / our business.</p>
            </div>
            <div class="company">
                <p><b>Cook Verse</b></p>
            </div>
        </div>
        </body>
        </html>';

        // Generate PDF using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($invoiceHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        // Define a safe path to save the PDF on Windows
        $tempDir = sys_get_temp_dir(); // Get the system's temporary directory
        $pdfPath = $tempDir . DIRECTORY_SEPARATOR . 'invoice_' . $master_id . '.pdf';

        if (file_put_contents($pdfPath, $pdfOutput) === false) {
          echo "Error: Unable to write PDF file to $pdfPath";
          exit;
        }

        // Send email with attachment
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'gentriusprojects@gmail.com';
        $mail->Password = 'lbef xirr qxgq tsix'; // Replace with your actual password
        $mail->setFrom('gentriusprojects@gmail.com', 'Cookware shop');
        $mail->addAddress($email);
        $mail->Subject = 'Your Invoice';
        $mail->Body = 'Dear customer, please find attached the invoice for your recent purchase.';
        $mail->addAttachment($pdfPath);
        if (!$mail->send()) {
          echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
          echo 'Invoice sent successfully!';
        }
        ?>

        <p>Total Amount: ₹<?php echo number_format($totalAmount, 2); ?></p>
        <p>Shipping : ₹<?php echo number_format(40, 2); ?></p>
        <h3>Grand Total: ₹<?php echo number_format($grandTotal, 2); ?></h3>
      </div>
      <div class="description">
        <h4><u>DESCRIPTION</u></h4>
        <p>
          I/ We hereby certify that my / our Registration certificate under The GST Act 2017 <br>
          is in force on the date on which the sale of the goods specified in this bill / cash <br>
          Memorandum is made by me /lus and that the transaction of sale covered by this bill/ cash <br>
          memorandum has been effected by my hus in the regular course of my / our business.</p>
      </div>
      <div class="company">
        <p><b>Cook Verse</b></p>
      </div>
      <a href="cust_home.php">
        <center>HOME/BACK TO SHOP</center>
      </a>
    </div>


    <!-- <form action="gst.php" method="post">
  <button type="submit" name="sendmail">Send Mail</button>
    </form> -->
    <!-- Add this button to your HTML file -->
    <button onclick="printBill()">Print Bill</button>

    <script>
      function showPreloader() {
        document.getElementById('preloader').style.display = 'flex';
        setTimeout(function() {
          document.getElementById('preloader').style.display = 'none';
          document.getElementById('billContainer').style.display = 'block';
        }, 3000); // Show the preloader for 3 seconds
      }

      function printBill() {
        window.print();
      }

      // Call the showPreloader function when the page loads
      window.onload = showPreloader;
    </script>
  </div>

</body>

</html>