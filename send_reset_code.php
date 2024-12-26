<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['Email'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'caravan');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM broker WHERE Email = ?");
    $stmt->bind_param("s", $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $reset_code = rand(100000, 999999);

        // Store the reset code in the database
        $stmt = $conn->prepare("UPDATE broker SET reset_code = ? WHERE id = ?");
        $stmt->bind_param("si", $reset_code, $user['id']);
        $stmt->execute();

        // Send email with PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'nitinpa987@gmail.com'; // Your email
            $mail->Password = 'Password'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('nitinpa987@gmail.com', 'Caravan');
            $mail->addAddress($user['Email']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Code';
            $mail->Body = "Your reset code is: <strong>$reset_code</strong>";

            $mail->send();
            echo 'Reset code has been sent to your email.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>