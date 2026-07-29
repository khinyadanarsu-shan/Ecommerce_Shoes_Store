<?php
session_start();
include 'db.php';

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header('Location: cart.php');
    exit;
}

$total = 0;

// Calculate total first
foreach ($_SESSION['cart'] as $item) {
    $product_id = (int)$item['product_id'];
    $qty = (int)$item['quantity'];

    $query = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id");
    if ($product = mysqli_fetch_assoc($query)) {
        $price = (float)$product['price'];
        $total += $price * $qty;
    }
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'] ?? '';
    $user_id = $_SESSION['user_id'] ?? 0;
    $status = 'Pending';

    if ($payment_method) {
        // Insert order
        $stmt = mysqli_prepare($conn, "INSERT INTO orders (user_id, total, payment_method, status) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "idss", $user_id, $total, $payment_method, $status);
        mysqli_stmt_execute($stmt);
        $order_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Insert items
        foreach ($_SESSION['cart'] as $item) {
            $product_id = (int)$item['product_id'];
            $quantity = (int)$item['quantity'];

            $result = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id");
            $product = mysqli_fetch_assoc($result);
            $price = (float)$product['price'];

            $stmt_item = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_item, "iiid", $order_id, $product_id, $quantity, $price);
            mysqli_stmt_execute($stmt_item);
            mysqli_stmt_close($stmt_item);
        }

        unset($_SESSION['cart']);
        echo "<script>alert('Order placed successfully with $payment_method!'); window.location.href='home.php';</script>";
        exit;
    } else {
        $error = "Please select a payment method.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
       background: radial-gradient(circle,rgb(31, 53, 54) 0%,rgb(66, 202, 207) 100%);
        padding: 40px;
        text-align: center;
    }
    .container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        max-width: 400px;
        margin: auto;
    }
    h2 {
        color: #333;
    }
    .total {
        font-size: 20px;
        margin: 20px 0;
    }
    .btn {
        background:rgb(22, 71, 67);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }
    select {
        padding: 10px;
        width: 100%;
        margin-top: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    .error {
        color: red;
        margin-top: 10px;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Checkout</h2>
    <div class="total">
        Total amount: <strong>$<?php echo number_format($total, 2); ?></strong>
    </div>
    <form method="POST">
        <label for="payment_method">Choose Payment Method:</label><br>
        <select name="payment_method" required>
            <option value="">-- Select Payment Method --</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Visa">Visa</option>
        </select>
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <button class="btn" type="submit">Place Order</button>
    </form>
</div>

</body>
</html>
