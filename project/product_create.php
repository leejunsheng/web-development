<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"> </script>
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
            $name = $_POST["name"];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $promotion_price = $_POST['promotion_price'];
            $manufacture_date = $_POST['manufacture_date'];
            $expired_date = $_POST['expired_date'];
            $date1 = date_create($manufacture_date);
            $date2 = date_create($expired_date);
            $diff = date_diff($date1, $date2);
            $result = $diff->format("%R%a");
            $flag = 0;

            if ($name == "" || $description == "" ||  $manufacture_date == "") {
                echo "Please make sure all field are not empty.";
                $flag =1;
            }

            if ($price == "") {
                echo "Please make sure price are not empty";
                $flag = 1;
            } elseif (preg_match('/[A-Z]/', $price)) {
                echo "Please make sure price are not contain capital A-Z";
                $flag = 1;
            } elseif (preg_match('/[a-z]/', $price)) {
                echo "Please make sure price are not contain capital a-z";
                $flag = 1;
            }elseif ($price < 0){
                echo "Please make sure price are not negative";
                $flag = 1;
            }elseif ($price > 1000){
                echo "Please make sure price are not more than RM1000";
                $flag = 1;
            }

            if ($promotion_price == "") {
                $promotion_price = NULL;
            }

            if($promotion_price > $price){
                echo "Please make sure promotion price is not more than normal price";
                $flag =1;
            }

            if ($expired_date == "") {
                $expired_date = NULL;
            }

            if ($result < "0") {
                $flag = 1;
                echo "Please make sure expired date is not earlier than manufacture date";
            }

            if ($flag == 0) {
                // include database connection
                include 'config/database.php';

                try {
                    // insert query
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date,expired_date=:expired_date,created=:created";

                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $created = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':created', $created);

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
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>

                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type='text' name='description' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Promotion_price</td>
                    <td><input type='text' name='promotion_price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture_date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired_date</td>
                    <td><input type='date' name='expired_date' class='form-control' /></td>
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