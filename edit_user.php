<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
  header("Location: all_users.php");
  exit();
}

$user_id = (int) $_GET['id'];

// Fetch user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
if (mysqli_num_rows($result) === 0) {
  echo "User not found.";
  exit();
}
$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);

  mysqli_query($conn, "UPDATE users SET fullname='$fullname', username='$username', email='$email' WHERE id=$user_id");
  header("Location: all_users.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User | LostLinkers</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 40px;
    }

    .form-container {
      max-width: 500px;
      background: white;
      padding: 30px;
      margin: auto;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h2 {
      margin-top: 0;
      text-align: center;
      color: #0077cc;
    }

    input[type="text"], input[type="email"] {
      width: 100%;
      padding: 10px;
      margin: 12px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background: #0077cc;
      color: white;
      border: none;
      padding: 12px 20px;
      cursor: pointer;
      border-radius: 4px;
      width: 100%;
      margin-top: 15px;
    }

    button:hover {
      background: #005fa3;
    }

    a.back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      text-decoration: none;
      color: #0077cc;
    }

    a.back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Edit User</h2>
  <form method="POST">
    <label>Full Name:</label>
    <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>

    <label>Username:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <button type="submit">Update User</button>
  </form>

  <a class="back-link" href="all_user.php">← Back to Users</a>
</div>

</body>
</html>
