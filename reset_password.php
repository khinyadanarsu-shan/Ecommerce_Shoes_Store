<?php
session_start();
require_once "db.php";

$error = "";
$success = "";
$current_step = $_GET['step'] ?? 'request';

// Step 1: Verify reset code
if ($current_step === 'verify' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = trim($_POST['verification_code']);

    if (empty($_SESSION['reset_code']) || empty($_SESSION['code_expiry'])) {
        $error = "Invalid request. Please start over.";
    } elseif (time() > $_SESSION['code_expiry']) {
        $error = "Code expired. Please request a new one.";
    } elseif ($entered_code != $_SESSION['reset_code']) {
        $error = "Invalid verification code.";
    } else {
        header("Location: reset_password.php?step=change");
        exit;
    }
}

// Step 2: Change password
if ($current_step === 'change' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($_SESSION['reset_username']) || empty($_SESSION['old_password_hash'])) {
        $error = "Session expired. Please start over.";
    } elseif (strlen($new_password) < 8) {
        $error = "Password must be at least 8 characters";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $new_password)) {
        $error = "Password must contain uppercase, lowercase, number, and special character";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (password_verify($new_password, $_SESSION['old_password_hash'])) {
        $error = "New password cannot be same as old password";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashed_password, $_SESSION['reset_username']);

        if ($stmt->execute()) {
            // Clear all reset data
            unset($_SESSION['reset_code']);
            unset($_SESSION['code_expiry']);
            unset($_SESSION['reset_username']);
            unset($_SESSION['old_password_hash']);

            $success = "Password updated successfully! You can now <a href='signin.php'>login</a>.";
        } else {
            $error = "Database error. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .reset-container {
            background: white;
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            width: 350px;
            border-top: 5px solidrgb(96, 213, 231);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #333;
            margin-top: 0;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Input Fields */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color:rgb(95, 206, 219);
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.2);
            outline: none;
        }

        /* Buttons */
        button {
            width: 100%;
            padding: 12px;
            background-color: rgb(95, 206, 219);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        button:hover {
            background-color: rgb(95, 206, 219);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .cancel-btn {
            background-color: #6b7280;
            margin-top: 10px;
        }

        .cancel-btn:hover {
            background-color: #4b5563;
        }

        /* Messages */
        .error {
            color: #ef4444;
            background-color: #fee2e2;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .success {
            color: #10b981;
            background-color: #d1fae5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
            position: relative;
        }

        .step.active {
            background-color:rgb(95, 206, 219);
            color: white;
        }

        .step.completed {
            background-color:rgb(181, 25, 116);
            color: white;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 2px;
            background-color: #e5e7eb;
            right: -20px;
        }

        /* Form Steps */
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .form-step.active {
            display: block;
        }

        .info-text {
            color: #6b7280;
            font-size: 13px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Password Requirements */
        .password-hints {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .password-hints ul {
            padding-left: 20px;
            margin: 5px 0;
        }

        .password-hints li {
            margin-bottom: 5px;
            color: #6b7280;
        }

        .password-hints li.valid {
            color: #10b981;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step <?php echo $current_step === 'verify' ? 'active' : ($current_step === 'change' ? 'completed' : ''); ?>">1</div>
            <div class="step <?php echo $current_step === 'change' ? 'active' : ''; ?>">2</div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php else: ?>

            <!-- Verification Code Form -->
            <div class="form-step <?php echo $current_step === 'verify' ? 'active' : ''; ?>">
                <h2>Verify Your Identity</h2>
                <p class="info-text">We've sent a 6-digit code to your email</p>
                <form method="post" action="reset_password.php?step=verify">
                    <input type="text" name="verification_code" placeholder="Enter verification code" required maxlength="6" pattern="\d{6}" title="Please enter a 6-digit code" />
                    <button type="submit">Verify Code</button>
                </form>
            </div>

            <!-- New Password Form -->
            <div class="form-step <?php echo $current_step === 'change' ? 'active' : ''; ?>">
                <h2>Create New Password</h2>
                <div class="password-hints">
                    <p>Password must contain:</p>
                    <ul>
                        <li id="length-requirement">At least 8 characters and must contain uppercase, lowercase, number, and special character</li>
                        <li id="match-requirement">Passwords must match</li>
                        <li id="different-requirement">Different from old password</li>
                    </ul>
                </div>
                <form method="post" action="reset_password.php?step=change">
                    <input type="password" name="new_password" placeholder="New Password" required minlength="8" id="new-password" />
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required minlength="8" id="confirm-password" />
                    <button type="submit">Change Password</button>
                </form>
            </div>

        <?php endif; ?>
    </div>

    <script>
        // Password validation feedback
        document.getElementById('new-password').addEventListener('input', validatePassword);
        document.getElementById('confirm-password').addEventListener('input', validatePassword);

        function validatePassword() {
            const newPass = document.getElementById('new-password').value;
            const confirmPass = document.getElementById('confirm-password').value;

            // Length requirement
            document.getElementById('length-requirement').className = newPass.length >= 8 ? 'valid' : '';

            // Match requirement
            document.getElementById('match-requirement').className =
                confirmPass && newPass === confirmPass ? 'valid' : '';
        }
    </script>
</body>

</html>