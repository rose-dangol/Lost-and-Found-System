<?php
include 'db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            if (strtolower($user['username']) == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | LostLinkers</title>
  <style>
    body {
      background: url("this.jpg") no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      position: relative;
    }
    body::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(6px);
      z-index: 0;
    }
    .auth-container {
      z-index: 1;
      background: rgba(255, 255, 255, 0.88);
      padding: 30px;
      width: 100%;
      max-width: 400px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      text-align: center;
    }
    .auth-container h2 { margin-bottom: 10px; color: #333; }
    .auth-container input {
      width: 100%;
      margin-bottom: 12px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .btn {
      background: #0077cc;
      color: white;
      padding: 10px;
      border: none;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
    }
    .btn:hover { background: #005fa3; }
    .auth-link a { color: #0077cc; text-decoration: none; }
    .error-msg {
      color: #a94442;
      background: #ffd6d6;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<div class='error-msg'>$error</div>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button class="btn" type="submit">Login</button>
    </form>
    <p class="auth-link">Don’t have an account? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
