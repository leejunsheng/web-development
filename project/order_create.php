<?php
// include database connection
include 'check_user_login.php';
?>



<!DOCTYPE HTML>
<html>

<head>
    <title>Create New Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'topnav.php'; ?>
    <div class="container-fluid px-0">
        <!-- container -->
        <div class="container my-3">

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
                $error_msg = "";

                if ($user == "Please select username") {
                    $error_msg .= "<div>Please make sure you have seleted username.</div>";
                }

                if ($product_id == ["Please select product"]) {
                    $error_msg .= "<div>Please make sure you have seleted product.</div>";
                }

                if ($quantity <= ["0"]) {
                    $error_msg .= "<div >Please make sure quantity cannot be 0.</div>";
                }

                if (!empty($error_msg)) {
                    echo "<div class='alert alert-danger'>{$error_msg}</div>";
                } else {
                    // include database connection
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
                                        header("Location:order_summary_read_one.php?order_id={$order_id}");
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
                <table id='delete_row' class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Customer_username</td>
                        <td colspan="4">
                            <select class="form-select form-select mb-3" name="user" aria-label=".form-select example">
                                <option>Please select username</option>
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
                        <select class=\"form-select form-select mb-3 col\" name=\"product_id[]\"  aria-label=\".form-select example\">
                            <option>Please select product</option>";
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
                        <td class='col-2'><input type='number' name='quantity[]' value='1' min='1' class='form-control' /></td>
                        <td class='col-1'><input type='button' value='Delete' class='btn btn-danger mt-2' onclick='deleteRow(this)'></td>
                </tr>";
                    ?>
                    <td colspan="">
                        <input type="button" value="Add More Product" class="add_one btn btn-secondary" />
                    </td>
                    <td colspan="4" class="text-end">
                        <input type='submit' value='Create Order' class='btn btn-primary me-2' onclick="checkDuplicate(event)" />
                    </td>
                    </tr>

                </table>
            </form>
        </div>
    </div>

 <!-- end .container -->

    <?php include 'script.php'; ?>

    <?php /*
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
        </script> */ ?>

    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add_one')) {
                var rows = document.getElementsByClassName('pRow');
                // Get the last row in the table
                var lastRow = rows[rows.length - 1];
                // Clone the last row
                var clone = lastRow.cloneNode(true);
                // Insert the clone after the last row
                lastRow.insertAdjacentElement('afterend', clone);

                // Loop through the rows
                for (var i = 0; i < rows.length; i++) {
                    // Set the inner HTML of the first cell to the current loop iteration number
                    rows[i].cells[0].innerHTML = i + 1;
                }
            }
        }, false);
    </script>

    <script>
        function deleteRow(r) {
            var total = document.querySelectorAll('.pRow').length;
            if (total > 1) {
                var i = r.parentNode.parentNode.rowIndex;
                document.getElementById("delete_row").deleteRow(i);
            } else {
                alert("Product row must at least one");
            }
        }
    </script>

    <script>
        function checkDuplicate(event) {
            var newarray = [];
            var selects = document.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                newarray.push(selects[i].value);
            }
            if (newarray.length !== new Set(newarray).size) {
                alert("There are duplicate item in the same time");
                event.preventDefault();
            }
        }
    </script>
</body>

</html>