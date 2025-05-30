<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LostLinkers - Lost & Found</title>
  <link rel="stylesheet" href="styles.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>
  <div class="container">
    <aside class="sidebar"> 
        <h2>LostLinkers</h2>
        <nav class="nav-links" >
        <a href="home.php" style="margin-top:8px;"><i class="fa fa-home"></i> Home</a>
        <a href="lost_items.php" style="margin-top:8px;"><i class="fa fa-search"></i> Lost Items</a>
        <a href="found_items.php" style="margin-top:8px;"><i class="fa fa-search"></i> Found Items</a>
        <a href="add_item.php" style="margin-top:8px;"><i class="fa fa-box"></i> Report an Item?</a>
        <a href="contact.php" style="margin-top:8px;"><i class="fa fa-phone"></i> Contact Us</a>
      </nav>
      <div class="auth-buttons">
        <button class="btn login" style="margin-top:25px; font-weight:bold;"><a href="logout.php" style="text-decoration:none;">Logout</a></button>
      </div>
    </aside>