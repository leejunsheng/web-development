
<?php
// used to connect to the database
$host = "sql109.epizy.com";
$db_name = "epiz_33245137_eshop";
$dbuser_name = "epiz_33245137";
$dbpass_word = "RYGTRraeS4bN";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $dbuser_name, $dbpass_word);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
}

// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>
