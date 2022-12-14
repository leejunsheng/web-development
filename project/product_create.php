<?php
// include database connection
include 'check_user_login.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Product - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- container -->
    <div>
        <?php include 'topnav.php'; ?>

        <!-- html form to create product will be here -->

        <!-- PHP insert code will be here -->
        <?php
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
            } elseif ($promotion_price > $price) {
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
            if ($image) {

                // upload to file to folder
                $target_directory = "uploads/";
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
                        echo "<div class='alert alert-danger'>";
                        $error_msg .= "<div>Unable to upload photo.</div>";
                        $error_msg .= "<div>Update the record to upload photo.</div>";
                        echo "</div>";
                    }
                }
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
                        echo "<div class='alert alert-success'>Record was saved.</div>";
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
                    <td><input type='text' name='name' class='form-control' /></td>

                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type="file" name="image" /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type='text' name='description' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Promotion_price</td>
                    <td><input type='text' name='promotion_price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture_date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired_date</td>
                    <td><input type='date' name='expired_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>