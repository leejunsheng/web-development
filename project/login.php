<?php
session_start();
?>



<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
  <?php include 'head.php'; ?>
</head>


<body>
    <!-- PHP code to read records will be here -->
    <!-- container -->
    <section class="h-100 bg-primary">

        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">

                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">

                        <div class="card-body p-5 text-center">
                            <?php
                            $action = isset($_GET['action']) ? $_GET['action'] : "";
                           
                            // if it was redirected from delete.php
                            if (isset($_GET['error']) && $_GET['error'] == 'access') {
                                echo "<div class='alert alert-danger'>You must be logged in to access this page.</div>";
                            }

                            if ($action == 'register') {
                                echo "<div class='alert alert-success'>Register successfully.</div>";
                            }
                            
                            if ($action == 'fail') {
                                echo "<div class='alert alert-danger'>Register fail.</div>";
                            }
                            ?>

                            <?php
                            // include database connection
                            include 'config/database.php';
                            if (isset($_POST['username']) && isset($_POST['password'])) {

                                $username = ($_POST['username']);
                                $password = md5($_POST['password']);
                                $query = " SELECT * FROM customers WHERE username = '$username'";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $num = $stmt->rowCount();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                if ($num == 1) {
                                    if ($row['password'] == $password) {
                                        if ($row['accstatus'] != "active") {
                                            echo "<div class='alert alert-danger'>Your Account is suspended.</div>";
                                        } else {
                                            $_SESSION["login"] = $username;
                                            $_SESSION['username'] = $username;
                                            $_SESSION['user_id'] = $current_user_id;
                                            header("Location: index.php");
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'>Incorrect Password.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>User not found.</div>";
                                }
                            };
                            ?>



                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your username and password!</p>

                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                                    <div class="form-floating text-dark">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="username" name="username">
                                        <label for="floatingInput">Username</label>
                                    </div>
                                    <div class="form-floating text-dark my-4">
                                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <button class="btn btn-outline-primary text-white btn-lg px-5" type="submit">Login</button>

                                    <div class="pt-3">
                                        <a href="customer_create.php">Dont' have an account? Register Now !</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>