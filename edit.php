<?php
require "connect.php";

// Check if review id exists
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];

// shows existing review data
$stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = :id");
$stmt->execute([':id' => $id]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$review) {
    die("Review not found.");
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $rating = trim($_POST['rating'] ?? '');
    $review_text = trim($_POST['review_text'] ?? '');

    $errors = [];

    // Validation
    if ($title === '') {
        $errors[] = "Book title is required.";
    }

    if ($author === '') {
        $errors[] = "Author is required.";
    }

    if ($review_text === '') {
        $errors[] = "Review text is required.";
    }

    if ($rating === '') {
        $errors[] = "Rating is required.";
    } elseif (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        $errors[] = "Rating must be a number between 1 and 5.";
    }

    // Show errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
    } else {
        // Update review in database
        $stmt = $pdo->prepare("UPDATE reviews 
                               SET title = :title, author = :author, rating = :rating, review_text = :review_text 
                               WHERE id = :id");

        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':rating' => $rating,
            ':review_text' => $review_text,
            ':id' => $id
        ]);

        header("Location: admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Review</title>
</head>
<body>

    <h1>Edit Book Review</h1>

    <form method="POST">
        <label for="title">Book Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($review['title']) ?>">

        <br><br>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="<?= htmlspecialchars($review['author']) ?>">

        <br><br>

        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" value="<?= htmlspecialchars($review['rating']) ?>">

        <br><br>

        <label for="review_text">Review:</label>
        <br>
        <textarea id="review_text" name="review_text" rows="6" cols="40"><?= htmlspecialchars($review['review_text']) ?></textarea>

        <br><br>

        <button type="submit">Save Changes</button>
    </form>

    <p><a href="admin.php">Back to Admin Page</a></p>

</body>
</html>