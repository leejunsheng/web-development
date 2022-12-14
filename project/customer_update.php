<?php
include 'check_user_login.php';
?>

<!DOCTYPE html>

<html>

<head>

    <title>Update Customer Profile</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<body>

    <div class="container-fluid px-0">

        <?php include 'topnav.php'; ?>

        <div class="container">
            <div class="page-header">
                <h1>Update Customer Profile</h1>
            </div>
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM customers WHERE user_id = ? LIMIT 0,1";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $user_id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $username = $row['username'];
                $image = $row['image'];
                $password = $row['password'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $gender = $row['gender'];
                $datebirth = $row['datebirth'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <?php
            // check if form was submitted
            if ($_POST) {
                $user_name = $_POST['username'];
                $pass_word = $_POST['password'];
                $old_password = $_POST['old_password'];
                $confirm_password = $_POST['confirm_password'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $gender = $_POST['gender'];
                $datebirth = $_POST['datebirth'];

                $today = date("Ymd");
                $date1 = date_create($datebirth);
                $date2 = date_create($today);
                $diff = date_diff($date1, $date2);

                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : htmlspecialchars($image, ENT_QUOTES);

                $flag = 0;
                $error_msg = "";

                if ($user_name == "") {
                    echo "<div class='alert alert-danger'>Please make sure username are not empty </div>";
                    $flag = 1;
                } elseif (strlen($user_name) < 6) {
                    echo "<div class='alert alert-danger'>Please make sure uername not less than 6 character </div>";
                    $flag = 1;
                } elseif (preg_match('/[" "]/', $user_name)) {
                    echo "<div class='alert alert-danger'> Please make sure uername did not conatain space </div>";
                    $flag = 1;
                }


                $password_empty = false;
                if ($old_password == "" && $pass_word == "" && $confirm_password == "") {
                    $password_empty = true;
                } else {
                    if ($row['password'] == $old_password) {
                        if ($pass_word == "") {
                            echo "<div class='alert alert-danger'>Please make sure password are not empty </div>";
                            $flag = 1;
                        } elseif (strlen($pass_word) < 8) {
                            echo "<div class='alert alert-danger'>Please make sure password less than 8 character </div>";
                            $flag = 1;
                        } elseif (!preg_match('/[a-z]/', $pass_word)) {
                            echo "<div class='alert alert-danger'> Please make sure password combine capital a-z </div>";
                            $flag = 1;
                        } elseif (!preg_match('/[0-9]/', $pass_word)) {
                            echo " <div class='alert alert-danger'> Please make sure password combine 0-9 </div>";
                            $flag = 1;
                        }

                        if ($old_password == $pass_word) {
                            echo "<div class='alert alert-danger'>Please make sure Old Password cannot same with New Password.</div>";
                            $flag = 1;
                        }
                        if ($old_password != "" && $password != "" && $confirm_password == "") {
                            echo "<div class='alert alert-danger'>Please make sure confirm password are not empty</div>";
                            $flag = 1;
                        }
                        if ($pass_word != $confirm_password) {
                            echo "<div class='alert alert-danger'>Please make sure Confirm Password and New Password are same</div>";
                            $flag = 1;
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Wrong Old Password</div>";
                        $flag = 1;
                    }
                }

                if ($firstname == "") {
                    echo "<div class='alert alert-danger'>Please enter your first name</div>";
                    $flag = 1;
                }

                if ($lastname == "") {
                    echo "<div class='alert alert-danger'>Please enter your last name</div>";
                    $flag = 1;
                }

                if ($gender == "") {
                    echo "<div class='alert alert-danger'>Please select your gender</div>";
                    $flag = 1;
                }

                if ($datebirth == "") {
                    echo "<div class='alert alert-danger'>Please select your date of birth</div>";
                    $flag = 1;
                }

                if ($datebirth == "") {
                    echo "<div class='alert alert-danger'>Please make sure birth date are not empty </div>";
                    $flag = 1;
                } elseif ($diff->format("%R%y") <= "18") {
                    echo "<div class='alert alert-danger'> User need 18 years old and above </div>";
                    $flag = 1;
                }

                // now, if image is not empty, try to upload the image
                if ($_FILES["image"]["name"]) {
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

                if ($flag == 0) {

                    try {
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE customers SET username=:username, image=:image, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, datebirth=:datebirth WHERE user_id = :user_id";
                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // posted values
                        $username = htmlspecialchars(strip_tags($_POST['username']));
                        $image = htmlspecialchars(strip_tags($image));
                        if ($password_empty == true) {
                            $password = $row['password'];
                        } else {
                            $password = htmlspecialchars(strip_tags($_POST['password']));
                        }
                        $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                        $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                        $gender = htmlspecialchars(strip_tags($_POST['gender']));
                        $datebirth = htmlspecialchars(strip_tags($_POST['datebirth']));


                        // bind the parameters
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':image', $image);
                        $stmt->bindParam(':password', $password);
                        $stmt->bindParam(':firstname', $firstname);
                        $stmt->bindParam(':lastname', $lastname);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':datebirth', $datebirth);
                        $stmt->bindParam(':user_id', $user_id);
                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was updated.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }

                    // show errors
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            } ?>

            <?php
            if (isset($_POST['delete'])) {
                $image = htmlspecialchars(strip_tags($image));

                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $target_directory = "uploads/";
                $target_file = $target_directory . $image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                unlink("uploads/" . $row['image']);
                $query = "UPDATE customers
                        SET image=:image WHERE user_id = :user_id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                $stmt->bindParam(':image', $image);
                $stmt->bindParam(':user_id', $user_id);
                // Execute the query
                $stmt->execute();
            }
            ?>


            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?user_id={$user_id}"); ?>" method="post" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Username</td>
                        <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Image</td>
                        <td>
                            <div><img src="uploads/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" class="w-25"></div>
                            <div><input type="file" name="image" value="<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" /></div>
                            

                            <?php
                            if ($image != "profile_default.png") {
                                echo "<input type='submit' value='Delete' name='delete' class='btn btn-primary' />";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Old Password</td>
                        <td><input type='password' name='old_password' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>New Password</td>
                        <td><input type='text' name='password' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input type='text' name='confirm_password' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><input type='text' name='gender' value="<?php echo htmlspecialchars($gender, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Date Of Birth</td>
                        <td><input type='date' name='datebirth' value="<?php echo htmlspecialchars($datebirth, ENT_QUOTES);  ?>" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save Changes' class='btn btn-primary' />
                            <a href='customer_read.php' class='btn btn-danger'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </form>

        </div>
        <!-- end .container -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>