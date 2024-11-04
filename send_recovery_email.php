<?php
// Database connection details
$conn = new mysqli("localhost", "root", "", "login");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    
    // Check if the email exists in the database
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    
    if ($result->num_rows > 0) {
        // Generate a unique token and expiry time
        $token = bin2hex(random_bytes(50)); // Random token
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token valid for 1 hour

        // Save the token and expiry in the database
        $conn->query("UPDATE users SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'");

        // Create the reset link
        $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;

        // Send email (set up PHP mail settings for this to work)
        mail($email, "Password Reset Request", "Click on this link to reset your password: " . $reset_link);

        echo "A password reset link has been sent to your email.";
    } else {
        echo "Email not found!";
    }
}
?>
