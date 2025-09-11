<?php
include '../../includes/db_connection.php';
include '../../classes/AdminAuth.php';

$auth = new AdminAuth($conn);

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../output.css">
</head>
<body class="bg-gray-50 min-h-screen flex">
  <?php include '../../includes/admin_sidebar.php'; ?>
  <main class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">
      Hello, <?= htmlspecialchars($_SESSION['admin']); ?>!
    </h1>
    <p class="text-gray-500">Welcome to dashboard.</p>
  </main>
</body>
</html>
