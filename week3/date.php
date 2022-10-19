<!DOCTYPE html>

<html>

<head>
    <title>Homework1</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="container">

    <div class="text-center m-5">
        <h1>What is your date of birth?</h1>
    </div>


    <div class="d-flex justify-content-center ">
        <div class="col-2">
            <select class="form-select bg-info" aria-label="Default select example">
                <option selected>Day</option>
                <?php
                for ($num = 1; $num <= 31; $num++) {
                    echo "<option value=\"$num\">$num</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-2">
            <select class="form-select bg-warning" aria-label="Default select example">
                <option selected>Month</option>
                <?php
                for ($num = 1; $num <= 12; $num++) {
                    echo "<option value=\"$num\">$num</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-2">
            <select class="form-select bg-danger" aria-label="Default select example">
                <option selected>Year</option>
                <?php
                for ($num = 2022; $num >= 1900; $num--) {
                    echo "<option value=\"$num\">$num</option>";
                }
                ?>
            </select>
        </div>

    </div>
</body>
</html>