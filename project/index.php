<?php
// To check user are login
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
    <!-- container -->
    <div>
        <?php include 'topnav.html'; ?>

        <div class="pt-3 p-md-2 m-md-2 text-center bg-light">
            <div class="col-md-5 p-lg-5 mx-auto my-5">
                <h1 class="display-4 fw-normal">Product</h1>
                <p class="lead fw-normal">Showing some dummy content</p>
                <a class="btn btn-outline-secondary" href="#">Coming soon</a>
            </div>
        </div>

        <div class="row container-fluid">
            <div class="col-lg-4 text-center">
                <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                </svg>

                <h2 class="fw-normal">Heading</h2>
                <p>Some representative placeholder content for the three columns of text below the carousel. This is the first column.</p>
                <p><a class="btn btn-secondary" href="#">View details »</a></p>
            </div><!-- /.col-lg-4 -->

            <div class="col-lg-4 text-center">
                <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                </svg>
                <h2 class="fw-normal">Heading</h2>
                <p>Another exciting bit of representative placeholder content. This time, we've moved on to the second column.</p>
                <p><a class="btn btn-secondary" href="#">View details »</a></p>
            </div><!-- /.col-lg-4 -->

            <div class="col-lg-4 text-center">
                <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                </svg>
                <h2 class="fw-normal">Heading</h2>
                <p>And lastly this, the third column of representative placeholder content.</p>
                <p><a class="btn btn-secondary" href="#">View details »</a></p>
            </div><!-- /.col-lg-4 -->
        </div>

    </div>
    <?php


    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"> </script>
</body>

</html>