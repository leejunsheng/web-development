<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>


<body>
    <!-- container -->
    <div class="bg-danger vh-100">
        <div class="d-flex justify-content-center align-item-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 ">
                <div class="card bg-dark text-white rounded-3 ">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <?php
                            // include database connection
                            include 'config/database.php';
                            if (isset($_POST['username']) && isset($_POST['password'])) {

                                $username = ($_POST['username']);
                                $password = ($_POST['password']);
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
                                            $_SESSION['user_id'] = $user_id;

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

                            <?php if ($_GET) {
                                echo "<div class='alert alert-danger'>Please make sure you are login.</div>";
                            } ?>

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
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>