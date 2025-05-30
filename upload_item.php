<?php
include 'db.php';

$type = $_POST['type'];
$description = $_POST['description'];
$uploaded_by = $_POST['uploaded_by'];
$image_name = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image_name = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image_name);
}

$stmt = $conn->prepare("INSERT INTO items (type, description, image, uploaded_by) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $type, $description, $image_name, $uploaded_by);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
?>
