<!DOCTYPE html>

<html>
<head>
    <title>PHP CODE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</head>

<style>
.red {
		color: red;
}

.blue {
		color: blue;
}

.green {
		color: green;
}

.italic {
		font-style: italic;
}
</style>

<body class="container">
<div class="row">

<?php
    $num1 = (rand(100, 200));
    $num2 = (rand(100, 200));

    if ($num1 > $num2) {
        echo "<h1 class = \"col text-center \"><strong>$num1</strong></h1>";
        echo "<h2 class = \"col text-center text-white bg-primary\">$num2</h2>";
    } 
    else {
        echo "<h2 class = \"col text-center text-white bg-primary \">$num1</h2>";
        echo "<h1 class = \"col text-center \"><strong>$num2</strong></h1>";
    } 

    ?>

</div>
</body>
</html>