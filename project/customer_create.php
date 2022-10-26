<!DOCTYPE HTML>
<html>

<head>
    <title>Customer Create</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"> </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
</head>

<body>
    <!-- container -->
    <div>
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="nav-link text-white" aria-current="page" href="http://localhost/web/project/index.php">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/product_create.php">Create Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/customer_create.php">Create Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/contact_us.php">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- html form to create product will be here -->

        <!-- PHP insert code will be here -->
        <?php




        if ($_POST) {
            $user_name = $_POST["username"];
            $pass_word = $_POST['password'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $datebirth = $_POST['datebirth'];
            $accstatus = $_POST['accstatus'];
        

          

           /* if ($name == "" || $description == "" || $price == "" ||  $promotion_price == "" ||  $manufacture_date == "" || $expired_date == "") {
                echo "Please make sure all field are not empty.";
            } elseif ($promotion_price >= $price) {
                echo "Please make sure promotion price is not more than normal price";
            } elseif ($result < "0") {
                echo "Please make sure expired date is not earlier than manufacture date";
            } else { */
                // include database connection
                include 'config/database.php';

                try {
                    // insert query
                    $query = "INSERT INTO customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname,gender=:gender,datebirth=:datebirth,registration_dt=:registration_dt,accstatus=:accstatus";

                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':username', $user_name);
                    $stmt->bindParam(':password', $pass_word);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':datebirth', $datebirth);

                    $registration_dt = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':registration_dt', $registration_dt);

                    $stmt->bindParam(':accstatus', $accstatus);




                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        

        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' /></td>

                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First name</td>
                    <td><input type='text' name='firstname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td><input type='text' name='lastname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input class="form-check-input" type="radio" name='gender' value="Male">
                        <label class="form-check-label" for="gender">
                            Male
                        </label>

                        <input class="form-check-input" type="radio" name='gender' value="Female">
                        <label class="form-check-label" for="gender">
                            Female
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Datebirth</td>
                    <td><input type='date' name='datebirth' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type='text' name='accstatus' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="container">
            <footer class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="http://localhost/web/project/index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-muted" href="http://localhost/web/project/product_create.php">Create Product</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  text-muted" href="http://localhost/web/project/customer_create.php">Create Customer</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  text-muted" href="http://localhost/web/project/contact_us.php">Contact Us</a>
                    </li>
                </ul>
                <p class="text-center text-muted">© 2022 Company, Inc</p>
            </footer>
        </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>