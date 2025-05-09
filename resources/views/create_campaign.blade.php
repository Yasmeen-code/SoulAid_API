<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Campaign - SoulAid</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #dbeafe, #fef3c7);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #ffffff;
            padding: 40px 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            border-top: 8px solid #60a5fa;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
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
            text-align: center;
            color: #374151;
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            margin-top: 10px;
            display: block;
            color: #374151;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #f9fafb;
        }

        button {
            background-color: #2563eb;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1e40af;
        }

        #response {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="logo">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="SoulAid Logo">
        <span>SoulAid</span>
    </div>

    <h2>Create New Campaign</h2>
    <form id="campaignForm">
        <label for="CampName">Campaign Name:</label>
        <input type="text" name="CampName" id="CampName" required>

        <label for="Description">Description:</label>
        <textarea name="Description" id="Description" required></textarea>

        <label for="StartDate">Start Date:</label>
        <input type="date" name="StartDate" id="StartDate" required>

        <label for="EndDate">End Date:</label>
        <input type="date" name="EndDate" id="EndDate" required>

        <label for="Image">Image URL (optional):</label>
        <input type="text" name="Image" id="Image">

        <label for="Amount">Amount:</label>
        <input type="number" name="Amount" id="Amount" step="0.01" required>

        <label for="Address">Address:</label>
        <input type="text" name="Address" id="Address" required>

        <label for="Admin_Id">Admin ID:</label>
        <input type="number" name="Admin_Id" id="Admin_Id" value="1" required>

        <label for="Don_Type_Id">Campaign Type:</label>
        <select name="Don_Type_Id" id="Don_Type_Id" required>
            <option value="1">Money</option>
            <option value="2">Food</option>
            <option value="3">Clothes</option>
            <option value="4">Books</option>
            <option value="5">Blood</option>
        </select>

        <button type="submit">Create Campaign</button>
    </form>

    <div id="response"></div>
</div>

<script>
    const form = document.getElementById('campaignForm');
    const responseDiv = document.getElementById('response');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const res = await fetch('http://localhost:8000/api/campaigns', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();
            if (res.ok) {
                responseDiv.style.color = 'green';
                responseDiv.innerHTML = `✅ ${result.message || 'Campaign created successfully!'}`;
            } else {
                responseDiv.style.color = 'red';
                responseDiv.innerHTML = `❌ Error: ${result.message || JSON.stringify(result)}`;
                if (result.error_details) {
                    responseDiv.innerHTML += `<pre>${result.error_details}</pre>`;
                }
            }
        } catch (error) {
            responseDiv.style.color = 'red';
            responseDiv.innerHTML = `❌ Network error or API unreachable`;
            console.error(error);
        }
    });
</script>

</body>
</html>
