
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || strtolower($_SESSION['username']) !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM items WHERE id = $id");
$item = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $type = $_POST['type'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE items SET type='$type', description='$description', status='$status' WHERE id = $id");
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Item</title>
  <style>
    body { font-family: Arial; background: #f9f9f9; padding: 30px; }
    .form-box { max-width: 500px; background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    input, select, textarea { width: 100%; margin-bottom: 15px; padding: 10px; }
    button { background: #0077cc; color: white; padding: 10px 15px; border: none; cursor: pointer; }
    a { text-decoration: none; color: #0077cc; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Edit Item #<?= $id ?></h2>
    <form method="POST">
      <label>Type</label>
      <select name="type" required>
        <option value="Lost" <?= $item['type'] === 'Lost' ? 'selected' : '' ?>>Lost</option>
        <option value="Found" <?= $item['type'] === 'Found' ? 'selected' : '' ?>>Found</option>
      </select>

      <label>Description</label>
      <textarea name="description" required><?= htmlspecialchars($item['description']) ?></textarea>

      <label>Status</label>
      <select name="status" required>
        <option value="Pending" <?= $item['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Found" <?= $item['status'] === 'Found' ? 'selected' : '' ?>>Found</option>
        <option value="Returned" <?= $item['status'] === 'Returned' ? 'selected' : '' ?>>Returned</option>
      </select>

      <button type="submit" name="update">Update Item</button>
    </form>
    <br>
    <a href="admin_dashboard.php">⬅ Back to Dashboard</a>
  </div>
</body>
</html>
