<?php
// include database connection
    include 'check_user_login.php';
    ?>
    
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div>
    <?php include 'topnav.php'; ?>
    
        <div class="page-header">
            <h1>Read Customer</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php

        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM customers WHERE user_id = :user_id";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":user_id", $user_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $username = $row['username'];
            $image = $row['image'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $datebirth = $row['datebirth'];
            $registration_dt = $row['registration_dt'];
            $accstatus = $row['accstatus'];
            // shorter way to do that is extract($row)
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
                <td>Username</td>
                <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Images</td>
                <td>
                    <div><img src="uploads/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" class="w-25 mb-2"></div>
                </td>
            </tr>
            <tr>
                <td>First name</td>
                <td><?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Last name</td>
                <td><?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Birth Date</td>
                <td><?php echo htmlspecialchars($datebirth, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Registeration Data</td>
                <td><?php echo htmlspecialchars($registration_dt, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Account Status</td>
                <td><?php echo htmlspecialchars($accstatus, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='customer_read.php' class='btn btn-danger m-r-1em mx-2'>Back to read customers</a>
                    <a href='product_update.php?id={$id}' class='btn btn-primary m-r-1em mx-2'>Edit</a>
                </td>
            </tr>
        </table>

    </div> <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>

</body>

</html>