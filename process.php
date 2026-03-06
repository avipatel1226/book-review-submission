<?php
require "connect.php";

// Check if form is submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and sanitize form data
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $rating = trim($_POST['rating'] ?? '');
    $review_text = trim($_POST['review_text'] ?? '');

    $errors = [];

    // Validate required fields
    if ($title === '') {
        $errors[] = "Book title is required.";
    }

    if ($author === '') {
        $errors[] = "Author is required.";
    }

    if ($review_text === '') {
        $errors[] = "Review text is required.";
    }

    // Validate rating
    if ($rating === '') {
        $errors[] = "Rating is required.";
    } elseif (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        $errors[] = "Rating must be a number between 1 and 5.";
    }

    // If errors exist, show them and stop
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        echo "<p><a href='index.php'>Go Back</a></p>";
        exit;
    }

    // Insert review into database using prepared statement
    $stmt = $pdo->prepare("INSERT INTO reviews (title, author, rating, review_text) 
                           VALUES (:title, :author, :rating, :review_text)");

    $stmt->execute([
        ':title' => $title,
        ':author' => $author,
        ':rating' => $rating,
        ':review_text' => $review_text
    ]);

    // Redirect to admin page after successful insert
    header("Location: admin.php");
    exit;
} else {
    echo "Invalid request.";
}
?>