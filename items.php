<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || strtolower($_SESSION['username']) !== 'admin') {
    header("Location: login.php");
    exit();
}

$items = mysqli_query($conn, "SELECT * FROM items ORDER BY id DESC");
$username = $_SESSION['username'];

// Fetch lost items by others
$other_lost_query = $conn->prepare("SELECT * FROM items WHERE type = 'Lost' AND uploaded_by != ? ORDER BY id DESC LIMIT 6");
$other_lost_query->bind_param("s", $username);
$other_lost_query->execute();
$other_lost_result = $other_lost_query->get_result();

// Fetch user items
$user_items_query = $conn->prepare("SELECT * FROM items WHERE uploaded_by = ? ORDER BY id DESC LIMIT 6");
$user_items_query->bind_param("s", $username);
$user_items_query->execute();
$user_items_result = $user_items_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Reported Items | LostLinkers</title>
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
    .back-link {
      background: white;
      color: #0077cc;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 4px;
      font-weight: bold;
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
    <h1>All Items</h1>
    <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
  </div>

<div class="dashboard">

<div class="container">
<section class="latest-items">
    <div class="cards">
    <?php while ($row = $other_lost_result->fetch_assoc()): ?>
        <div class="card">
            <div class="card-img" style="background-image: url('uploads/<?php echo $row['image']; ?>');"></div>
            <p class="card-title">Desc: <?php echo htmlspecialchars($row['description']); ?></p>
            <div class="lostContainer">
              <p class={status?"classpending":"classresolved"}>Status: <strong><?php echo $row['status']; ?></strong></p>
              <p>Type: <?php echo $row['type']; ?></p>
              <p>Reported By: <?php echo htmlspecialchars($row['uploaded_by']); ?></p>
            </div>
            <button class="btn details" style="margin-top:10px; background-color:#0077cc">View Details</button>
        </div>
    <?php endwhile; ?>
    </div>
  </section>
</div>


</body>
<!-- <?php include("footer.php") ?> -->
</html>
