<!DOCTYPE html>
<html>

   

<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid d-flex justify-content-end ">
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link text-white" aria-current="page" href="index.php">Dashboard</a>
                </li>

                <div class="dropdown ">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Customer
                    </a>
                    <ul class="dropdown-menu">
                        <a class="nav-link" href="customer_create.php">Create Customer</a>
                        <a class="nav-link" href="customer_read.php">Customer List</a>
                    </ul>
                </div>

                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Product
                    </a>
                    <ul class="dropdown-menu">
                        <a class="nav-link" href="product_create.php">Create New Product</a>
                        <a class="nav-link" href="product_read.php">Product List</a>
                    </ul>
                </div>

                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Order
                    </a>
                    <ul class="dropdown-menu">
                        <a class="nav-link" href="order_create.php">Create New Order</a>
                        <a class="nav-link" href="order_summary.php">Order Summary</a>
                    </ul>
                </div>

                <li class="nav-item">
                    <a class="nav-link text-white" href="contact_us.php">Contact Us</a>
                </li>

                <div class="dropdown mx-2">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Welcome, <?php echo $_SESSION['username']; ?>
            </a>
            <ul class="dropdown-menu">
                <a class="nav-link text-dark" href="logout.php"> <i class="fa-solid fa-right-from-bracket">Logout</i> Logout </a>
            </ul>
        </div>
            </ul>
        </div>
    </div>
</nav>

</html>