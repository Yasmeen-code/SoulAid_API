<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Campaign - SoulAid</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #dbeafe, #fef3c7);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background: #fff;
      padding: 30px 25px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      border-top: 8px solid #60a5fa;
    }

    .logo {
      display: flex;
      justify-content: center;
      align-items: center;
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
      color: #2563eb;
    }

    h2 {
      color: #374151;
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #374151;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      font-family: inherit;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    .btn-save {
      background-color: #3b82f6;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    .btn-save:hover {
      background-color: #2563eb;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="logo">
    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="SoulAid Logo">
    <span>SoulAid</span>
  </div>

  <h2>Edit Campaign</h2>

  <form id="editForm">
    <label for="name">Campaign Name</label>
    <input type="text" id="name" name="name" required />

    <label for="description">Description</label>
    <textarea id="description" name="description" required></textarea>

    <label for="start">Start Date</label>
    <input type="date" id="start" name="start" required />

    <label for="end">End Date</label>
    <input type="date" id="end" name="end" required />

    <label for="amount">Amount</label>
    <input type="number" id="amount" name="amount" required />

    <label for="address">Address</label>
    <input type="text" id="address" name="address" required />

    <label for="admin_id">Admin ID</label>
    <input type="number" id="admin_id" name="admin_id" required />

    <label for="don_type_id">Donation Type ID</label>
    <input type="number" id="don_type_id" name="don_type_id" required />

    <button type="submit" class="btn-save">💾 Save Changes</button>
  </form>
</div>

<script>
  // عند تحميل الصفحة، نقوم بتحميل بيانات الحملة القديمة من localStorage
  document.addEventListener("DOMContentLoaded", function() {
    const campaign = JSON.parse(localStorage.getItem("selected_campaign"));
    
    if (campaign) {
      // ملء الحقول بالبيانات القديمة
      document.getElementById("name").value = campaign.CampName;
      document.getElementById("description").value = campaign.Description;
      document.getElementById("start").value = campaign.StartDate.split('T')[0]; // تحويل التاريخ إلى صيغة HTML المطلوبة
      document.getElementById("end").value = campaign.EndDate.split('T')[0]; // تحويل التاريخ إلى صيغة HTML المطلوبة
      document.getElementById("amount").value = campaign.Amount;
      document.getElementById("address").value = campaign.Address;
      document.getElementById("admin_id").value = campaign.Admin_Id;
      document.getElementById("don_type_id").value = campaign.Don_Type_Id;
    } else {
      alert("No campaign selected!");
      window.location.href = "/campaigns/manage-campaigns"; // إذا لم توجد حملة محددة، إعادة التوجيه
    }
  });
  document.getElementById("editForm").addEventListener("submit", function (e) {
  e.preventDefault();
  
  // التأكد من وجود الحملة و الـ token
  const campaign = JSON.parse(localStorage.getItem("selected_campaign"));
  const token = localStorage.getItem("auth_token");
  
  if (!campaign) {
    alert("No campaign selected!");
    return;
  }
  
  if (!token) {
    alert("User not authorized. Please log in.");
    return;
  }
  
  // جمع البيانات من النموذج
  const updatedData = {
    CampName: document.getElementById("name").value,
    Description: document.getElementById("description").value,
    StartDate: document.getElementById("start").value,
    EndDate: document.getElementById("end").value,
    Admin_Id: campaign.Admin_Id, // استرجاع ID المسؤول من البيانات المخزنة
    Don_Type_Id: campaign.Don_Type_Id, // استرجاع نوع التبرع من البيانات المخزنة
    Amount: document.getElementById("amount").value, // يجب إضافة حقل للمبلغ في الـ form
    Address: document.getElementById("address").value, // يجب إضافة حقل العنوان في الـ form
  };
  
  // التأكد من أن البيانات ليست فارغة
  if (!updatedData.CampName || !updatedData.Description || !updatedData.StartDate || !updatedData.EndDate || !updatedData.Amount || !updatedData.Address) {
    alert("Please fill all fields.");
    return;
  }

  // التحقق من أن التاريخ النهائي لا يكون قبل التاريخ الابتدائي
  if (new Date(updatedData.EndDate) < new Date(updatedData.StartDate)) {
    alert("End date cannot be before start date.");
    return;
  }

  // إرسال البيانات عبر fetch
  fetch(`http://localhost:8000/api/campaigns/update/${campaign.Camp_Id}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
      "Authorization": "Bearer " + token, // إرسال التوكن
    },
    body: JSON.stringify(updatedData),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        alert("Campaign updated successfully!");
        localStorage.removeItem("selected_campaign");
        window.location.href = "/manage-campaigns"; 
      } else {
        alert("Error: " + JSON.stringify(data));
        console.error("API Error:", data);
      }
    })
    .catch((err) => {
      alert("Error updating campaign: " + JSON.stringify(err));
      console.error("Error details:", err);
    });
});


</script>

</body>
</html>
