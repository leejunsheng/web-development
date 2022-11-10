<!DOCTYPE html>

<html>

<head>
    <title>Homework2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/91b33330fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</head>

<?php
// used to connect to the database
$host = "localhost";
$db_name = "eshop";
$username = "eshop";
$password = "eshop2250159";



try {
    $mysqli = mysqli_connect($host, $username, $password ,$db_name);
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
}

// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>

</html>