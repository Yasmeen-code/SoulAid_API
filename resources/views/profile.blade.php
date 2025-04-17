<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            font-size: 18px;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
        }

        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .profile-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 2px solid #4CAF50;
            margin-bottom: 20px;
        }

        .profile-container h2 {
            color: #333;
        }

        .profile-container p {
            color: #777;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="navbar-container">
        <span>Profile</span>
    </div>
</div>

<!-- Profile Section -->
<div class="profile-container">
    <img id="profileImage" src="https://via.placeholder.com/120" alt="Profile Image">
    <h2 id="profileName">User Name</h2>
    <p id="profileRole">Role: Donor</p>
    <p id="profileAddress">Address: Not Provided</p>
    <button class="back-button" onclick="goBack()">Back to Dashboard</button>
</div>

<script>
    // Function to go back to the dashboard
    function goBack() {
        window.location.href = "dashboard";  // Link إلى الصفحة الرئيسية أو لوحة التحكم
    }

    // Function to display profile info from localStorage
    function displayProfileInfo() {
        const name = localStorage.getItem('user_name') || 'User';
        const image = localStorage.getItem('user_image') || 'https://via.placeholder.com/120';
        const role = localStorage.getItem('user_role') || 'Donor';
        const address = localStorage.getItem('user_address') || 'Not Provided';

        document.getElementById('profileName').textContent = name;
        document.getElementById('profileImage').src = image;
        document.getElementById('profileRole').textContent = `Role: ${role}`;
        document.getElementById('profileAddress').textContent = `Address: ${address}`;
    }

    // On page load
    window.onload = function () {
        displayProfileInfo();
    };
</script>

</body>
</html>
