<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 400px;
        }

        h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .loading {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>
    <form id="loginForm">
        <div id="errorMessages" class="error"></div>
        <div id="loadingMessages" class="loading" style="display: none;">Logging in...</div>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Show loading message
        document.getElementById('loadingMessages').style.display = 'block';

        const formData = new FormData(event.target);
        const data = {
            email: formData.get('email'),
            password: formData.get('password')
        };

        fetch('http://localhost:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            // Hide loading message
            document.getElementById('loadingMessages').style.display = 'none';

            if (data.status === 'success') {
                // Store token in localStorage if login is successful
                localStorage.setItem('auth_token', data.token); 
                localStorage.setItem('user_name', data.data.name); // Storing user info
                localStorage.setItem('user_image', data.data.image); // Storing user image

                alert('Login successful');
                window.location.href = '/admin-dashboard'; // Redirect to dashboard or main page
            } else {
                // Display error message if login fails
                document.getElementById('errorMessages').textContent = 'Error: ' + data.message;
            }
        })
        .catch(error => {
            // Hide loading message
            document.getElementById('loadingMessages').style.display = 'none';

            console.error('Error:', error);
            document.getElementById('errorMessages').textContent = 'An error occurred during login';
        });
    });
</script>

</body>
</html>
