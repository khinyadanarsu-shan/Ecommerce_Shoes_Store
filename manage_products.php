<?php
require_once "db.php";
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 40px 20px;
      color: #333;
    }

   .dashboard-container {
  max-width: 1200px;
  margin: auto;
}

.back-btn {
  display: inline-block;
  margin-bottom: 20px;
  font-weight: 500;
  color:rgb(59, 136, 160);
  text-decoration: none;
  transition: 0.3s;
}
.back-btn i {
  margin-right: 6px;
}

.back-btn:hover {
  color: #002752;
}
    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title {
      font-size: 2rem;
      font-weight: 600;
      color: #2c3e50;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .page-title i {
      color: #0d6efd;
    }

    .add-btn {
      background-color: #198754;
      color: #fff;
      padding: 10px 18px;
      border-radius: 10px;
      font-weight: 500;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .add-btn:hover {
      background-color: #146c43;
    }

    .card {
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      padding: 25px;
    }

    .table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 12px;
    }

    .table thead th {
      background-color: rgb(3, 102, 117);
      color: #fff;
      font-weight: 600;
      padding: 15px 12px;
      text-align: left;
      border-radius: 10px 10px 0 0;
    }

    .table tbody tr {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
      background-color: #e9f0ff;
    }

    .table tbody td {
      padding: 15px 12px;
      vertical-align: middle;
      color: #555;
    }

    .product-image {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 12px;
      border: 1.5px solid #ddd;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .description-cell {
      max-width: 320px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-style: italic;
      color: #666;
    }

    .action-btns {
      display: flex;
      gap: 10px;
    }

    .action-btns a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      border-radius: 8px;
      font-size: 1.1rem;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn-edit {
      background-color: rgb(77, 171, 211);
      color: white;
      border: none;
    }

    .btn-edit:hover {
      background-color: rgb(37, 78, 93);
    }

    .btn-delete {
      background-color: #dc3545;
      color: white;
      border: none;
    }

    .btn-delete:hover {
      background-color: #a52731;
    }


 
  </style>

</head>
<body>
  <div class="dashboard-container">
    <a href="admin_dashboard.php" class="back-btn">
      <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <div class="card">
      <div class="card-body">
       <table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Image</th>
      <th>Name</th>
      <th>Price</th>
      <th>Description</th>
     
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $products->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="product-image"></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td>$<?= number_format($row['price'], 2) ?></td>
        <td class="description-cell" title="<?= htmlspecialchars($row['description']) ?>">
          <?= htmlspecialchars($row['description']) ?>
        </td>
        <td class="action-btns">
    
          <a href="delete_products.php?delete=<?= $row['id'] ?>" class="btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this product?');"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

      </div>
    </div>
  </div>
</body>
</html>
