<!DOCTYPE html>

<html>

<head>
    <title>Homework2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
                $day = date("d");

                for ($num = 1; $num <= 31; $num++) {
                    $state = "";
                    if ($num == $day) {
                        $state = "selected";
                    }
                    echo "<option class=text-dark value=$num $state>$num </option>";
                }
                ?>
            </select>
        </div>

        <div class="col-2">
        <select class="form-select bg-warning text-light" aria-label="Default select example">
            <option selected class="text-light">Month</option>
            <?php
            $cur_month = date("n");
            $month = array("Month","January","Febuary","March","April","May","June","July","August","September","October","November","December");
            for ($m = 1; $m <= 12; $m++) {
                if($m == $cur_month){
                    echo "<option class=\"text-light\" value=\"$m\" selected>$month[$m]</option>";
                }
                else{
                    echo "<option class=\"text-light\" value=\"$m\">$month[$m]</option>";
                }

            }
            ?>
        </select>
        </div>

        <div class="col-2">
            <select class="form-select bg-danger" aria-label="Default select example">
                <option selected class="text-light"> Year </option>
                <?php
                $current_year = date("Y");
                for ($year = 1900; $year <= $current_year; $year++) {
                    $state = "";
                    if ($current_year == $year) {
                        $state = "selected";
                    }
                    echo "<option class=text-dark value=$year $state>$year </option>";
                }
                ?>
            </select>
        </div>

    </div>
</body>

</html>