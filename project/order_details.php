<?php
// include database connection
    include 'check_user_login.php';
    ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Order Detail - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div>
    <?php include 'topnav.html'; ?>

        <div class="page-header">
            <h1>Order Details</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // include database connection
        include 'config/database.php';
    
        // delete message prompt will be here
        // select all data
        $query = "SELECT detail_id, order_id, product_id, quantity FROM order_details ORDER BY detail_id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='create_new_order.php' class='btn btn-primary m-b-1em my-3'>Create New Order</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here

        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }

        //new
        echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

        //creating our table heading
        echo "<tr>";
        echo "<th>Detail ID</th>";
        echo "<th>Order ID</th>";
        echo "<th>Product ID</th>";
        echo "<th>Quantity</th>";
        echo "</tr>";

        // table body will be here
        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['firstname'] to just $firstname only
            extract($row);
            // creating new table row per record
            echo "<tr>";
            echo "<td>{$detail_id}</td>";
            echo "<td>{$order_id}</td>";
            echo "<td>{$product_id}</td>";
            echo "<td>{$quantity}</td>";
            echo "</tr>";
        }

        // end table
        echo "</table>";
        ?>

    </div> <!-- end .container -->

</body>

</html>