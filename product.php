<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Shoes Store</title>
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
  background: linear-gradient(135deg, #6bcdcd,rgb(34, 51, 56)); /* dark blue to light blue gradient */
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
  background-color: rgba(0, 0, 0, 0.4); /* transparent black overlay */
  padding: 15px 30px;
  border-radius: 10px;
  font-size: 30px;
  font-weight: 600;
  letter-spacing: 1px;
}



  /* Products Grid */
  .products {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    padding: 40px;
  }

  .product {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    padding: 16px;
  }

  .product:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
  }

  .product img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 12px;
  }

  .product h3 {
    margin: 0;
    font-size: 18px;
    color: #222;
  }

  .product span {
    display: block;
    margin-top: 8px;
    font-weight: bold;
    color: #3b8d99;
    font-size: 16px;
  }

  /* Buttons */
  .button-33 {
    background-color: #3b8d99;
    border-radius: 30px;
    color: #fff;
    font-weight: bold;
    padding: 10px 24px;
    border: none;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
  }

  .button-33:hover {
    background-color: #2c6e74;
    transform: scale(1.05);
  }

  

  /* Alerts */
  #overlayAlert,
  .alert {
    margin: 20px;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 14px;
    background-color: #d1fae5;
    color: #065f46;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
  }

  .alert-danger {
    background-color: #fee2e2;
    color: #b91c1c;
  }

  .btn-close {
    float: right;
    font-size: 18px;
    font-weight: bold;
    background: none;
    border: none;
    cursor: pointer;
    color: inherit;
  }
 .profile-section {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #fff;
  padding: 6px 12px;
  border-radius: 25px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  cursor: pointer;
  transition: background 0.3s;
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
<!-- Beautiful Header -->
<div class="hero">
    <h1>Explore Our Shoe Collection</h1>
    <div class="underline"></div>
</div>
<div class="products">
<?php
if (isset($_GET['query'])) {
    $search = "%" . mysqli_real_escape_string($conn, $_GET['query']) . "%";
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE name LIKE ?");
    mysqli_stmt_bind_param($stmt, "s", $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($conn, "SELECT * FROM products LIMIT 10");
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product-link" data-id="' . $row['id'] . '">';
        echo '<div class="product">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<span>$' . $row['price'] . '</span><br>';
        echo '<button class="button-33">View Details</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<p>No products found.</p>";
}
?>
</div>

<!-- Modal -->
<div id="productModal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%);
background:white; border:2px solid #aaa; border-radius:10px; padding:20px; z-index:999; width:400px; max-width:90%;">
    <div id="modalContent"></div>
    <button onclick="closeModal()" style="margin-top:10px;">Close</button>
</div>

<script>
function closeModal() {
    document.getElementById("productModal").style.display = "none";
}

document.querySelectorAll('.product-link').forEach(link => {
    link.addEventListener('click', function() {
        const id = this.dataset.id;
        fetch('get_product_detail.php?id=' + id)
            .then(response => response.text())
            .then(data => {
                document.getElementById("modalContent").innerHTML = data;
                document.getElementById("productModal").style.display = "block";
            });
    });
});
</script>
