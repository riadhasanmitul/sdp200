<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = $_POST['mobile'];
    $query = "SELECT * FROM tbl_vehicle WHERE owner_mobile = '$mobile'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['toast_message'] = "Vehicle details found!";
        $_SESSION['vehicle_details'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $_SESSION['toast_message'] = "No vehicle found for this mobile number.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin: 40px;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .result {
            margin-top: 30px;
            text-align: left;
            color: #333;
        }

        .result p {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .result p strong {
            color: #000;
        }

        .toast {
            visibility: hidden;
            max-width: 50px;
            height: 50px;
            margin: -125px auto 0;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            position: fixed;
            z-index: 1;
            left: 0; right: 0;
            bottom: 30px;
            font-size: 17px;
            white-space: nowrap;
        }

        .toast #desc {
            color: #fff;
            padding: 16px;
            overflow: hidden;
            white-space: nowrap;
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
</head>
<body>
    <div class="container">
        <h1>User Dashboard</h1>
        <form action="user_dashboard.php" method="POST">
            <div class="form-group">
                <label for="mobile">Enter Your Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Check</button>
        </form>
        <div class="result">
            <?php
            if (isset($_SESSION['vehicle_details'])) {
                echo "<div class='result'>";
                echo "<h2>Vehicle Details</h2>";
                foreach ($_SESSION['vehicle_details'] as $vehicle) {
                    $in_time = strtotime($vehicle['in_time']);
                    $current_time = time();
                    $elapsed_time = $current_time - $in_time;
                    $hours = floor($elapsed_time / 3600);
                    $minutes = floor(($elapsed_time % 3600) / 60);
                    $rate_per_hour = 5;
                    $charge = $hours * $rate_per_hour;

                    echo "<div class='vehicle-details'>";
                    echo "<p><strong>Vehicle Category:</strong> " . $vehicle['category'] . "</p>";
                    echo "<p><strong>Vehicle Brand:</strong> " . $vehicle['brand_name'] . "</p>";
                    echo "<p><strong>Registration Number:</strong> " . $vehicle['reg_no'] . "</p>";
                    echo "<p><strong>Owner Name:</strong> " . $vehicle['owner_name'] . "</p>";
                    echo "<p><strong>Owner Mobile:</strong> " . $vehicle['owner_mobile'] . "</p>";
                    echo "<p><strong>Check-in Time:</strong> " . date('Y-m-d H:i:s', $in_time) . "</p>";
                    echo "<p><strong>Elapsed Time:</strong> " . $hours . " hours and " . $minutes . " minutes</p>";
                    echo "<p><strong>Charge:</strong> $" . number_format($charge, 2) . "</p>";
                    echo "<hr>";
                    echo "</div>";
                }
                echo "</div>";
                unset($_SESSION['vehicle_details']); // Clear the session data after displaying
            }
            ?>
        </div>
        <a href="user_dashboard.php"><button class="btn-back">User Dashboard</button></a>
        <a href="index.php"><button class="btn-back">Back to Login</button></a>
    </div>
    <div id="toast" class="toast">
        <div id="desc"></div>
    </div>
    <script>
        function showToast(message) {
            const toast = document.getElementById("toast");
            const desc = document.getElementById("desc");
            desc.textContent = message;
            toast.className = "show";
            setTimeout(() => { toast.className = toast.className.replace("show", ""); }, 3000);
        }

        <?php
        if (isset($_SESSION['toast_message'])) {
            echo 'showToast("' . $_SESSION['toast_message'] . '");';
            unset($_SESSION['toast_message']);
        }
        ?>
    </script>
</body>
</html>
