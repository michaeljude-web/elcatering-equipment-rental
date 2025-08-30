<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
include '../db_connection.php';

$message = '';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM category WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header("Location: category.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name'] ?? '');
    if ($category_name !== '') {
        $stmt = $conn->prepare("INSERT INTO category (category_name) VALUES (?)");
        $stmt->bind_param('s', $category_name);
        if ($stmt->execute()) {
            $message = "Category added successfully!";
        } else {
            $message = "Error adding category: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "Category name cannot be empty.";
    }
}

$categories = [];
$result = $conn->query("SELECT * FROM category ORDER BY id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Category List</title>
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
        form {
            margin-bottom: 24px;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        label {
            font-weight: bold;
        }
        input[type=text] {
            width: 220px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 2px;
        }
        input[type=submit] {
            padding: 8px 16px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 2px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #0056b3;
        }
        .message { margin-bottom: 15px; color: green; }
        .error { color: red; margin-bottom: 15px; }
        .cat-list { margin-top:20px; }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
        }
        th, td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }
        th {
            background: #f0f0f0;
        }
        tr:nth-child(even) {
            background: #fafbfc;
        }
        .action-btn {
            background: #ff5454;
            color: #fff;
            padding: 6px 12px;
            border: none;
            border-radius: 2px;
            cursor: pointer;
            text-decoration: none;
        }
        .action-btn:hover {
            background: #e03d3d;
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
        <h2>Add Category</h2>
        <?php if($message): ?>
            <div class="<?= strpos($message, 'successfully') !== false ? 'message' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" id="category_name" required autofocus>
            <input type="submit" value="Add Category">
        </form>
        <div class="cat-list">
            <h3>Category List</h3>
            <?php if (count($categories)): ?>
            <table>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
                <?php foreach($categories as $cat): ?>
                <tr>
                    <td><?= htmlspecialchars($cat['id']); ?></td>
                    <td><?= htmlspecialchars($cat['category_name']); ?></td>
                    <td>
                        <a class="action-btn" href="category.php?delete=<?= $cat['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p>No categories yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>