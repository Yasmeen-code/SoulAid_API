<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login | SoulAid</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(to right, #dbeafe, #fef3c7);
      margin: 0;
    }

    .form-container {
      background: #ffffff;
      padding: 40px 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      border-top: 8px solid #2563eb;
      position: relative;
    }

    .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }

    .logo img {
      width: 50px;
      height: 50px;
      margin-right: 10px;
    }

    .logo span {
      font-size: 24px;
      font-weight: bold;
      color: #2563eb;
    }

    h2 {
      text-align: center;
      color: #374151;
      margin-bottom: 20px;
    }

    label {
      font-weight: 600;
      margin-top: 10px;
      display: block;
      color: #374151;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 8px 0 20px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      box-sizing: border-box;
      background-color: #f9fafb;
    }

    button {
      background-color: #2563eb;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #1e40af;
    }

    .error {
      color: red;
      margin-bottom: 15px;
      text-align: center;
    }

    .loading {
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
      color: #2563eb;
    }

    .note {
      font-size: 13px;
      color: #6b7280;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <div class="logo">
    <img src="https://cdn-icons-png.flaticon.com/512/1828/1828506.png" alt="Admin Logo" />
    <span>SoulAid Admin</span>
  </div>

  <h2>Admin Login</h2>

  <form id="loginForm">
    <div id="errorMessages" class="error"></div>
    <div id="loadingMessages" class="loading" style="display: none;">Logging in...</div>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="admin@soulaid.org" />

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required placeholder="Enter your password" />

    <button type="submit">Login</button>
    <div class="note">This login is for administrators only</div>
  </form>
</div>

<script>
  document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    document.getElementById('loadingMessages').style.display = 'block';
    document.getElementById('errorMessages').textContent = '';

    const formData = new FormData(event.target);
    const data = {
      email: formData.get('email'),
      password: formData.get('password')
    };
    fetch('http://localhost:8000/api/admin/login', {

      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
    })
    .then(response => {
      // إخفاء رسالة التحميل بعد استلام الاستجابة
      document.getElementById('loadingMessages').style.display = 'none';

      if (!response.ok) {
        throw new Error('Network error: ' + response.statusText);  // في حال حدوث خطأ في الاتصال
      }
      return response.json();  // تحليل الاستجابة على هيئة JSON
    })
    .then(data => {
      if (data.status === 'success') {  // في حال نجاح التحقق
        localStorage.setItem('auth_token', data.token);  // تخزين التوكن
        localStorage.setItem('user_name', data.data.name);  // تخزين اسم المسؤول
        localStorage.setItem('user_role', data.data.role);  // تخزين صورة المسؤول

        alert('Login successful');  // تنبيه عند النجاح
        window.location.href = '/admin-dashboard';  // إعادة التوجيه إلى لوحة التحكم
      } else {
        document.getElementById('errorMessages').textContent = 'Error: ' + data.message;  // في حال فشل تسجيل الدخول
      }
    })
    .catch(error => {
      document.getElementById('loadingMessages').style.display = 'none';
      document.getElementById('errorMessages').textContent = 'An error occurred during login';  // في حال حدوث خطأ
      console.error('Error:', error);
    });
  });
</script>

</body>
</html>
