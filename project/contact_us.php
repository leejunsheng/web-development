<?php
// include database connection
    include 'check_user_login.php';
    ?>
    
<!DOCTYPE HTML>
<html>

<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>


<body>
<?php include 'topnav.html'; ?>
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
                        <input type='submit' value='Save' class='btn btn-primary' />

                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </div>
            </form>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"> </script>
</body>

</html>