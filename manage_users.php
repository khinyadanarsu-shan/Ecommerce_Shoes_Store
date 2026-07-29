<?php
session_start();
require_once "db.php";

$admins = $conn->query("SELECT * FROM users WHERE role = 0 ORDER BY id DESC");
$customers = $conn->query("SELECT * FROM users WHERE role = 1 ORDER BY id DESC");

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $deleteId = intval($_GET['delete']);
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $deleteId);

  if ($stmt->execute()) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  } else {
    echo "<script>alert('Failed to delete user');</script>";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Management Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    /* Reset and base styles */
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(to right, #e8f0ff, #f7faff);
  margin: 0;
  padding: 40px;
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

/* Card styles */
.card {
  background-color: white;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  margin-bottom: 30px;
  overflow: hidden;
  border: none;
}

.card-header {
  background-color:rgb(56, 167, 171);
  padding: 20px;
  color: white;
}

.card-title {
  font-size: 1.5rem;
  margin: 0;
}

.card-body {
  padding: 20px;
}

/* Table styles */
.table {
  width: 100%;
  border-collapse: collapse;
}

.table th {
  background-color:rgb(105, 206, 217);
  color: #fff;
  font-weight: 600;
  padding: 14px;
  border: none;
}

.table td {
  padding: 14px;
  vertical-align: middle;
  border-top: 1px solid #dee2e6;
}

.table tr:hover {
  background-color: #f1f9ff;
}

/* User avatar */
.username-wrapper {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user-avatar {
  width: 32px;
  height: 32px;
  background-color:rgb(95, 202, 221);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
}

/* Badges */
.badge-admin {
  background-color: #ffc107;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 500;
  color: #333;
}

.badge-customer {
  background-color: #17a2b8;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 500;
  color: white;
}

/* Action buttons */
.action-btns .btn-delete {
  background-color: #dc3545;
  color: white;
  font-size: 0.875rem;
  border-radius: 6px;
  padding: 5px 12px;
  transition: background-color 0.3s;
}

.action-btns .btn-delete:hover {
  background-color: #c82333;
}

/* Empty state */
.empty-state {
  text-align: center;
  color: #999;
  padding: 40px 0;
}

.empty-state i {
  font-size: 2rem;
  display: block;
  margin-bottom: 10px;
}

  </style>
</head>

<body>
  <div class="dashboard-container">
    <a href="admin_dashboard.php" class="back-btn">
      <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>

    <div class="card">
      <div class="card-header">
        <h2 class="card-title"><i class="bi bi-shield-lock"></i> Admin Users</h2>
      </div>
      <div class="card-body">
        <?php if ($admins->num_rows > 0): ?>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $admins->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                      <div class="username-wrapper">
                        <div class="user-avatar">
                          <?= strtoupper(substr($row['username'], 0, 1)) ?>
                        </div>
                        <?= htmlspecialchars($row['username']) ?>
                      </div>
                    </td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
    
                    <td><span class="badge-admin">Admin</span></td>
                    <td class="action-btns">
                      <a href="?delete=<?= $row['id'] ?>" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="empty-state">
            <i class="bi bi-person-x"></i>
            <p>No admin users found.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h2 class="card-title"><i class="bi bi-people"></i> Customer Users</h2>
      </div>
      <div class="card-body">
        <?php if ($customers->num_rows > 0): ?>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $customers->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                      <div class="username-wrapper">
                        <div class="user-avatar">
                          <?= strtoupper(substr($row['username'], 0, 1)) ?>
                        </div>
                        <?= htmlspecialchars($row['username']) ?>
                      </div>
                    </td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><span class="badge-customer">Customer</span></td>
                    <td class="action-btns">
                      <a href="?delete=<?= $row['id'] ?>" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="empty-state">
            <i class="bi bi-person-x"></i>
            <p>No customer users found.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>
