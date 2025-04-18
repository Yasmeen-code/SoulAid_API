<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Campaigns</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #4CAF50; /* تغيير اللون الرئيسي للـ Navbar */
            color: white;
            padding: 12px 30px; /* تقليل padding لتقليص الحجم */
            font-size: 16px;
            border-bottom: 2px solid #388E3C; /* إضافة حدود تحت الـ navbar */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* تحسين تأثير الظل */
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .navbar-container span {
            font-weight: bold;
            font-size: 20px;
        }

        .navbar-container img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .navbar-container img:hover {
            transform: scale(1.1); /* زيادة الحجم عند المرور فوق الصورة */
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .search-bar {
            width: 80%;
            max-width: 600px;
            padding: 12px 16px;
            border-radius: 30px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .search-bar:focus {
            outline: none;
            border-color: #4CAF50; /* تغيير اللون عند التركيز */
        }

        .campaign-list {
            width: 80%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .campaign-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
            cursor: pointer;
            overflow: hidden; /* لإخفاء أي تجاوز في المحتوى */
        }

        .campaign-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2); /* إضافة تأثير الظل عند المرور */
        }

        .campaign-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .campaign-card h3 {
            color: #333;
            margin-top: 15px;
            font-size: 18px;
        }

        .campaign-card p {
            color: #777;
            font-size: 14px;
        }

        .error {
            color: red;
            margin-top: 20px;
        }

        .loading {
            text-align: center;
            font-size: 18px;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="navbar-container">
        <span id="welcomeMsg">Welcome, User</span>
        <img id="userImage" src="https://via.placeholder.com/40" alt="Profile" onclick="goToProfile()" />
    </div>
</div>

<!-- Dashboard -->
<div class="dashboard-container">
    <input type="text" id="searchInput" class="search-bar" placeholder="Search campaigns..." onkeyup="filterCampaigns()" />
    <div id="errorMessages" class="error"></div>
    <div id="loadingMessage" class="loading">Loading campaigns...</div>
    <div class="campaign-list" id="campaignList">
        <!-- Campaigns will be loaded here -->
    </div>
</div>

<script>
    // Function to display user info in navbar
    function displayUserInfo() {
        const name = localStorage.getItem('user_name') || 'User';
        const image = localStorage.getItem('user_image') || 'https://via.placeholder.com/40';

        document.getElementById('welcomeMsg').textContent = `Welcome, ${name}`;
        document.getElementById('userImage').src = image;
    }

    // Function to check if token is valid
    function checkAuthToken() {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '/login'; // Redirect to login page if no token found
        }
    }

    // Function to fetch campaigns from API
    function loadCampaigns() {
        document.getElementById('loadingMessage').style.display = 'block';

        fetch('http://localhost:8000/api/campaigns', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingMessage').style.display = 'none';
            if (data.status === 'success') {
                displayCampaigns(data.data);
            } else {
                document.getElementById('errorMessages').textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error fetching campaigns:', error);
            document.getElementById('loadingMessage').style.display = 'none';
            document.getElementById('errorMessages').textContent = 'Failed to load campaigns';
        });
    }

    // Function to display campaign cards
    function displayCampaigns(campaigns) {
        const campaignList = document.getElementById('campaignList');
        campaignList.innerHTML = '';

        campaigns.forEach(campaign => {
            const card = document.createElement('div');
            card.classList.add('campaign-card');

            // حفظ بيانات الحملة عند الضغط
            card.onclick = function () {
                localStorage.setItem('selected_campaign', JSON.stringify(campaign));
                window.location.href = 'campaign-details';
            };

            card.innerHTML = `
                <img src="${campaign.Image || 'https://via.placeholder.com/300'}" alt="Campaign Image">
                <h3>${campaign.CampName}</h3>
                <p>${campaign.Description}</p>
                <p><strong>Start Date:</strong> ${new Date(campaign.StartDate).toLocaleDateString()}</p>
                <p><strong>End Date:</strong> ${new Date(campaign.EndDate).toLocaleDateString()}</p>
            `;

            campaignList.appendChild(card);
        });
    }

    // Function to filter campaign cards by name
    function filterCampaigns() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const campaignCards = document.querySelectorAll('.campaign-card');
        
        campaignCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            if (title.includes(searchValue)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Function to redirect to profile page
    function goToProfile() {
        window.location.href = '/profile'; // رابط صفحة البروفايل
    }

    // On page load
    window.onload = function () {
        checkAuthToken();
        displayUserInfo();
        loadCampaigns();
    };
</script>

</body>
</html>
