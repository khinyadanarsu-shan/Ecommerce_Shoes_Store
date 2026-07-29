<?php
session_start();

// Debugging - check what's in session (remove in production)
error_log("Session data: " . print_r($_SESSION, true));

require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if code exists and is not expired
    if (empty($_SESSION["verification_code"]) || empty($_SESSION["code_expires_at"])) {
        $error = "Session expired. Please login again.";
        $show_login_button = true;
    } elseif (time() > $_SESSION["code_expires_at"]) {
        $error = "Verification code expired (60 seconds limit). Please login again.";
        $show_login_button = true;
        unset($_SESSION["verification_code"]); // Clear expired code
    } else {
        $input_code = trim($_POST["verification_code"]);
        $email = $_SESSION["user_email"];
        
        if ($input_code == $_SESSION["verification_code"]) {
            // Fetch role from database using email from session
            $stmt = $conn->prepare("SELECT role FROM users WHERE email = ?");
            if (!$stmt) {
                $error = "Database error. Please try again.";
            } else {
                $stmt->bind_param("s", $email);
                if ($stmt->execute()) {
                    $stmt->bind_result($role);
                    if ($stmt->fetch()) {
                        // Ensure role is treated as integer
                        $role = (int)$role;
                        
                        if ($role === 0) {
                            header("Location: admin_dashboard.php");
                            exit;
                        } elseif ($role === 1) {
                            header("Location: home.php");
                            exit;
                        } else {
                            $error = "Invalid user role.";
                        }
                    } else {
                        $error = "User not found.";
                    }
                } else {
                    $error = "Database error. Please try again.";
                }
                $stmt->close();
            }
        } else {
            $error = "Incorrect verification code.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>2FA Verification</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .verification-container {
            background: white;
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            border-radius: 15px;
            width: 350px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color:rgb(96, 241, 234);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="verification-container">
    <h2 style="text-align:center;">Enter Verification Code</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
        <?php if (isset($show_login_button) && $show_login_button): ?>
            <a href="signin.php" style="display: block; text-align: center; margin-top: 15px;">
                <button style="background-color: #6b7280;">Go Back to Login</button>
            </a>
        <?php endif; ?>
    <?php endif; ?>
    <form method="post" action="2fa.php">
        <input type="text" name="verification_code" placeholder="Verification Code" required />
        <div class="time-left" style="color: #a78bfa; margin-bottom: 15px;"></div>
        <button type="submit">Verify</button>
    </form>
</div>
</body>
<script>
    let expiry = <?php echo $_SESSION["code_expires_at"] ?? 0; ?>;
    let timer = setInterval(() => {
    let secondsLeft = Math.max(0, expiry - Math.floor(Date.now()/1000));
    if (secondsLeft <= 0) {
        clearInterval(timer);
        document.querySelector('.time-left').textContent = "Code expired!";
    } else {
        document.querySelector('.time-left').textContent = `Time left: ${secondsLeft}s`;
    }
}, 1000);
</script>
</html>
