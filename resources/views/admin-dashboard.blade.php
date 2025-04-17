<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial;
      background-color: #f2f2f2;
      padding: 30px;
    }

    h1 {
      text-align: center;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-top: 40px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .card:hover {
      background-color: #4CAF50;
      color: white;
    }
  </style>
</head>
<body>

  <h1>Welcome Admin 👑</h1>
  <div class="grid">
    <div class="card" onclick="alert('عرض المستخدمين')">إدارة المستخدمين</div>
    <div class="card" onclick="alert('عرض الحملات')">إدارة الحملات</div>
    <div class="card" onclick="alert('عرض التبرعات')">تقارير التبرعات</div>
    <div class="card" onclick="alert('مراجعة التعليقات')">مراجعة التعليقات</div>
    <div class="card" onclick="alert('إدارة المحتوى')">إدارة المحتوى</div>
    <div class="card" onclick="logout()">تسجيل الخروج</div>
  </div>

  <script>
    function logout() {
      localStorage.clear();
      window.location.href = '/login';
    }
  </script>

</body>
</html>
