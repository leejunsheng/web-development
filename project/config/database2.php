<!DOCTYPE html>

<html>

<?php
// used to connect to the database
$host = "sql109.epizy.com";
$db_name = "epiz_33245137_eshop";
$username = "epiz_33245137";
$password = "RYGTRraeS4bN";

try {
   
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
}

// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>

</html>