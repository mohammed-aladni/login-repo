<?php
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Debugging: Check if environment variables are loaded correctly
    // echo 'SMTP_USER: ' . $_SERVER['SMTP_USER'] . "<br>";
    //echo 'SMTP_PASS: ' . $_SERVER['SMTP_PASS'] . "<br>";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $_SERVER['SMTP_USER']; // Retrieve the email from environment variable
        $mail->Password = $_SERVER['SMTP_PASS']; // Retrieve the password from environment variable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Disable SSL verification (temporary solution for testing)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Email content settings
        $mail->setFrom($email, $name);
        $mail->addAddress('mohammed10aladni@gmail.com'); // Replace with recipient's email

        $mail->isHTML(false);
        $mail->Subject = "New Message from Contact Form";
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        // Send email
        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send message. Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Method Not Allowed";
}
?>
