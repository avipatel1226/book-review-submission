<?php
require "connect.php";

// Check if id exists
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];

// Delete review 
$stmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: admin.php");
exit;
?>