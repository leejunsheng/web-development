<?php
include 'check_user_login.php';
?>



<!DOCTYPE html>
<html>


<head>
    <title>Update Product Detail</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'topnav.php'; ?>
    <div class="container-fluid px-0">
        <div class="container">
            <div class="page-header my-3">
                <h1>Update Product</h1>
            </div>
            <?php

            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // delete message prompt will be here
            $action = isset($_GET['action']) ? $_GET['action'] : "";
            // if it was redirected from delete.php
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM products WHERE id = ? LIMIT 0,1";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $name = $row['name'];
                $description = $row['description'];
                $price = $row['price'];
                $image = $row['image'];
                $promotion_price = $row['promotion_price'];
                $manufacture_date = $row['manufacture_date'];
                $expired_date = $row['expired_date'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <?php
            // check if form was submitted

            if ($_POST) {
                $name = $_POST["name"];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];
                // new 'image' field
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : htmlspecialchars($image, ENT_QUOTES);

                $error_msg = "";

                if ($name == "" || $description == "" ||  $manufacture_date == "") {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure all field are not empty. </div>";
                }
                if ($price == "") {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure price are not empty. </div>";
                } elseif (!is_numeric($price)) {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure price are only accept for number. </div>";
                } elseif ($price < 0) {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure price cannot be negative. </div>";
                } elseif ($price > 1000) {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure price are not more than RM1000. </div>";
                }

                if ($promotion_price == "") {
                    $promotion_price = NULL;
                } elseif (!is_numeric($promotion_price)) {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure price are only accept for number.</div>";
                } elseif ($promotion_price < 0) {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure price are not negative.</div>";
                } elseif ($promotion_price > 1000) {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure price are not more than RM1000.</div>";
                } elseif ($promotion_price >= $price) {
                    $error_msg .= "<div class='alert alert-danger'> Please make sure promotion price is not more than normal price.</div>";
                }

                if ($expired_date == "") {
                    $expired_date = NULL;
                } else {
                    $date1 = date_create($manufacture_date);
                    $date2 = date_create($expired_date);
                    $diff = date_diff($date1, $date2);
                    $result = $diff->format("%R%a");
                    if ($result < "0") {
                        $error_msg .= "<div class='alert alert-danger'> Please make sure expired date is not earlier than manufacture date.</div>";
                    }
                }

                // now, if image is not empty, try to upload the image
                if ($_FILES["image"]["name"]) {
                    // upload to file to folder
                    $target_directory = "uploads/product/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    // make sure that file is a real image
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check === false) {
                        // submitted file is an image
                        $error_msg .= "<div>Submitted file is not an image.</div>";
                    }

                    // make sure certain file types are allowed
                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $error_msg .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }

                    // make sure file does not exist
                    if (file_exists($target_file)) {
                        $error_msg .= "<div>Image already exists. Try to change file name.</div>";
                    }

                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['image']['size'] > (1024000)) {
                        $error_msg .= "<div>Image must be less than 1 MB in size.</div>";
                    }

                    // make sure the 'uploads' folder exists
                    // if not, create it
                    if (!is_dir($target_directory)) {
                        mkdir($target_directory, 0777, true);
                    }

                    // if $file_upload_error_messages is still empty
                    if (empty($error_msg)) {
                        // it means there are no errors, so try to upload the file
                        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            // it means photo was uploaded
                            echo "<div class='alert alert-danger'>";
                            $error_msg .= "<div>Unable to upload photo.</div>";
                            $error_msg .= "<div>Update the record to upload photo.</div>";
                            echo "</div>";
                        }
                    }
                } elseif (empty($image)) {
                    $image = "default.png";
                }

                if (isset($_POST['delete'])) {
                    $image = htmlspecialchars(strip_tags($image));
                    $image = !empty($_FILES["image"]["name"])
                        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                        : "";
                    $target_directory = "uploads/product/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    unlink("uploads/product/" . $row['image']);
                    $query = "UPDATE products SET image=:image WHERE id = :id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':image', $image);
                    $stmt->bindParam(':id', $id);
                    // Execute the query
                    if ($stmt->execute()) {
                        // redirect to read records page and
                        // tell the user record was deleted
                        $error_msg .= "<div>Image delete successful, Please click update button.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to delete image. Please try again.</div>";
                    }
                }

                if ($expired_date == NULL) {
                    $expired_date = NULL;
                } else {
                    $expired_date = $_POST['expired_date'];
                }
                if ($promotion_price == NULL) {
                    $promotion_price = NULL;
                } else {
                    $promotion_price = $_POST['promotion_price'];
                }


                if (!empty($error_msg)) {
                    echo "<div class='alert alert-danger'>{$error_msg}</div>";
                } else {

                    try {
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE products SET name=:name, description=:description, price=:price, image=:image, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date WHERE id = :id";
                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // posted values
                        $name = htmlspecialchars(strip_tags($_POST['name']));
                        $description = htmlspecialchars(strip_tags($_POST['description']));
                        $price = htmlspecialchars(strip_tags($_POST['price']));

                        $image = htmlspecialchars(strip_tags($image));
                        $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));


                        // bind the parameters
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':image', $image);
                        $stmt->bindParam(':promotion_price', $promotion_price);
                        $stmt->bindParam(':manufacture_date', $manufacture_date);
                        $stmt->bindParam(':expired_date', $expired_date);
                        $stmt->bindParam(':id', $id);
                        // Execute the query

                        if ($stmt->execute()) {
                            // redirect to read records page and
                            // tell the user record was deleted
                            // echo "<div class='alert alert-success'>Record was saved.</div>";
                            header("Location: product_read.php?update");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }
                    // show errors
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
            ?>

            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Image</td>
                        <td>
                            <div><img src="uploads/product/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" class="w-25"></div>
                            <div><input type="file" name="image" value="<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" /></div>

                            <?php
                            if ($image != "default.png") {
                                echo "<input type='submit' value='Delete' name='delete' class='btn btn-primary' />";
                            }
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' class='form-control'> <?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>

                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion_price' value="<?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Manufacture Date</td>
                        <td><input type='date' name='manufacture_date' class='form-control' value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?>" /></td>
                    </tr>
                    <tr>
                        <td>Expired Date</td>
                        <td><input type='date' name='expired_date' class='form-control' value="<?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?>" /></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Update' class='btn btn-primary' />
                            <a href='product_read.php' class='btn btn-secondary'>Back to read products</a>

                            <?php echo "<a href='product_delete.php?id={$id}' onclick='delete_product({$id});'  class='btn btn-danger'>Delete</a> "; ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- end .container -->
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>