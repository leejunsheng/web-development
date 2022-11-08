<!DOCTYPE HTML>
<html>

<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div>
        <nav class=" navbar navbar-expand-lg bg-primary">
            <div class="">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/product_create.php">Create Product</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/product_read.php">Read Product</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/customer_create.php">Create Customer</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/customer_read.php">Read Customer</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/create_new_order.php">Order Product</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/order_summary.php">Order Summary</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/order_details.php">Order Detail</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/contact_us.php">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php
        // include database connection
        include 'config/database.php';
        session_start();
        if (isset($_POST['username']) && isset($_POST['password'])) {

            $username = ($_POST['username']);
            $password = ($_POST['password']);

            $select = " SELECT * FROM customers WHERE username = '$username' && password = '$password' ";
            $result = mysqli_query($mysqli, $select);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                //print_r($row);
                if ($row['username'] === $username && $row['password'] === $password) {
                    if ($row['accstatus'] != "active") {
                        echo "<div class='alert alert-danger'>Your Account is suspended.</div>";
                    } else {
                        header("Location: index.php");
                    }
                }
            }

            $checkuser = " SELECT username FROM customers WHERE username = '$username'";
            $checkpass = " SELECT password FROM customers WHERE password = '$password'";

            $result2 = mysqli_query($mysqli, $checkuser);
            $row = mysqli_fetch_assoc($result2);
            if (mysqli_num_rows($result2) == 0) {
                echo "<div class='alert alert-danger'>User not found.</div>";
            } else {
                $result3 = mysqli_query($mysqli, $checkpass);
                $row = mysqli_fetch_assoc($result3);
                if (mysqli_num_rows($result3) == 0) {
                    echo "<div class='alert alert-danger'>Incorrect Password.</div>";
                }
            }
        };
        ?>

        <div class="container d-flex justify-content-center mt-5">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered '>
                    <div class="form-floating  ">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating ">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                        <label for="floatingPassword">Password</label>
                    </div>

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="w-50 btn btn-lg btn-primary" type="submit">Sign in</button>
                </table>
            </form>
        </div>
    </div>
</body>

</html>