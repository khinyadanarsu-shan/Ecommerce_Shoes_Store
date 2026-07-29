<?php
require_once "db.php";

if (!isset($_GET['delete']) || !is_numeric($_GET['delete'])) {
    header("Location: manage_products.php?msg=Invalid product ID");
    exit;
}

$id = (int)$_GET['delete'];

// Optionally, delete product image file as well
// First get the filename from DB
$res = $conn->query("SELECT image FROM products WHERE id = $id");
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if (!empty($row['image'])) {
        $image_path = __DIR__ . "/uploads/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // delete image file
        }
    }
}

// Delete product from database
$sql = "DELETE FROM products WHERE id = $id";
if ($conn->query($sql)) {
    header("Location: manage_products.php?msg=Product deleted successfully");
} else {
    header("Location: manage_products.php?msg=Error deleting product");
}
exit;
