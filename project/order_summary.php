<?php
// include database connection
    include 'check_user_login.php';
    ?>
    
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Order Summary - PHP CRUD Tutorial</title>
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
            <h1>Order Summary</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';
        
        // delete message prompt will be here

        // select all data
        $query = "SELECT order_id, user, order_time FROM order_summary ORDER BY order_id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='create_new_order.php' class='btn btn-primary m-b-1em'>Create New Order</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Username</th>";
            echo "<th>Order Data</th>";
            echo "</tr>";

            //GET DATA FROM DATABASE
            // table body will be here 
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$user}</td>";
                echo "<td>{$order_time}</td>";
                echo "<td>";
                // read one record
                echo "<a href=order_details.php?order_id={$order_id}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='product_update.php?id={$order_id}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_product({$order_id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }

            // end table
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>


    </div> <!-- end .container -->

</body>

</html>