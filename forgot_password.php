<?php
session_start();
include 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $code = rand(100000, 999999);
        $_SESSION['reset_code'] = $code;
        $_SESSION['reset_email'] = $email;
        $_SESSION['code_expires_at'] = time() + 300;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com';
            $mail->Password = 'your_app_password';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Shoes Store');
            $mail->addAddress($email);
            $mail->Subject = 'Reset Password Code';
            $mail->Body = "Your reset password code is: $code";

            $mail->send();
            $success = "Reset code sent to your email.";
            header("Location: reset_password.php");
            exit;
        } catch (Exception $e) {
            $error = "Email error: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Forgot Password</title></head>
<body>
<h2>Forgot Password</h2>
<form method="post">
    <input type="email" name="email" required placeholder="Enter your email"><br>
    <button type="submit">Send Reset Code</button>
</form>
<p style="color:green;"><?php echo $success; ?></p>
<p style="color:red;"><?php echo $error; ?></p>
</body>
</html>