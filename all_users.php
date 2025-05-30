<?php
session_start();
include 'db.php';

// Handle delete action
if (isset($_GET['delete_user'])) {
  $id = (int) $_GET['delete_user'];
  mysqli_query($conn, "DELETE FROM users WHERE id = $id");
  header("Location: manage_users.php");
  exit();
}

// Fetch all users
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users | LostLinkers</title>
  <link rel="stylesheet" href="styles.css">
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

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
    }

    h2 {
      margin-top: 0;
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

    .action-btn {
      text-decoration: none;
      padding: 6px 10px;
      border-radius: 4px;
      font-weight: bold;
    }

    .edit-btn {
      background: #28a745;
      color: white;
    }

    .delete-btn {
      background: #dc3545;
      color: white;
    }
    .back-link {
      background: white;
      color: #0077cc;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 4px;
      font-weight: bold;
    }
    .action-btn:hover {
      opacity: 0.85;
    }
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
        <h1>All Users</h1>
        <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
    <br>
  <table>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Action</th>
    </tr>

    <?php while ($user = mysqli_fetch_assoc($users)): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['fullname']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td>
          <a class="action-btn edit-btn" href="edit_user.php?id=<?= $user['id'] ?>">Edit</a>
          <a class="action-btn delete-btn" href="?delete_user=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<?php include("footer.php"); ?>

</body>
</html>
