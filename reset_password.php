<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "login");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for token in URL and process form submission
if (isset($_GET['token']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_GET['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Find the user with the token and check if it’s still valid
    $result = $conn->query("SELECT * FROM users WHERE reset_token='$token' AND token_expiry > NOW()");
    if ($result->num_rows > 0) {
        // Update the password and clear the reset token
        $conn->query("UPDATE users SET password='$new_password', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'");
        echo "Password has been reset successfully!";
    } else {
        echo "Invalid or expired token!";
    }
}
?>
