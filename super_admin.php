<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            box-sizing: border-box;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus {
            border-color: #007bff;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        /* Toast Styles */
        .toast {
            visibility: hidden;
            max-width: 50px;
            height: 50px;
            margin: auto;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
            white-space: nowrap;
        }
        .toast #desc {
            padding: 16px;
            display: block;
        }
        .toast.show {
            visibility: visible;
            max-width: 100%;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;} 
            to {bottom: 30px; opacity: 1;}
        }
        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }
        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;} 
            to {bottom: 0; opacity: 0;}
        }
        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>
    <script>
        function showToast(message) {
            const toast = document.getElementById("toast");
            const desc = document.getElementById("desc");
            desc.textContent = message;
            toast.className = "toast show";
            setTimeout(() => { toast.className = toast.className.replace("show", ""); }, 3000);
        }

        function validateForm() {
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone").value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^01\d{9}$/;
            const allowedEmailDomains = ['gmail.com', 'yahoo.com', 'outlook.com'];

            if (!emailPattern.test(email)) {
                showToast("Invalid email format.");
                return false;
            }

            const emailDomain = email.split('@')[1];
            if (!allowedEmailDomains.includes(emailDomain)) {
                showToast("Must be a valid email");
                return false;
            }

            if (!phonePattern.test(phone)) {
                showToast("Phone number must start with 01 and be exactly 11 digits.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <a href="super_admin_dashboard.php" class="btn">Back to Dashboard</a>
        <h2>Create Admin Account</h2>
        <form action="super_admin.php" method="post" onsubmit="return validateForm()">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            
            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" required>
            
            <label for="super_admin_confirm">Super Admin Password for Confirmation:</label>
            <input type="password" id="super_admin_confirm" name="super_admin_confirm" required>
            
            <input type="submit" name="submit" value="Create Admin">
        </form>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <span id="desc"></span>
    </div>
</body>
</html>
<?php
$server = "localhost";
$username = "root";
$password = "";
$databasename = "pms_db";

// Create a connection
$conn = new mysqli($server, $username, $password, $databasename);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Super Admin password
$super_admin_password = "123456";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $employee_id = $conn->real_escape_string($_POST['employee_id']);
    $super_admin_confirm = $conn->real_escape_string($_POST['super_admin_confirm']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>showToast('Invalid email format.');</script>";
        $conn->close();
        exit;
    }

    // Validate email domain
    $allowedEmailDomains = ['gmail.com', 'yahoo.com', 'outlook.com'];
    $emailDomain = substr(strrchr($email, "@"), 1);
    if (!in_array($emailDomain, $allowedEmailDomains)) {
        echo "<script>showToast('Must be a valid email');</script>";
        $conn->close();
        exit;
    }

    // Validate phone number (must start with '01' and be exactly 11 digits)
    if (!preg_match("/^01\d{9}$/", $phone)) {
        echo "<script>showToast('Phone number must start with 01 and be exactly 11 digits.');</script>";
        $conn->close();
        exit;
    }

    // Check if the super admin password is correct
    if ($super_admin_confirm === $super_admin_password) {
        // Insert the new admin into the database
        $sql = "INSERT INTO tbl_users (full_name, user_name, emailid, password, phone, address, employee_id) VALUES ('$full_name', '$username', '$email', '$password', '$phone', '$address', '$employee_id')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>showToast('New admin created successfully');</script>";
        } else {
            echo "<script>showToast('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>showToast('Super Admin password incorrect. Access denied.');</script>";
    }
}

// Close the connection
$conn->close();
?>
