<?php
// include database connection
include 'check_user_login.php';
?>



<!DOCTYPE HTML>
<html>

<head>
    <title>Create Product</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'topnav.php'; ?>
    <!-- container -->
    <div class="container-fluid px-0">
        <!-- container -->
        <div class="container my-3">

            <div class="page-header my-3">
                <h1>Create Product</h1>
            </div>

            <!-- html form to create product will be here -->

            <!-- PHP insert code will be here -->
            <?php
            $name = $description = $price = $promotion_price = $manufacture_date = $expired_date = "";

            if ($_POST) {
                $name = $_POST["name"];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];
                $error_msg = "";

                // new 'image' field
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";

                if ($name == "" || $description == "" ||  $manufacture_date == "") {
                    $error_msg .= "<div> Please make sure all field are not empty.</div>";
                }
                if ($price == "") {
                    $error_msg .= "<div> Please make sure price are not empty.</div>";
                } elseif (!is_numeric($price)) {
                    $error_msg .= "<div> Please make sure price are only accept for number.</div>";
                } elseif ($price < 0) {
                    $error_msg .= "<div> Please make sure price cannot be negative.</div>";
                } elseif ($price > 1000) {
                    $error_msg .= "<div> Please make sure price are not more than RM1000.</div>";
                }

                if ($promotion_price == "") {
                    $promotion_price = NULL;
                } elseif (!is_numeric($promotion_price)) {
                    $error_msg .= "<div> Please make sure price are only accept for number.</div>";
                } elseif ($promotion_price < 0) {
                    $error_msg .= "<div> Please make sure price are not negative.</div>";
                } elseif ($promotion_price > 1000) {
                    $error_msg .= "<div> Please make sure price are not more than RM1000.</div>";
                } elseif ($promotion_price > $price) {
                    $error_msg .= "<div> Please make sure promotion price is not more than normal price.</div>";
                }

                if ($expired_date == "") {
                    $expired_date = NULL;
                } else {
                    $date1 = date_create($manufacture_date);
                    $date2 = date_create($expired_date);
                    $diff = date_diff($date1, $date2);
                    $result = $diff->format("%R%a");
                    if ($result < "0") {
                        $error_msg .= "<div> Please make sure expired date is not earlier than manufacture date.</div>";
                    }
                }

                // now, if image is not empty, try to upload the image
                if ($image) {
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
                    //if (file_exists($target_file)) {
                    //    $error_msg .= "<div>Image already exists. Try to change file name.</div>";
                    //}

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
                            echo "<div>";
                            $error_msg .= "<div>Unable to upload photo.</div>";
                            $error_msg .= "<div>Update the record to upload photo.</div>";
                            echo "</div>";
                        }
                    }
                } elseif (empty($image)) {
                    $image = "default.png";
                }

                if (!empty($error_msg)) {
                    echo "<div class='alert alert-danger'>{$error_msg}</div>";
                } else {
                    // include database connection
                    include 'config/database.php';
                    try {
                        // insert query
                        $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date,expired_date=:expired_date,image=:image,created=:created";

                        // prepare query for execution
                        $stmt = $con->prepare($query);

                        // bind the parameters
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':promotion_price', $promotion_price);
                        $stmt->bindParam(':manufacture_date', $manufacture_date);
                        $stmt->bindParam(':expired_date', $expired_date);
                        $stmt->bindParam(':image', $image);
                        $created = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':created', $created);

                        // Execute the query
                        if ($stmt->execute()) {
                            header("Location: product_read.php?update");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }

                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
            ?>

            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">

                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' value='<?php echo $name ?>' class='form-control' /></td>

                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td><input type='file' name='image' /></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea type='text' name='description' class='form-control'><?php echo $description ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' value='<?php echo $price ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Promotion Price</td>
                        <td><input type='text' name='promotion_price' value='<?php echo $promotion_price ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Manufacture Date</td>
                        <td><input type='date' name='manufacture_date' value='<?php echo $manufacture_date ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Expired Date</td>
                        <td><input type='date' name='expired_date' value='<?php echo $expired_date ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='index.php' class='btn btn-secondary'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- end .container -->
    <?php include 'script.php'; ?>

</body>

</html>