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
    <?php
    $sum = 0;

    for ($num = 1; $num <= 100; $num++) {
        if ($num % 2 == 0) {
            echo "<h1 class = \"text-center \"> $num </h1>";
        } else {
            echo "<p class = \"col text-center\"> $num </p>";
        }
        $sum = $sum + $num;
    }
    echo "<p class = \"col text-center\"> $sum </p>";
    ?>
</body>
</html>