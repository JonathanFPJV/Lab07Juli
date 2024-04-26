<?php

// Example of input validation for an email address
$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid email format
    echo "Invalid email address";
}

?>
