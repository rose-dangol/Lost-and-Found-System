<?php
  //session_start();
  include 'db.php';
  include 'header.php';

  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $uploaded_by = mysqli_real_escape_string($conn, $_POST['uploaded_by']);
      $image_name = '';

      // Handle image upload if provided
      if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
          $image_tmp = $_FILES['image']['tmp_name'];
          $image_name = time() . '_' . basename($_FILES['image']['name']);
          $target_path = "uploads/" . $image_name;

          move_uploaded_file($image_tmp, $target_path);
      }

      // Insert into DB
      $query = "INSERT INTO items (type, description, image, uploaded_by, status) 
                VALUES ('$type', '$description', '$image_name', '$uploaded_by', 'Not Found')";

      if (mysqli_query($conn, $query)) {
          $success = "Item successfully reported.";
      } else {
          $error = "Error: " . mysqli_error($conn);
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Item | LostLinkers</title>
  <link rel="stylesheet" href="styles.css"/>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      padding: 30px;
    }
    .form-container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .form-container h2 {
      text-align: center;
      color: #0077cc;
    }
    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }
    input[type="text"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    input[type="file"] {
      margin-top: 5px;
    }
    button {
      margin-top: 20px;
      background-color: #0077cc;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #005fa3;
    }
    .message {
      margin-top: 20px;
      padding: 10px;
      border-radius: 6px;
      font-weight: bold;
    }
    .success { background-color: #d4edda; color: #155724; }
    .error { background-color: #f8d7da; color: #721c24; }
  </style>
</head>
<body>
<main class="main-content">
  <header class="topbar">
    <div class="logo">LostLinkers - Lost & Found</div>
    <div class="icons">
      <i class="fa fa-search"></i>
      <i class="fa fa-bars"></i>
      <i class="fa fa-user"></i>
    </div>
  </header>
<div class="form-container">
  <h2>Report Lost/Found Item</h2>

  <?php if (isset($success)): ?>
    <div class="message success"><?= $success ?></div>
  <?php elseif (isset($error)): ?>
    <div class="message error"><?= $error ?></div>
  <?php endif; ?>

  <form action="add_item.php" method="POST" enctype="multipart/form-data">
    <label for="type">Type:</label>
    <select name="type" required>
      <option value="Lost">Lost</option>
      <option value="Found">Found</option>
    </select>

    <label for="description">Description:</label>
    <textarea name="description" rows="4" required></textarea>

    <label for="image">Image (optional):</label>
    <input type="file" name="image">

    <label for="uploaded_by">Uploaded By (Username):</label>
    <input type="text" name="uploaded_by" required>

    <button type="submit">Submit Report</button>
  </form>
</div>

</body>
</html>
<!-- <?php 
    include 'footer.php';
?> -->
