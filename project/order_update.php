<?php
include 'check_user_login.php';
?>

<!DOCTYPE html>

<html>

<head>
    <title>Update Order Summary</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid px-0">
        <?php include 'topnav.php'; ?>

        <div class="container">
            <div class="page-header">
                <h1>Update Order Summary</h1>
            </div>

            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM order_summary INNER JOIN order_details ON order_details.order_id = order_summary.order_id INNER JOIN products ON products.id = order_details.product_id WHERE order_summary.order_id = ?";

                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $order_id);

                // execute our query
                $stmt->execute();
                $num = $stmt->rowCount();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $order_id = $row['order_id'];
                $order_time = $row['order_time'];
                $user = $row['user'];
                $id = $row['id'];
                $name = $row['name'];
                $price = $row['price'];
                $quantity = $row['quantity'];
                $product_id = $row['product_id'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <?php
            // check if form was submitted
            if ($_POST) {
                $order_id = $_POST['order_id'];
                $order_time = $_POST['order_time'];
                $user = $_POST['user'];
                $id = $_POST['id'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $product_id = $_POST['product_id'];
                $error_message = "";

                try {
                    // write update query
                    // in this case, it seemed like we have so many fields to pass and
                    // it is better to label them and not use question marks
                    $query = "UPDATE order_summary SET order_id=:order_id, order_time=:order_time, user=:user WHERE order_id=:order_id";

                    //delete order detail and insert order like create order  maintain order_id and other

                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // posted values
                    $order_id = htmlspecialchars(strip_tags($_POST['order_id']));
                    $order_time = htmlspecialchars(strip_tags($_POST['order_time']));
                    $user = htmlspecialchars(strip_tags($_POST['user']));
                    // bind the parameters
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':order_time', $order_time);
                    $stmt->bindParam(':user', $user);
                    $id = htmlspecialchars(strip_tags($_POST['id']));
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                    $price = htmlspecialchars(strip_tags($_POST['price']));
                    $quantity = htmlspecialchars(strip_tags($_POST['quantity']));
                    $product_id = htmlspecialchars(strip_tags($_POST['product_id']));
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
                // show errors
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
            ?>

            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?order_id={$order_id}"); ?>" method="post" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Order ID</td>
                        <td colspan="3"><input type='text' name='order_id' value="<?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td colspan="3"><input type='text' name='order_time' value="<?php echo htmlspecialchars($order_time, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>

                    <tr>
                        <td>Username</td>
                        <td colspan="3">
                            <select class="form-select form-select-lg" name="user" aria-label=".form-select-lg example">
                                <option><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></option>
                                <?php
                                $query = "SELECT user_id, username FROM customers ORDER BY user_id DESC";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $row = $stmt->rowCount();
                                if ($row > 0) {
                                    // table body will be here
                                    // retrieve our table contents
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // extract row
                                        extract($row);
                                        // creating new table row per record
                                        echo "<option value=\"$username\">$username</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    
                    <?php
                    $query = "SELECT * FROM order_details INNER JOIN products ON products.id = order_details.product_id INNER JOIN order_summary ON order_summary.order_id = order_details.order_id WHERE order_details.order_id=:order_id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(":order_id", $order_id);
                    $stmt->execute();
                    $count = $stmt->rowCount();

                    if ($count > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr>
                            <td class='col-3'>Product</td>
                            <td class='col-3'><select class=\"form-select form-select\" aria-label=\".form-select example\" name=\"product_id[]\">
                            <option value=\"$name\">$name</option>";

                            $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                            $stmt_product = $con->prepare($query);
                            $stmt_product->execute();
                            $num = $stmt_product->rowCount();

                            if ($num > 0) {
                                while ($row = $stmt_product->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                                    echo "<option value=\"$id\">$name</option>";
                                }
                            }

                            echo "<td class='col-3'>Quantity</td>
                            <td class='col-3'>
                            <select class=\"form-select form-select\" aria-label=\".form-select example\" name=\"quantity[]\">
                            <option value=\"$quantity\">$quantity</option>
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option></td>
                            </select>
                            </tr>";
                        }
                    }
                    ?>

                    <tr>
                        <td></td>
                        <td colspan="3" class="text-end">
                            <input type='submit' value='Save Changes' class='btn btn-primary' />
                            <a href='order_summary.php' class='btn btn-danger'>Back to read order summary</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- end .container -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>