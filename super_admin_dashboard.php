<?php
session_start();
include 'connection.php';

// Check if the user is logged in as Super Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: index.php");
    exit();
}

// Fetch all admin users from the database
$sql = "SELECT * FROM tbl_users WHERE role != 'super_admin'";
$result = $conn->query($sql);

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle delete admin
if (isset($_POST['delete_admin'])) {
    $admin_id = $_POST['admin_id'];
    $delete_sql = "DELETE FROM tbl_users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $admin_id);
    if ($stmt->execute()) {
        echo "<script>alert('Admin deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting admin.');</script>";
    }
    $stmt->close();
    // Refresh the page to reflect the changes
    header("Location: super_admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            box-sizing: border-box;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-logout {
            background-color: #dc3545;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
        .btn-delete {
            background-color: #ff6347;
        }
        .btn-delete:hover {
            background-color: #e53e2e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Super Admin Dashboard</h2>
        <a href="super_admin.php" class="btn">Add New Admin</a>
        <form method="post" style="display: inline;">
            <input type="submit" name="logout" value="Logout" class="btn btn-logout">
        </form>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Employee ID</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['full_name']) . "</td>
                                <td>" . htmlspecialchars($row['user_name']) . "</td>
                                <td>" . htmlspecialchars($row['emailid']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['address']) . "</td>
                                <td>" . htmlspecialchars($row['employee_id']) . "</td>
                                <td>" . htmlspecialchars($row['role']) . "</td>
                                <td>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='admin_id' value='" . $row['id'] . "'>
                                        <input type='submit' name='delete_admin' value='Delete' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this admin?\")'>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No admin accounts found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>
