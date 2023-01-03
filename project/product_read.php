<?php
// include database connection
include 'check_user_login.php';
?>



<!DOCTYPE HTML>
<html>

<head>
    <style>
        td {
            height: 120px;
        }
    </style>
    <title>Product List</title>
  <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'topnav.php'; ?>
    <!-- container -->
    <div class="container-fluid px-0">
        <!-- container -->
        <div class="container my-3">
            <div class="page-header">
                <h1>Read Products</h1>
            </div>

            <!-- PHP code to read records will be here -->
            <?php
            if (isset($_GET['update'])) {
                echo "<div class='alert alert-success'>Record was updated.</div>";
            }
            // include database connection
            include 'config/database.php';


            // delete message prompt will be here
            $action = isset($_GET['action']) ? $_GET['action'] : "";
            // if it was redirected from delete.php
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }

            if ($action == 'updated') {
                echo "<div class='alert alert-success'>Record was updated.</div>";
            }

            if ($action == 'faildelete') {
                echo "<div class='alert alert-success'>The product unable to delete.</div>";
            }

            if ($action == 'created') {
                echo "<div class='alert alert-success'>The product is created.</div>";
            }

            // select all data
            $query = "SELECT id, name, description, price ,image FROM products ORDER BY id DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();

            // this is how to get number of rows returned
            $num = $stmt->rowCount();

            // link to create record form
            echo "<a href='product_create.php' class='btn btn-primary m-b-1em my-3'>   Create New Product <i class='fa-solid fa-plus mt-1'></i></a> ";

            //check if more than 0 record found
            if ($num > 0) {
                // data from database will be here
                echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                //creating our table heading
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Name</th>";
                echo "<th>Image</th>";
                echo "<th>Description</th>";
                echo "<th class='text-center'>Price (RM)</th>";
                echo "<th>Action</th>";
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
                    echo "<td>{$id}</td>";
                    echo "<td>{$name}</td>";
                    echo "<td style='width:150px;'><img src='uploads/product/$image' class='img-fluid' style='height:100px;'></td>";
                    echo "<td>{$description}</td>";
                    $format_price = number_format((float)$price, 2, '.', '');
                    echo "<td class='text-end'>{$format_price}</td>";
                    echo "<td style='width:350px;'>";

                    // read one record
                    echo "<a href='product_read_one.php?id={$id}' class='btn btn-info m-r-1em mx-2'>Read <i class='fa-brands fa-readme'></i></a>";

                    // we will use this links on next part of this post
                    echo "<a href='product_update.php?id={$id}' class='btn btn-primary m-r-1em mx-2'>Edit <i class='fa-solid fa-pen-to-square'></i></a>";

                    // we will use this links on next part of this post
                    echo "<a href='product_delete.php?id={$id}' onclick='delete_product({$id});'  class='btn btn-danger mx-2'>Delete <i class='fa-solid fa-trash'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }

                // end table
                echo "</table>";
            } else {
                echo "<div class='alert alert-danger'>No records found.</div>";
            }
            ?>
        </div>
    </div>
    
    <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion
        function delete_product(id) {
            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'product_delete.php?id=' + id;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>