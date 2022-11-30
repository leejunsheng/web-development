<?php
// include database connection
include 'check_user_login.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Customer Create</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>


<body>
    <!-- container -->
    <div>
        <?php include 'topnav.html'; ?>
        <!-- html form to create product will be here -->

        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            $user_name = $_POST['username'];
            $pass_word = $_POST['password'];
            $comfirm_pasword = $_POST['comfirm_password'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $datebirth = $_POST['datebirth'];
            $accstatus = $_POST['accstatus'];

            $today = date("Ymd");
            $date1 = date_create($datebirth);
            $date2 = date_create($today);
            $diff = date_diff($date1, $date2);
            $flag = 0;

            if ($user_name == "") {
                echo "<div class='alert alert-danger'>Please make sure username are not empty</div>";
                $flag = 1;
            } elseif (strlen($user_name) < 6) {
                echo "<div class='alert alert-danger'>Please make sure uername not less than 6 character</div>";
                $flag = 1;
            } elseif (preg_match('/[" "]/', $user_name)) {
                echo "<div class='alert alert-danger'>Please make sure uername did not conatain space</div>";
                $flag = 1;
            }

            if ($pass_word == "") {
                echo "<div class='alert alert-danger'>Please make sure password are not empty</div>";
                $flag = 1;
            } elseif (strlen($pass_word) < 8) {
                echo "<div class='alert alert-danger'>Please make sure password less than 8 character</div>";
                $flag = 1;
            } elseif (!preg_match('/[A-Z]/', $pass_word)) {
                echo "<div class='alert alert-danger'>Please make sure password combine capital A-Z</div>";
                $flag = 1;
            } elseif (!preg_match('/[a-z]/', $pass_word)) {
                echo "<div class='alert alert-danger'>Please make sure password combine capital a-z</div>";
                $flag = 1;
            } elseif (!preg_match('/[0-9]/', $pass_word)) {
                echo "<div class='alert alert-danger'>Please make sure password combine 0-9</div>";
                $flag = 1;
            }

            if ($comfirm_pasword != $pass_word) {
                echo "<div class='alert alert-danger'>Please make sure comfirm_password and password are same</div>";
                $flag = 1;
            }

            if ($firstname == "") {
                echo "<div class='alert alert-danger'>Please make sure firstname are not empty</div>";
                $flag = 1;
            }

            if ($lastname == "") {
                echo "<div class='alert alert-danger'>Please make sure lastname are not empty</div>";
                $flag = 1;
            }

            if ($datebirth == "") {
                echo "<div class='alert alert-danger'>Please make sure birth date are not empty</div>";
                $flag = 1;
            } elseif ($diff->format("%R%y") <= "18") {
                echo "<div class='alert alert-danger'>User need 18 years old and above</div>";
                $flag = 1;
            }

            if ($accstatus == "") {
                echo "<div class='alert alert-danger'>Please make sure account status are not empty</div>";
                $flag = 1;
            }

            if ($flag == 0) {
                // include database connection
                include 'config/database.php';

                try {
                    // insert query
                    $query = "INSERT INTO customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname,gender=:gender,datebirth=:datebirth,registration_dt=:registration_dt,accstatus=:accstatus";

                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':username', $user_name);
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
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' /></td>

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
                    <td><input type='text' name='firstname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td><input type='text' name='lastname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input class="form-check-input" type="radio" name='gender' value="Male">
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
                    <td><input type='date' name='datebirth' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type='text' name='accstatus' class='form-control' /></td>
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