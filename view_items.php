<?php
// session_start();
include 'db.php';
include 'header.php';

if (!isset($_GET['id'])) {
    echo "<p>Item ID not provided.</p>";
    exit();
}

$item_id = intval($_GET['id']);  // sanitize
$query = $conn->prepare("SELECT * FROM items WHERE id = ?");
$query->bind_param("i", $item_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "<p>Item not found.</p>";
    exit();
}

$item = $result->fetch_assoc();
?>

<style>
  .single-card {
  max-width: 500px;
  margin: 2rem auto;
  padding: 1rem;
  border-radius: 10px;
  background: #f9f9f9;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  .single-card .card-img {
    width: 100%;
    height: 250px;
    background-size: cover;
    background-position: center;
    margin-bottom: 1rem;
  }
</style> 
<link rel="stylesheet" href="styles.css">
<section class="item-detail">
    <div class="card single-card">
        <div class="card-img" style="background-image: url('uploads/<?php echo $item['image']; ?>');"></div>
        <h2><?php echo htmlspecialchars($item['type']); ?> Item</h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
        <p class={status?"classpending":"classresolved"}><strong>Status:</strong> <?php echo $item['status']; ?></p>
        <p><strong>Uploaded By:</strong> <?php echo htmlspecialchars($item['uploaded_by']); ?></p>

        <!-- Contact the uploader section -->
        <p><strong>Contact the Uploader:</strong>
            <a href="https://mail.google.com/mail/u/0/?hl=en" class="btn">Send Email</a>
        </p>

        <p><a href="home.php" class="btn">Back to Home</a></p>
    </div>
</section>


<?php //include 'footer.php'; ?>