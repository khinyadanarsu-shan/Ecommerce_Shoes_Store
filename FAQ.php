<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>FAQ - Shoes Store</title>
  <style>
    /* Include all styles from your original file (navbar, footer, hero, etc.) */
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

    .faq-container {
      max-width: 900px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .faq-item {
      background: #fff;
      margin-bottom: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      padding: 20px;
      transition: 0.3s;
    }

    .faq-item:hover {
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .faq-question {
      font-size: 18px;
      font-weight: 600;
      color: #3b8d99;
    }

    .faq-answer {
      margin-top: 10px;
      font-size: 15px;
      line-height: 1.6;
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

<!-- Hero -->
<div class="hero">
  <span>Frequently Asked Questions</span>
</div>

<!-- FAQ Section -->
<div class="faq-container">
  <div class="faq-item">
    <div class="faq-question">What payment methods do you accept?</div>
    <div class="faq-answer">We accept Kpay, Wavepay, Ayapay, and other local mobile wallets. No credit card is needed.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">How do I track my order?</div>
    <div class="faq-answer">You can log into your account and check your order status from the "My Orders" section.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">Can I return shoes if they don't fit?</div>
    <div class="faq-answer">Yes! We accept returns within 7 days of delivery as long as the shoes are unworn and in original packaging.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">How long does shipping take?</div>
    <div class="faq-answer">Shipping usually takes 2-5 business days depending on your location within the country.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">Do you offer size guides?</div>
    <div class="faq-answer">Yes, we provide size charts on each product page to help you find the perfect fit.</div>
  </div>
</div>

<!-- Footer -->
<div class="footer">
  &copy; <?php echo date("Y"); ?> <strong>Shoes Store</strong>. All rights reserved.
</div>

</body>
</html>
