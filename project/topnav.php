<!DOCTYPE html>

<head>
    <style>
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <title>topnav</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid d-flex justify-content-end">
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link text-white" aria-current="page" href="index.php">Home</a>
                </li>

                <div class="dropdown ">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Customer
                    </a>
                    <ul class="dropdown-menu">
                        <a class="nav-link" href="customer_create.php">Create Customer</a>
                        <a class="nav-link" href="customer_read.php">Customer List</a>
                    </ul>
                </div>

                <div class="dropdown mx-2">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Product
                    </a>
                    <ul class="dropdown-menu">
                        <a class="nav-link" href="product_create.php">Create New Product</a>
                        <a class="nav-link" href="product_read.php">Product List</a>
                    </ul>
                </div>

                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Order
                    </a>
                    <ul class="dropdown-menu">
                        <a class="nav-link" href="create_new_order.php">Create New Order</a>
                        <a class="nav-link" href="order_details.php">Order Detail</a>
                        <a class="nav-link" href="order_summary.php">Order Summary</a>
                    </ul>
                </div>

                <li class="nav-item">
                    <a class="nav-link text-white" href="contact_us.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
      
    </div>
    <h6 class="m-2 text-end text-white"><?php echo $_SESSION["login"] ?></h6>
</nav>