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
      min-height: 100vh;
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

    hr {
      margin: 40px 0;
      border: none;
      border-top: 1px solid #ddd;
    }

    #feedbackList p {
      background: #f9f9f9;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 10px;
      text-align: left;
    }

    textarea, input[type="text"], input[type="number"] {
      width: 100%;
      padding: 8px;
      margin-top: 6px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
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

    <!-- Feedback Section -->
    <hr>
    <h2>💬 User Feedback</h2>

    <!-- Display existing feedback -->
    <div id="feedbackList" style="text-align: left; margin-top: 20px;"></div>

    <!-- Add new feedback -->
    <div style="margin-top: 30px; text-align: left;">
      <label for="username">Name:</label><br>
      <input type="text" id="username" placeholder="Your name"><br>

      <label for="rating">Rating (1-5):</label><br>
      <input type="number" id="rating" min="1" max="5"><br>

      <label for="comment">Comment:</label><br>
      <textarea id="comment" rows="4" placeholder="Write your feedback..."></textarea><br>

      <button class="cta-button" onclick="submitFeedback()">Submit Feedback</button>
    </div>
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

    function loadFeedback() {
      const feedbackList = JSON.parse(localStorage.getItem('campaign_feedback')) || [];
      const currentCampId = campaign?.CampID || 'default';
      const filtered = feedbackList.filter(fb => fb.campId === currentCampId);
      
      const container = document.getElementById('feedbackList');
      container.innerHTML = filtered.length
        ? filtered.map(f => `<p><strong>${f.name}</strong> ⭐${f.rating}<br>${f.comment}</p>`).join('')
        : '<p>No feedback yet. Be the first to comment!</p>';
    }

    function submitFeedback() {
      const name = document.getElementById('username').value.trim();
      const rating = parseInt(document.getElementById('rating').value);
      const comment = document.getElementById('comment').value.trim();
      
      if (!name || !comment || isNaN(rating) || rating < 1 || rating > 5) {
        alert('Please fill all fields correctly.');
        return;
      }

      const feedbackList = JSON.parse(localStorage.getItem('campaign_feedback')) || [];
      feedbackList.push({
        campId: campaign?.CampID || 'default',
        name,
        rating,
        comment,
        date: new Date().toISOString()
      });

      localStorage.setItem('campaign_feedback', JSON.stringify(feedbackList));
      alert('Feedback submitted!');
      document.getElementById('username').value = '';
      document.getElementById('rating').value = '';
      document.getElementById('comment').value = '';
      loadFeedback();
    }

    loadFeedback();
  </script>

</body>
</html>
