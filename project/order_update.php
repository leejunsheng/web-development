<?php
include 'check_user_login.php';
?>

<?php include 'topnav.php'; ?>

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


        <div class="container">
            <div class="page-header">
                <h1>Update Order Summary</h1>
            </div>

            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            include 'config/database.php';
            $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

            if ($_POST) {
                $user = $_POST['user'];
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $error_msg = "";

                if ($user == "Please select username") {
                    $error_msg .= "<div class='alert alert-danger'>Please make sure you have seleted username</div>";
                }

                if ($product_id == ["Please select product"]) {
                    $error_msg .= "<div class='alert alert-danger'>Please make sure you have seleted product</div>";
                }

                if ($quantity <= ["0"]) {
                    $error_msg .= "<div class='alert alert-danger'>Please make sure quantity cannot be 0</div>";
                }

                if (!empty($error_message)) {
                    echo "<div class='alert alert-danger'>{$error_message}</div>";
                } else {
                    try {
                        // insert query
                        $query = "UPDATE order_summary SET user=:user, order_time=:order_time WHERE order_id=:order_id";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':user', $user);
                        $order_time = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':order_time', $order_time);
                        $stmt->bindParam(':order_id', $order_id);

                        // Execute the query and delete existing order details
                        if ($stmt->execute()) {
                            // echo "<div class='alert alert-success'>Your order is updated.</div>";

                            $query = "DELETE FROM order_details WHERE order_id=:order_id";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':order_id', $order_id);

                            // insert new order details
                            if ($stmt->execute()) {
                                $purchased = 0;
                                for ($count = 0; $count < count($product_id); $count++) {
                                    try {
                                        // insert query
                                        $query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                                        // prepare query for execution
                                        $stmt = $con->prepare($query);
                                        // bind the parameters
                                        $stmt->bindParam(':order_id', $order_id);
                                        $stmt->bindParam(':product_id', $product_id[$count]);
                                        $stmt->bindParam(':quantity', $quantity[$count]);


                                        // Execute the query
                                        $record_number = $count + 1;

                                        if ($stmt->execute()) {
                                            $purchased++;
                                        } else {
                                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                                        }
                                    }
                                    // show errorproduct_id
                                    catch (PDOException $exception) {
                                        die('ERROR: ' . $exception->getMessage());
                                    }
                                }

                                // check if all records were inserted successfully
                                if ($purchased == count($product_id)) {
                                    echo "header";
                                } else {
                                    echo "<div class='alert alert-danger'>Not all product have been purchased .</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Unable to delete existing order details</div>";
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

            try {
                // prepare select query
                $query = "SELECT * FROM order_summary WHERE order_summary.order_id =:order_id";
                $stmt = $con->prepare($query);
                $stmt->bindParam(":order_id", $order_id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }

            ?>

            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?order_id={$order_id}"); ?>" method="post" enctype="multipart/form-data">
                <table id='delete_row' class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Username</td>
                        <td colspan="4">
                            <select class="form-select form-select" name="user" aria-label=".form-select example">
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

                    $query = "SELECT * FROM order_details INNER JOIN products ON products.id = order_details.product_id WHERE order_details.order_id=:order_id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(":order_id", $order_id);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr class='pRow'>
                            <td class='col-3'>Product</td>
                            <td class='col-3'><select class=\"form-select form-select\" aria-label=\".form-select example\" name=\"product_id[]\">
                            <option value=\"$id\">$name</option>";
                            $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                            $stmt2 = $con->prepare($query);
                            $stmt2->execute();
                            $num = $stmt2->rowCount();
                            if ($num > 0) {
                                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                                    echo "<option value='$id'>$name</option>";
                                }
                            }
                            echo "<td class='col-3'>Quantity</td>
                            <td class='col-3'>
                            <input type='number' name='quantity[]' value='$quantity' class='form-control' min='1' /></td>
                            <td><input type='button' value='Delete' class='btn btn-danger mt-2' onclick='deleteRow(this)'></td>
                            </tr>";
                        }
                    }
                    ?>

                    <tr>
                        <td>
                            <input type="button" value="Add More Product" class="add_one btn btn-secondary" />
                        </td>
                        <td colspan=4 class="text-end">
                            <!--<button type="button">Check duplicate product</button>-->
                            <input type='submit' value='Update' class='btn btn-primary' onclick="checkDuplicate(event)" />
                            <a href='order_summary.php' class='btn btn-danger'>Back to read order summary</a>

                        </td>
                    </tr>
                </table>
            </form>

        </div>
        <!-- end .container -->
    </div>

    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add_one')) {
                var element = document.querySelector('.pRow');
                var clone = element.cloneNode(true);
                element.after(clone);
            }

        }, false);

        function deleteRow(r) {
            var total = document.querySelectorAll('.pRow').length;
            if (total > 1) {
                var i = r.parentNode.parentNode.rowIndex;
                document.getElementById("delete_row").deleteRow(i);
            } else {
                alert("Product row must at least one");
            }
        }

        function checkDuplicate(event) {
            var newarray = [];
            var selects = document.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                newarray.push(selects[i].value);
            }
            if (newarray.length !== new Set(newarray).size) {
                alert("There are duplicate item in the array");
                event.preventDefault();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>