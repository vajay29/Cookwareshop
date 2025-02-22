<?php
session_start();
include('connection.php');

$name = $location = $contactno = $email = $password = $confpassword = "";

if (isset($_POST["custreg"])) {

    $customername = $_POST['name'];
    $custemail = $_POST['email'];
    $custphone = $_POST['phone'];
    $custpassword = $_POST['password'];
    $user = "customer";


    $sql = "SELECT * FROM customer WHERE email='$custemail'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        echo '<script>alert("User with this email already exists. Please choose a different email.");</script>';
    } else {

        $sql = "INSERT INTO customer(name,email,phone) VALUES('$customername','$custemail','$custphone')";
        if (mysqli_query($conn, $sql)) {

            $sql = "INSERT INTO login(email,password,usertype) VALUES ('$custemail','$custpassword','$user')";
            mysqli_query($conn, $sql);

            //for email
            require 'vendor/autoload.php'; //Create an instance; passing true enables exceptions
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            // Use SMT
            $mail->isSMTP();

            // SMTP settings
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'gentriusprojects@gmail.com';
            $mail->Password = 'lbef xirr qxgq tsix';

            // Set 'from' email address and name
            $mail->setFrom('vgajay11@gmail.com', 'CookVerse');

            // Add a recipient email address
            $mail->addAddress($custemail);

            // Email subject and body
            $mail->Subject = 'Welcome to CookVerse!';
            $mail->Body = "Dear $customername,\n\n" .   // Include user name
                "Welcome to CookVerse! We're thrilled to have you join our community of cooking enthusiasts and home chefs.\n\n" .
                "At CookVerse, we bring you the best in cookware and kitchen essentials from a wide selection of top brands. Whether you’re looking for premium cookware, bakeware, or kitchen gadgets, we’ve got you covered!\n\n" .
                "Here are the details of your registration:\n\n" .
                "- Email: $custemail\n" .  // Include email
                "- Registration Date: " . date('Y-m-d') . "\n\n" .  // Include registration date
                
                "If you have any questions or need help selecting the perfect cookware, feel free to reach out to our support team at support@cookverse.com. We’re here to help make your cooking experience exceptional!\n\n" .
                "Happy Cooking!\n\n" .
                "Warm regards,\n" .
                "The CookVerse Team\n" .
                "+91 9496722757\n" .
                "www.cookverse.com";
            

            // Send email
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                // echo 'Message sent!';
            }
?>
            <script type="text/javascript" src="swal/jquery.min.js"></script>
            <script type="text/javascript" src="swal/bootstrap.min.js"></script>
            <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // SweetAlert initialization code goes here
                    Swal.fire({
                        icon: 'success',
                        text: 'Successfully Registered',
                        didClose: () => {
                            window.location.replace('login.php');
                        }
                    });
                });
            </script>
<?php
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>CookVerse</title>

    <!-- ::::::::::::::Favicon icon::::::::::::::-->
    <link rel="shortcut icon" href="mainstyle/images/favicon.ico" type="image/png">

    <!-- ::::::::::::::All CSS Files here :::::::::::::: -->
    <!-- Vendor CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="mainstyle/css/vendor/ionicons.css">
    <link rel="stylesheet" href="mainstyle/css/vendor/simple-line-icons.css">
    <link rel="stylesheet" href="mainstyle/css/vendor/jquery-ui.min.css"> -->

    <!-- Plugin CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/animate.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/nice-select.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/venobox.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/jquery.lineProgressbar.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/aos.min.css"> -->

    <!-- Main CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/sass/style.css"> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="mainstyle/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/plugins.min.css">
    <link rel="stylesheet" href="mainstyle/css/style.min.css">



    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?php include('headers/MainHeader.php')  ?>

    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Register</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li>Home</li>
                                    <li>Shop</li>
                                    <li class="active" aria-current="page">Register</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Customer Login Section :::... -->
    <div class="customer-login">
        <div class="container" style="margin-left:450px;">
            <div class="row">
                <!--login area start-->

                <!--login area start-->

                <!--register area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form register" data-aos="fade-up" data-aos-delay="200">
                        <h3 style="margin-left:200px;">Register</h3>
                        <form id="sign-in-form" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" class="sign-in-form">
                            <div class="default-form-box">
                                <label>Name</label>
                                <input type="text" id="name" name="name" required>
                                <span id="nameError" class="error"></span>
                            </div>
                            <div class="default-form-box">
                                <label>Email</label>
                                <input type="text" id="email" name="email" required>
                                <span id="emailError" class="error"></span>
                            </div>
                            <div class="default-form-box">
                                <label>Phone number</label>
                                <input type="text" id="phone" name="phone" required>
                                <span id="phoneError" class="error"></span>
                            </div>
                            <div class="default-form-box">
                                <label>Password</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <div class="default-form-box">
                                <label>Confirm Password</label>
                                <input type="password" id="confpassword" name="confirmpassword" >
                                <span id="passwordError" class="error"></span>
                            </div>
                            <div class="login_submit" style="margin-left:200px;">
                                <button class="btn btn-md btn-black-default-hover" name="custreg" id="submit" type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--register area end-->
            </div>
        </div>
    </div> <!-- ...:::: End Customer Login Section :::... -->

    <?php include('footers/footer.php')  ?>

    <!-- material-scrolltop button -->
    <button class="material-scrolltop" type="button"></button>


    <!-- ::::::::::::::All JS Files here :::::::::::::: -->
    <!-- Global Vendor, plugins JS -->
    <!-- <script src="mainstyle/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="mainstyle/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="mainstyle/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="mainstyle/js/vendor/popper.min.js"></script>
    <script src="mainstyle/js/vendor/bootstrap.min.js"></script>
    <script src="mainstyle/js/vendor/jquery-ui.min.js"></script>  -->

    <!--Plugins JS-->
    <!-- <script src="mainstyle/js/plugins/swiper-bundle.min.js"></script>
    <script src="mainstyle/js/plugins/material-scrolltop.js"></script>
    <script src="mainstyle/js/plugins/jquery.nice-select.min.js"></script>
    <script src="mainstyle/js/plugins/jquery.zoom.min.js"></script>
    <script src="mainstyle/js/plugins/venobox.min.js"></script>
    <script src="mainstyle/js/plugins/jquery.waypoints.js"></script>
    <script src="mainstyle/js/plugins/jquery.lineProgressbar.js"></script>
    <script src="mainstyle/js/plugins/aos.min.js"></script>
    <script src="mainstyle/js/plugins/jquery.instagramFeed.js"></script>
    <script src="mainstyle/js/plugins/ajax-mail.js"></script> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="mainstyle/js/vendor/vendor.min.js"></script>
    <script src="mainstyle/js/plugins/plugins.min.js"></script>

    <!-- Main JS -->
    <script src="mainstyle/js/main.js"></script>
    <script src="mainstyle/js/validation.js"></script>
</body>

</html>