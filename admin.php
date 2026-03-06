<?php
require "connect.php";

// Fetch all reviews from database
$stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Book Reviews</title>
</head>
<body>

    <h1>Admin Page - Book Reviews</h1>

    <p><a href="index.php">Add New Review</a></p>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= htmlspecialchars($review['id']) ?></td>
                    <td><?= htmlspecialchars($review['title']) ?></td>
                    <td><?= htmlspecialchars($review['author']) ?></td>
                    <td><?= htmlspecialchars($review['rating']) ?></td>
                    <td><?= htmlspecialchars($review['review_text']) ?></td>
                    <td><?= htmlspecialchars($review['created_at']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $review['id'] ?>">Update</a> |
                        <a href="delete.php?id=<?= $review['id'] ?>" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No reviews found.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>