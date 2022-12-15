<?php
// include database connection
include 'check_user_login.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order Form</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div>
        <?php include 'topnav.php'; ?>

        <div class="container">
            <div class="page-header d-flex justify-content-center my-3">
                <h1>Create Order</h1>
            </div>

            <!-- html form to create product will be here -->
            <!-- PHP insert code will be here -->
            <?php
            if ($_POST) {
                $user = $_POST['user'];
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $flag = 0;

                if ($flag == 0) {
                    include 'config/database.php';
                    try {
                        // insert query
                        $query = "INSERT INTO order_summary SET user=:user, order_time =:order_time";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':user', $user);
                        $order_time = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':order_time', $order_time);

                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Your order is created.</div>";

                            // Get and set order id to latest id
                            $query = "SELECT MAX(order_id) as order_id FROM order_summary";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $order_id = $row['order_id'];

                            for ($count = 0; $count < count($product_id); $count++) {
                                try {
                                    // insert query
                                    $query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                                    // prepare query for execution
                                    $stmt = $con->prepare($query);

                                    // bind the parameters
                                    // insert with latest order_id
                                    $stmt->bindParam(':order_id', $order_id);
                                    $stmt->bindParam(':product_id', $product_id[$count]);
                                    $stmt->bindParam(':quantity', $quantity[$count]);
                                    //echo $product_id[$count];
                                    // Execute the query
                                    if ($stmt->execute()) {
                                        echo "<div class='alert alert-success'>Details was saved.</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                                    }
                                }

                                // show error product_id
                                catch (PDOException $exception) {
                                    die('ERROR: ' . $exception->getMessage());
                                }
                            }
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
                        <td>Customer_username</td>
                        <td colspan="3">
                            <select class="form-select form-select-lg mb-3" name="user" aria-label=".form-select-lg example">
                                <option>Select Customer Username</option>
                                <?php
                                // include database connection
                                include 'config/database.php';
                                $query = "SELECT user_id, username FROM customers ORDER BY user_id DESC";
                                $stmt = $con->prepare($query);
                                $stmt->execute();

                                $num = $stmt->rowCount();
                                if ($num > 0) {

                                    // table body will be here
                                    // retrieve our table contents
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // extract row
                                        // this will make $row['firstname'] to just $firstname only
                                        extract($row);
                                        // creating new table row per record
                                        echo "<option value=\"$username\">$username</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>


                    <!-- For loop product row -->
                    <?php

                    echo "<tr class=\"pRow\">
                    <td>Product</td>
                    <td class=\"d-flex \">
                        <select class=\"form-select form-select-lg mb-3 col\" name=\"product_id[]\"  aria-label=\".form-select-lg example\">
                            <option>Select product</option>";
                    $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);

                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    echo "</select>

                    </td>
                    <td>Quantity</td>
                        <td>
                            <select class=\"form-select form-select-lg mb-3\" name=\"quantity[]\" aria-label=\".form-select-lg example\">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                            </select>
                        </td>
                </tr>";
                    ?>

                    <tr>
                        <td>
                            <input type="button" value="Add More Product" class="add_one btn btn-secondary" />
                            <input type="button" value="Delete" class="delete_one btn btn-danger" />
                        </td>
                        <td></td>
                    </tr>

                    <td></td>
                    <td colspan="3">
                        <input type='submit' value='Save' class='btn btn-primary' />
                    </td>
                    </tr>

                </table>
            </form>
        </div>

        <!-- end .container -->
        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var element = document.querySelector('.pRow');
                    var clone = element.cloneNode(true);
                    element.after(clone);
                }
                if (event.target.matches('.delete_one')) {
                    var total = document.querySelectorAll('.pRow').length;
                    if (total > 1) {
                        var element = document.querySelector('.pRow');
                        element.remove(element);
                    }
                }
            }, false);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>

</html>