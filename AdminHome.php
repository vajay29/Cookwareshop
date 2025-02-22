<?php
include('connection.php');
// Get the current page from the URL parameter
$page = isset($_GET['page']) ? $_GET['page'] : '';

// Define an array of valid pages for easy checking
$pages = [
	'dashboard',
	'category',
	'material',
	'brand',
	'product',
	'viewfeedback',
	'stock',
	'customer',
	'manageorder',
	'orderdetails',
	'orderhistory',
	'bestsellingproducts',
	'salesbybrand',
	'salesbydate'
];

// Check if the current page is one of the valid pages
$isValidPage = in_array($page, $pages);

?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>CookVerse</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="stylesheet" href="adminstyle/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="adminstyle/css/ready.css">
	<link rel="stylesheet" href="adminstyle/css/demo.css">

</head>

<body>

	<div class="wrapper">
		<div class="main-header">
			<div class="logo-header">
				<div class="logo">CookVerse</div>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg">
				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="adminstyle/img/profile.jpg" alt="user-img" width="36" class="img-circle"><span>Admin</span></span> </a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<div class="user-box">
										<div class="u-img"><img src="adminstyle/img/profile.jpg" alt="user"></div>
										<div class="u-text">
											<h4>Admin</h4>
											<p class="text-muted">admin@gmail.com</p>
										</div>
									</div>
								</li>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="sign_out.php"><i class="fa fa-power-off"></i> Logout</a>
							</ul>
							<!-- /.dropdown-user -->
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="sidebar">
			<div class="scrollbar-inner sidebar-wrapper">
				<ul class="nav">
					<li class="nav-item <?php echo $page === 'dashboard' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=dashboard">
							<i class="la la-black-tie"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'category' ? 'active' : ''; ?>">
						<a href="#">
							<p><strong>Manage</strong></p>
						</a>
						<a href="AdminHome.php?page=category">
							<i class="la la-tasks"></i>
							<p>Category</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'material' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=material">
							<i class="la la-table"></i>
							<p>Material</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'brand' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=brand">
							<i class="la la-certificate"></i>
							<p>Brand</p>

						</a>
					</li>
					<li class="nav-item <?php echo $page === 'product' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=product">
							<i class="la la-archive"></i>
							<p>Products</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'viewfeedback' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=viewfeedback">
							<i class="la la-envelope"></i>
							<p>Feedback</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'stock' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=stock">
							<i class="la la-home"></i>
							<p>Stock</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'customer' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=customer">
							<i class="la la-users"></i>
							<p>Customer</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'manageorder' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=manageorder">
							<i class="la la-list"></i>
							<p>Order</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'orderhistory' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=orderhistory">
							<i class="la la-list-alt"></i>
							<p>Order History</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#">
							<p><strong>Reports</strong></p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'bestsellingproducts' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=bestsellingproducts">
							<i class="la la-bar-chart"></i>
							<p>Best Selling Products</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'salesbybrand' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=salesbybrand">
							<i class="la la-pie-chart"></i>
							<p>Sales By Brand</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'salesbydate' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=salesbydate">
							<i class="la la-line-chart"></i>
							<p>Sales by selected dates</p>
						</a>
					</li>
					<li class="nav-item <?php echo $page === 'bestselling' ? 'active' : ''; ?>">
						<a href="AdminHome.php?page=bestselling">
							<i class="la la-keyboard-o"></i>
							<p>Best Selling Products</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="main-panel">
			<div class="content">
				<div class="container-fluid">
					<!-- Content based on selected page -->

					<?php
					if ($isValidPage) {
						include 'admin_' . $page . '.php';
					} else {
						include('admin_dashboard.php');
						include 'connection.php';
					}
					?>
				</div>
			</div>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul class="nav">
							<li class="nav-item">
								<p class="nav-link" href="http://www.themekita.com">

								</p>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">

								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="https://themewagon.com/license/#free-item">

								</a>
							</li>
						</ul>
					</nav>
					<div class="copyright ml-auto">
						Copyright &copy; 2024 All rights reserved | Made by Ajay
					</div>
				</div>
			</footer>
		</div>
	</div>

</body>

<script src="adminstyle/js/core/jquery.3.2.1.min.js"></script>
<script src="adminstyle/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="adminstyle/js/core/popper.min.js"></script>
<script src="adminstyle/js/core/bootstrap.min.js"></script>
<script src="adminstyle/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="adminstyle/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="adminstyle/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="adminstyle/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="adminstyle/js/plugin/chart-circle/circles.min.js"></script>
<script src="adminstyle/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="adminstyle/js/ready.min.js"></script>
<script src="adminstyle/js/demo.js"></script>

</html>