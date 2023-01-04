<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5>Welcome, <?php echo $_SESSION['username']; ?></h5>
            </div>

            <ul class="list-unstyled components ">
                <p>Dummy Heading</p>
                <li >
                    <a aria-current="page" href="index.php">Dashboard</a>
                </li>

                <li >
                    <a href="#pageSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Customer</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                          <a class="nav-bar" href="customer_create.php">Create Customer</a>
                        </li>
                        <li>
                          <a class="nav-bar" href="customer_read.php">Customer List</a>
                        </li>
                      </ul>
                </li>
                

                <li>
                    <a href="#pageSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Product</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a class="nav-link" href="product_create.php">Create New Product</a>
                        </li>
                        <li>
                            <a class="nav-link" href="product_read.php">Product List</a>
                        </li>
                   
                    </ul>
                </li>

                <li>
                    <a href="#pageSubmenu1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Order</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu1">
                        <li>
                            <a class="nav-link" href="order_create.php">Create New Order</a>
                        </li>
                        <li>
                            <a class="nav-link" href="order_summary.php">Order Summary</a>
                        </li>
                   
                    </ul>
                </li>
                <li>
                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                </li>
        
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a class="nav-link text-dark" href="logout.php"> <i class="fa-solid fa-right-from-bracket">Logout</i> Logout </a>
                </li>
             
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>


                </div>
            </nav>