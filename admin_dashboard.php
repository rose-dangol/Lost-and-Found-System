<?php
  session_start();
  include 'db.php';

  if (!isset($_SESSION['username']) || strtolower($_SESSION['username']) !== 'admin') {
      header("Location: login.php");
      exit();
  }

  // Handle delete user
  if (isset($_GET['delete_user'])) {
      $id = intval($_GET['delete_user']);
      mysqli_query($conn, "DELETE FROM users WHERE id = $id");
  }

  // Handle delete item
  if (isset($_GET['delete_item'])) {
      $id = intval($_GET['delete_item']);
      mysqli_query($conn, "DELETE FROM items WHERE id = $id");
  }

  // Handle mark item as found
  if (isset($_GET['mark_found'])) {
      $id = intval($_GET['mark_found']);
      mysqli_query($conn, "UPDATE items SET status = 'Found' WHERE id = $id");
  }

  // Fetch user and item data
  $users = mysqli_query($conn, "SELECT id, fullname, username, email FROM users WHERE username!='admin'");
  $items = mysqli_query($conn, "SELECT * FROM items");

  $total_users = mysqli_num_rows($users);
  $total_lost_items = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM items WHERE type = 'Lost'"));
  $total_found_items = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM items WHERE status = 'Found'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | LostLinkers</title>
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
  </style>
</head>
<body>
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
    <h1>Admin Dashboard</h1>
  </div>

<div class="dashboard">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h2>

  <div class="cards">
    <div class="card"><h3><?php echo $total_users; ?></h3><p>Total Users</p></div>
    <div class="card"><h3><?php echo $total_lost_items; ?></h3><p>Lost Items</p></div>
    <div class="card"><h3><?php echo $total_found_items; ?></h3><p>Found Items</p></div>
  </div>

  <h3>Registered Users</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
    <?php 
        $count = 0;
        while($row = mysqli_fetch_assoc($users)): 
        if ($count >= 4) break;
    ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td>
          <a class="action-btn" href="?delete_user=<?= $row['id'] ?>" onclick="return confirm('Remove this user?')">Remove</a>
        </td>
    </tr>
    <?php 
    $count++;
        endwhile; 
    ?>
    <tr>
      <td colspan="7" style="text-align:center; padding: 15px;">
        <a class="mark-btn" href="all_users.php">View All Users</a>
      </td>
    <!-- View More row -->

  </table>


  <h3>Reported Items</h3>
  <table>
    <tr><th>Item ID</th><th>Type</th><th>Description</th><th>Status</th><th>Image</th><th>Uploaded By</th><th>Actions</th></tr>
    <?php while($item = mysqli_fetch_assoc($items)): ?>
      <tr>
        <td><?= $item['id'] ?></td>
        <td><?= $item['type'] ?></td>
        <td><?= htmlspecialchars($item['description']) ?></td>
        <td><?= $item['status'] ?></td>
        <td>
          <?php if ($item['image']): ?>
            <img class="item-img" src="<?= $item['image'] ?>" alt="Item Image">
          <?php else: ?>
            N/A
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($item['uploaded_by']) ?></td>
        <td>
          <?php if ($item['status'] !== 'Found'): ?>
            <a class="mark-btn" href="?mark_found=<?= $item['id'] ?>">Mark as Found</a>
          <?php endif; ?>
          <a class="action-btn" href="?delete_item=<?= $item['id'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    <tr>
      <td colspan="7" style="text-align:center; padding: 15px;">
        <a class="mark-btn" href="all_item.php">View More Items</a>
      </td>
  </table>

</div>
</body>
<?php
  include("footer.php")
?>
</html>
