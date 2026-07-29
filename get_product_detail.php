<?php
include 'db.php';

$id = intval($_GET['id']);  // Sanitize input

// Fetch product info
$product_query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
if (!$product_query || mysqli_num_rows($product_query) == 0) {
    echo "Product not found.";
    exit;
}

$product = mysqli_fetch_assoc($product_query);

echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
echo "<img src='" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "' style='width:100%; max-width:400px; height:200px; object-fit:cover; border-radius:8px;'><br>";
echo "<p><strong>Price:</strong> $" . number_format($product['price'], 2) . "</p>";
echo "<p><strong>Description:</strong> " . nl2br(htmlspecialchars($product['description'])) . "</p>";

echo "<form action='add_to_cart.php' method='POST'>";
echo "<input type='hidden' name='product_id' value='$id'>";
echo "<label><strong>Choose Size:</strong></label><br>";

// Fetch available sizes
$size_query = mysqli_query($conn, "SELECT size, stock FROM shoes_size WHERE product_id = $id AND stock > 0 ORDER BY size ASC");

if (mysqli_num_rows($size_query) > 0) {
    echo "<div class='size-options'>";
    while ($row = mysqli_fetch_assoc($size_query)) {
        $size = htmlspecialchars($row['size']);
        echo "<input type='radio' id='size_$size' name='size' value='$size' required>";
        echo "<label for='size_$size'>$size</label>";
    }
    echo "</div>";
    echo "<br><br><button type='submit' class='button-33'>Add to Cart</button>";
} else {
    echo "<p>No sizes available.</p>";
}

echo "</form>";
?>

<style>
.size-options {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 8px;
}

.size-options input[type="radio"] {
  display: none;
}

.size-options label {
  cursor: pointer;
  padding: 10px 16px;
  border: 2px solid #333;
  border-radius: 6px;
  font-weight: bold;
  transition: all 0.3s ease;
  user-select: none;
  min-width: 40px;
  text-align: center;
  background-color: #f0f0f0;
}

.size-options input[type="radio"]:checked + label {
  background-color:rgb(55, 173, 167);
  color: white;
  border-color:rgb(32, 113, 123);
  box-shadow: 0 0 8px rgba(62, 177, 195, 0.6);
}

.size-options label:hover {
  background-color: #d0e7ff;
  border-color:rgb(53, 129, 137);
}
.button-33 {
            background-color: #c2fbd7;
            border-radius: 100px;
            box-shadow: rgba(44, 187, 99, .2) 0 -25px 18px -14px inset,
                        rgba(44, 187, 99, .15) 0 1px 2px,
                        rgba(44, 187, 99, .15) 0 2px 4px,
                        rgba(44, 187, 99, .15) 0 4px 8px,
                        rgba(44, 187, 99, .15) 0 8px 16px,
                        rgba(44, 187, 99, .15) 0 16px 32px;
            color: green;
            cursor: pointer;
            display: inline-block;
            padding: 7px 20px;
            font-size: 16px;
            text-decoration: none;
            border: none;
            transition: all 250ms;
        }

        .button-33:hover {
            box-shadow: rgba(44,187,99,.35) 0 -25px 18px -14px inset,
                        rgba(44,187,99,.25) 0 1px 2px,
                        rgba(44,187,99,.25) 0 2px 4px,
                        rgba(44,187,99,.25) 0 4px 8px,
                        rgba(44,187,99,.25) 0 8px 16px,
                        rgba(44,187,99,.25) 0 16px 32px;
            transform: scale(1.05) rotate(-1deg);
        }
</style>
