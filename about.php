<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>About Us - Shoes Store</title>
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


.footer {
  background: linear-gradient(90deg,rgb(108, 191, 207),rgb(45, 79, 89)); /* Dark gradient */
  color: #ecf0f1; /* Light text */
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
  color: #f1c40f; /* Highlight brand name in yellow */
}

        .about-section {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        .about-section h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        .about-section p {
            font-size: 16px;
            line-height: 1.7;
            color: #555;
            margin-bottom: 15px;
        }

        .about-section .highlight {
            color: rgb(117, 178, 184);
            font-weight: bold;
        }

        .about-section .team {
            margin-top: 40px;
        }

        .about-section .team h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }

        .about-section .team-members {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .about-section .member {
            background: #e7f7f9;
            padding: 15px;
            border-radius: 6px;
            flex: 1 1 250px;
            text-align: center;
        }

        .about-section .member h3 {
            margin: 10px 0 5px;
        }

        .about-section .member p {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="navbar">
       <div class="logo">Shoes Store</div>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="FAQ.php">FAQ</a></li>
    </ul>  <div class="right">
        <form action="product.php" method="GET">
            <input type="text" name="query" placeholder="Search shoes by name..." required>
            <button type="submit">Search</button>
        </form>
   <button class="logout-button" onclick="location.href='signin.php'">Logout</button>
        <button onclick="location.href='cart.php'">Cart 🛒</button>
        
    </div>
</div>

<div class="about-section">
    <h1>About Shoes Store</h1>
    <p>Welcome to <span class="highlight">Shoes Store</span> — your one-stop destination for stylish, affordable, and comfortable footwear. Whether you're looking for athletic shoes, casual wear, or something to match your style, we've got something for everyone.</p>

    <p>We believe that shoes are more than just accessories — they’re a reflection of your personality and comfort. That’s why we’ve curated a collection that brings together top-notch materials, trendy designs, and unbeatable prices.</p>

    <p>Our mission is to make shopping for shoes enjoyable, simple, and secure. We work hard every day to ensure quality service and a smooth customer experience.</p>

    <div class="team">
        <h2>Meet Our Team</h2>
        <div class="team-members">
            <div class="member">
                <h3>Khin Yadanar Hsu Shan</h3>
                <p>Founder & CEO</p>
            </div>
            <div class="member">
                <h3>Anna</h3>
                <p>Lead Developer</p>
            </div>
            <div class="member">
                <h3>Chuee</h3>
                <p>UI/UX Designer</p>
            </div>
        </div>
    </div>
</div>
 <footer class="footer">
  &copy; <?php echo date("Y"); ?> <strong>Shoes Store</strong>. All rights reserved.
</footer>

</body>
</html>