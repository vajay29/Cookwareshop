<?php
include('connection.php');
ini_set('display_errors', 1);
if (isset($_GET['ordermaster_id'])) {
	$ordermaster_id = $_GET['ordermaster_id'];
	// Fetch product details from the database using $prod_id
	$sql = "SELECT o.*,d.*,p.payment_method,p.payment_date,p.payment_status FROM ordermaster o JOIN delivery_address d on o.deliveryaddress_id=d.deliveryaddress_id
	JOIN payment p ON o.ordermaster_id=p.ordermaster_id WHERE o.ordermaster_id='$ordermaster_id'";
	$order = mysqli_fetch_array(mysqli_query($conn, $sql));
	$order_status = $order['status'];
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
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

	<style>
		.cart-detail ul {
			list-style: none;
			padding: 0;
			margin: 20px 0;
		}

		.cart-detail ul li {
			display: flex;
			justify-content: space-between;
			padding: 10px 0;
			border-bottom: 1px solid #eee;
		}



		.table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
			border-collapse: collapse;
		}

		.table th,
		.table td {
			padding: 0.75rem;
			vertical-align: top;
			border: 1px solid #dee2e6;
		}

		.table th {
			font-weight: bold;
			text-align: left;
		}

		.table img {
			display: block;
			max-width: 80px;
			height: auto;
		}
	</style>

</head>

<body>
	<div class="row" style="margin-top: 20px;">
		<div class="col-md-12" style="margin-bottom: 50px;">
			<h3 class="tm-block-title"></h3>
			<a class="btn btn-primary" href="javascript:history.back()" style="margin-bottom: 20px;">Back</a>
			<div class="colorlib-product">
				<div class="container">
					<?php
					$sql = "SELECT d.* FROM ordermaster om 
                        JOIN delivery_address d ON om.deliveryaddress_id=d.deliveryaddress_id
                        WHERE ordermaster_id=$ordermaster_id";
					$result = mysqli_query($conn, $sql);
					$order = mysqli_fetch_array($result);

					?>
					<form id="orderForm">
						<input type="hidden" name="order_master_id" value="<?php echo $ordermaster_id; ?>">
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Sl No</th>
											<th>Image</th>
											<th>Product Name</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT p.*, om.*,od.*
										FROM product p
										JOIN orders od ON p.product_id = od.product_id
										JOIN ordermaster om ON od.ordermaster_id = om.ordermaster_id
										WHERE om.ordermaster_id = '$ordermaster_id'";

										$result = mysqli_query($conn, $sql);
										if ($result) {
											$cartsubtotal = 0;
											$count = 0;
											while ($product = mysqli_fetch_array($result)) {
												$total = $product['price'] * $product['quantity'];
												$cartsubtotal += $total;
												$count++;
										?>
												<tr>
													<td><?php echo $count; ?></td>
													<td>
														<img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" style="width: 80px; height: 80px; object-fit: cover;">
													</td>
													<td>
														<?php echo $product['product_name']; ?>
													</td>
													<td>₹<?php echo number_format($product['price'], 2); ?></td>
													<td><?php echo $product['quantity']; ?></td>
													<td>₹<?php echo number_format($total, 2); ?></td>
												</tr>
										<?php
											}
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
											<td>₹<?php echo number_format($cartsubtotal, 2); ?></td>
										</tr>
										<tr>
											<td colspan="5" class="text-right"><strong>Shipping:</strong></td>
											<td>₹50.00</td>
										</tr>
										<tr>
											<td colspan="5" class="text-right"><strong>Order Total:</strong></td>
											<td>₹<?php echo number_format(($cartsubtotal + 50), 2); ?></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="cart-detail col-lg-12">
								<div class="row">
									<div class="col-md-6">
										<div class="payment-address">
											<h4 class="mb-4">Shipping Address</h4>
											<p>
												<strong>Name:</strong> <?php echo $order['name']; ?><br>
												<strong>Address:</strong> <?php echo $order['address']; ?><br>
												<strong>Location:</strong> <?php echo $order['location']; ?><br>
												<strong>City/Town:</strong> <?php echo $order['city']; ?><br>
												<strong>Landmark:</strong> <?php echo $order['landmark']; ?><br>
												<strong>Pincode:</strong> <?php echo $order['pincode']; ?><br>
												<strong>Contact No.:</strong> <?php echo $order['mobile']; ?>
											</p>
										</div>
									</div>

									<div class="col-md-6">
										<div class="payment-address">
											<h4 class="mb-4">Payment Method</h4>
											<?php
											$sql = "SELECT o.*,p.* FROM payment p JOIN ordermaster o ON p.ordermaster_id =o.ordermaster_id  WHERE o.ordermaster_id='$ordermaster_id'";
											$result = mysqli_query($conn, $sql);
											$payment = mysqli_fetch_array($result);
											?>
											<p>
												<strong>Payment Method:</strong> <?php echo $payment['payment_method']; ?><br>
												<strong>Status:</strong> <?php echo $payment['payment_status']; ?><br>
											</p>
										</div>
										<div class="row">
											<div class="col-md-12 text-center">
												<div class="form-group staffdiv">
													<?php
													$sql = "SELECT status FROM ordermaster WHERE ordermaster_id = '$ordermaster_id'";
													$result = mysqli_query($conn, $sql);
													$row = mysqli_fetch_array($result);
													$order_status = $row['status'];
													if ($order_status != 'Delivered' && $order_status != 'Cancelled') { ?>
														<label for="order-status-select">Order Status:</label>
														<select name="order_status" id="order-status-select" class="form-control">
															<option value="" disabled selected>Select Status</option>
															<option value="delivered">Delivered</option>
															<!-- <option value="cancelled">Cancelled</option> -->
														</select>
														<input type="submit" class="btn btn-primary" name="update_status" value="Update Status" style="margin-top: 20px;">
													<?php } else { ?>
														<p>Order Status: <strong><?php echo ucfirst($order_status); ?></strong></p>
														<input type="hidden" name="order_status" value="<?php echo htmlspecialchars($order_status); ?>">
													<?php } ?>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<!-- Search Functionality Script -->
	<script>
		document.getElementById('orderForm').addEventListener('submit', function(event) {
			event.preventDefault(); // Prevent the form from submitting normally

			var formData = new FormData(this);
			var action = 'update_status.php';

			var xhr = new XMLHttpRequest();
			xhr.open('POST', action, true);
			xhr.onload = function() {
				if (xhr.status === 200) {
					try {
						var response = JSON.parse(xhr.responseText);
						Toastify({
							text: response.message,
							backgroundColor: response.status === 'success' ? 'green' : 'red',
							duration: 3000
						}).showToast();

						if (response.status === 'success') {
							var formGroupDiv = document.querySelector('.staffdiv');
							if (action === 'update_status.php') {
								// Update the content of the form-group div
								formGroupDiv.innerHTML =

									'<p>Order Status: <strong>' + response.updated_status + '</strong></p>';
							}
						}
					} catch (e) {
						console.error('Failed to parse JSON response:', e);
						Toastify({
							text: 'Failed to parse response.',
							backgroundColor: 'red',
							duration: 3000
						}).showToast();
					}
				} else {
					Toastify({
						text: 'An error occurred while processing the request.',
						backgroundColor: 'red',
						duration: 3000
					}).showToast();
				}
			};
			xhr.send(formData);
		});
	</script>


</body>

</html>