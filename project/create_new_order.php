<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order Form</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div>
        <!-- container -->
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

                /* $product_1 = $_POST['product_1'];
                $product_2 = $_POST['product_2'];
                $product_3 = $_POST['product_3'];
                $quantity_1 = $_POST['quantity_1'];
                $quantity_2 = $_POST['quantity_2'];
                $quantity_3 = $_POST['quantity_3'];
                $price_1 = 0;
                $price_2 = 0;
                $price_3 = 0;
                $total_amount = 0;
               

                if ($user == "Select Customer Username") {
                    echo "<div class='alert alert-danger'>You must to select customer.</div>";
                    $flag = 1;
                } else if ($product_1 == "Select product") {
                    echo "<div class='alert alert-danger'>You must to select at least 1 product.</div>";
                    $flag = 1;
                }

                if ($product_1 == "Pillow") {
                    $price_1 = 8.99;
                } else if ($product_1 == "tea") {
                    $price_1 = 1;
                } else if ($product_1 == "Earphone") {
                    $price_1 = 7;
                } else if ($product_1 == "Mouse") {
                    $price_1 = 11.35;
                } else if ($product_1 == "Trash Can") {
                    $price_1 = 3.95;
                } else if ($product_1 == "Eye Glasses") {
                    $price_1 = 6;
                } else if ($product_1 == "Gatorade") {
                    $price_1 = 1.99;
                } else if ($product_1 == "Basketball") {
                    $price_1 = 49.99;
                }

                if ($product_2 == "Pillow") {
                    $price_2 = 8.99;
                } else if ($product_2 == "tea") {
                    $price_2 = 1;
                } else if ($product_2 == "Earphone") {
                    $price_2 = 7;
                } else if ($product_2 == "Mouse") {
                    $price_2 = 11.35;
                } else if ($product_2 == "Trash Can") {
                    $price_2 = 3.95;
                } else if ($product_2 == "Eye Glasses") {
                    $price_2 = 6;
                } else if ($product_2 == "Gatorade") {
                    $price_2 = 1.99;
                } else if ($product_2 == "Basketball") {
                    $price_2 = 49.99;
                }

                if ($product_3 == "Pillow") {
                    $price_3 = 8.99;
                } else if ($product_3 == "tea") {
                    $price_3 = 1;
                } else if ($product_3 == "Earphone") {
                    $price_3 = 7;
                } else if ($product_3 == "Mouse") {
                    $price_3 = 11.35;
                } else if ($product_3 == "Trash Can") {
                    $price_3 = 3.95;
                } else if ($product_3 == "Eye Glasses") {
                    $price_3 = 6;
                } else if ($product_3 == "Gatorade") {
                    $price_3 = 1.99;
                } else if ($product_3 == "Basketball") {
                    $price_3 = 49.99;
                }

                $total_amount += (((int)$price_1 * (int)$quantity_1) + ((int)$price_2 * (int)$quantity_2) + ((int)$price_3 * (int)$quantity_3));*/

                if ($flag == 0) {
                    include 'config/database.php';
                    try {
                        // insert query
                        $query = "INSERT INTO order_summary SET user=:user, order_time=:order_time";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':user', $user);
                        $order_time = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':order_time', $order_time);

                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Your order is created.</div>";
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

                                // show errorproduct_id
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>

</html>