<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] :  die('ERROR: Record ID not found.');

    $select = "SELECT username AS check_user, image FROM customers WHERE user_id=:user_id";
    $stmt = $con->prepare($select);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $check = "SELECT user FROM order_summary WHERE user=:user";
    $stmt = $con->prepare($check);
    $stmt->bindParam(":user", $check_user);
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
    
        header('Location: customer_read.php?action=faildelete');
    } else {
        // delete query
        $query = "DELETE FROM customers WHERE user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $user_id);

        if ($stmt->execute()) {
            unlink("uploads/customer/" . $row['image']);
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: customer_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
