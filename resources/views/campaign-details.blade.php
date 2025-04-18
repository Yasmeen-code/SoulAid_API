<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Campaign Details</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: #fff;
      padding: 30px;
      max-width: 900px;
      margin: 0 15px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      text-align: center;
    }

    h1 {
      color: #333;
      font-size: 32px;
      margin-bottom: 20px;
      font-weight: bold;
    }

    img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    p {
      font-size: 18px;
      color: #555;
      margin: 10px 0;
    }

    .details {
      margin: 20px 0;
      font-size: 18px;
    }

    .details strong {
      color: #4CAF50;
    }

    .cta-button {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 18px;
      transition: background-color 0.3s ease;
      margin-top: 20px;
    }

    .cta-button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1 id="campTitle">Campaign Title</h1>
    <img id="campImage" src="" alt="Campaign Image">
    <p id="campDescription"></p>

    <div class="details">
      <p><strong>Start Date:</strong> <span id="campStart"></span></p>
      <p><strong>End Date:</strong> <span id="campEnd"></span></p>
    </div>

    <button class="cta-button" onclick="alert('Support Campaign')">Support Campaign</button>
  </div>

  <script>
    // Fetch campaign data from localStorage
    const campaign = JSON.parse(localStorage.getItem('selected_campaign'));

    if (campaign) {
      document.getElementById('campTitle').textContent = campaign.CampName;
      document.getElementById('campImage').src = campaign.Image || 'https://via.placeholder.com/600x400';
      document.getElementById('campDescription').textContent = campaign.Description;
      document.getElementById('campStart').textContent = new Date(campaign.StartDate).toLocaleDateString();
      document.getElementById('campEnd').textContent = new Date(campaign.EndDate).toLocaleDateString();
    } else {
      document.querySelector('.container').innerHTML = '<p>Campaign not found.</p>';
    }
  </script>

</body>
</html>
