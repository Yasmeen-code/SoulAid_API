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
            padding: 18px 0;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
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
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #4CAF50;
            margin-bottom: 20px;
            object-fit: cover;
        }

        .profile-container h2 {
            color: #333;
            font-size: 24px;
        }

        .profile-container p {
            color: #777;
            font-size: 18px;
        }

        .back-button {
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 16px;
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
    <img id="profileImage" src="https://via.placeholder.com/150" alt="Profile Image">
    <h2 id="profileName">User Name</h2>
    <p id="profileRole">Role: Not Provided</p>
    <p id="profileEmail">Email: Not Provided</p>
    <p id="profileAddress">Address: Not Provided</p>
    <button class="back-button" onclick="goBack()">Back to Dashboard</button>
    <div id="errorMessages" class="error-message"></div>
</div>

<script>
    // Function to go back to the dashboard
    function goBack() {
        window.location.href = "dashboard";  // Link إلى الصفحة الرئيسية أو لوحة التحكم
    }

    // Function to display profile info from localStorage
    function displayProfileInfo() {
        // Get values from localStorage
        const name = localStorage.getItem('user_name') || 'User';
        const image = localStorage.getItem('user_image') || 'https://via.placeholder.com/150';
        const email = localStorage.getItem('user_email') || 'Not Provided';
const address = localStorage.getItem('user_address') || 'Not Provided';
const role = localStorage.getItem('user_type') || 'Not Provided';


        // Log values to console for debugging
        console.log("Name: ", name);
        console.log("Image: ", image);
        console.log("Role: ", role);
        console.log("Email: ", email);
        console.log("Address: ", address);

        // Update profile information
        document.getElementById('profileName').textContent = name;
        document.getElementById('profileImage').src = image;
        document.getElementById('profileRole').textContent = `Role: ${role}`;
        document.getElementById('profileEmail').textContent = `Email: ${email}`;
        document.getElementById('profileAddress').textContent = `Address: ${address}`;

        // Handle undefined or missing values
        if (role === 'undefined' || role === null) {
            document.getElementById('profileRole').textContent = 'Role: Not Provided';
        }

        if (email === 'undefined' || email === null) {
            document.getElementById('profileEmail').textContent = 'Email: Not Provided';
        }

        if (address === 'undefined' || address === null) {
            document.getElementById('profileAddress').textContent = 'Address: Not Provided';
        }
    }

    // On page load
    window.onload = function () {
        displayProfileInfo();
    };
</script>

</body>
</html>
