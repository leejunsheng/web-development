<?php
// include database connection
include 'check_user_login.php';
?>



<!DOCTYPE HTML>
<html>

<head>
    <title>Order Summary List</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <?php include 'head.php'; ?>
</head>


<body>
    <?php include 'topnav.php'; ?>
    <div class="container-fluid px-0">


        <!-- container -->
        <div class="container my-3">
            <div class="page-header">
                <h1>Read Order Summary</h1>
            </div>

            <?php
            // include database connection
            include 'config/database.php';

            if (isset($_GET['update'])) {
                echo "<div class='alert alert-success'>Record was updated.</div>";
            }

            // delete message prompt will be here
            $action = isset($_GET['action']) ? $_GET['action'] : "";

            // if it was redirected from delete.php
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }

            // select all data
            $query = "SELECT * , sum(price*quantity) AS total_price FROM order_details INNER JOIN order_summary ON order_summary.order_id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id GROUP BY order_summary.order_id DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();

            // this is how to get number of rows returned
            $num = $stmt->rowCount();

            // link to create record form
            echo "<a href='order_create.php' class='btn btn-primary m-b-1em my-3'>  Create New Order <i class='fa-solid fa-plus mt-1'></i> </a>";

            //check if more than 0 record found
            if ($num > 0) {

                // data from database will be here
                //new
                echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                //creating our table heading
                echo "<tr>";
                echo "<th>Order ID</th>";
                echo "<th>Order Date</th>";
                echo "<th class='text-center'>Total Price</th>";
                echo "<th>Username</th>";
                echo "<th>Action</th>";
                echo "</tr>";

                // table body will be here
                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    // this will make $row['firstname'] to just $firstname only
                    extract($row);

                    // creating new table row per record
                    echo "<tr>";
                    echo "<td>{$order_id}</td>";
                    echo "<td>{$order_time}</td>";
                    $total_price = htmlspecialchars(round($total_price, 1));
                    $total_price = htmlspecialchars(number_format($total_price, 2, '.', ''));
                    echo "<td class='text-end'>{$total_price}</td>";
                    echo "<td>{$user}</td>";
                    echo "<td style='width:400px;'>";
                    // read one record
                    echo "<a href='order_summary_read_one.php?order_id={$order_id}' class='btn btn-info m-r-1em  mx-2'>Read <i class='fa-brands fa-readme'></i> </a>";

                    // we will use this links on next part of this post
                    echo "<a href='order_update.php?order_id={$order_id}' class='btn btn-primary m-r-1em  mx-2'>Edit <i class='fa-solid fa-pen-to-square'></i></a>";

                    // we will use this links on next part of this post
                    echo "<a href='#' onclick='delete_order({$order_id});' class='btn btn-danger mx-2'>Delete <i class='fa-solid fa-trash'></i></a>";
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

        <!-- confirm delete record will be here -->
        <script type='text/javascript'>
            // confirm record deletion
            function delete_order(order_id) {

                if (confirm('Are you sure?')) {
                    // if user clicked ok,
                    // pass the id to delete.php and execute the delete query
                    window.location = 'order_delete.php?order_id=' + order_id;
                }
            }
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>