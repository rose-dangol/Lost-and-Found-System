<?php
// session_start();
include 'db.php';
include 'header.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch lost items by others
$other_lost_query = $conn->prepare("SELECT * FROM items WHERE type = 'Lost' AND uploaded_by != ? ORDER BY id DESC LIMIT 6");
$other_lost_query->bind_param("s", $username);
$other_lost_query->execute();
$other_lost_result = $other_lost_query->get_result();
?>
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
    <h2 style="margin:30px 0px 30px 0px;">Recently Reported Items</h2>
    <div class="cards">
    <?php while ($row = $other_lost_result->fetch_assoc()): ?>
        <div class="card">

            <div class="card-img">
            <div class="card-img" style="background-image: url('uploads/<?php echo $row['image']; ?>');"></div>            </div>
            <p class="card-title">Desc:<?php echo htmlspecialchars($row['description']); ?></p>
            <div class="lostContainer">
                <p class={status?"classpending":"classresolved"}>Status: <strong><?php echo $row['status']; ?></strong></p>
                <p>Type: <?php echo $row['type']; ?></p>
                <p>Reported By: <?php echo htmlspecialchars($row['uploaded_by']); ?></p>
            </div>
            <button class="btn details" style="margin-top:10px;"><a href="view_items.php?id=<?php echo $row['id'];?> ">View Details</a></button>

        </div>
    <?php endwhile; ?>
    </div>
    <!-- <?php include "footer.php" ?> -->
  </section>

