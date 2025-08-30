<?php
session_start();
include '../db_connection.php'; 

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param('ss', $username, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; }
        .login-box {
            background: #fff; padding: 24px; margin: 100px auto; width: 320px;
            box-shadow: 0 0 12px #aaa; border-radius: 8px;
        }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px; margin: 8px 0 16px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        input[type=submit] {
            width: 100%; padding: 10px; background: #007bff;
            color: #fff; border: none; border-radius: 4px;
        }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if($message): ?>
            <div class="error"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required autofocus>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>