<?php
//session_start();
include 'db.php';
include 'header.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch found items by others
$other_found_query = $conn->prepare("SELECT * FROM items WHERE type = 'Found' AND uploaded_by != ? ORDER BY id DESC LIMIT 6");
$other_found_query->bind_param("s", $username);
$other_found_query->execute();
$other_found_result = $other_found_query->get_result();
?>
<link rel="stylesheet" href="styles.css">
<style>
    .card-img img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }
</style>
<section class="latest-items">
    <h2>Recently Found Items</h2>
    <div class="cards">
    <?php while ($row = $other_found_result->fetch_assoc()): ?>
        <div class="card">
            <div class="card-img">
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Item Image">
            </div>
            <p class="card-title"><?php echo htmlspecialchars($row['description']); ?></p>
            <div class="foundContainer">
                <p class={status?"classpending":"classresolved"}>Status: <strong><?php echo $row['status']; ?></strong></p>
                <p>Type: <?php echo $row['type']; ?></p>
                <p>Reported By: <?php echo htmlspecialchars($row['uploaded_by']); ?></p>
            </div>
                <button class="btn details" style="margin-top:10px;"><a href="view_items.php?id=<?php echo $row['id']; ?>" class="btn details">View Details</a></button>

        </div>
    <?php endwhile; ?>
    </div>
    
</section>
<!-- <?php 
    include("footer.php")    
?> -->
