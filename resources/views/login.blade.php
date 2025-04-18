<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoulAid Login</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #dbeafe, #fef3c7); /* أزرق فاتح مع أصفر دافي */
            margin: 0;
        }

        .form-container {
            background: #ffffff;
            padding: 40px 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            position: relative;
            border-top: 8px solid #60a5fa; /* شريط علوي بلون هادي */
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .logo span {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb; /* أزرق مريح */
        }

        h2 {
            text-align: center;
            color: #374151; /* رمادي أنيق */
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

        .register-btn {
            background-color: #f59e0b;
            margin-top: 10px;
        }

        .register-btn:hover {
            background-color: #d97706;
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
    </style>
</head>
<body>

<div class="form-container">
    <div class="logo">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="SoulAid Logo">
        <span>SoulAid</span>
    </div>

    <h2>Login to Your Account</h2>
    <form id="loginForm">
        <div id="errorMessages" class="error"></div>
        <div id="loadingMessages" class="loading" style="display: none;">Logging in...</div>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="example@soulaid.org">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="Enter your password">

        <button type="submit">Login</button>
        <button type="button" class="register-btn" onclick="window.location.href='/register'">Create Account</button>
    </form>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Show loading message
        document.getElementById('loadingMessages').style.display = 'block';
        document.getElementById('errorMessages').textContent = '';

        const formData = new FormData(event.target);
        const data = {
            email: formData.get('email'),
            password: formData.get('password')
        };

        fetch('http://localhost:8000/api/user/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            document.getElementById('loadingMessages').style.display = 'none';
            if (!response.ok) {
                throw new Error('Network error: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                localStorage.setItem('auth_token', data.token); 
                localStorage.setItem('user_name', data.data.name);
                localStorage.setItem('user_image', data.data.image);
                localStorage.setItem("user_email", data.data.email || "Not Provided");
                localStorage.setItem("user_address", data.data.address || "Not Provided");
                localStorage.setItem("user_type", data.data.user_type || "Not Provided");


                alert('Login successful');
                window.location.href = '/dashboard';
            } else {
                document.getElementById('errorMessages').textContent = 'Error: ' + data.message;
            }
        })
        .catch(error => {
            document.getElementById('loadingMessages').style.display = 'none';
            document.getElementById('errorMessages').textContent = 'An error occurred during login';
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>
