<?php
// To check user are login
include 'check_user_login.php';
?>



<!DOCTYPE HTML>
<html>

<head>
  <title>Dashboard</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <?php include 'head.php'; ?>
</head>


<body>
  <!-- container -->
    <?php include 'topnav.php'; ?>

  <div class="container-fluid row m-0  d-flex justify-content-between align-items-center">
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
    echo "
            <div class='row text-center d-flex justify-content-center mt-3'>
              <h3 class='text-center'>Summary</h3>
          
              <div class='col-md-4 mt-2'>
                <div class='card text-white bg-primary'>
                  <div class='card-body row d-flex'>
                    <div class='card-title col'>
                      <p class='card-text fs-4'> $customer</p>
                      <h6>Total Customers</h6>
                    </div>
                    <div class='col d-flex flex-column pt-3'>
                      <i class='fa-solid fa-users fs-4'> </i>
                      <a class='fs-4 text-white text-decoration-none' href='customer_read.php'> ViewList</a>
                    </div>
                  </div>
                </div>
              </div>
          
              <div class='col-md-4 mt-2'>
               <div class='card text-white bg-success'>
                  <div class='card-body row d-flex'>
                    <div class='card-title col'>
                      <p class='card-text fs-4'> $products</p>
                      <h6>Total Products</h6>
                    </div>
                    <div class='col d-flex flex-column pt-3'>
                      <i class='fa-solid fa-box-open fs-4'> </i>
                      <a class='fs-4 text-white text-decoration-none' href='product_read.php'> ViewList</a>
                    </div>
                  </div>
                </div>
              </div>
          
              <div class='col-md-4 mt-2'>
                <div class='card text-white bg-info'>
                  <div class='card-body row d-flex'>
                    <div class='card-title col'>
                      <p class='card-text fs-4'>$order</p>
                      <h6>Total Orders </h6>
                    </div>
                    <div class='col d-flex flex-column pt-3'>
                      <i class='fa-solid fa-cart-flatbed fs-4'> </i>
                      <a class='fs-4 text-white text-decoration-none' href='order_summary.php'> ViewList</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          "; ?>

    <!-- Lastest order record table will be here -->
    <div class="container-fluid mt-3">
      <div class="row">
        <div class='col-md-6'>
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
            $query = "SELECT *, sum(price*quantity) AS total_price FROM order_details INNER JOIN order_summary ON order_summary.order_id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id INNER JOIN customers ON customers.username = order_summary.user WHERE order_summary.order_id = ?";

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
              <tr class='bg-info'>
                <th class="col-2">Order ID</th>
                <th class="col-3">Order Date</th>
                <th class="col-2">First Name</th>
                <th class="col-2">Last Name</th>
                <th class="col-3">Total Price (RM)</th>
              </tr>

              <tbody>
                <tr>
                  <?php
                  echo "<td> <a href='order_summary_read_one.php?order_id={$order_id} class'text-white'>{$order_id}</a></td>";
                  echo "<td>$order_time</td>";
                  echo "<td>$firstname</td>";
                  echo "<td>$lastname</td>";

                  $total_price = round($total_price, 1);
                  $total_price = number_format($total_price, 2, '.', '');
                  echo "<td>RM $total_price</td>"; ?>
                </tr>
              </tbody>
            </table>
        </div>

        <div class='col-md-6'>
          <?php
          //Highest Purchased Amount Order
          $query = "SELECT *,sum(price*quantity) AS highest FROM order_summary INNER JOIN order_details ON order_details.order_id = order_summary.order_id INNER JOIN products ON products.id = order_details.product_id INNER JOIN customers ON customers.username = order_summary.user GROUP BY order_summary.order_id ORDER BY HIGHEST DESC";
          $stmt = $con->prepare($query);
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
          ?>

          <h3>Highest Purchased Amount Order</h3>
          <table class='table  table-hover table-responsive table-bordered text-center'>
            <tr class='bg-info'>
              <th class="col-2">Order ID</th>
              <th class="col-3">Order Date</th>
              <th class="col-2">First Name</th>
              <th class="col-2">Last Name</th>
              <th class="col-3">Total Price(RM)</th>
            </tr>

            <tbody>
              <tr>
                <?php
                echo "<td> <a href='order_summary_read_one.php?order_id={$order_id}'>{$order_id}</a></td>";
                echo "<td>$order_time</td>";
                echo "<td>$firstname</td>";
                echo "<td>$lastname</td>";
                $highest = round($highest, 1);
                $highest = number_format($highest, 2, '.', '');
                echo "<td>RM $highest</td>";; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <div class="container-fluid mt-3">
      <div class="row">
        <?php
        echo "<div class='col-md-6'>";
        //Top 5 Selling product
        $query = "SELECT *, sum(quantity) AS top5 FROM products INNER JOIN order_details ON order_details.product_id = products.id GROUP BY name ORDER BY sum(quantity) desc limit 5;";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          echo "<h3>Top 5 Selling Ranking</h1>";
          echo "<table class='table table-hover table-responsive table-bordered text-center'>";
          echo "<tr class='bg-info'>
                        <th>Ranking</th>
                        <th>Product Name</th>
                        <th>Sold Quantity</th>
                        <th class='text-end'>Price per unit</th></tr>";

          $ranknum = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<tr>";
            echo "<td> <a href='product_read_one.php?id={$id}'>$ranknum</a></td>";
            echo "<td> {$name}</td>";
            echo "<td>{$top5}</td>";
            echo "<td class='text-end'>RM $price</td>";
            echo "</tr>";
            $ranknum++;
          }
          echo "</table>";
        }
        echo "</div>";


        //Products that never purchased
        $query = "SELECT * FROM products LEFT JOIN order_details ON order_details.product_id = products.id WHERE product_id is NULL limit 3";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          echo "<div class='col-md-6'>";
          echo "<h3>Top 3 Products That Never Purchase</h3>";
          echo "<table class='table table-hover table-responsive table-bordered text-center'>";
          echo "<tr class='bg-info'>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Product Photo</th>
                                <th class='text-end'>Price per unit</th> </tr>";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<tr>";
            echo "<td><a href='product_read_one.php?id={$id}'>{$id}</a></td>";

            echo "<td>{$name}</td>";
            echo "<td style='width:150px;'><img src='uploads/product/$image' class='img-fluid' style='height:100px;'></td>";
            echo "<td class='text-end'>RM $price</td>";
            echo "</tr>";
          }
          echo "</table>";
        }
        echo "</div>";
        ?>
      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>