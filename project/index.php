<?php
// To check user are login
include 'check_user_login.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>


<body>
    <!-- container -->
    <div>
        <?php include 'topnav.html'; ?>

        <div class="container-fluid row m-0  d-flex justify-content-between align-items-center">
            <div class="col-5">
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

                echo "<h1>Summary</h1>";
                echo "<table class='table table-dark table-hover table-bordered text-center'>";
                echo "</tr class='table-dark'>";
                echo "<th>Total Number of Customer</th>";
                echo "<th>Total Number of Products</th>";
                echo "<th>Total Number of Order</th>";
                echo "</tr>";
                echo "<td class='table-dark'>$customer</td>";
                echo "<td class='table-dark'>$products</td>";
                echo "<td class='table-dark'>$order</td>";
                echo "</table>";
                ?>
            </div>

            <div class="col-5">
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

                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <h1>Latest Order</h1>
                <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                    <tr>
                        <td>Order ID</td>
                        <td>Order Date</td>
                        <td>Username</td>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($order_time, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></td>
                    </tr>
                </table>
            </div>
            

            <div class="col-5">
            <?php
                    $query = "SELECT *,sum(price*quantity) AS HIGHEST FROM order_summary INNER JOIN order_details ON order_details.order_id = order_summary.order_id INNER JOIN products ON products.id = order_details.product_id GROUP BY order_summary.order_id ORDER BY HIGHEST DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);

                    ?>
                    <h1 class="text-center">Highest Purchased Amount Order</h1>
                    <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                        <tr>
                            <td>Order ID</td>
                            <td>Order Date</td>
                            <td>Username</td>
                            <td>Highest Amount</td>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($order_time, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></td>
                            <td><?php $amount = htmlspecialchars(round($HIGHEST), ENT_QUOTES);
                                echo "RM $HIGHEST";
                                ?></td>
                        </tr>
                    </table>
                    <?php
                    $query = "SELECT name, sum(quantity) AS top5 FROM products INNER JOIN order_details ON order_details.product_id = products.id group by name order by sum(quantity) desc limit 5;";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h1 class=\"text-center\">Top 5 Selling Product</h1>";
                        echo "<table class='table table-dark table-hover table-responsive table-bordered text-center'>";
                        echo "<tr><td>Product Name</td>
                        <td>Quantity</td></tr>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<tr>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$top5}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    }

                    $havensellitem = "SELECT * FROM products left JOIN order_details ON order_details.product_id = products.id WHERE product_id is NULL limit 5";
                    $stmt = $con->prepare($havensellitem);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h1 class=\"text-center\">3 Products that never purchased</h1>";
                        echo "<table class='table table-dark table-hover table-responsive table-bordered text-center'>";
                        echo "<tr><td>Product Name</td>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<tr>";
                        echo "<td>{$name}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                    ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>