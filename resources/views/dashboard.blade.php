<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Campaigns</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .navbar {
      background-color: #4CAF50;
      color: white;
      padding: 12px 30px;
      font-size: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
      transform: scale(1.1);
    }

    .menu-toggle {
      font-size: 24px;
      cursor: pointer;
    }
    .sidebar .close-icon {
  font-size: 24px;
  cursor: pointer;
  display: none;
  margin-bottom: 20px;
}

.sidebar.active .close-icon {
  display: block;
}

.sidebar a {
  color: white;
  text-decoration: none;
  display: block;
  margin: 15px 0;
  font-size: 16px;
  padding: 8px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar a:hover {
  color: #4CAF50;
}

    .sidebar {
      position: fixed;
      top: 0;
      left: -250px;
      width: 250px;
      height: 100%;
      background-color: #333;
      color: white;
      padding: 20px;
      transition: left 0.3s ease;
      z-index: 1000;
    }

    .sidebar.active {
      left: 0;
    }

    .sidebar h3 {
      margin-bottom: 20px;
      color: #4CAF50;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      margin: 10px 0;
    }

    .dashboard-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      margin-left: 0;
      transition: margin-left 0.3s ease;
    }

    .search-bar {
      width: 80%;
      max-width: 600px;
      padding: 12px 16px;
      border-radius: 30px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      font-size: 16px;
    }

    .categories {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 20px;
    }

    .category {
      background-color: white;
      padding: 10px 15px;
      border-radius: 25px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .category:hover {
      background-color: #e0f2f1;
    }

    .category.active {
      background-color: #c8e6c9;
      font-weight: bold;
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
    }

    .campaign-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
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
    <div class="sidebar" id="sidebar">
        <span class="close-icon" id="closeIcon">&times;</span>
        <h3>Menu</h3>
        <a  href = '/dashboard'>Dashboard</a>
        <a href = '/profile'>Profile</a>
        <a href="#">Settings</a>
        <a href="#" onclick="logout()">Logout</a>
            </div>
      
      <div class="navbar">
        <span class="menu-toggle" id="menuToggle">&#9776;</span>
        <div class="navbar-container">
          <span id="welcomeMsg">Welcome, User</span>
          <img id="userImage" src="https://via.placeholder.com/40" alt="Profile" onclick="goToProfile()" />
        </div>
      </div>
      

<div class="dashboard-container" id="dashboard">
  <input type="text" id="searchInput" class="search-bar" placeholder="Search campaigns..." onkeyup="filterCampaigns()" />

  <div class="categories" id="categoryContainer">
    <div class="category active" data-type="All"><i class="fas fa-globe"></i> All</div>
    <div class="category" data-type="Money"><i class="fas fa-hand-holding-usd"></i> Money</div>
    <div class="category" data-type="Clothes"><i class="fas fa-tshirt"></i> Clothes</div>
    <div class="category" data-type="Food"><i class="fas fa-utensils"></i> Food</div>
    <div class="category" data-type="Books"><i class="fas fa-book"></i> Books</div>
    <div class="category" data-type="Blood"><i class="fas fa-tint"></i> Blood</div>
    <div class="category" data-type="Other"><i class="fas fa-box"></i> Other</div>
  </div>

  <div id="errorMessages" class="error"></div>
  <div id="loadingMessage" class="loading">Loading campaigns...</div>
  <div class="campaign-list" id="campaignList"></div>
</div>

<script>
  const menuToggle = document.getElementById('menuToggle');
  const sidebar = document.getElementById('sidebar');
  let campaignsData = [];

  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    menuToggle.innerHTML = sidebar.classList.contains('active') ? '&times;' : '&#9776;';
  });
  document.getElementById('closeIcon').addEventListener('click', () => {
  sidebar.classList.remove('active');
  menuToggle.innerHTML = '&#9776;';
});

  function displayUserInfo() {
    const name = localStorage.getItem('user_name') || 'User';
    const image = localStorage.getItem('user_image') || 'https://via.placeholder.com/40';
    document.getElementById('welcomeMsg').textContent = `Welcome, ${name}`;
    document.getElementById('userImage').src = image;
  }

  function checkAuthToken() {
    const token = localStorage.getItem('auth_token');
    if (!token) {
      window.location.href = '/login';
    }
  }
  function logout() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_name');
    localStorage.removeItem('selected_campaign');

    
    window.location.href = '/login'; 
  }
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
          campaignsData = data.data;
          displayCampaigns(campaignsData);
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

  function displayCampaigns(campaigns) {
    const campaignList = document.getElementById('campaignList');
    campaignList.innerHTML = '';

    campaigns.forEach(campaign => {
      const card = document.createElement('div');
      card.classList.add('campaign-card');
      card.onclick = () => {
        localStorage.setItem('selected_campaign', JSON.stringify(campaign));
        window.location.href = 'campaign-details';
      };
      const shortDescription = campaign.Description.length > 100 
  ? campaign.Description.substring(0, 100) + '...' 
  : campaign.Description;

      card.innerHTML = `
        <img src="${campaign.Image || 'https://via.placeholder.com/300'}" alt="Campaign Image">
        <h3>${campaign.CampName}</h3>
<p>${shortDescription}</p>
<br>
        <p><strong>Start:</strong> ${new Date(campaign.StartDate).toLocaleDateString()}</p>
        <p><strong>End:</strong> ${new Date(campaign.EndDate).toLocaleDateString()}</p>
      `;
      campaignList.appendChild(card);
    });
  }

  function filterCampaigns() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const selectedCategory = document.querySelector('.category.active').dataset.type;

    const filtered = campaignsData.filter(camp => {
      const titleMatch = camp.CampName.toLowerCase().includes(searchValue);
      const categoryMatch = selectedCategory === 'All' || camp.Type === selectedCategory;
      return titleMatch && categoryMatch;
    });

    displayCampaigns(filtered);
  }

  function goToProfile() {
    window.location.href = '/profile';
  }

  function setupCategoryFiltering() {
    const categories = document.querySelectorAll('.category');
    categories.forEach(category => {
      category.addEventListener('click', () => {
        categories.forEach(cat => cat.classList.remove('active'));
        category.classList.add('active');
        filterCampaigns();
      });
    });
  }

  window.onload = function () {
    checkAuthToken();
    displayUserInfo();
    loadCampaigns();
    setupCategoryFiltering();
  };
 

</script>

</body>
</html>
