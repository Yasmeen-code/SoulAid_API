<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Campaigns - SoulAid</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #dbeafe, #fef3c7);
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    .header {
      text-align: center;
      margin-top: 30px;
    }

    .logo {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 10px;
    }

    .logo img {
      width: 50px;
      height: 50px;
      margin-right: 10px;
    }

    .logo span {
      font-size: 24px;
      font-weight: bold;
      color: #2563eb;
    }

    h2 {
      color: #374151;
      margin-bottom: 10px;
    }

    .btn-create {
      background-color: #10b981;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 20px;
    }

    .btn-create:hover {
      background-color: #059669;
    }

    .campaigns-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      padding: 0 30px 50px;
      width: 100%;
      max-width: 1200px;
    }

    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      padding: 20px;
      border-top: 6px solid #60a5fa;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      margin: 0 0 10px;
      color: #2563eb;
    }

    .card p {
      margin: 0 0 10px;
      color: #374151;
      font-size: 14px;
    }

    .card .dates {
      font-size: 12px;
      color: #6b7280;
      margin-bottom: 10px;
    }

    .actions {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .actions button {
      flex: 1;
      padding: 10px;
      font-size: 14px;
      border: none;
      border-radius: 6px;
      color: white;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .btn-edit {
      background-color: #3b82f6;
    }

    .btn-edit:hover {
      background-color: #2563eb;
    }

    .btn-delete {
      background-color: #ef4444;
    }

    .btn-delete:hover {
      background-color: #dc2626;
    }
  </style>
</head>
<body>

<div class="header">
  <div class="logo">
    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="SoulAid Logo">
    <span>SoulAid</span>
  </div>
  <h2>Manage Campaigns</h2>
  <button class="btn-create" onclick="handleCreate()">➕ Create Campaign</button>
</div>

<div class="campaigns-container" id="campaignsContainer">
</div>

<script>
  const token = localStorage.getItem("auth_token");

  function handleCreate() {
    window.location.href = "/campaigns/create_campaign";
  }
  function handleEdit(campaign) {
  console.log("Campaign object in handleEdit:", campaign); 
  if (campaign && campaign.Camp_Id) {  
    console.log("Campaign ID:", campaign.Camp_Id);
    localStorage.setItem("selected_campaign", JSON.stringify(campaign));
    window.location.href = "/campaigns/edit-campaign/" + campaign.Camp_Id;  // استخدم Camp_Id هنا أيضًا
  } else {
    alert("Campaign ID is missing.");
  }
}

function handleDelete(id) {
  if (!confirm("Are you sure you want to delete this campaign?")) return;

  fetch(`http://localhost:8000/api/campaigns/${id}`, {
    method: "DELETE",
    headers: {
      Authorization: "Bearer " + token,
    },
  })
    .then((res) => res.json())
    .then((data) => {
      alert("Campaign deleted successfully");
      loadCampaigns(); 
    })
    .catch((err) => {
      alert("Failed to delete campaign");
      console.error(err);
    });
}

function loadCampaigns() {
  fetch("http://localhost:8000/api/campaigns", {
    method: "GET",
    headers: {
      Authorization: "Bearer " + token,
    },
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);  // تحقق من البيانات المستلمة من الـ API
      const campaigns = data.data || [];
      const container = document.getElementById("campaignsContainer");
      container.innerHTML = "";

      campaigns.forEach((camp) => {
        console.log(camp);  // تحقق من كل حملة
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <h3>${camp.CampName}</h3>
          <p>${camp.Description.slice(0, 80)}...</p>
          <div class="dates">
            <strong>Start:</strong> ${new Date(camp.StartDate).toLocaleDateString()}<br>
            <strong>End:</strong> ${new Date(camp.EndDate).toLocaleDateString()}
          </div>
          <div class="actions">
            <button class="btn-edit" onclick='handleEdit(${JSON.stringify(camp)})'>✏️ Edit</button>
            <button class="btn-delete" onclick="handleDelete(${camp.Camp_Id})">🗑️ Delete</button>
          </div>
        `;
        container.appendChild(card);
      });
    })
    .catch((err) => {
      console.error("Failed to load campaigns", err);
    });
}
loadCampaigns(); 
</script>

</body>
</html>
