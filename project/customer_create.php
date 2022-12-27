<?php
// include database connection
include 'check_user_login.php';
?>

<?php include 'topnav.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Create Customer</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>


<body>
    <!-- container -->
    <div>

        <!-- html form to create product will be here -->

        <!-- PHP insert code will be here -->


        <?php
        $user_name = $image = $firstname = $lastname =  $gender = $datebirth = $accstatus = "";

        if ($_POST) {
            $user_name = $_POST['username'];
            $pass_word = md5($_POST['password']);
            $comfirm_pasword = md5($_POST['comfirm_password']);
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $datebirth = $_POST['datebirth'];
            $accstatus = $_POST['accstatus'];

            $today = date("Ymd");
            $date1 = date_create($datebirth);
            $date2 = date_create($today);
            $diff = date_diff($date1, $date2);

            // new 'image' field
            $image = !empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                : "";

            $error_msg = "";

            if ($user_name == "") {
                $error_msg .= "<div class='alert alert-danger'>Please make sure username are not empty</div>";
            } elseif (strlen($user_name) < 6) {
                $error_msg .= "<div class='alert alert-danger'>Please make sure uername not less than 6 character</div>";
            } elseif (preg_match('/[" "]/', $user_name)) {
                $error_msg .= "<div class='alert alert-danger'>Please make sure uername did not conatain space</div>";
            }

            if ($pass_word == md5("")) {
                $error_msg .= "<div class='alert alert-danger'>Please make sure password are not empty</div>";
            } elseif (strlen($pass_word) < 8) {
                $error_msg .= "<div class='alert alert-danger'>Please make sure password less than 8 character</div>";
            } elseif (!preg_match('/[a-z]/', $pass_word)) {
                $error_msg .= "<div class='alert alert-danger'>Please make sure password combine capital a-z</div>";
            } elseif (!preg_match('/[0-9]/', $pass_word)) {
                $error_msg .= "<div class='alert alert-danger'>Please make sure password combine 0-9</div>";
            }

            if ($comfirm_pasword != $pass_word) {
                $error_msg .= "<div class='alert alert-danger'>Please make sure comfirm_password and password are same</div>";
            }

            if ($firstname == "") {
                echo "<div class='alert alert-danger'>Please make sure firstname are not empty</div>";
            }

            if ($lastname == "") {
                $error_msg .= "<div class='alert alert-danger'>Please make sure lastname are not empty</div>";
            }

            if ($datebirth == "") {
                $error_msg .= "<div class='alert alert-danger'>Please make sure birth date are not empty</div>";
            } elseif ($diff->format("%R%y") <= "18") {
                $error_msg .= "<div class='alert alert-danger'>User need 18 years old and above</div>";
            }


            // now, if image is not empty, try to upload the image
            if ($image) {

                // upload to file to folder
                $target_directory = "uploads/customer/";
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
                $image = "profile_default.png";
            }

            if (!empty($error_msg)) {
                echo "<div class='alert alert-danger'>{$error_msg}</div>";
            } else {
                // include database connection
                include 'config/database.php';
                try {
                    // insert query
                    $query = "INSERT INTO customers SET username=:username, image=:image, password=:password, firstname=:firstname, lastname=:lastname,gender=:gender,datebirth=:datebirth,registration_dt=:registration_dt,accstatus=:accstatus";

                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':username', $user_name);
                    $stmt->bindParam(':image', $image);
                    $stmt->bindParam(':password', $pass_word);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':datebirth', $datebirth);
                    $registration_dt = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':registration_dt', $registration_dt);
                    $stmt->bindParam(':accstatus', $accstatus);

                    // Execute the query
                    if ($stmt->execute()) {
                        header("Location: customer_read.php?action=created");
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
                    <td>Username</td>
                    <td><input type='text' name='username' value='<?php echo $user_name ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Image</td>
                    <div>
                        <td><input type="file" name="image" value='<?php echo $image ?>' class="w-25" />
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Comfirm_Password</td>
                    <td><input type='password' name='comfirm_password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First name</td>
                    <td><input type='text' name='firstname' value='<?php echo $firstname ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td><input type='text' name='lastname' value='<?php echo $lastname ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input class="form-check-input" type="radio" name='gender' value="Male" checked>
                        <label class="form-check-label" for="gender">
                            Male
                        </label>

                        <input class="form-check-input" type="radio" name='gender' value="Female">
                        <label class="form-check-label" for="gender">
                            Female
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Datebirth</td>
                    <td><input type='date' name='datebirth' value='<?php echo $datebirth ?>' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <input class="form-check-input" type="radio" name='accstatus' value="active" checked>
                        <label class="form-check-label" for="active">
                            Active
                        </label>

                        <input class="form-check-input" type="radio" name='accstatus' value="inactive">
                        <label class="form-check-label" for="inactive">
                            Inactive
                        </label>
                    </td>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>