<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color:rgb(70, 115, 125);
      color: #f5f5f5;
    }

    .sidebar {
      background-color:rgb(19, 31, 37);
      color: #ffffff;
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 30px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4);
      z-index: 1000;
    }

    .sidebar h2 {
      text-align: center;
      font-size: 24px;
      font-weight: 700;
      color:rgb(140, 215, 225);
      margin-bottom: 40px;
    }

    .sidebar a {
      color: #b0b0c0;
      text-decoration: none;
      font-size: 18px;
      padding: 15px 30px;
      display: block;
      transition: 0.3s ease;
    }

    .sidebar a:hover {
      background-color:rgb(53, 178, 176);
      color: #1f1f2e;
      font-weight: 500;
    }

    .content {
      margin-left: 250px;
      padding: 40px;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      background: linear-gradient(135deg, #2a2a40, #3a3a5a);
      color: #fff;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-header {
      background: transparent;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      font-weight: 600;
      font-size: 20px;
    }

    .card-body h1 {
      font-size: 40px;
      font-weight: 700;
      color: #00ffae;
    }

    .badge.bg-success {
      background-color: #00c896 !important;
      color: #fff;
    }

    .badge.bg-warning {
      background-color: #ffc107 !important;
      color: #1f1f2e;
    }

    .badge.bg-danger {
      background-color: #ff5c75 !important;
      color: #fff;
    }

    .table {
      background-color: #2a2a40;
      color: #fff;
    }

    .table th,
    .table td {
      border-color: #444;
    }

    .footer {
      background-color: #151522;
      color: #aaa;
      text-align: center;
      padding: 15px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }

      .content {
        margin-left: 200px;
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="#">Dashboard</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_products.php">Manage Products</a>
  </div>

  <!-- Content Area -->
  <div class="content">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Active Users</div>
            <div class="card-body text-center">
              <h1>1289</h1>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Total Products</div>
            <div class="card-body text-center">
              <h1>879</h1>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Total Orders</div>
            <div class="card-body text-center">
              <h1>765</h1>
            </div>
          </div>
        </div>
      </div>

      <!-- Orders Table -->
      <div class="card">
        <div class="card-header">Recent Orders</div>
        <div class="card-body">
          <table class="table table-bordered text-white">
            <thead>
              <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>#12345</td>
                <td><span class="badge bg-success">Completed</span></td>
                <td>2025-04-23</td>
              </tr>
              <tr>
                <td>2</td>
                <td>#12346</td>
                <td><span class="badge bg-warning">Pending</span></td>
                <td>2025-04-22</td>
              </tr>
              <tr>
                <td>3</td>
                <td>#12347</td>
                <td><span class="badge bg-danger">Canceled</span></td>
                <td>2025-04-21</td>
              </tr>
              <tr>
                <td>4</td>
                <td>#12348</td>
                <td><span class="badge bg-success">Completed</span></td>
                <td>2025-04-20</td>
              </tr>
              <tr>
                <td>5</td>
                <td>#12349</td>
                <td><span class="badge bg-warning">Pending</span></td>
                <td>2025-04-19</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>&copy; Shoes Store | Admin Dashboard</p>
  </div>
</body>

</html>
