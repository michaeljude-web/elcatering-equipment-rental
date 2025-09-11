<?php
include '../../includes/db_connection.php';
include '../../classes/AdminAuth.php';
include '../../classes/Category.php';

$auth = new AdminAuth($conn);
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$category = new Category($conn);

$limit = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

if (isset($_POST['add_category'])) {
    $message = $category->add($_POST['category_name']);
}

if (isset($_GET['delete'])) {
    $category->delete($_GET['delete']);
    header("Location: category.php");
    exit();
}

$total_categories = $category->count();
$total_pages = ceil($total_categories / $limit);
$result = $category->getAll($start, $limit);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Category</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../output.css">
</head>
<body class="bg-gray-50 min-h-screen flex">
  <?php include '../../includes/admin_sidebar.php'; ?>
  <main class="flex-1 p-8">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold text-gray-800">Category</h1>
    </div>

    <?php if (!empty($message)) echo $message; ?>

    <div class="flex justify-between items-center mb-2">
      <p class="text-gray-600">Total Categories: <strong><?= $total_categories ?></strong></p>
      <div class="flex gap-2 items-center">
        <button id="openModal" type="button"
                class="px-3 py-1 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
          + Add
        </button>

        <a href="<?= ($page > 1) ? '?page='.($page-1) : '#' ?>"
           class="px-3 py-1 rounded-lg <?= ($page > 1) ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed' ?>">
           Previous
        </a>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="?page=<?= $i ?>"
             class="px-3 py-1 rounded-lg <?= ($i === $page) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
             <?= $i ?>
          </a>
        <?php endfor; ?>

        <a href="<?= ($page < $total_pages) ? '?page='.($page+1) : '#' ?>"
           class="px-3 py-1 rounded-lg <?= ($page < $total_pages) ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed' ?>">
           Next
        </a>
      </div>
    </div>

    <div class="bg-white shadow rounded-lg p-4" style="height:545px;">
      <table class="w-full">
        <thead class="border-b border-gray-200 bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-sm font-medium text-gray-600 text-center">Category Name</th>
            <th class="px-4 py-2 text-sm font-medium text-gray-600 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-700 text-center leading-relaxed"><?= htmlspecialchars($row['category_name']); ?></td>
                <td class="px-4 py-3 text-center">
                  <a href="?delete=<?= $row['id']; ?>"
                     onclick="return confirm('Are you sure you want to delete this category?');"
                     class="text-red-600 hover:text-red-800 inline-flex items-center justify-center p-1 rounded hover:bg-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z"/>
                    </svg>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="2" class="px-4 py-3 text-center text-gray-500">No categories found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold">Add Category</h2>
          <button id="closeModal" type="button" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form method="POST" class="space-y-4">
          <input type="text" name="category_name" placeholder="Enter category name"
                 class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <button type="submit" name="add_category"
                  class="bg-blue-600 text-white w-full py-2 rounded-lg hover:bg-blue-700">Save</button>
        </form>
      </div>
    </div>
  </main>
  <script src="admin.js"></script>
</body>
</html>
