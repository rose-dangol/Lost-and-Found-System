<?php
session_start();
include 'db.php';

// Fetch all items from the database
$items = mysqli_query($conn, "SELECT * FROM items ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Reported Items | LostLinkers</title>
  <link rel="stylesheet" href="styles.css"></link>
  <style>
    .sidebar {
      width: 220px;
      background: #0077cc;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding: 30px 20px;
      color: white;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .sidebar h2 {
      margin-bottom: 30px;
      font-size: 22px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px;
      border-radius: 4px;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background: rgba(255,255,255,0.2);
    }

    .main-content {
      margin-left: 240px;
      padding: 30px;
    }
    .back-link {
      background: white;
      color: #0077cc;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 4px;
      font-weight: bold;
    }
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
    }
    .header {
      background: #0077cc;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header h1 {
      margin: 0;
    }
    .logout-btn {
      background: #fff;
      color: #0077cc;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 4px;
      font-weight: bold;
    }
    .logout-btn:hover {
      background: #e0e0e0;
    }
    .dashboard {
      padding: 30px;
    }
    .dashboard h2 {
      margin-top: 0;
    }
    .cards {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
    }
    .card {
      flex: 1;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .card h3 {
      margin: 0;
      color: #0077cc;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      margin-bottom: 40px;
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #0077cc;
      color: white;
    }
    .action-btn { color: red; text-decoration: none; margin-right: 10px; }
    .mark-btn { color: green; text-decoration: none; margin-right: 10px; }
    img.item-img { width: 100px; height: auto; }

    

    img.item-img {
      width: 100px;
      height: auto;
      border-radius: 4px;
    }

    .not-found { color: orange; }
    .found { color: green; font-weight: bold; }
  </style>
</head>
<body>
<div class="sidebar">
  <h2>LostLinkers</h2>
  <a href="admin_dashboard.php">Home</a>
  <a href="all_users.php">View Users</a>
  <a href="items.php">Latest Items</a>
  <a href="manage_items.php">Manage Items</a>
  <a href="logout.php">Logout</a>
</div>

<div class="main-content">
  <div class="header">
    <h1>All Reported Items</h1>
    <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
  </div>
  <br>
  <table>
    <tr>
      <th>ID</th>
      <th>Type</th>
      <th>Description</th>
      <th>Status</th>
      <th>Image</th>
      <th>Uploaded By</th>
      <th>Date Reported</th>
    </tr>

    <?php while ($item = mysqli_fetch_assoc($items)): ?>
      <tr>
        <td><?= $item['id'] ?></td>
        <td><?= $item['type'] ?></td>
        <td><?= htmlspecialchars($item['description']) ?></td>
        <td class="<?= strtolower($item['status']) === 'found' ? 'found' : 'not-found' ?>">
          <?= $item['status'] ?>
        </td>
        <td>
          <?php if ($item['image']): ?>
            <img class="item-img" src="uploads/<?= $item['image'] ?>" alt="Item Image">
          <?php else: ?>
            N/A
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($item['uploaded_by']) ?></td>
        <td><?= isset($item['created_at']) ? $item['created_at'] : 'N/A' ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

</body>
<!-- <?php
  include("footer.php")
?> -->
  </body>
</html>
</html>
