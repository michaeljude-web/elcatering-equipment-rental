<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6fa;
        }
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 220px;
            background: #222d32;
            color: #fff;
            padding-top: 40px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.03);
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 32px;
            font-size: 24px;
            letter-spacing: 1px;
            color: #00aaff;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 16px 32px;
            border-bottom: 1px solid #2c3b41;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .sidebar ul li a:hover {
            background: #00aaff;
            border-radius: 4px;
            padding-left: 8px;
            transition: 0.2s;
        }
        .main-content {
            margin-left: 240px;
            padding: 40px;
        }
        .logout-btn {
            background: #ff4545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 32px;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background: #ff2222;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="category.php">Category List</a></li>
            <li><a href="equipment_list.php">Equipment List</a></li>
            <li><a href="booking_list.php">Booking List</a></li>
            <li><a href="customer_reports.php">Customer Reports</a></li>
        </ul>
        <form action="logout.php" method="post">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>
    <div class="main-content">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</h1>
    </div>
</body>
</html>