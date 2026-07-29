<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['errors']['form'] = "Invalid CSRF token. Please try again.";
        header("Location: signup.php");
        exit();
    }
}

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function isStrongPassword($password)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $captcha_input = trim($_POST['captcha_input']);
    $captcha_hidden = trim($_POST['captcha_hidden']);

    // Check username availability
    $check_username = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    // Check email availability
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    $errors = [];

    if ($check_username->num_rows > 0) {
        $errors['username'] = "This username is already taken";
    }

    if ($check_email->num_rows > 0) {
        $errors['email'] = "This email is already registered";
    }

    if (!isStrongPassword($password)) {
        $errors['password'] = "Password must contain uppercase, lowercase, number, symbol, and be at least 8 characters";
    }

    if (strtoupper($captcha_input) !== strtoupper($captcha_hidden)) {
        $errors['captcha'] = "The CAPTCHA code doesn't match";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = [
            'username' => htmlspecialchars($username),
            'email' => htmlspecialchars($email)
        ];
        header("Location: signup.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = 1;

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['errors']['form'] = "Database error. Please try again.";
        header("Location: signup.php");
        exit();
    }

    $stmt->bind_param("sssi", $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Sign up successful! Please check your email.";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hsushan2162005@gmail.com';
            $mail->Password = 'ywqqkefkqogqcwrw';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('hsushan2162005@gmail.com', 'Shoes Store');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Shoes Store!';
            $mail->Body    = '
                <html>
                <head>
                    <title>Welcome to Shoes Store</title>
                </head>
                <body>
                    <h2>Thank you for registering!</h2>
                    <p>Your registration was successful. You can now log in to your account.</p>
                </body>
                </html>
            ';

            $mail->send();
            header("Location: signin.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['alert'] = "Account created but welcome email failed: " . $e->getMessage();
            header("Location: signin.php");
            exit();
        }
    } else {
        $_SESSION['errors']['form'] = "Registration failed: " . $stmt->error;
        header("Location: signup.php");
        exit();
    }
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shoes Store - Sign Up</title>
    <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeInUp 1s ease forwards;
        }

        form {
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 350px;
            border-top: 5px solid rgb(96, 209, 211);
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.5s;
        }

        h2 {
            text-align: center;
            color: rgb(96, 209, 211);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            transform: scale(1.02);
            box-shadow: 0 0 8px rgb(96, 209, 211);
        }

        input[type="submit"] {
            background-color:rgb(96, 209, 211);
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color:rgb(96, 209, 211);
        }

        #strengthMessage {
            margin-top: 1px;
            margin-left: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        p {
            text-align: center;
            margin-top: 15px;
        }

        a {
            color: rgb(96, 209, 211);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-container {
            margin-bottom: 1.5rem;
            animation: fadeIn 0.3s ease-out;
        }

        .error-message {
            background: #fef2f2;
            color: #b91c1c;
            padding: 12px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #dc2626;
            margin-bottom: 8px;
            position: relative;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .error-message svg {
            flex-shrink: 0;
            color: #dc2626;
        }

        .close-error {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
        }

        .close-error:hover {
            opacity: 1;
        }

        .fade-out {
            opacity: 0;
            transform: translateY(-10px);
            height: 0;
            padding-top: 0;
            padding-bottom: 0;
            margin-bottom: 0;
            overflow: hidden;
        }

        .password-error-container {
            margin-bottom: 1rem;
        }

        .strength-detail {
            font-size: 0.85rem;
            margin-top: 0.25rem;
            font-style: italic;
        }

        /* Add these to your existing error styles */
        .error-message {
            /* Your existing error styles */
            transition: all 0.3s ease;
        }

        .error-message.hidden {
            opacity: 0;
            transform: translateY(-10px);
            height: 0;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
    </style>
</head>

<body>

    <form action="signup.php" method="POST" onsubmit="return validateForm()">
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="error-container" id="errorContainer">
                <?php foreach ($_SESSION['errors'] as $field => $error): ?>
                    <div class="error-message" data-field="<?= $field ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span><?= htmlspecialchars($error) ?></span>
                        <button type="button" class="close-error" aria-label="Close">&times;</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <h2>Create Account</h2>

        <input type="text" name="username" placeholder="Username" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" onkeyup="checkStrength(this.value)" required>
        <div class="flex items-center mt-1">
            <span id="strengthMessage" class="font-medium">Strength</span>
        </div>

        <p>Enter the text: <strong id="captchaText"></strong></p>
        <input type="text" name="captcha_input" placeholder="Enter captcha" required>
        <input type="hidden" name="captcha_hidden" id="captchaHidden">

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <input type="submit" value="Sign Up">
        <p style="text-align:center; margin-top: 15px;">
            Already have an account? <a href="signin.php">Sign In</a>
        </p>
    </form>

</body>
<script>
    let currentStrength = "Weak";

    function checkStrength(password) {
        let strength = "Weak";
        let color = "#ef4444"; // red-500
        let message = "Password must contain uppercase, lowercase, number, and special character";

        if (password.length >= 8 &&
            /[A-Z]/.test(password) &&
            /[a-z]/.test(password) &&
            /[0-9]/.test(password) &&
            /[^A-Za-z0-9]/.test(password)) {
            strength = "Strong";
            color = "#10b981"; // emerald-500
            message = "Strong password!";
        } else if (password.length >= 6 &&
            /[A-Z]/.test(password) &&
            /[a-z]/.test(password) &&
            /[0-9]/.test(password)) {
            strength = "Moderate";
            color = "#f59e0b"; // amber-500
            message = "Add a special character to strengthen";
        }

        currentStrength = strength;
        const msg = document.getElementById("strengthMessage");
        msg.textContent = strength;
        msg.style.color = color;

        const detailMsg = document.getElementById("strengthDetail");
        if (detailMsg) {
            detailMsg.textContent = message;
            detailMsg.style.color = color;
        }
    }

    function validateForm() {
        if (currentStrength !== "Strong") {
            // Create or show error message
            let errorContainer = document.querySelector('.password-error-container');
            if (!errorContainer) {
                errorContainer = document.createElement('div');
                errorContainer.className = 'password-error-container';
                errorContainer.innerHTML = `
                <div class="error-message" id="passwordStrengthError">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>Password must meet all strength requirements</span>
                    <button class="close-error" aria-label="Close">&times;</button>
                </div>
            `;
                document.querySelector('form').prepend(errorContainer);
            } else {
                errorContainer.style.display = 'block';
            }

            // Scroll to the error
            document.getElementById("passwordStrengthError").scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            return false;
        }
        return true;
    }

    function generateCaptcha() {
        const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        let captcha = "";
        for (let i = 0; i < 5; i++) {
            captcha += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById("captchaText").textContent = captcha;
        document.getElementById("captchaHidden").value = captcha;
    }

    window.onload = generateCaptcha;

    document.addEventListener('DOMContentLoaded', function() {
        // Close button functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('close-error')) {
                const errorMessage = e.target.closest('.error-message');
                fadeOut(errorMessage);
            }
        });

        // Auto-dismiss after 8 seconds
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(msg => {
            setTimeout(() => {
                fadeOut(msg);
            }, 8000);
        });

        function fadeOut(element) {
            if (!element) return;

            element.classList.add('fade-out');
            setTimeout(() => {
                element.remove();

                // Remove container if no more errors
                const container = document.getElementById('errorContainer');
                if (container && container.children.length === 0) {
                    container.remove();
                }
            }, 300);
        }
    });
</script>

</html>