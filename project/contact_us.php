<!DOCTYPE HTML>
<html>

<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"> </script>
</head>

<body>
    <!-- container -->
    <div>
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="nav-link text-white" aria-current="page" href="http://localhost/web/project/index.php">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"> <a class="nav-link text-white" href="http://localhost/web/project/product_create.php">Create Product</a></li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/customer_create.php">Create Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://localhost/web/project/contact_us.php">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

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
                <td >
                        <input type='submit' value='Save' class='btn btn-primary' /> 
               
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td></div>
            </form>
        </div>

        <div class="container">
            <footer class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="http://localhost/web/project/index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-muted" href="http://localhost/web/project/product_create.php">Create Product</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  text-muted" href="http://localhost/web/project/customer_create.php">Create Customer</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  text-muted" href="http://localhost/web/project/contact_us.php">Contact Us</a>
                    </li>
                </ul>
                <p class="text-center text-muted">© 2022 Company, Inc</p>
            </footer>
        </div>

    </div>
</body>

</html>