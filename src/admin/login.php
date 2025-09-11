<?php
include '../../includes/db_connection.php';
include '../../classes/AdminAuth.php';

$auth = new AdminAuth($conn);
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($username, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $message = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Login</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../output.css">
   </head>
   <body class="bg-gray-100 flex items-center justify-center min-h-screen">
      <form method="post" action="" class="bg-white p-8 rounded shadow w-80 flex flex-col gap-4">
         <h2 class="text-2xl font-bold text-center mb-2">Admin Login</h2>
         <?php if($message): ?>
         <div class="text-red-600 text-center"><?= htmlspecialchars($message) ?></div>
         <?php endif; ?>
         <input type="text" name="username" placeholder="Username" class="border rounded px-3 py-2" required autofocus>
         <input type="password" name="password" placeholder="Password" class="border rounded px-3 py-2" required>
         <button type="submit" class="bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
      </form>
   </body>
</html>

