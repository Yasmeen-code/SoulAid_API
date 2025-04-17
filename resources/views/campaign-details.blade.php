<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Campaign Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f4f4f4;
    }
    .container {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 10px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1 id="campTitle">Campaign Title</h1>
    <img id="campImage" src="" alt="Campaign Image">
    <p id="campDescription"></p>
    <p><strong>Start Date:</strong> <span id="campStart"></span></p>
    <p><strong>End Date:</strong> <span id="campEnd"></span></p>
  </div>

  <script>
    // جلب البيانات من الـ localStorage
    const campaign = JSON.parse(localStorage.getItem('selected_campaign'));

    if (campaign) {
      document.getElementById('campTitle').textContent = campaign.CampName;
      document.getElementById('campImage').src = campaign.Image || 'https://via.placeholder.com/300';
      document.getElementById('campDescription').textContent = campaign.Description;
      document.getElementById('campStart').textContent = new Date(campaign.StartDate).toLocaleDateString();
      document.getElementById('campEnd').textContent = new Date(campaign.EndDate).toLocaleDateString();
    } else {
      document.querySelector('.container').innerHTML = '<p>Campaign not found.</p>';
    }
  </script>

</body>
</html>
