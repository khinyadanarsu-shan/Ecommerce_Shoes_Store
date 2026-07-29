<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = ''; // Change if you set a password
$dbname = 'shoes_store'; // Change to your actual DB name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$success = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $success = "Message sent successfully!";
    } else {
        $success = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Contact Us - Shoes Store</title>
    <style>
   body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f8;
    color: #333;
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  /* Navbar Styles */
  .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to right, #3b8d99, #6bcdcd);
    padding: 12px 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    color: white;
    position: sticky;
    top: 0;
    z-index: 999;
  }

  .navbar .logo {
    font-size: 26px;
    font-weight: bold;
  }

  .navbar ul {
    list-style: none;
    display: flex;
    gap: 25px;
    padding: 0;
    margin: 0;
  }

  .navbar ul li a {
    font-weight: 500;
    padding: 6px 12px;
    transition: background 0.3s, color 0.3s;
  }

  .navbar ul li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 6px;
  }

  .navbar .right {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .navbar input[type="text"] {
    padding: 6px 10px;
    border-radius: 6px;
    border: none;
    outline: none;
    font-size: 14px;
  }

  .navbar button {
    background-color: #ffffff;
    color: #3b8d99;
    font-weight: 500;
    padding: 6px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .navbar button:hover {
    background-color: #e6f7f7;
  }

.hero {
  background: linear-gradient(135deg, #6bcdcd,rgb(34, 51, 56));
  height: 30vh;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
  font-size: 32px;
  font-weight: bold;
  position: relative;
  text-align: center;
  padding: 20px;
  border-radius: 12px;
  box-shadow: inset 0 0 30px rgba(154, 60, 60, 0.3);
}

.hero span {
  background-color: rgba(0, 0, 0, 0.4);
  padding: 15px 30px;
  border-radius: 10px;
  font-size: 30px;
  font-weight: 600;
  letter-spacing: 1px;
}

.footer {
  background: linear-gradient(90deg,rgb(108, 191, 207),rgb(45, 79, 89));
  color: #ecf0f1;
  text-align: center;
  padding: 20px 0;
  font-size: 16px;
  font-weight: 500;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
  position: relative;
  bottom: 0;
  width: 100%;
}

.footer strong {
  color: #f1c40f;
}
.container {
  max-width: 600px;
  margin: 0 auto 60px auto;
  background: white;
  padding: 40px 40px 50px 40px;
  border-radius: 14px;
  box-shadow: 0 12px 40px rgba(30, 60, 114, 0.2);
  margin-top: 50px;
}

.container h2 {
  text-align: center;
  font-weight: 700;
  color:rgb(30, 103, 114);
  margin-bottom: 30px;
  letter-spacing: 0.7px;
  
}

/* Success Message */
.success-message {
  text-align: center;
  color: #16a34a;
  font-weight: 600;
  margin-bottom: 25px;
  background: #d1fae5;
  padding: 12px 18px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(22, 163, 74, 0.3);
  animation: fadeInSuccess 1s ease forwards;
}
@keyframes fadeInSuccess {
  from {opacity: 0; transform: translateY(-10px);}
  to {opacity: 1; transform: translateY(0);}
}

/* Contact Form */
.contact-form {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;

}

.contact-form input,
.contact-form textarea {
  padding: 14px 16px;
  border: 2px solid #d1d5db;
  border-radius: 10px;
  font-size: 16px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  resize: none;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #222;
}

.contact-form input:focus,
.contact-form textarea:focus {
  border-color:rgb(70, 136, 167);
  box-shadow: 0 0 8px rgba(39, 103, 116, 0.5);
  outline: none;
}

.contact-form textarea {
  grid-column: span 2;
  min-height: 140px;
}

.contact-form button {
  grid-column: span 2;
  background-color:rgb(54, 91, 109);
  color: white;
  font-weight: 700;
  padding: 16px 0;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  font-size: 18px;
  box-shadow: 0 8px 15px rgba(58, 155, 177, 0.4);
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.contact-form button:hover {
  background-color:rgb(68, 161, 195);
  transform: translateY(-3px);
  box-shadow: 0 12px 20px rgba(81, 152, 193, 0.6);
}

/* Responsive */
@media (max-width: 700px) {
  .contact-form {
    grid-template-columns: 1fr;
  }
  .contact-form textarea,
  .contact-form button {
    grid-column: span 1;
  }
}
    </style>
</head>
<body>
<!-- Navbar -->
<div class="navbar">
    <div class="logo">Shoes Store</div>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="FAQ.php">FAQ</a></li>
    </ul>  
    <div class="right">
        <form action="product.php" method="GET">
            <input type="text" name="query" placeholder="Search shoes by name..." required>
            <button type="submit">Search</button>
        </form>
        <button class="logout-button" onclick="location.href='signin.php'">Logout</button>
        <button onclick="location.href='cart.php'">Cart 🛒</button>
    </div>
</div>

<div class="container">
    <h2>Contact Us</h2>
    <?php if ($success): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <form class="contact-form" method="post" action="">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</div>

<footer class="footer">
    &copy; <?php echo date("Y"); ?> <strong>Shoes Store</strong>. All rights reserved.
</footer>

<script>
    const navLinks = document.querySelectorAll('.navbar ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            this.classList.remove('animate-click');
            void this.offsetWidth;
            this.classList.add('animate-click');
        });
    });
</script>
</body>
</html>
