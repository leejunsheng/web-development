<?php
// include database connection
include 'check_user_login.php';
?>



<!DOCTYPE HTML>
<html>

<head>
    <title>Product Detail</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
  <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'topnav.php'; ?>
    <!-- container -->
    <div class="container-fluid px-0">
        <!-- container -->
        <div class="container">
            <div class="page-header">
                <h1>Read Product</h1>
            </div>

            <!-- PHP read one record will be here -->
            <?php

            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM products WHERE id = :id ";
                $stmt = $con->prepare($query);

                // Bind the parameter
                $stmt->bindParam(":id", $id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // shorter way to do that is extract($row)
                extract($row);
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>


            <!-- HTML read one record table will be here -->
            <!--we have our html table here where the record will be displayed-->
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>
                        <div><img src="uploads/product/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" class="img-fluid"  style="height:100px;"></div>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Price (RM)</td>
                    <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Promotion Price (RM)</td>
                    <?php $promotion_price = number_format((float)$promotion_price, 2, '.', ''); ?>
                    <td><?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php echo "<a href='product_update.php?id={$id}' class='btn btn-primary'>Edit <i class='fa-solid fa-pen-to-square'></i></a>"; ?>
                        <a href='product_read.php' class='btn btn-secondary  m-r-1em mx-2'>Back to read products</a>

                    </td>


                </tr>

            </table>

        </div>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>