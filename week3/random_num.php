<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <title>PHP CODE</title>

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

<body>

<?php
$num1 = rand (100, 200); 
$num2 = rand (100, 200);
$sum = $num1 + $num2;
$multiple = ($num1 * $num2);


echo "<p class=\"green italic \">$num1</p>";
echo  "<p class = \"blue italic \">  $num2</p>";
echo  "<p class = \"red \"> <strong> $sum <strong> </p>";
echo  "<p class = \" italic \"> <strong> $multiple <strong></p>";
?>
</body>
</html>