<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .dashboard-container {
      background: #fff;
      width: 500px;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 28px;
      color: #333;
    }

    .admin-welcome {
      text-align: center;
      font-weight: 500;
      color: #4CAF50;
      margin-bottom: 30px;
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .card {
      background-color: #f9f9f9;
      padding: 20px 15px;
      border-radius: 10px;
      text-align: center;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      cursor: pointer;
      border: 1px solid #e0e0e0;
    }

    .card:hover {
      background-color: #4CAF50;
      color: white;
      transform: scale(1.03);
    }

    .card i {
      font-size: 24px;
      margin-bottom: 10px;
      display: block;
    }

    .logout-btn {
      margin-top: 30px;
      background-color: #f44336;
      color: white;
      padding: 12px;
      width: 100%;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background-color: #d32f2f;
    }
  </style>
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

  <div class="dashboard-container">
    <h2>Admin Dashboard</h2>
    <div class="admin-welcome">
      Welcome back, <span id="name"></span> 👑
    </div>

    <div class="grid">
      <div class="card" onclick="window.location.href='manage-users'">
        <i class="fas fa-users"></i>
        Manage Users
      </div>      
      <div class="card" onclick="window.location.href='manage-campaigns'">
        <i class="fas fa-bullhorn"></i>
        Manage Campaigns
      </div>
      <div class="card" onclick="alert('Donation Reports')">
        <i class="fas fa-donate"></i>
        Donation Reports
      </div>
      <div class="card" onclick="alert('Review Feedback')">
        <i class="fas fa-comments"></i>
        Review Feedback
      </div>
      <div class="card" onclick="alert('Manage Content')">
        <i class="fas fa-edit"></i>
        Manage Content
      </div>
      <div class="card" onclick="alert('Other Settings')">
        <i class="fas fa-cogs"></i>
        Settings
      </div>
    </div>

    <button class="logout-btn" onclick="logout()">Logout</button>
  </div>

  <script>
    // ✅ Check if user is authenticated
    if (!localStorage.getItem('auth_token')) {
      window.location.href = 'admin/login';
    }

    // ✅ Display admin name if available
    const name = localStorage.getItem('auth_name');
    document.getElementById('name').textContent = name || 'Admin';

    // ✅ Logout function
    function logout() {
      localStorage.clear();
      window.location.href = '/login-admin';
    }
  </script>

</body>
</html>
