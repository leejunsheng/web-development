<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];
}

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] :  die('ERROR: Record ID not found.');
include 'config/database.php';

try {
    $check_user = "SELECT user_id, username AS check_user, image FROM customers INNER JOIN order_summary
         ON customers.username = order_summary.user WHERE customers.user_id = :user_id";
    $stmt = $con->prepare($check_user);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $count = $stmt->rowCount();


    echo "user_id: $user_id<br>";
    echo "current_user_id: $current_user_id<br>";

    if ($count > 0) {
        header('Location: customer_read.php?action=faildelete');
    } else {
        if ($current_user_id == $user_id) {
            // prevent delete operation and show error message
            // or redirect the user to a different page
            echo "Error: You cannot delete yourself!";
        } else {
            // delete query
            $query = "DELETE FROM customers WHERE user_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $user_id);

            if ($stmt->execute()) {
                //unlink("uploads/customer/" . $row['image']);
                // redirect to read records page and
                // tell the user record was deleted
                echo $user_id;
            } else {
                die('Unable to delete record.');
            }
        }
    }
}

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
