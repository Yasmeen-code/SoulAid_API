<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    .container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 80%;
      max-width: 900px;
      overflow-x: auto;
      margin-top: 80px;
    }

    h2 {
      font-size: 28px;
      margin-bottom: 20px;
      color: #333;
      text-align: center;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      text-align: left;
      table-layout: fixed;
      word-wrap: break-word;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #4CAF50;
      color: white;
    }

    td {
      color: #555;
    }

    .action-btn {
      background-color: #4CAF50;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      transition: 0.3s;
      margin-right: 5px;
    }

    .action-btn:hover {
      background-color: #45a049;
    }

    .delete-btn {
      background-color: #f44336;
    }

    .delete-btn:hover {
      background-color: #d32f2f;
    }

    #loading {
      text-align: center;
      font-weight: bold;
      color: #555;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Manage Users</h2>
    <div id="loading">Loading users...</div>
    <table id="userTable" style="display:none;">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>User ID</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="userTableBody">
        <!-- Data will be inserted here dynamically -->
      </tbody>
    </table>
  </div>

  <script>
    const token = localStorage.getItem('auth_token');
    const role = localStorage.getItem('user_role');

    // Validation check for access
    if (!token || role !== 'admin') {
      alert('Access denied. Admins only!');
      window.location.href = '/admin-login';
    }

    // Fetch users data from API
    function fetchUsers() {
      fetch('http://localhost:8000/api/admin/users', {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(handleFetchedData)  <!-- Refactored code to handle fetched data -->
      .catch(handleError);  <!-- Refactored error handling -->
    }

    // Handle fetched data and display users in table
    function handleFetchedData(data) {
      const loading = document.getElementById('loading');
      const table = document.getElementById('userTable');
      loading.style.display = 'none';

      if (data.status === 'success') {
        displayUsers(data.data);  <!-- Refactored to separate displaying logic -->
      } else {
        alert('Failed to fetch users: ' + data.message);
      }
    }

    // Display users in the table
    function displayUsers(users) {
      const userTableBody = document.getElementById('userTableBody');
      const table = document.getElementById('userTable');
      table.style.display = 'table';

      users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${user.Name}</td>
          <td>${user.Email}</td>
          <td>${user.UserType}</td>
          <td>${user.UserId}</td>
          <td>
            <button class="action-btn" onclick="editUser(${user.UserId})">Edit</button>
            <button class="action-btn delete-btn" onclick="deleteUser(${user.UserId})">Delete</button>
          </td>
        `;
        userTableBody.appendChild(row);
      });
    }

    // Error handling function
    function handleError(error) {
      document.getElementById('loading').innerText = 'Error loading users.';
      console.error('Error:', error);
    }

    // Delete user by ID
    function deleteUser(userId) {
      if (confirm('Are you sure you want to delete this user?')) {
        fetch(`http://localhost:8000/api/users/${userId}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(handleDeleteResponse)  <!-- Refactored delete response handling -->
        .catch(handleDeleteError);   <!-- Refactored delete error handling -->
      }
    }

    // Handle the response after deleting a user
    function handleDeleteResponse(data) {
      if (data.status === 'success') {
        alert('User deleted successfully.');
        location.reload();
      } else {
        alert('Failed to delete user: ' + data.message);
      }
    }

    // Handle errors during delete process
    function handleDeleteError(error) {
      console.error('Delete Error:', error);
      alert('An error occurred while deleting the user.');
    }

    // Redirect to the user edit page
    function editUser(userId) {
      window.location.href = `/edit-user.html?id=${userId}`;
    }

    // Initialize by fetching users
    fetchUsers(); <!-- Refactored to call fetchUsers function for initial load -->
  </script>

</body>
</html>
