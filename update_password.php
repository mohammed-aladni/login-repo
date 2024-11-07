<?php
require 'database_connection.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the new password

    // Update the user's password, clear reset_token and token_expiry
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);
    $stmt->execute();
    $stmt->close();

    echo 'Your password has been successfully reset.';
}
?>
