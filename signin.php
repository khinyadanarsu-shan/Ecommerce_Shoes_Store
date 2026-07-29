<?php
session_start();
require_once "db.php";
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = "";
$forgot_password = false;
$forgot_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['forgot_password'])) {
        $forgot_username = trim($_POST["forgot_username"]);

        $stmt = $conn->prepare("SELECT email, password FROM users WHERE LOWER(username) = LOWER(?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $forgot_username);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($email, $old_password_hash);
            $stmt->fetch();

            $reset_code = rand(100000, 999999);
            $expiry = time() + 3600;

            $_SESSION['reset_code'] = $reset_code;
            $_SESSION['code_expiry'] = $expiry;
            $_SESSION['reset_username'] = $forgot_username;
            $_SESSION['old_password_hash'] = $old_password_hash;

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
                $mail->Subject = 'Password Reset Verification Code';
                $mail->Body    = "Your verification code is: <b>$reset_code</b><br>This code expires in 1 hour.";

                $mail->send();
                header("Location: reset_password.php?step=verify");
                exit;
            } catch (Exception $e) {
                $forgot_error = "Mail could not be sent. Please try again later.";
            }
        } else {
            $forgot_error = "Username not found.";
        }
        $stmt->close();
    }
    if (isset($_POST['signin'])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $stmt = $conn->prepare("SELECT id, password, email FROM users WHERE LOWER(username) = LOWER(?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $username);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed_password, $email);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $verification_code = rand(100000, 999999);

                $_SESSION["verification_code"] = $verification_code;
                $_SESSION["code_expires_at"] = time() + 60;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["user_email"] = $email;
                $_SESSION["username"] = $username;

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
                    $mail->Subject = 'Your 2FA Verification Code';
                    $mail->Body    = "Your verification code is: <b>$verification_code</b>";

                    $mail->send();
                    header("Location: 2fa.php");
                    exit;
                } catch (Exception $e) {
                    $error = "Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username is not found.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign In</title>
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
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeInUp 0.8s ease forwards;
        }

        .login-container {
            background: white;
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            width: 350px;
            border-top: 5px solid rgb(96, 209, 211);
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.3s;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            transform: scale(1.02);
            box-shadow: 0 0 8pxrgb(138, 208, 227);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color:rgb(96, 209, 211);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color:rgb(96, 209, 211);
            transform: translateY(-2px);
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        p {
            text-align: center;
            margin-top: 15px;
        }

        a {
            color:rgb(96, 209, 211);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 style="text-align:center;">Sign In</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="signin.php">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="signin">Sign In</button>

        </form>
        <p style="text-align:center; margin-top: 15px;">
            Don't have an account? <a href="signup.php">Sign Up</a>
        </p>
        <p style="text-align:center; margin-top: 10px;">
            <a href="reset_password.php" onclick="document.getElementById('forgot-form').style.display='block'; this.style.display='none'; return false;">Forgot Password?</a>
        </p>
        <div id="forgot-form" style="display: none; margin-top: 20px;">
            <?php if (!empty($forgot_error)): ?>
                <div class="error"><?php echo $forgot_error; ?></div>
            <?php endif; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="text" name="forgot_username" placeholder="Enter your username" required
                    value="<?php echo isset($_POST['forgot_username']) ? htmlspecialchars($_POST['forgot_username']) : '' ?>" />
                <button type="submit" name="forgot_password">Send Verification Code</button>
                <button type="button" onclick="hideForgotForm()"
                    style="background-color: #6b7280; margin-top: 10px;">
                    Cancel
                </button>
            </form>
        </div>
    </div>
</body>
<script>
    function hideForgotForm() {
        document.getElementById('forgot-form').style.display = 'none';
        document.querySelector('p a').style.display = 'inline';
    }

    // Show forgot form if there's an error
    <?php if (!empty($forgot_error)): ?>
        document.getElementById('forgot-form').style.display = 'block';
        document.querySelector('p a').style.display = 'none';
    <?php endif; ?>
</script>

</html>