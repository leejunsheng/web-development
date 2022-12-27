<?php
// include database connection
include 'check_user_login.php';
?>

<?php include 'topnav.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Contact Page</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>


<body>
    <div class=" text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto">
            <h1>Contact Us</h1>
        </div>
    </div>

    <div class="container">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="John Doe">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Your Message</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <td>
                    <input type='submit' value='Save' class='btn btn-primary mx-2' />



                    <a href='index.php' class='btn btn-danger'>Back to home</a>
                </td>
            </div>
        </form>
    </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>