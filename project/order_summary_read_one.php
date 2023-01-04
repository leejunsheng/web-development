<?php
// include database connection
include 'check_user_login.php';
?>



<!DOCTYPE HTML>
<html>

<head>
    <title>Order Detail</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'topnav.php'; ?>
    <!-- container -->
    <div class="container">
        <div class="page-header my-3">
            <h1>Read Order Summary One</h1>
        </div>

        <!-- PHP read one record will be here -->

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
        } else {
            die('ERROR: Record ID not found.');
        }
        include 'config/database.php';

        $money = "SELECT sum(price*quantity) AS total_price FROM order_details INNER JOIN order_summary ON order_summary.order_id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id WHERE order_summary.order_id =:order_id GROUP BY order_summary.order_id";
        $stmt = $con->prepare($money);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        try {
            $query = "SELECT * FROM order_details INNER JOIN products ON products.id = order_details.product_id INNER JOIN order_summary ON order_summary.order_id = order_details.order_id WHERE order_details.order_id=:order_id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":order_id", $order_id);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                echo "<h3>Order ID :$order_id</h3>";
                echo "<table class='table table-hover table-responsive table-bordered'>

                <tr class='bg-info'>
                <th class='col-4'> Product Name</td>
                <th class='col-3 text-end'>Price Per Unit (RM)</td>
                <th class='col-2 text-end'>Quantity</td>
                <th class='col-3 text-end'>Total Price (RM)</td>
                </tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $sum = $price * $quantity;
                    echo "<tr>";
                    echo "<td class='col-4'>{$name}</td>";
                    $price = htmlspecialchars(number_format($price, 2, '.', ''));
                    echo "<td class='col-3 text-end'>{$price}</td>";
                    echo "<td class='col-2 text-end'><strong>X</strong> &nbsp&nbsp{$quantity}</td>";
                    $sum = htmlspecialchars(number_format($sum, 2, '.', ''));
                    echo "<td class='col-3 text-end'>{$sum}</td>";
                    echo "</tr>";
                }
            }
            echo "<tr class='border border-5'>";
            echo "<td class='col-2'>SubTotal (RM)</td>";
            echo "<td colspan=2></td>";
            echo "<td colspan=4 class='text-end'>";
            $total_price = (number_format($total_price, 2, '.', ''));
            echo "$total_price";
            echo "</td></tr>";


            echo "<tr class='border border-5'>";
            echo "<td class='col-2' >Rounded off amount (RM)</td>";
            echo "<td colspan=2></td>";
            echo "<td colspan = 4 class='text-end'>";
            $rounded_total_price = round($total_price, 1);
            $difference = $rounded_total_price - $total_price;
            $difference = number_format($difference, 2, '.', '');
            echo "$difference";

            echo "<tr class='border border-5 bg-table'>";
            echo "<td class='col-2 '> <strong> Total Price (RM)</strong></td>";
            echo "<td colspan=2></td>";
            echo "<td colspan = 4 class='text-end'>";
            $total_price = round($total_price, 1);
            $total_price = number_format($total_price, 2, '.', '');
            echo "<strong>$total_price</strong>";
            echo "</td></tr></table>";
        }
        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        // show error
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <div class="w-50 ">
            <?php echo " <a href='order_update.php?order_id={$order_id}' class='btn btn-primary m-r-1em mx-2 mx-2'>Edit <i class='fa-solid fa-pen-to-square'></i></a>"; ?>

            <a href='order_summary.php' class='btn btn-secondary'>Back to read order summary</a>
        </div>
    </div>

    <!-- end .container -->

    <?php include 'script.php'; ?>

</body>

</html>