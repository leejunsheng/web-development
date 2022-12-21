<?php
// To check user are login
include 'check_user_login.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <style>
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>


<body>
    <!-- container -->
    <div>
        <?php include 'topnav.php'; ?>

        <div class="container-fluid row m-0  d-flex justify-content-between align-items-center">
            <div class="col-lg-5">
                <?php
                include 'config/database.php';

                $query = "SELECT * FROM customers";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $customer = $stmt->rowCount();

                $query = "SELECT * FROM products";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $products = $stmt->rowCount();

                $query = "SELECT * FROM order_summary";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $order = $stmt->rowCount();

                //Summary Table

                echo "<h3>Summary</h1>";
                echo "<table class='table table-hover table-bordered text-center'>";
                echo "<tr class='bg-danger'>";
                echo "<th >Total Number of Customer</th>";
                echo "<th>Total Number of Products</th>";
                echo "<th>Total Number of Order</th>";
                echo "</tr>";
                echo "<td class=''>$customer</td>";
                echo "<td class=''>$products</td>";
                echo "<td class=''>$order</td>";
                echo "</table>";
                ?>
            </div>

            <!-- Lastest order record table will be here -->
            <div class="col-lg-5">
                <?php
                include 'config/database.php';

                $query = "SELECT MAX(order_id) as order_id FROM order_summary";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $order_id = $row['order_id'];
                isset($order_id);
                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT * FROM order_summary WHERE order_id = ? ";
                    $stmt = $con->prepare($query);

                    // Bind the parameter
                    $stmt->bindParam(1, $order_id);

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    extract($row);
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
                ?>


                <!--we have our html table here where the record will be displayed-->
                <h3>Latest Order</h1>
                    <table class='table table-hover table-responsive table-bordered text-center'>
                        <tr class='bg-danger'>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Username</th>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($order_time, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></td>
                        </tr>
                    </table>
            </div>

            <div class="container ">
                <div class="col-lg-5 ">
                    <?php
                    //Highest Purchased Amount Order
                    $query = "SELECT *,sum(price*quantity) AS highest FROM order_summary INNER JOIN order_details ON order_details.order_id = order_summary.order_id INNER JOIN products ON products.id = order_details.product_id GROUP BY order_summary.order_id ORDER BY HIGHEST DESC";



                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);


                    ?>
                    <h3>Highest Purchased Amount Order</h3>
                    <table class='table  table-hover table-responsive table-bordered text-center'>
                        <tr class='bg-danger'>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Username</th>
                            <th>Highest Amount</th>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($order_time, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></td>
                            <td><?php $amount = htmlspecialchars(round($highest));

                                $amount  = htmlspecialchars(number_format($highest, 2, '.', ''));
                                echo "$highest";
                                ?></td>
                        </tr>
                    </table>

                    <?php
                    //Top 5 Selling product
                    $query = "SELECT name, sum(quantity) AS top5 FROM products INNER JOIN order_details ON order_details.product_id = products.id group by name order by sum(quantity) desc limit 5;";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h3>Top 5 Selling Product</h1>";
                        echo "<table class='table  table-hover table-responsive table-bordered text-center'>";
                        echo "<tr class='bg-danger'><th>Product Name</th>
                        <th>Quantity</th></tr>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr>";
                            echo "<td>{$name}</td>";
                            echo "<td>{$top5}</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }

                    //Products that never purchased
                    $havensellitem = "SELECT * FROM products left JOIN order_details ON order_details.product_id = products.id WHERE product_id is NULL limit 5";
                    $stmt = $con->prepare($havensellitem);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h3>3 Products that never purchased</h1>";
                        echo "<table class='table  table-hover table-responsive table-bordered text-center'>";
                        echo "<tr class='bg-danger'><th>Product Name</th>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr>";
                            echo "<td>{$name}</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>