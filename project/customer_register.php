<!DOCTYPE HTML>
<html>

<head>
    <title>Create Customer</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/online-shopping.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>


<body>

    <section class="h-100 bg-primary py-3">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">


    <!-- container -->
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
            $error_msg .= "<div class='alert alert-danger'>Please make sure firstname are not empty</div>";
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

                    <div class="card shadow-2-strong h-75" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">

                                <div class="">
                                    <div class="col-md-12 mb-4">
                                        <div class="form-outline">
                                            <input input type='text' name='username' value='<?php echo $user_name ?>' class="form-control form-control-lg" />
                                            <label class="form-label" for="firstName">Username</label>
                                        </div>

                                    </div>

                                </div>

                                <div class="">
                                    <div class="col-md-12 mb-4">
                                        <div class="form-outline">
                                            <input input type='file' name='image' value='<?php echo $image ?>' class="form-control form-control-lg" />
                                            <label class="form-label">Image</label>
                                        </div>

                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type='text' name='firstname' value='<?php echo  $firstname ?>' class="form-control form-control-lg" />
                                            <label class="form-label" for="firstName">First Name</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <input type='text' name='lastname' value='<?php echo $lastname ?>' class="form-control form-control-lg" />
                                            <label class="form-label" for="lastName">Last Name</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type='password' name='password' class='form-control' class="form-control form-control-lg" />
                                            <label class="form-label" for="password">Pasword</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <input type='password' name='comfirm_password' class="form-control form-control-lg" />
                                            <label class="form-label" for="confirmpassword">Confirm Password</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <h6 class="mb-2 pb-1">Gender: </h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name='gender' value="Male" checked>
                                            <label class="form-check-label" for="gender">
                                                Male
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name='gender' value="Female">
                                            <label class="form-check-label" for="gender">
                                                Female
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <h6 class="mb-2 pb-1">Account Status: </h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name='accstatus' value="active" checked>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name='accstatus' value="inactive">
                                            <label class="form-check-label" for="inactive">
                                                Inactive
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 d-flex align-items-center">

                                        <div class="form-outline datepicker w-100">
                                            <input type='date' name='datebirth' value='<?php echo $datebirth ?>' class="form-control form-control-lg" />
                                            <label for="birthdayDate" class="form-label">Birthday</label>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <input class="btn btn-outline-primary text-dark btn-lg px-5 btn-lg" type="submit" value="Submit" />
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>