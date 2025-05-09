<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SoulAid | Register</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #fef3c7, #dbeafe);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background: #ffffff;
      padding: 35px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
      position: relative;
      border-top: 8px solid #60a5fa;
    }

    .logo {
      text-align: center;
      margin-bottom: 15px;
    }

    .logo img {
      width: 55px;
      height: 55px;
    }

    .logo h1 {
      margin-top: 10px;
      font-size: 24px;
      color: #2563eb;
    }

    h2 {
      text-align: center;
      color: #374151;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      margin-top: 12px;
      display: block;
      color: #374151;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      background-color: #f9fafb;
    }

    button {
      background-color: #2563eb;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 20px;
      width: 100%;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #1e40af;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .login-link a {
      color: #2563eb;
      text-decoration: none;
      font-weight: bold;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    .error {
      color: red;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="form-container">
  <div class="logo">
    <img src="https://i.ibb.co/THbBcCP/heart-icon.png" alt="SoulAid Logo">
    <h1>SoulAid</h1>
  </div>
  <h2>Create a New Account</h2>

  <form id="registerForm">
    <div id="errorMessages" class="error"></div>

    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address">

    <label for="user_type">User Type:</label>
    <select id="user_type" name="user_type" required>
      <option value="Donor">Donor</option>
      <option value="Acceptor">Acceptor</option>
    </select>

    <label for="image">Profile Image (optional):</label>
    <input type="file" id="image" name="image">

    <button type="submit">Register</button>
  </form>

  <div class="login-link">
    Already have an account? <a href="/login">Login here</a>
  </div>
</div>

<script>
  document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append('name', document.getElementById('name').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('password', document.getElementById('password').value);
    formData.append('address', document.getElementById('address').value);
    formData.append('user_type', document.getElementById('user_type').value);

    const imageInput = document.getElementById('image');
    if (imageInput.files.length > 0) {
      formData.append('image', imageInput.files[0]);
    }

    fetch('http://localhost:8000/api/user/register', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert('Registration successful!');
        window.location.href = '/login';
      } else {
        document.getElementById('errorMessages').textContent = 'Error: ' + data.message;
      }
    })
    .catch(error => {
      document.getElementById('errorMessages').textContent = 'An error occurred. Try again later.';
      console.error(error);
    });
  });
</script>

</body>
</html>
