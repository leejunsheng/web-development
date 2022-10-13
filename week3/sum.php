<!DOCTYPE html>

<html>

<head>
    <title>PHP CODE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="d-flex flex-wrap">
        <?php
        $sum = 0;
        $plus = "+";

        for ($num = 1; $num <= 100; $num++) {

            if ($num == 100) {
                $plus = " ";
            }

            if ($num % 2 == 0) {
                echo "<p class = \"text-center d-flex \"><strong> $num $plus </strong></p>";
            } else {
                echo "<p class = \"text-center d-flex\">  $num $plus</p>";
            }
            
            $sum = $sum + $num;
        }
        echo "<p class = \" text-center\"> \nTotal = $sum </p>";
        ?></div>
</body>

</html>