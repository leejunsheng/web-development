<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>

    <!-- container -->
    <div>
        <nav class=" navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
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

        <div class="page-header">
            <h1>Read Product</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, description, price,promotion_price FROM products WHERE id = :id ";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":id", $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            // shorter way to do that is extract($row)
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>


        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Promotion_price</td>
                <td><?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='index.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>

    </div> <!-- end .container -->

</body>

</html>