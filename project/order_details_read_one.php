<?php
// include database connection
include 'check_user_login.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Order Detail - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'topnav.php'; ?>

    <!-- container -->
    <div class="container">
        <div class="page-header my-3">
            <h1>Read One Order Details</h1>
        </div>

        <!-- PHP read one record will be here -->

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        if (isset($_GET['order_id']) && isset($_GET['product_id'])) {
            $order_id = $_GET['order_id'];
            $product_id = $_GET['product_id'];
        } else {
            die('ERROR: Record ID not found.');
        }

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM order_details INNER JOIN products ON order_details.product_id = products.id WHERE order_id = ? && product_id = ?";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(1, $order_id);
            $stmt->bindParam(2, $product_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            extract($row);

            $query = "SELECT user, order_time FROM order_summary WHERE order_id =:order_id ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":order_id", $order_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
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
                <td>Order Date</td>
                <td><?php echo htmlspecialchars($order_time, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Order ID</td>
                <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Product Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Price per unit</td>
                <?php $format_price = number_format((float)$price, 2, '.', ''); ?>
                <td><?php echo htmlspecialchars($format_price, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Total Price</td>
                <?php $format_total_price = number_format((float)$price * $quantity, 2, '.', ''); ?>
                <td><?php echo $format_total_price;  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='order_details.php' class='btn btn-secondary'>Back to read Order Details</a>
                </td>
            </tr>
        </table>


    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

</body>

</html>