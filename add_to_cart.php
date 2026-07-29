<?php
session_start();
require 'db.php'; // Your database connection file

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Check if product ID and size are passed
if (isset($_POST['product_id'], $_POST['size'])) {
    $product_id = intval($_POST['product_id']);
    $size = intval($_POST['size']);

    // 1. Check stock availability for selected size
    $stmt = $conn->prepare("SELECT stock FROM shoes_size WHERE product_id = ? AND size = ?");
    $stmt->bind_param("ii", $product_id, $size);
    $stmt->execute();
    $stmt->bind_result($available_stock);
    $stmt->fetch();
    $stmt->close();

    if ($available_stock <= 0) {
        echo "Out of stock for selected size!";
        exit();
    }

    // 2. Add to session cart (if using session-based cart)
    $cart_item = $product_id . '_' . $size;
    if (isset($_SESSION['cart'][$cart_item])) {
        $_SESSION['cart'][$cart_item]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$cart_item] = [
            'product_id' => $product_id,
            'size' => $size,
            'quantity' => 1
        ];
    }

    // 3. Reduce stock for selected size
    $stmt = $conn->prepare("UPDATE shoes_size SET stock = stock - 1 WHERE product_id = ? AND size = ?");
    $stmt->bind_param("ii", $product_id, $size);
    $stmt->execute();
    $stmt->close();

    // 4. Update total stock in products table
    $stmt = $conn->prepare("UPDATE products SET stock = (
        SELECT SUM(stock) FROM shoes_size WHERE product_id = ?
    ) WHERE id = ?");
    $stmt->bind_param("ii", $product_id, $product_id);
    $stmt->execute();
    $stmt->close();

    // 5. Redirect back or show message
    header("Location: cart.php");
    exit();
} else {
    echo "Invalid request.";
    exit();
}
