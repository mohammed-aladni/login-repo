<?php
require 'database_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token is valid and not expired
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, allow the user to reset their password
        echo '<form action="update_password.php" method="post">
                <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                <label for="password">New Password</label>
                <input type="password" name="password" required>
                <button type="submit">Reset Password</button>
              </form>';
    } else {
        echo "Invalid or expired token.";
    }
}
?>
