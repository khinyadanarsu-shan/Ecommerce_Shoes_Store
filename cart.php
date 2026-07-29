<?php
session_start();
include 'db.php';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<h3 style='font-family: Arial, sans-serif; color: #555;'>Your cart is empty.</h3>";
    echo '<a href="home.php" class="btn">← Go to Home</a>';
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Your Shopping Cart</title>
<style>
  /* Reset & base */
  * {
    box-sizing: border-box;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: radial-gradient(circle,rgb(69, 201, 195) 0%,rgb(78, 113, 110) 100%);
    padding: 40px 20px;
    color: #333;
  }
  h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 25px;
    text-align: center;
    color: #222;
  }
  /* Container */
  .cart-container {
    max-width: 900px;
    margin: 30px auto;
    background: #fff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-radius: 16px;
    padding: 20px 30px;
    color: #333;
    user-select: none;
  }
  /* Header & items */
  .cart-header, .cart-item {
    display: flex;
    align-items: center;
    padding: 18px 15px;
    border-bottom: 1px solid #e3e6f0;
    transition: background-color 0.25s ease;
  }
  .cart-header {
    font-weight: 700;
    font-size: 1.1rem;
    color: #5a5f7d;
    border-bottom: 2px solid #a6a9c8;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .cart-item:hover {
    background-color: #f8faff;
    box-shadow: inset 3px 0 0 0 #2f80ed;
    border-radius: 8px;
  }
  /* Columns */
  .col {
    padding: 0 15px;
  }
  .col.product { flex: 3; font-weight: 600; font-size: 1rem; }
  .col.name { flex: 3; font-weight: 600; font-size: 1rem; }
  .col.size { flex: 1; text-align: center; font-size: 0.95rem; color: #666; }
  .col.qty { flex: 1; text-align: center; font-size: 0.95rem; color: #666; }
  .col.price { flex: 1.3; text-align: center; font-size: 0.95rem; color: #444; font-weight: 600; }
  .col.action { flex: 1; text-align: center; }
  /* Buttons */
  .btn-red {
    background-color: #ff5f5f;
    border: none;
    padding: 10px 22px;
    color: white;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(255,95,95,0.4);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    user-select: none;
  }
  .btn-red:hover {
    background-color: #e14e4e;
    box-shadow: 0 7px 20px rgba(225,78,78,0.7);
    transform: translateY(-2px);
  }
  a.btn {
    display: inline-block;
    margin: 20px 10px 0 0;
    padding: 12px 25px;
    background-color:rgb(40, 77, 75);
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: background-color 0.3s ease;
    user-select: none;
  }
  a.btn:hover {
    background-color: #1c5ed6;
  }
  /* Total */
  .total-container {
    max-width: 900px;
    margin: 20px auto;
    text-align: right;
    font-size: 1.4rem;
    font-weight: 700;
    color: #222;
  }
  /* Responsive */
  @media (max-width: 700px) {
    .cart-header, .cart-item {
      flex-direction: column;
      align-items: flex-start;
      padding: 15px 12px;
    }
    .col {
      padding: 6px 0;
      width: 100%;
      text-align: left !important;
    }
    .col.action {
      text-align: left !important;
    }
    .btn-red {
      width: 100%;
      padding: 12px 0;
    }
  }
  .button-group {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 30px;
}

</style>
</head>
<body>
<h2><?= htmlspecialchars($username) ?>'s Shopping Cart</h2>
<div class="cart-container">
  <div class="cart-header">
    <div class="col product">Product ID</div>
    <div class="col name">Name</div>
    <div class="col size">Size</div>
    <div class="col qty">Quantity</div>
    <div class="col price">Price</div>
    <div class="col action">Action</div>
  </div>

  <?php foreach ($_SESSION['cart'] as $item): 
    // Fetch product name and price from DB
    $productId = (int)$item['product_id'];
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    $price = $product ? $product['price'] : 0;
    $subtotal = $price * $item['quantity'];
    $total += $subtotal;
  ?>
    <div class="cart-item">
      <div class="col product"><?= htmlspecialchars($item['product_id']) ?></div>
      <div class="col name"><?= htmlspecialchars($product['name'] ?? 'Unknown') ?></div>
      <div class="col size"><?= htmlspecialchars($item['size']) ?></div>
      <div class="col qty"><?= (int)$item['quantity'] ?></div>
      <div class="col price">$<?= number_format($price, 2) ?></div>
      <div class="col action">
        <form action="remove_from_cart.php" method="POST" style="margin:0;">
          <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['product_id']) ?>">
          <input type="hidden" name="size" value="<?= htmlspecialchars($item['size']) ?>">
          <button type="submit" class="btn-red">Remove</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="total-container">
  Total: $<?= number_format($total, 2) ?>
</div>
<div class="button-group">
  <a href="home.php" class="btn">← Continue Shopping</a>
  <a href="checkout.php" class="btn">Proceed to Checkout →</a>
</div>

</body>
</html>
